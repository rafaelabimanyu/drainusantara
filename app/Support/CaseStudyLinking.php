<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Gallery;
use App\Services\RegionService;
use App\Services\ServiceCatalogRegistry;
use Illuminate\Support\Str;

final class CaseStudyLinking
{
    private const BRAND_SUFFIX = 'oleh Drainusantara';

    private const MAX_TITLE_LENGTH = 58;

    /**
     * Build a concise SERP-optimized <title> (<= 58 chars) ending once with "oleh Drainusantara".
     */
    public static function buildSeoTitle(Gallery $caseStudy): string
    {
        $rawTitle = trim((string) $caseStudy->title);
        $problem = self::extractCompactProblem($caseStudy, $rawTitle);
        $location = self::extractCompactLocation($caseStudy, $rawTitle);

        $candidates = [];
        if ($location !== '') {
            $candidates[] = "{$problem} {$location} " . self::BRAND_SUFFIX;

            // Try removing generic city qualifier if location has a comma or long suffix
            $shortLocation = self::shortenLocation($location);
            if ($shortLocation !== '' && $shortLocation !== $location) {
                $candidates[] = "{$problem} {$shortLocation} " . self::BRAND_SUFFIX;
            }
        }

        // Shorter problem phrasing without "Solusi" / "Atasi"
        $tightProblem = preg_replace('/^(?:Solusi|Atasi|Pelancaran)\s+/i', '', $problem) ?: $problem;
        if ($location !== '') {
            $shortLocation = self::shortenLocation($location) ?: $location;
            $candidates[] = "{$tightProblem} {$shortLocation} " . self::BRAND_SUFFIX;
        }
        $candidates[] = "{$problem} " . self::BRAND_SUFFIX;
        $candidates[] = "{$tightProblem} " . self::BRAND_SUFFIX;

        foreach ($candidates as $candidate) {
            $normalized = trim((string) preg_replace('/\s+/', ' ', $candidate));
            if (mb_strlen($normalized) <= self::MAX_TITLE_LENGTH) {
                return $normalized;
            }
        }

        // Strict budget fallback so "oleh Drainusantara" is never truncated
        $maxPrefix = self::MAX_TITLE_LENGTH - mb_strlen(' ' . self::BRAND_SUFFIX);
        $prefix = rtrim(mb_substr(trim("{$tightProblem} {$location}"), 0, $maxPrefix), ' ,-|');

        return trim($prefix . ' ' . self::BRAND_SUFFIX);
    }

    /**
     * Build a CTR-focused meta description (140-155 chars) with value hook up front.
     */
    public static function buildMetaDescription(Gallery $caseStudy): string
    {
        $problem = strtolower(self::extractCompactProblem($caseStudy, (string) $caseStudy->title));
        $problem = preg_replace('/^(?:solusi|atasi)\s+/i', '', $problem) ?: $problem;
        $location = self::extractCompactLocation($caseStudy, (string) $caseStudy->title);
        $method = trim((string) ($caseStudy->method ?: 'mesin spiral baja Ridgid'));
        if (mb_strlen($method) > 36) {
            $method = 'mesin spiral baja Ridgid';
        }

        $locClause = $location !== '' ? " di {$location}" : '';
        $desc = "Lancar tanpa bongkar keramik! Penanganan nyata {$problem}{$locClause} memakai {$method}. Garansi resmi 30 hari & No Cure No Pay.";
        $desc = trim((string) preg_replace('/\s+/', ' ', $desc));

        if (mb_strlen($desc) > 158) {
            $desc = "Lancar tanpa bongkar keramik! Penanganan {$problem}{$locClause} dengan {$method}. Garansi 30 hari & No Cure No Pay.";
        }

        return Str::limit($desc, 160, '');
    }

    /**
     * Resolve matching City Hub (+ optional indexable District) from location, title, and slug.
     *
     * @return array{
     *     city_slug: string,
     *     city_name: string,
     *     province_slug: string,
     *     province_name: string,
     *     city_url: string,
     *     district_slug: ?string,
     *     district_name: ?string,
     *     district_url: ?string
     * }|null
     */
    public static function resolveCityHub(Gallery $caseStudy): ?array
    {
        $haystack = strtolower(trim(implode(' ', array_filter([
            (string) $caseStudy->location,
            (string) $caseStudy->title,
            str_replace('-', ' ', (string) $caseStudy->slug),
        ]))));

        if ($haystack === '') {
            return null;
        }

        $allProvinces = RegionService::all();

        // 1. High-specificity neighborhood/landmark aliases first (prevents "BSD, Tangerang" matching tangerang-kota)
        $landmarkCityMap = [
            'bsd' => ['city' => 'tangerang-selatan', 'district' => 'bsd-city'],
            'gading serpong' => ['city' => 'tangerang-selatan', 'district' => 'serpong'],
            'serpong' => ['city' => 'tangerang-selatan', 'district' => 'serpong'],
            'bintaro' => ['city' => 'tangerang-selatan', 'district' => 'bintaro'],
            'tangsel' => ['city' => 'tangerang-selatan', 'district' => null],
            'tangerang selatan' => ['city' => 'tangerang-selatan', 'district' => null],
            'pik 2' => ['city' => 'jakarta-utara', 'district' => 'pantai-indah-kapuk'],
            'pik kapuk' => ['city' => 'jakarta-utara', 'district' => 'pantai-indah-kapuk'],
            'pantai indah kapuk' => ['city' => 'jakarta-utara', 'district' => 'pantai-indah-kapuk'],
            'kelapa gading' => ['city' => 'jakarta-utara', 'district' => 'kelapa-gading'],
            'pademangan' => ['city' => 'jakarta-utara', 'district' => 'pademangan'],
            'scbd' => ['city' => 'jakarta-selatan', 'district' => 'kebayoran-baru'],
            'blok m' => ['city' => 'jakarta-selatan', 'district' => 'kebayoran-baru'],
            'senopati' => ['city' => 'jakarta-selatan', 'district' => 'kebayoran-baru'],
            'pejaten' => ['city' => 'jakarta-selatan', 'district' => 'pasar-minggu'],
            'cilandak' => ['city' => 'jakarta-selatan', 'district' => 'cilandak'],
            'tebet' => ['city' => 'jakarta-selatan', 'district' => 'tebet'],
            'pasar minggu' => ['city' => 'jakarta-selatan', 'district' => 'pasar-minggu'],
            'cawang' => ['city' => 'jakarta-timur', 'district' => 'kramat-jati'],
            'condet' => ['city' => 'jakarta-timur', 'district' => 'kramat-jati'],
            'cibubur' => ['city' => 'jakarta-timur', 'district' => 'ciracas'],
            'cideng' => ['city' => 'jakarta-pusat', 'district' => 'gambir'],
            'tanjung duren' => ['city' => 'jakarta-barat', 'district' => 'grogol-petamburan'],
            'kelapa dua' => ['city' => 'depok-cinere', 'district' => 'cimanggis'],
            'sukmajaya' => ['city' => 'depok-cinere', 'district' => 'sukmajaya'],
            'jatisampurna' => ['city' => 'bekasi-cikarang', 'district' => null],
            'sentul' => ['city' => 'bogor', 'district' => 'sentul-city'],
            'gunung putri' => ['city' => 'bogor', 'district' => 'gunung-putri'],
            'jakarta premium outlet' => ['city' => 'tangerang-kota', 'district' => 'pinang'],
            'lempuyangan' => ['city' => 'semarang', 'district' => null],
        ];

        foreach ($landmarkCityMap as $needle => $target) {
            if (preg_match('/\b' . preg_quote($needle, '/') . '\b/i', $haystack)) {
                $cityData = RegionService::findCity($target['city']);
                if ($cityData) {
                    return self::formatCityHub($cityData, $target['district']);
                }
            }
        }

        // 2. Match exact district names across all cities (longer district names first to avoid substring collision)
        $districtMatches = [];
        foreach ($allProvinces as $prov) {
            foreach ($prov['cities'] as $city) {
                foreach ($city['districts'] as $distName) {
                    $districtMatches[] = [
                        'name' => $distName,
                        'slug' => Str::slug($distName),
                        'city' => $city,
                    ];
                }
            }
        }
        usort($districtMatches, static fn (array $a, array $b): int => mb_strlen($b['name']) <=> mb_strlen($a['name']));

        foreach ($districtMatches as $entry) {
            if (mb_strlen($entry['name']) >= 4 && preg_match('/\b' . preg_quote(strtolower($entry['name']), '/') . '\b/i', $haystack)) {
                return self::formatCityHub($entry['city'], $entry['slug']);
            }
        }

        // 3. Match city names & aliases
        $cityAliases = [
            'jakarta selatan' => 'jakarta-selatan',
            'jaksel' => 'jakarta-selatan',
            'jakarta timur' => 'jakarta-timur',
            'jaktim' => 'jakarta-timur',
            'jakarta barat' => 'jakarta-barat',
            'jakbar' => 'jakarta-barat',
            'jakarta utara' => 'jakarta-utara',
            'jakut' => 'jakarta-utara',
            'jakarta pusat' => 'jakarta-pusat',
            'jakpus' => 'jakarta-pusat',
            'depok' => 'depok-cinere',
            'cinere' => 'depok-cinere',
            'bekasi' => 'bekasi-cikarang',
            'cikarang' => 'bekasi-cikarang',
            'bogor' => 'bogor',
            'tangerang' => 'tangerang-kota',
            'bandung' => 'bandung',
            'cimahi' => 'kota-cimahi',
            'semarang' => 'semarang',
            'demak' => 'demak',
            'lampung' => 'bandar-lampung',
            'denpasar' => 'kota-denpasar',
            'badung' => 'kabupaten-badung',
            'gianyar' => 'kabupaten-gianyar',
            'tabanan' => 'kabupaten-tabanan',
            'bali' => 'kota-denpasar',
        ];

        foreach ($cityAliases as $alias => $citySlug) {
            if (preg_match('/\b' . preg_quote($alias, '/') . '\b/i', $haystack)) {
                $cityData = RegionService::findCity($citySlug);
                if ($cityData) {
                    return self::formatCityHub($cityData, null);
                }
            }
        }

        return null;
    }

    /**
     * Resolve canonical service target for a case study (never points to legacy slug or /#layanan).
     *
     * @return array{slug: string, name: string, url: string, badge: string}
     */
    public static function resolveService(Gallery $caseStudy): array
    {
        $allServices = ServiceCatalogRegistry::all();

        if ($caseStudy->service && ! empty($caseStudy->service->slug)) {
            $canonicalSlug = ServiceCatalogRegistry::canonicalSlug((string) $caseStudy->service->slug);
            if (isset($allServices[$canonicalSlug])) {
                $svc = $allServices[$canonicalSlug];

                return [
                    'slug' => $svc['slug'],
                    'name' => $svc['name'],
                    'url' => route('services.show', ['slug' => $svc['slug']]),
                    'badge' => $svc['badge'],
                ];
            }
        }

        $haystack = strtolower(trim(implode(' ', array_filter([
            (string) $caseStudy->drain_type,
            (string) $caseStudy->title,
            str_replace('-', ' ', (string) $caseStudy->slug),
            (string) optional($caseStudy->service)->name,
        ]))));

        $targetSlug = 'jasa-talang-air-dan-saluran-utama-mampet';
        if (str_contains($haystack, 'kamera') || str_contains($haystack, 'cctv') || str_contains($haystack, 'inspeksi')) {
            $targetSlug = 'jasa-inspeksi-kamera-cctv-pipa';
        } elseif (str_contains($haystack, 'grease') || str_contains($haystack, 'lemak') || str_contains($haystack, 'hydro') || str_contains($haystack, 'gutter')) {
            $targetSlug = 'jasa-hydro-jetting-dan-rooter-pipa';
        } elseif (str_contains($haystack, 'kloset') || str_contains($haystack, 'wc') || str_contains($haystack, 'toilet')) {
            $targetSlug = 'jasa-wc-dan-kloset-mampet';
        } elseif (str_contains($haystack, 'floor drain') || str_contains($haystack, 'kamar mandi') || str_contains($haystack, 'mesin cuci')) {
            $targetSlug = 'jasa-kamar-mandi-dan-floor-drain-mampet';
        } elseif (str_contains($haystack, 'wastafel') || str_contains($haystack, 'dapur') || str_contains($haystack, 'sink') || str_contains($haystack, 'cucian piring')) {
            $targetSlug = 'jasa-wastafel-dan-cucian-piring-mampet';
        } elseif (str_contains($haystack, 'bak kontrol') || str_contains($haystack, 'talang') || str_contains($haystack, 'clean out') || str_contains($haystack, 'saluran utama')) {
            $targetSlug = 'jasa-talang-air-dan-saluran-utama-mampet';
        }

        $svc = $allServices[$targetSlug];

        return [
            'slug' => $svc['slug'],
            'name' => $svc['name'],
            'url' => route('services.show', ['slug' => $svc['slug']]),
            'badge' => $svc['badge'],
        ];
    }

    /**
     * @param  array<string, mixed>  $cityData
     * @return array{
     *     city_slug: string,
     *     city_name: string,
     *     province_slug: string,
     *     province_name: string,
     *     city_url: string,
     *     district_slug: ?string,
     *     district_name: ?string,
     *     district_url: ?string
     * }
     */
    private static function formatCityHub(array $cityData, ?string $districtSlug): array
    {
        $districtName = null;
        $districtUrl = null;

        if ($districtSlug) {
            $matched = collect($cityData['districts'] ?? [])
                ->first(fn (string $d): bool => Str::slug($d) === $districtSlug);

            if ($matched && RegionService::isIndexableDistrict($cityData['slug'], $districtSlug)) {
                $districtName = $matched;
                $districtUrl = route('area.detail', [
                    'city' => $cityData['slug'],
                    'district' => $districtSlug,
                ]);
            } else {
                $districtSlug = null;
            }
        }

        return [
            'city_slug' => $cityData['slug'],
            'city_name' => $cityData['name'],
            'province_slug' => $cityData['province_slug'],
            'province_name' => $cityData['province_name'],
            'city_url' => route('area.city', ['city' => $cityData['slug']]),
            'district_slug' => $districtSlug,
            'district_name' => $districtName,
            'district_url' => $districtUrl,
        ];
    }

    private static function extractCompactProblem(Gallery $caseStudy, string $rawTitle): string
    {
        $clean = self::stripBrandNoise($rawTitle);
        $titleLower = strtolower($clean);
        $fallbackLower = strtolower(trim($clean . ' ' . (string) $caseStudy->drain_type));

        foreach ([$titleLower, $fallbackLower] as $lower) {
            if (str_contains($lower, 'inspeksi') || str_contains($lower, 'kamera') || str_contains($lower, 'cctv')) {
                if (str_contains($lower, 'kloset') || str_contains($lower, 'wc')) {
                    return 'Inspeksi CCTV Kloset';
                }
                if (str_contains($lower, 'floor drain')) {
                    return 'Inspeksi CCTV Floor Drain';
                }

                return 'Inspeksi Kamera Pipa';
            }
            if (str_contains($lower, 'grease trap') && str_contains($lower, 'gutter')) {
                return 'Solusi Grease Trap & Gutter';
            }
            if (str_contains($lower, 'grease trap')) {
                return 'Solusi Grease Trap Mampet';
            }
            if (str_contains($lower, 'gutter')) {
                return 'Solusi Gutter Mampet';
            }
            if (str_contains($lower, 'bak kontrol')) {
                return 'Solusi Bak Kontrol Mampet';
            }
            if (str_contains($lower, 'clean out')) {
                return 'Solusi Clean Out Mampet';
            }
            if (str_contains($lower, 'kloset') || str_contains($lower, 'wc')) {
                return 'Atasi Kloset Mampet';
            }
            if (str_contains($lower, 'floor drain') || str_contains($lower, 'kamar mandi')) {
                return 'Solusi Floor Drain Mampet';
            }
            if (str_contains($lower, 'wastafel')) {
                return 'Solusi Wastafel Mampet';
            }
            if (str_contains($lower, 'dapur')) {
                return 'Solusi Saluran Dapur Mampet';
            }
            if (str_contains($lower, 'talang')) {
                return 'Solusi Talang Air Mampet';
            }
        }

        // Fall back to cleaned title prefix before "di ..."
        $beforeLocation = trim((string) preg_replace('/\s+di\s+.+$/i', '', $clean));
        $beforeLocation = preg_replace('/^Pelancaran\s+(?:Saluran\s+|Pipa\s+)?/i', 'Solusi ', $beforeLocation) ?: $beforeLocation;

        return Str::limit($beforeLocation !== '' ? $beforeLocation : 'Solusi Pipa Mampet', 26, '');
    }

    private static function extractCompactLocation(Gallery $caseStudy, string $rawTitle): string
    {
        $rawLocation = trim((string) $caseStudy->location);
        $location = trim((string) preg_replace('/\s*\([^)]*\)/', '', $rawLocation));

        // Detect venue/brand-first locations (e.g. "Haka Dimsum, Jl. ..., Kelapa Gading, Jakarta Utara")
        if ($location !== '' && str_contains($location, ',')) {
            $parts = array_values(array_filter(array_map('trim', explode(',', $location))));
            $preferred = self::pickGeographicSegment($parts);
            if ($preferred !== null) {
                $location = $preferred;
            }
        }

        // If location looks like a pure venue name without a geographic token (e.g., "La Trobe Coffee & Brunch")
        if ($location === '' || self::looksLikeVenueOnly($location)) {
            $hub = self::resolveCityHub($caseStudy);
            if ($hub) {
                $location = $hub['district_name'] ?: $hub['city_name'];
            } else {
                $cleanTitle = self::stripBrandNoise($rawTitle);
                if (preg_match('/\s+di\s+(.+)$/i', $cleanTitle, $matches)) {
                    $location = trim($matches[1]);
                } elseif (preg_match('/\b(BSD|PIK 2|PIK|SCBD|Kelapa Gading|Cilandak|Pasar Minggu|Tebet|Pademangan|Cibubur|Cawang|Condet|Cideng|Pejaten|Sentul|Sukmajaya|Tanjung Duren|Jatisampurna|Gunung Putri|Gading Serpong|Kelapa Dua|Tangerang|Depok|Bekasi|Bogor|Bandung|Semarang|Bali)\b/i', $cleanTitle, $matches)) {
                    $location = trim($matches[1]);
                }
            }
        }

        $location = self::stripBrandNoise($location);
        $location = trim((string) preg_replace('/\s*\([^)]*\)/', '', $location));
        $location = trim((string) preg_replace('/\s+/', ' ', $location), ' ,-|');

        // Strip leading venue prefixes when followed by a real neighborhood (e.g. "EM Gelato Blok M" -> "Blok M")
        if (preg_match('/\b(Blok M|SCBD|PIK 2|PIK|BSD|Kelapa Gading|Cilandak|Pasar Minggu|Tebet|Pademangan|Cibubur|Cawang|Condet|Cideng|Pejaten|Sentul|Sukmajaya|Tanjung Duren|Jatisampurna|Gunung Putri|Gading Serpong|Kelapa Dua)\b/i', $location, $known)) {
            $location = trim($known[1]);
        }

        // Strip trailing redundant city qualifier if a specific district precedes it
        $location = (string) preg_replace('/^(?:Kota|Kabupaten)\s+/i', '', $location);
        $location = (string) preg_replace('/\s+(?:Jakarta\s+(?:Selatan|Timur|Barat|Utara|Pusat)|Tangerang\s+Selatan|Tangsel|Depok|Bekasi|Bogor)$/i', '', $location);

        return trim($location, ' ,-|');
    }

    /**
     * @param  array<int, string>  $parts
     */
    private static function pickGeographicSegment(array $parts): ?string
    {
        $filtered = array_values(array_filter($parts, static function (string $seg): bool {
            $lower = strtolower($seg);
            if ($lower === '' || preg_match('/^(?:jl\.|jalan\s|gg\.|gang\s|dki jakarta|jawa barat|banten|indonesia)/i', $seg)) {
                return false;
            }

            return ! self::looksLikeVenueOnly($seg);
        }));

        if (! empty($filtered)) {
            return $filtered[0];
        }

        return $parts[0] ?? null;
    }

    private static function looksLikeVenueOnly(string $text): bool
    {
        if (preg_match('/^(?:area|lokasi|nasional|indonesia)$/i', $text)) {
            return true;
        }

        // Known geographic terms override venue heuristics
        if (preg_match('/\b(Jakarta|Tangerang|Tangsel|Depok|Bekasi|Bogor|Bandung|Cimahi|Semarang|Demak|Lampung|Denpasar|Badung|Gianyar|Tabanan|Bali|BSD|PIK|SCBD|Blok M|Kelapa Gading|Kelapa Dua|Cilandak|Pasar Minggu|Tebet|Pademangan|Cibubur|Cawang|Condet|Cideng|Pejaten|Sentul|Sukmajaya|Tanjung Duren|Jatisampurna|Gading Serpong|Serpong|Bintaro|Pinang|Kemang)\b/i', $text)) {
            // Even if "Jakarta Premium Outlet" contains "Jakarta", it's a mall venue name
            if (preg_match('/\b(?:Outlet|Superindo|Dimsum|Coffee|Brunch|Gelato|Resto|Restoran|Cafe|Kafe|Richeese|Mie|Cluster|Gerai|Mall)\b/i', $text)) {
                return ! preg_match('/\b(Blok M|SCBD|PIK|BSD|Tebet|Kelapa Gading|Cilandak)\b/i', $text);
            }

            return false;
        }

        return (bool) preg_match('/\b(?:Gerai|Outlet|Dimsum|Coffee|Brunch|Gelato|Resto|Restoran|Cafe|Kafe|Cluster|Superindo|Richeese|Mall|Hotel|PT\.?|CV\.?)\b/i', $text);
    }

    private static function shortenLocation(string $location): string
    {
        $clean = trim((string) preg_replace('/\s*\([^)]*\)/', '', $location));
        $short = preg_replace('/^(?:Kawasan|Area|Kecamatan|Kelurahan|Kota|Kabupaten|PT|Restoran|Superindo|Richeese|Gerai|Cluster)\s+/i', '', $clean) ?: $clean;
        $words = preg_split('/\s+/', trim($short)) ?: [];

        if (count($words) > 2) {
            return implode(' ', array_slice($words, 0, 2));
        }

        return trim($short);
    }

    private static function stripBrandNoise(string $text): string
    {
        $cleaned = preg_replace('/(?:\s*[-|]\s*(?:Studi Kasus|Drainusantara(?:\s+Bergaransi)?))+\s*$/i', '', $text) ?? $text;
        $cleaned = preg_replace('/\s*oleh\s+drainusantara\s*$/i', '', $cleaned) ?? $cleaned;

        return trim($cleaned, ' ,-|');
    }
}
