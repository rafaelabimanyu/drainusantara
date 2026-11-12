<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CoverageArea;
use Illuminate\Support\Str;

class AreaImageResolver
{
    /**
     * Default fallback fleet image path.
     */
    public const DEFAULT_IMAGE = 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp';

    /**
     * Cache for resolved images during request lifecycle.
     *
     * @var array<string, array{path: string, encoded_path: string, url: string, source: string}>
     */
    protected static array $memoized = [];

    /**
     * Resolve image URL for a given CoverageArea model or geographical parameters.
     */
    public static function resolveUrl(?CoverageArea $area = null, ?string $provinceSlug = null, ?string $citySlug = null, ?string $district = null): string
    {
        $resolved = self::resolve($area, $provinceSlug, $citySlug, $district);

        return $resolved['url'];
    }

    /**
     * Resolve presence / local operations image URL.
     */
    public static function resolvePresenceUrl(?CoverageArea $area = null, ?string $provinceSlug = null, ?string $citySlug = null, ?string $district = null): string
    {
        // 1. If CoverageArea has explicit custom presence_image
        if ($area && ! empty($area->presence_image)) {
            $presence = $area->presence_image;
            if (filter_var($presence, FILTER_VALIDATE_URL)) {
                return $presence;
            }

            $clean = ltrim(str_replace('\\', '/', $presence), '/');
            $decoded = rawurldecode($clean);

            return asset(self::encodePath($decoded));
        }

        // 2. Otherwise fall back to the standard resolved area hero image
        return self::resolveUrl($area, $provinceSlug, $citySlug, $district);
    }

    /**
     * Resolve image metadata (path, encoded_path, url, source).
     *
     * @return array{path: string, encoded_path: string, url: string, source: string}
     */
    public static function resolve(?CoverageArea $area = null, ?string $provinceSlug = null, ?string $citySlug = null, ?string $district = null): array
    {
        $memoKey = self::buildMemoKey($area, $provinceSlug, $citySlug, $district);
        if (isset(self::$memoized[$memoKey])) {
            return self::$memoized[$memoKey];
        }

        // Priority 1: Custom CMS Upload on CoverageArea model
        if ($area && ! empty($area->hero_image)) {
            $hero = $area->hero_image;
            if (filter_var($hero, FILTER_VALIDATE_URL)) {
                return self::$memoized[$memoKey] = [
                    'path' => $hero,
                    'encoded_path' => $hero,
                    'url' => $hero,
                    'source' => 'cms_custom',
                ];
            }

            $clean = ltrim(str_replace('\\', '/', $hero), '/');
            $decoded = rawurldecode($clean);
            $enc = self::encodePath($decoded);

            $source = 'cms_custom';
            if (str_contains($decoded, '/KECAMATAN') || str_contains($decoded, '/kecamatan')) {
                $source = 'district_asset';
            } elseif (str_contains($decoded, 'images/areas/provinces/')) {
                $source = 'province_asset';
            } elseif (str_contains($decoded, 'images/areas/') && (str_ends_with($decoded, 'semarang.jpg') || str_ends_with($decoded, 'tangerang-kota.jpg') || str_ends_with($decoded, 'tangerang-selatan.jpg') || str_ends_with($decoded, 'bekasi-cikarang.jpg') || str_ends_with($decoded, 'depok-cinere.jpg') || str_ends_with($decoded, 'jakarta-selatan.jpg') || str_ends_with($decoded, 'jakarta-barat.jpg') || str_ends_with($decoded, 'jakarta-timur.jpg') || str_ends_with($decoded, 'jakarta-utara.jpg') || str_ends_with($decoded, 'jakarta-pusat.jpg'))) {
                $source = 'city_asset';
            }

            return self::$memoized[$memoKey] = [
                'path' => $decoded,
                'encoded_path' => $enc,
                'url' => asset($enc),
                'source' => $source,
            ];
        }

        // Extract normalized geographical identifiers
        [$pSlug, $cSlug, $distName] = self::extractGeoParams($area, $provinceSlug, $citySlug, $district);

        // Priority 2: Auto-matched District Image
        if (! empty($distName) && ! empty($cSlug)) {
            $districtAsset = self::findDistrictAsset($pSlug, $cSlug, $distName);
            if ($districtAsset !== null) {
                $enc = self::encodePath($districtAsset);

                return self::$memoized[$memoKey] = [
                    'path' => $districtAsset,
                    'encoded_path' => $enc,
                    'url' => asset($enc),
                    'source' => 'district_asset',
                ];
            }
        }

        // Priority 2b: Auto-matched City Image
        if (! empty($cSlug)) {
            $cityAsset = self::findCityAsset($pSlug, $cSlug);
            if ($cityAsset !== null) {
                $enc = self::encodePath($cityAsset);

                return self::$memoized[$memoKey] = [
                    'path' => $cityAsset,
                    'encoded_path' => $enc,
                    'url' => asset($enc),
                    'source' => 'city_asset',
                ];
            }
        }

        // Priority 2c: Auto-matched Province Image
        if (! empty($pSlug)) {
            $provinceAsset = self::findProvinceAsset($pSlug);
            if ($provinceAsset !== null) {
                $enc = self::encodePath($provinceAsset);

                return self::$memoized[$memoKey] = [
                    'path' => $provinceAsset,
                    'encoded_path' => $enc,
                    'url' => asset($enc),
                    'source' => 'province_asset',
                ];
            }
        }

        // Priority 3: Fallback to Drainusantara fleet image
        $defaultPath = self::DEFAULT_IMAGE;
        $encDefault = self::encodePath($defaultPath);

        return self::$memoized[$memoKey] = [
            'path' => $defaultPath,
            'encoded_path' => $encDefault,
            'url' => asset($encDefault),
            'source' => 'default_fleet',
        ];
    }

    /**
     * Safely encode URL path segments (e.g., spaces to %20).
     */
    public static function encodePath(string $path): string
    {
        $clean = ltrim(str_replace('\\', '/', $path), '/');
        $segments = explode('/', $clean);
        $encoded = array_map('rawurlencode', $segments);

        return implode('/', $encoded);
    }

    /**
     * Extract geo parameters from CoverageArea model or manual arguments.
     *
     * @return array{0: string|null, 1: string|null, 2: string|null} [provinceSlug, citySlug, district]
     */
    protected static function extractGeoParams(?CoverageArea $area, ?string $provinceSlug, ?string $citySlug, ?string $district): array
    {
        $pSlug = $provinceSlug;
        $cSlug = $citySlug;
        $dist = $district;

        if ($area !== null) {
            if ($area->isProvince()) {
                $pSlug = $pSlug ?: ($area->slug ?? Str::slug($area->province_name ?: $area->city));
                $cSlug = null;
                $dist = null;
            } elseif ($area->isCity()) {
                $cityData = RegionService::findCity($area->city);
                $cSlug = $cSlug ?: ($cityData['slug'] ?? Str::slug($area->city));
                $pSlug = $pSlug ?: ($cityData['province_slug'] ?? Str::slug($area->province_name ?? ''));
                $dist = null;
            } else {
                // District level
                $cleanDist = $area->getCleanDistrict() ?: $area->district;
                $dist = $dist ?: $cleanDist;
                $cityData = RegionService::findCity($area->city);
                $cSlug = $cSlug ?: ($cityData['slug'] ?? Str::slug($area->city));
                $pSlug = $pSlug ?: ($cityData['province_slug'] ?? Str::slug($area->province_name ?? ''));
            }
        }

        // Normalize city slug aliases
        if ($cSlug) {
            $cSlug = self::normalizeCitySlug($cSlug);
        }

        // Normalize province slug aliases
        if ($pSlug) {
            $pSlug = self::normalizeProvinceSlug($pSlug);
        }

        return [$pSlug, $cSlug, $dist];
    }

    /**
     * Normalize city slug aliases.
     */
    protected static function normalizeCitySlug(string $citySlug): string
    {
        $slug = Str::slug($citySlug);

        return match ($slug) {
            'depok', 'cinere' => 'depok-cinere',
            'bekasi', 'cikarang' => 'bekasi-cikarang',
            'tangerang' => 'tangerang-kota',
            'tangsel' => 'tangerang-selatan',
            default => $slug,
        };
    }

    /**
     * Normalize province slug aliases.
     */
    protected static function normalizeProvinceSlug(string $provinceSlug): string
    {
        $slug = Str::slug($provinceSlug);

        return match ($slug) {
            'jakarta', 'dki' => 'dki-jakarta',
            'jabar' => 'jawa-barat',
            'jateng' => 'jawa-tengah',
            default => $slug,
        };
    }

    /**
     * Search for district asset in public/images/areas directory.
     */
    protected static function findDistrictAsset(?string $provinceSlug, string $citySlug, string $district): ?string
    {
        $dSlug = Str::slug($district);
        $extensions = ['jpg', 'webp', 'png', 'jpeg'];

        // District slug variations (e.g. Setiabudi vs setia-budi)
        $districtVariants = array_unique(array_filter([
            $dSlug,
            str_replace('setiabudi', 'setia-budi', $dSlug),
            str_replace('setia-budi', 'setiabudi', $dSlug),
            str_replace('pantai-indah-kapuk', 'pik', $dSlug),
            str_replace('puri-kembangan', 'kembangan', $dSlug),
        ]));

        $candidatePaths = [];

        // 1. DKI Jakarta Districts
        if (str_starts_with($citySlug, 'jakarta-') || $provinceSlug === 'dki-jakarta') {
            $jktDir = strtoupper(str_replace('-', ' ', $citySlug));
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/DKI JAKARTA/KECAMATAN {$jktDir}/{$var}.{$ext}";
                }
            }
        }

        // 2. Tangerang Kota Districts
        if ($citySlug === 'tangerang-kota' || str_contains($citySlug, 'tangerang-kota')) {
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/BANTEN/TANGERANG KOTA/KECAMATAN/{$var}.{$ext}";
                }
            }
        }

        // 3. Tangerang Selatan Districts
        if ($citySlug === 'tangerang-selatan') {
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/BANTEN/TANGERANG SELATAN/KECAMATAN/{$var}.{$ext}";
                }
            }
        }

        // 4. Bekasi Districts
        if (str_contains($citySlug, 'bekasi') || str_contains($citySlug, 'cikarang')) {
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/JAWA BARAT/BEKASI/KECAMATAN/{$var}.{$ext}";
                }
            }
        }

        // 5. Depok Districts
        if (str_contains($citySlug, 'depok') || str_contains($citySlug, 'cinere')) {
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/JAWA BARAT/DEPOK/KECAMATAN/{$var}.{$ext}";
                }
            }
        }

        // 6. Semarang Districts
        if (str_contains($citySlug, 'semarang')) {
            foreach ($districtVariants as $var) {
                foreach ($extensions as $ext) {
                    $candidatePaths[] = "images/areas/JAWA TENGAH/SEMARANG/KECAMATAN/{$var}.{$ext}";
                }
            }
        }

        // 7. Legacy paths
        foreach ($districtVariants as $var) {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/districts/{$citySlug}-{$var}.{$ext}";
                $candidatePaths[] = "images/areas/districts/{$var}.{$ext}";
            }
        }

        foreach ($candidatePaths as $rel) {
            if (file_exists(public_path($rel))) {
                return $rel;
            }
        }

        return null;
    }

    /**
     * Search for city asset in public/images/areas directory.
     */
    protected static function findCityAsset(?string $provinceSlug, string $citySlug): ?string
    {
        $extensions = ['jpg', 'webp', 'png', 'jpeg'];
        $candidatePaths = [];

        // DKI Jakarta Cities
        if (str_starts_with($citySlug, 'jakarta-') || $provinceSlug === 'dki-jakarta') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/DKI JAKARTA/{$citySlug}.{$ext}";
            }
        }

        // Tangerang Kota
        if ($citySlug === 'tangerang-kota') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/BANTEN/TANGERANG KOTA/tangerang-kota.{$ext}";
                $candidatePaths[] = "images/areas/BANTEN/TANGERANG KOTA/tangerang.{$ext}";
            }
        }

        // Tangerang Selatan
        if ($citySlug === 'tangerang-selatan') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/BANTEN/TANGERANG SELATAN/tangerang-selatan.{$ext}";
            }
        }

        // Bekasi & Cikarang
        if (str_contains($citySlug, 'bekasi') || str_contains($citySlug, 'cikarang')) {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/JAWA BARAT/BEKASI/bekasi-cikarang.{$ext}";
                $candidatePaths[] = "images/areas/JAWA BARAT/BEKASI/bekasi.{$ext}";
            }
        }

        // Depok & Cinere
        if (str_contains($citySlug, 'depok') || str_contains($citySlug, 'cinere')) {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/JAWA BARAT/DEPOK/depok-cinere.{$ext}";
                $candidatePaths[] = "images/areas/JAWA BARAT/DEPOK/depok.{$ext}";
            }
        }

        // Semarang
        if ($citySlug === 'semarang') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/JAWA TENGAH/SEMARANG/semarang.{$ext}";
            }
        }

        // Legacy city paths
        foreach ($extensions as $ext) {
            $candidatePaths[] = "images/areas/cities/{$citySlug}.{$ext}";
        }

        foreach ($candidatePaths as $rel) {
            if (file_exists(public_path($rel))) {
                return $rel;
            }
        }

        return null;
    }

    /**
     * Search for province asset in public/images/areas directory.
     */
    protected static function findProvinceAsset(string $provinceSlug): ?string
    {
        $extensions = ['webp', 'jpg', 'png', 'jpeg'];
        $candidatePaths = [];

        // Banten
        if ($provinceSlug === 'banten') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/BANTEN/banten.{$ext}";
            }
        }

        // DKI Jakarta
        if ($provinceSlug === 'dki-jakarta') {
            foreach ($extensions as $ext) {
                $candidatePaths[] = "images/areas/DKI JAKARTA/dki-jakarta.{$ext}";
            }
        }

        // General provinces folder
        foreach ($extensions as $ext) {
            $candidatePaths[] = "images/areas/provinces/{$provinceSlug}.{$ext}";
        }

        foreach ($candidatePaths as $rel) {
            if (file_exists(public_path($rel))) {
                return $rel;
            }
        }

        return null;
    }

    /**
     * Build memoization key.
     */
    protected static function buildMemoKey(?CoverageArea $area, ?string $provinceSlug, ?string $citySlug, ?string $district): string
    {
        $areaId = $area ? ($area->id ?? $area->slug ?? 'area') : 'null';
        $hero = $area ? ($area->hero_image ?? '') : '';

        return implode(':', [$areaId, $hero, $provinceSlug ?? '', $citySlug ?? '', $district ?? '']);
    }

    /**
     * Clear memory cache (useful in tests).
     */
    public static function clearCache(): void
    {
        self::$memoized = [];
    }
}

