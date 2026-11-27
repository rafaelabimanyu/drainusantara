<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Service;
use App\Services\AreaImageResolver;
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    use HasPageSeo;

    /**
     * Complete synchronized mapping of city aliases to canonical slug.
     * Prevents 404 errors across common abbreviations, alternate names, and regional hub variations.
     *
     * @return array<string, string>
     */
    public static function getCityAliases(): array
    {
        return [
            // DKI Jakarta
            'jaksel' => 'jakarta-selatan',
            'jaktim' => 'jakarta-timur',
            'jakbar' => 'jakarta-barat',
            'jakut' => 'jakarta-utara',
            'jakpus' => 'jakarta-pusat',

            // Jawa Barat & Bodetabek
            'depok' => 'depok-cinere',
            'cinere' => 'depok-cinere',
            'kota-depok' => 'depok-cinere',
            'bekasi' => 'bekasi-cikarang',
            'cikarang' => 'bekasi-cikarang',
            'kota-bekasi' => 'bekasi-cikarang',
            'kabupaten-bekasi' => 'bekasi-cikarang',
            'bogor' => 'bogor',
            'kota-bogor' => 'bogor',
            'kabupaten-bogor' => 'bogor',
            'bandung' => 'bandung',
            'kota-bandung' => 'bandung',
            'bandung-kota' => 'bandung',
            'cimahi' => 'kota-cimahi',

            // Banten
            'tangerang' => 'tangerang-kota',
            'kota-tangerang' => 'tangerang-kota',
            'tangsel' => 'tangerang-selatan',
            'kota-tangerang-selatan' => 'tangerang-selatan',
            'bsd' => 'tangerang-selatan',

            // Jawa Tengah
            'semarang' => 'semarang',
            'kota-semarang' => 'semarang',
            'semarang-kota' => 'semarang',
            'demak' => 'demak',
            'kota-demak' => 'demak',
            'kabupaten-demak' => 'demak',

            // Lampung
            'lampung' => 'bandar-lampung',
            'kota-bandar-lampung' => 'bandar-lampung',

            // Bali
            'denpasar' => 'kota-denpasar',
            'badung' => 'kabupaten-badung',
            'gianyar' => 'kabupaten-gianyar',
            'tabanan' => 'kabupaten-tabanan',
            'buleleng' => 'kabupaten-buleleng',
            'bangli' => 'kabupaten-bangli',
            'klungkung' => 'kabupaten-klungkung',
            'karangasem' => 'kabupaten-karangasem',
            'jembrana' => 'kabupaten-jembrana',
        ];
    }

    /**
     * Display all provinces and cities coverage directory.
     */
    public function areasIndex(): View
    {
        PageMetadata::title('Wilayah Jangkauan Teknisi Pipa Mampet');
        SEOMeta::setDescription('Daftar jangkauan posko siaga teknisi pipa mampet Drainusantara di Jabodetabek, Semarang, & Lampung. Siaga 24 jam respon cepat & garansi 30 hari.');
        SEOMeta::setCanonical(route('area.index'));

        $areaImage = AreaImageResolver::resolveUrl(null, 'dki-jakarta');

        OpenGraph::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        OpenGraph::setUrl(route('area.index'));
        OpenGraph::addImage($areaImage);

        TwitterCard::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        TwitterCard::setImage($areaImage);

        JsonLdMulti::setTitle('Wilayah Jangkauan Layanan Drainusantara');
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            '@id' => route('area.index') . '#localbusiness',
            'name' => 'Drainusantara - Wilayah Jangkauan Layanan',
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => route('area.index'),
            'image' => $areaImage,
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'address' => $this->getHeadquartersAddress(),
            'geo' => $this->getHeadquartersGeo(),
            'sameAs' => $this->getSameAsUrls(),
            'hasMap' => config('services.company.google_maps_url') ?: null,
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
            'priceRange' => 'Mulai Rp 400.000',
            'parentOrganization' => $this->getParentOrganizationSchema(),
        ]);

        $this->addBreadcrumb(['Area Layanan', route('area.index')]);

        $provinces = RegionService::all();
        $nonPriorityDistrictKeys = $this->getNonPriorityDistrictKeys();
        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });

        return view('areas.index', compact('provinces', 'services', 'nonPriorityDistrictKeys'));
    }

    /**
     * Display province-level coverage area page.
     */
    public function province(string $province): View
    {
        $provinceData = RegionService::findProvince($province);
        if (! $provinceData) {
            abort(404, 'Provinsi tidak ditemukan dalam cakupan armada kami.');
        }

        $area = CoverageArea::where(function ($q) use ($provinceData, $province) {
            $q->where('slug', $provinceData['slug'])
              ->orWhere('slug', $province)
              ->orWhere(function ($sub) use ($provinceData) {
                  $sub->where('city', $provinceData['name'])->where('district', '[PROVINSI]');
              });
        })->first();

        if (! $area) {
            $area = new CoverageArea([
                'type' => 'province',
                'province_name' => $provinceData['name'],
                'city' => $provinceData['name'],
                'district' => '[PROVINSI]',
                'slug' => $provinceData['slug'],
                'meta_title' => "Jasa Saluran Pipa Mampet {$provinceData['name']} - Tanpa Bongkar & Garansi 30 Hari",
                'meta_description' => "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.",
                'content' => "Layanan pelancaran saluran pipa mampet profesional untuk wilayah Provinsi {$provinceData['name']}.",
                'is_active' => true,
            ]);
        }

        if ($area->meta_title) {
            $cleanTitle = PageMetadata::cleanTitle($area->meta_title);
            if (preg_match('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', $cleanTitle)) {
                $locationPart = preg_replace('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', '', $cleanTitle);
                $cleanTitle = "Jasa Saluran Pipa Mampet {$locationPart}";
                if (! str_contains(strtolower($cleanTitle), 'garansi')) {
                    $cleanTitle .= ' - Tanpa Bongkar & Garansi 30 Hari';
                }
            }
        } else {
            $cleanTitle = "Jasa Saluran Pipa Mampet {$provinceData['name']} - Tanpa Bongkar & Garansi 30 Hari";
        }

        $description = $area->meta_description ?: "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.";

        $canonicalProvinceUrl = route('area.province', ['province' => $provinceData['slug']]);
        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonicalProvinceUrl);
        SEOMeta::addKeyword([
            "jasa saluran pipa mampet {$provinceData['name']}",
            "jasa saluran mampet {$provinceData['name']}",
            "pipa mampet {$provinceData['name']}",
            "wastafel mampet {$provinceData['name']}",
            "kloset mampet {$provinceData['name']}",
            'tanpa bongkar keramik',
            'garansi 30 hari',
            'drainusantara',
        ]);

        $resolvedAreaImage = AreaImageResolver::resolveUrl($area, $provinceData['slug']);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonicalProvinceUrl);
        OpenGraph::addImage($resolvedAreaImage);

        TwitterCard::setDescription($description);
        TwitterCard::setImage($resolvedAreaImage);

        $firstCityKey = array_key_first($provinceData['cities'] ?? []);
        $provCentroid = RegionService::centroid($firstCityKey ?? 'jakarta-timur');

        JsonLdMulti::setTitle("Drainusantara Provinsi {$provinceData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            '@id' => $canonicalProvinceUrl . '#localbusiness',
            'name' => "Drainusantara Provinsi {$provinceData['name']} - Jasa Saluran Pipa Mampet",
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => $canonicalProvinceUrl,
            'image' => $resolvedAreaImage,
            'areaServed' => $provinceData['name'],
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'priceRange' => 'Mulai Rp ' . number_format($area->resolved_price, 0, ',', '.'),
            'openingHours' => 'Mo-Su 00:00-24:00',
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'address' => $this->getHeadquartersAddress(),
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $provCentroid['lat'],
                'longitude' => $provCentroid['lng'],
            ],
            'sameAs' => $this->getSameAsUrls(),
            'hasMap' => config('services.company.google_maps_url') ?: null,
            'parentOrganization' => $this->getParentOrganizationSchema(),
        ]);

        $serviceJsonLd = JsonLdMulti::newJsonLd();
        $serviceJsonLd->setType('Service');
        $serviceJsonLd->addValues([
            '@id' => route('area.province', ['province' => $province]) . '#service',
            'name' => "Jasa Saluran Pipa Mampet Provinsi {$provinceData['name']}",
            'serviceType' => 'Plumbing Service',
            'description' => "Layanan pelancaran saluran pipa wastafel, kloset toilet, dan floor drain di seluruh kota wilayah {$provinceData['name']} tanpa bongkar keramik bergaransi 30 hari.",
            'provider' => [
                '@id' => route('area.province', ['province' => $province]) . '#localbusiness',
            ],
            'areaServed' => $provinceData['name'],
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $area->resolved_price,
                'priceCurrency' => 'IDR',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => (string) $area->resolved_price,
                    'priceCurrency' => 'IDR',
                ],
            ],
        ]);

        $this->addBreadcrumb(
            ['Area Layanan', route('area.index')],
            [$provinceData['name'], route('area.province', ['province' => $province])]
        );

        $faqs = $area->resolved_faqs;
        if (! empty($faqs) && is_array($faqs)) {
            $faqJsonLd = JsonLdMulti::newJsonLd();
            $faqJsonLd->setType('FAQPage');
            $faqJsonLd->addValues([
                '@id' => route('area.province', ['province' => $province]) . '#faq',
                'mainEntity' => array_map(static fn (array $faq): array => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ], $faqs),
            ]);
        }

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });
        $reviews = Cache::remember('reviews.top3', 86400, function () {
            return Review::where('is_active', true)->latest()->take(3)->get();
        });
        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });
        $galleries = $area->getResolvedGalleries(3);
        if ($galleries->isEmpty()) {
            $galleries = Cache::remember('galleries.top3', 86400, function () {
                return Gallery::where('is_active', true)
                    ->with('service')
                    ->orderBy('order')
                    ->take(3)
                    ->get();
            });
        }
        $galleries = $this->mapGalleriesForLocation($galleries, $provinceData['name']);
        $articles = $this->getArticlesForLocation($provinceData['name'], 3);

        $nonPriorityDistrictKeys = $this->getNonPriorityDistrictKeys();
        $contextualWaMsg = "Halo Tim Drainusantara, saya ingin konsultasi layanan saluran pipa mampet untuk wilayah {$provinceData['name']}.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('areas.province', compact('provinceData', 'services', 'reviews', 'galleries', 'area', 'faqs', 'equipments', 'articles', 'resolvedAreaImage', 'nonPriorityDistrictKeys', 'contextualWaMsg', 'contextualWaUrl'));
    }

    /**
     * Display city/kabupaten level coverage area page.
     */
    public function city(string $city): View|RedirectResponse
    {
        $normalizedCity = Str::slug($city);
        $cityAliases = self::getCityAliases();

        if (isset($cityAliases[$normalizedCity]) && $cityAliases[$normalizedCity] !== $city) {
            return redirect()->route('area.city', ['city' => $cityAliases[$normalizedCity]], 301);
        }

        $cityData = RegionService::findCity($city);
        abort_unless($cityData && $city === $cityData['slug'], 404);

        $area = CoverageArea::where(function ($q) use ($cityData, $city) {
            $q->where('slug', $cityData['slug'])
              ->orWhere('slug', $city)
              ->orWhere(function ($sub) use ($cityData) {
                  $sub->where('city', $cityData['name'])
                      ->where(function ($d) {
                          $d->whereNull('district')->orWhere('district', '')->orWhere('district', '[KOTA]');
                      });
              });
        })->first();

        $searchCityName = match ($cityData['slug']) {
            'depok-cinere' => 'Depok & Cinere',
            'bekasi-cikarang' => 'Bekasi & Cikarang',
            'tangerang-kota' => 'Tangerang Kota',
            'kota-denpasar' => 'Denpasar Bali',
            default => $cityData['name'],
        };

        if (! $area) {
            $area = new CoverageArea([
                'type' => 'city',
                'province_name' => $cityData['province_name'] ?? null,
                'city' => $cityData['name'],
                'district' => '[KOTA]',
                'slug' => $cityData['slug'],
                'meta_title' => "Jasa Saluran Pipa Mampet {$searchCityName} - Tanpa Bongkar & Garansi 30 Hari",
                'meta_description' => "Jasa saluran pipa mampet di {$cityData['name']} & tukang saluran mampet panggilan 24 jam. Ahli wastafel, WC kloset tersumbat & kuras grease trap tanpa bongkar keramik pakai spiral baja rotary. Garansi 30 hari!",
                'content' => "Layanan penanganan saluran pipa mampet di seluruh wilayah {$cityData['name']} dan sekitarnya.",
                'is_active' => true,
            ]);
        }

        if ($area->meta_title) {
            $cleanTitle = PageMetadata::cleanTitle($area->meta_title);
            if (preg_match('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', $cleanTitle)) {
                $locationPart = preg_replace('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', '', $cleanTitle);
                $cleanTitle = "Jasa Saluran Pipa Mampet {$locationPart}";
                if (! str_contains(strtolower($cleanTitle), 'garansi')) {
                    $cleanTitle .= ' - Tanpa Bongkar & Garansi 30 Hari';
                }
            }
        } else {
            $cleanTitle = "Jasa Saluran Pipa Mampet {$searchCityName} - Tanpa Bongkar & Garansi 30 Hari";
        }

        $description = $area->meta_description ?: "Jasa saluran pipa mampet di {$cityData['name']} & tukang saluran mampet panggilan 24 jam. Ahli wastafel, WC kloset tersumbat & kuras grease trap tanpa bongkar keramik pakai spiral baja rotary. Garansi 30 hari!";

        $canonicalCityUrl = route('area.city', ['city' => $cityData['slug']]);
        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonicalCityUrl);
        SEOMeta::addKeyword([
            "jasa saluran pipa mampet {$searchCityName}",
            "jasa saluran mampet {$searchCityName}",
            "tukang saluran mampet {$searchCityName}",
            "tukang pipa tersumbat {$searchCityName}",
            "jasa wc mampet {$searchCityName}",
            "wastafel mampet {$searchCityName}",
            "toilet mampet {$searchCityName}",
            "saluran air kamar mandi mampet {$searchCityName}",
            "kuras grease trap {$searchCityName}",
            "ahli saluran air mampet {$searchCityName}",
            "jasa pelancaran pipa mampet terdekat {$searchCityName}",
            'tanpa bongkar keramik',
            'tanpa bobok lantai',
            'garansi 30 hari',
            'no cure no pay',
            'drainusantara',
        ]);

        $resolvedAreaImage = AreaImageResolver::resolveUrl($area, $cityData['province_slug'], $cityData['slug']);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonicalCityUrl);
        OpenGraph::addImage($resolvedAreaImage);

        TwitterCard::setDescription($description);
        TwitterCard::setImage($resolvedAreaImage);

        $resolvedCoords = $area->resolved_coordinates;
        $districtsServed = array_map(fn ($d) => [
            '@type' => 'AdministrativeArea',
            'name' => RegionService::districtType($cityData, $d)." {$d}",
        ], $cityData['districts'] ?? []);

        $jsonLdValues = [
            '@id' => route('area.city', ['city' => $cityData['slug']]) . '#localbusiness',
            'name' => "Drainusantara {$cityData['name']} - Jasa Saluran Pipa Mampet",
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => route('area.city', ['city' => $cityData['slug']]),
            'image' => $resolvedAreaImage,
            'areaServed' => ! empty($districtsServed) ? $districtsServed : "{$cityData['name']}, {$cityData['province_name']}",
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'priceRange' => 'Mulai Rp ' . number_format($area->resolved_price, 0, ',', '.'),
            'openingHours' => 'Mo-Su 00:00-24:00',
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $area->posko_address ?: ($cityData['posko_address'] ?? "Posko Armada Siaga {$cityData['name']}"),
                'addressLocality' => $cityData['name'],
                'addressRegion' => $cityData['province_name'],
                'addressCountry' => 'ID',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $resolvedCoords['lat'],
                'longitude' => $resolvedCoords['lng'],
            ],
            'sameAs' => $this->getSameAsUrls(),
            'hasMap' => config('services.company.google_maps_url') ?: null,
            'parentOrganization' => $this->getParentOrganizationSchema(),
        ];

        JsonLdMulti::setTitle("Drainusantara {$cityData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues($jsonLdValues);

        $serviceJsonLd = JsonLdMulti::newJsonLd();
        $serviceJsonLd->setType('Service');
        $serviceJsonLd->addValues([
            '@id' => route('area.city', ['city' => $cityData['slug']]) . '#service',
            'name' => "Jasa Saluran Pipa Mampet {$cityData['name']}",
            'serviceType' => 'Plumbing Service',
            'description' => "Layanan pelancaran wastafel, kloset toilet, dan saluran mampet di {$cityData['name']} tanpa bongkar keramik & garansi 30 hari.",
            'provider' => [
                '@id' => route('area.city', ['city' => $cityData['slug']]) . '#localbusiness',
            ],
            'areaServed' => $districtsServed ?: $cityData['name'],
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $area->resolved_price,
                'priceCurrency' => 'IDR',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => (string) $area->resolved_price,
                    'priceCurrency' => 'IDR',
                ],
            ],
        ]);

        $this->addBreadcrumb(
            ['Area Layanan', route('area.index')],
            [$cityData['province_name'], route('area.province', ['province' => $cityData['province_slug']])],
            [$cityData['name'], route('area.city', ['city' => $cityData['slug']])]
        );

        $faqs = $area->resolved_faqs;
        if (! empty($faqs) && is_array($faqs)) {
            $faqJsonLd = JsonLdMulti::newJsonLd();
            $faqJsonLd->setType('FAQPage');
            $faqJsonLd->addValues([
                '@id' => route('area.city', ['city' => $cityData['slug']]) . '#faq',
                'mainEntity' => array_map(static fn (array $faq): array => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ], $faqs),
            ]);
        }

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });
        $reviews = Cache::remember('reviews.top4', 86400, function () {
            return Review::where('is_active', true)->latest()->take(4)->get();
        });

        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });

        $cityMatchTokens = $this->buildCityMatchTokens($cityData);
        $galleries = $area->getResolvedGalleries(3);
        if ($galleries->isEmpty()) {
            $galleries = Cache::remember('galleries.city.v2.' . Str::slug($cityData['name']), 86400, function () use ($cityMatchTokens) {
                $cityGalleries = Gallery::where('is_active', true)
                    ->whereNotNull('slug')
                    ->with('service')
                    ->where(function ($q) use ($cityMatchTokens) {
                        foreach ($cityMatchTokens as $token) {
                            $q->orWhere('location', 'like', "%{$token}%")
                              ->orWhere('title', 'like', "%{$token}%")
                              ->orWhere('slug', 'like', '%' . Str::slug($token) . '%');
                        }
                    })
                    ->latest()
                    ->take(3)
                    ->get();

                if ($cityGalleries->count() < 3) {
                    $fallbackGalleries = Gallery::where('is_active', true)
                        ->with('service')
                        ->whereNotIn('id', $cityGalleries->pluck('id'))
                        ->orderBy('order')
                        ->latest()
                        ->take(3 - $cityGalleries->count())
                        ->get();
                    $cityGalleries = $cityGalleries->concat($fallbackGalleries);
                }

                return $cityGalleries;
            });
        }
        $galleries = $this->mapGalleriesForLocation($galleries, $cityData['name'], $cityMatchTokens);
        $articles = $this->getArticlesForLocation($cityData['name'], 3);
        $localReviews = $area->resolved_local_reviews;
        $nonPriorityDistrictKeys = $this->getNonPriorityDistrictKeys();

        $contextualWaMsg = "Halo Tim Drainusantara, saya butuh penanganan saluran pipa mampet di wilayah {$cityData['name']}. Mohon info armada terdekat.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('areas.city', compact('cityData', 'services', 'reviews', 'localReviews', 'area', 'faqs', 'equipments', 'galleries', 'articles', 'resolvedAreaImage', 'nonPriorityDistrictKeys', 'contextualWaMsg', 'contextualWaUrl'));
    }

    /**
     * Display coverage area SEO detail page (Kecamatan level).
     */
    public function area(string $city, string $district): View|RedirectResponse
    {
        $lowerCity = Str::slug($city);
        $cityAliases = self::getCityAliases();

        if (isset($cityAliases[$lowerCity]) && $cityAliases[$lowerCity] !== $city) {
            return redirect()->route('area.detail', ['city' => $cityAliases[$lowerCity], 'district' => $district], 301);
        }

        $cityData = RegionService::findCity($city);
        abort_unless($cityData && $city === $cityData['slug'], 404);

        $districtFormatted = collect($cityData['districts'])
            ->first(fn (string $name) => Str::slug($name) === $district);
        abort_unless($districtFormatted, 404);

        $cityFormatted = $cityData['name'];
        $combinedSlug = $cityData['slug'].'-'.$district;

        $area = CoverageArea::whereIn('city', [
            $cityFormatted,
            ucwords(str_replace('-', ' ', $cityData['slug'])),
        ])
            ->whereRaw('LOWER(district) = ?', [Str::lower($districtFormatted)])
            ->first();

        abort_if($area && ! $area->is_active, 404);

        // Konsolidasi 7 slug kembar & kecamatan yang dinon-prioritaskan (is_priority=false) -> 301 ke hub /area/{kota}
        if (! RegionService::isIndexableDistrict($cityData['slug'], $district, $area)) {
            return redirect()->route('area.city', ['city' => $cityData['slug']], 301);
        }

        if (! $area) {
            $area = new CoverageArea([
                'slug' => $combinedSlug,
                'city' => $cityFormatted,
                'district' => $districtFormatted,
                'meta_title' => "Jasa Saluran Pipa Mampet {$districtFormatted}, {$cityFormatted} - Tanpa Bongkar & Garansi 30 Hari",
                'meta_description' => "Jasa saluran pipa mampet di {$districtFormatted}, {$cityFormatted}. Tukang pipa & WC mampet terdekat pelancar wastafel serta saluran air tanpa bongkar keramik pakai spiral baja rotary. Siaga 24 jam & garansi 30 hari!",
                'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di area {$districtFormatted}, {$cityFormatted} dan sekitarnya.",
                'is_active' => true,
            ]);
        }

        if ($area->meta_title) {
            $cleanTitle = PageMetadata::cleanTitle($area->meta_title);
            if (preg_match('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', $cleanTitle)) {
                $locationPart = preg_replace('/^Jasa (?:Saluran )?(?:Pipa )?Mampet (?:di )?/i', '', $cleanTitle);
                $cleanTitle = "Jasa Saluran Pipa Mampet {$locationPart}";
                if (! str_contains(strtolower($cleanTitle), 'garansi')) {
                    $cleanTitle .= ' - Tanpa Bongkar & Garansi 30 Hari';
                }
            }
        } else {
            $cleanTitle = "Jasa Saluran Pipa Mampet {$area->district}, {$area->city} - Tanpa Bongkar & Garansi 30 Hari";
        }

        $description = $area->meta_description ?: "Jasa saluran pipa mampet di {$area->district}, {$area->city}. Tukang pipa & WC mampet terdekat pelancar wastafel serta saluran air tanpa bongkar keramik pakai spiral baja rotary. Siaga 24 jam & garansi 30 hari!";

        $canonicalDistrictUrl = route('area.detail', ['city' => $cityData['slug'], 'district' => $district]);
        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonicalDistrictUrl);
        $keywords = [
            "jasa saluran pipa mampet {$area->district}",
            "jasa saluran mampet {$area->district}",
            "tukang saluran mampet {$area->district}",
            "tukang pipa mampet {$area->district}",
            "tukang pipa terdekat {$area->district}",
            "jasa wc mampet {$area->district}",
            "wastafel mampet {$area->district}",
            "toilet wc mampet {$area->district}",
            "saluran air kamar mandi mampet {$area->district}",
            "saluran pipa mampet {$area->city}",
            "tukang pipa tersumbat {$area->city}",
            'tanpa bongkar keramik',
            'tanpa bobok lantai',
            'garansi 30 hari',
            'no cure no pay',
            'drainusantara',
        ];

        if (! empty($area->resolved_geo_keywords)) {
            $keywords = array_values(array_unique(array_merge($keywords, $area->resolved_geo_keywords)));
        }

        SEOMeta::addKeyword($keywords);

        $resolvedAreaImage = AreaImageResolver::resolveUrl($area, $cityData['province_slug'] ?? null, $cityData['slug'] ?? null, $area->district);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonicalDistrictUrl);
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage($resolvedAreaImage);

        TwitterCard::setDescription($description);
        TwitterCard::setImage($resolvedAreaImage);

        $provinceSlug = $cityData['province_slug'] ?? 'dki-jakarta';
        $provinceName = $cityData['province_name'] ?? 'DKI Jakarta';

        $resolvedCoords = $area->resolved_coordinates;
        $districtLabel = RegionService::districtType($cityData, $area->district)." {$area->district}";

        JsonLdMulti::setTitle("Drainusantara - Area {$area->district}, {$area->city}");
        JsonLdMulti::setDescription($description);
        $jsonLdValues = [
            '@id' => $canonicalDistrictUrl . '#localbusiness',
            'name' => "Drainusantara {$area->district} - Jasa Saluran Pipa Mampet",
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => $canonicalDistrictUrl,
            'image' => $resolvedAreaImage,
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'priceRange' => 'Mulai Rp ' . number_format($area->resolved_price, 0, ',', '.'),
            'openingHours' => 'Mo-Su 00:00-24:00',
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => $districtLabel,
                'containedInPlace' => [
                    '@type' => 'City',
                    'name' => $area->city,
                ],
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $area->posko_address ?: "Area {$area->district}, {$area->city}",
                'addressLocality' => $area->district,
                'addressRegion' => $provinceName,
                'postalCode' => $area->postal_code ?: null,
                'addressCountry' => 'ID',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $resolvedCoords['lat'],
                'longitude' => $resolvedCoords['lng'],
            ],
            'sameAs' => $this->getSameAsUrls(),
            'hasMap' => config('services.company.google_maps_url') ?: null,
            'parentOrganization' => $this->getParentOrganizationSchema(),
        ];

        if (! empty($area->posko_name)) {
            $jsonLdValues['serviceArea'] = [
                '@type' => 'GeoCircle',
                'geoMidpoint' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => $resolvedCoords['lat'],
                    'longitude' => $resolvedCoords['lng'],
                ],
                'geoRadius' => 15000,
            ];
        }

        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues($jsonLdValues);

        $serviceJsonLd = JsonLdMulti::newJsonLd();
        $serviceJsonLd->setType('Service');
        $serviceJsonLd->addValues([
            '@id' => route('area.detail', ['city' => $city, 'district' => $district]) . '#service',
            'name' => "Jasa Saluran Pipa Mampet {$area->district}, {$area->city}",
            'serviceType' => 'Plumbing Service',
            'description' => "Penanganan saluran pipa wastafel, kloset toilet, dan floor drain di area {$area->district}, {$area->city} dengan mesin spiral rotary tanpa bongkar keramik bergaransi 30 hari.",
            'provider' => [
                '@id' => route('area.detail', ['city' => $city, 'district' => $district]) . '#localbusiness',
            ],
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => $districtLabel,
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $area->resolved_price,
                'priceCurrency' => 'IDR',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => (string) $area->resolved_price,
                    'priceCurrency' => 'IDR',
                ],
            ],
        ]);

        $this->addBreadcrumb(
            ['Area Layanan', route('area.index')],
            [$provinceName, route('area.province', ['province' => $provinceSlug])],
            [$area->city, route('area.city', ['city' => Str::slug($city)])],
            [$area->district, route('area.detail', ['city' => $city, 'district' => $district])]
        );

        $faqs = $area->resolved_faqs;
        if (! empty($faqs) && is_array($faqs)) {
            $faqJsonLd = JsonLdMulti::newJsonLd();
            $faqJsonLd->setType('FAQPage');
            $faqJsonLd->addValues([
                '@id' => route('area.detail', ['city' => $city, 'district' => $district]) . '#faq',
                'mainEntity' => array_map(static fn (array $faq): array => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ], $faqs),
            ]);
        }

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });

        $reviews = Cache::remember('reviews.top3', 86400, function () {
            return Review::where('is_active', true)->latest()->take(3)->get();
        });

        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });

        $galleries = $area->getResolvedGalleries(3);
        if ($galleries->isEmpty()) {
            $cacheKey = 'galleries.district.' . Str::slug($area->city . '-' . $area->district);
            $galleries = Cache::remember($cacheKey, 86400, function () use ($area) {
                $districtGalleries = Gallery::where('is_active', true)
                    ->with('service')
                    ->where(function ($q) use ($area) {
                        $q->where('location', 'like', "%{$area->district}%")
                          ->orWhere('location', 'like', "%{$area->city}%");
                    })
                    ->latest()
                    ->take(3)
                    ->get();

                if ($districtGalleries->count() < 3) {
                    $fallbackGalleries = Gallery::where('is_active', true)
                        ->with('service')
                        ->whereNotIn('id', $districtGalleries->pluck('id'))
                        ->orderBy('order')
                        ->latest()
                        ->take(3 - $districtGalleries->count())
                        ->get();
                    $districtGalleries = $districtGalleries->concat($fallbackGalleries);
                }

                return $districtGalleries;
            });
        }
        $galleries = $this->mapGalleriesForLocation($galleries, "{$area->district}, {$area->city}", [$area->district, $area->city]);
        $articles = $this->getArticlesForLocation($area->city, 3);
        $localReviews = $area->resolved_local_reviews;
        $nonPriorityDistrictKeys = $this->getNonPriorityDistrictKeys();

        $contextualWaMsg = "Halo Tim Drainusantara, saya membutuhkan jasa pelancaran pipa mampet di area Kecamatan {$area->district}, {$area->city}. Mohon info estimasi biaya dan teknisi terdekat.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('areas.district', compact('area', 'services', 'reviews', 'localReviews', 'cityData', 'equipments', 'galleries', 'articles', 'resolvedAreaImage', 'nonPriorityDistrictKeys', 'contextualWaMsg', 'contextualWaUrl'));
    }

    /**
     * Load map of "citySlug|districtSlug" keys explicitly set to is_priority = false in CMS.
     *
     * @return array<string, bool>
     */
    private function getNonPriorityDistrictKeys(): array
    {
        $map = [];
        try {
            $rows = CoverageArea::where('type', 'district')
                ->where('is_priority', false)
                ->get(['city', 'district']);

            foreach ($rows as $row) {
                $cData = RegionService::findCity((string) $row->city);
                $cSlug = $cData['slug'] ?? Str::slug((string) $row->city);
                $map[$cSlug . '|' . Str::slug((string) $row->district)] = true;
            }
        } catch (\Throwable) {
            // Graceful fallback
        }

        return $map;
    }

    /**
     * Build rich search tokens for a city hub (handles compound names, aliases, and districts).
     *
     * @param  array<string, mixed>  $cityData
     * @return array<int, string>
     */
    private function buildCityMatchTokens(array $cityData): array
    {
        $tokens = [];
        $cityName = (string) ($cityData['name'] ?? '');
        $citySlug = (string) ($cityData['slug'] ?? '');

        if ($cityName !== '') {
            $tokens[] = $cityName;
            $pure = trim((string) preg_replace('/^(?:Kota|Kabupaten)\s+/i', '', $cityName));
            if ($pure !== '') {
                $tokens[] = $pure;
            }
            foreach (preg_split('/\s*[&\/]\s*/', $pure) ?: [] as $part) {
                $part = trim($part);
                if (mb_strlen($part) >= 4) {
                    $tokens[] = $part;
                }
            }
        }

        $aliasMap = [
            'tangerang-selatan' => ['Tangsel', 'BSD', 'Serpong', 'Bintaro', 'Gading Serpong'],
            'jakarta-selatan' => ['Jaksel', 'SCBD', 'Blok M', 'Senopati', 'Pejaten'],
            'jakarta-utara' => ['Jakut', 'PIK', 'Kapuk', 'Kelapa Gading', 'Pademangan'],
            'jakarta-timur' => ['Jaktim', 'Cibubur', 'Cawang', 'Condet'],
            'jakarta-barat' => ['Jakbar', 'Tanjung Duren', 'Puri'],
            'jakarta-pusat' => ['Jakpus', 'Cideng'],
            'depok-cinere' => ['Depok', 'Cinere', 'Kelapa Dua'],
            'bekasi-cikarang' => ['Bekasi', 'Cikarang', 'Jatisampurna'],
            'bogor' => ['Bogor', 'Sentul', 'Gunung Putri'],
        ];

        foreach ($aliasMap[$citySlug] ?? [] as $alias) {
            $tokens[] = $alias;
        }

        foreach ($cityData['districts'] ?? [] as $dist) {
            if (mb_strlen((string) $dist) >= 4) {
                $tokens[] = (string) $dist;
            }
        }

        return array_values(array_unique(array_filter($tokens)));
    }

    /**
     * Map gallery items to ensure no geographic dissonance on non-local pages.
     *
     * @param  \Illuminate\Support\Collection<int, \App\Models\Gallery>  $galleries
     * @param  array<int, string>  $matchTokens
     * @return \Illuminate\Support\Collection<int, \App\Models\Gallery>
     */
    private function mapGalleriesForLocation(Collection $galleries, string $locationName, array $matchTokens = []): Collection
    {
        $pureLoc = strtolower(trim(str_ireplace(['kota', 'kabupaten', '[kota]', '[provinsi]'], '', $locationName)));
        $displayLoc = trim(str_ireplace(['[KOTA]', '[PROVINSI]'], '', $locationName)) ?: 'Nasional';
        $lowerTokens = array_values(array_filter(array_map(
            static fn (string $t): string => strtolower(trim($t)),
            array_merge($pureLoc !== '' ? [$pureLoc] : [], $matchTokens)
        )));

        return $galleries->map(function ($g) use ($lowerTokens, $displayLoc) {
            $haystack = strtolower(trim(implode(' ', [
                (string) ($g->location ?? ''),
                (string) ($g->title ?? ''),
                str_replace('-', ' ', (string) ($g->slug ?? '')),
            ])));

            $isLocal = false;
            foreach ($lowerTokens as $tok) {
                if (mb_strlen($tok) >= 3 && str_contains($haystack, $tok)) {
                    $isLocal = true;
                    break;
                }
            }

            if ($isLocal) {
                $g->display_location = $g->location ?: $displayLoc;
                $g->display_title = $g->title;
            } else {
                $g->display_location = "Standar Layanan Drainusantara {$displayLoc}";
                $serviceName = $g->service ? trim($g->service->name) : 'Pipa Saluran';
                $cleanService = preg_replace('/^pelancaran\s+/i', '', $serviceName);
                $g->display_title = "Studi Kasus Layanan {$displayLoc}: Pelancaran {$cleanService} Tanpa Bongkar";
            }

            return $g;
        });
    }

    /**
     * Get prioritized articles matching the local city, backfilled to $limit with latest articles.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\Article>
     */
    private function getArticlesForLocation(string $cityName, int $limit = 3): Collection
    {
        $cacheKey = 'area.articles.' . Str::slug($cityName) . '.' . $limit;

        return Cache::remember($cacheKey, 86400, function () use ($cityName, $limit) {
            $pureCity = trim(str_ireplace(['kota', 'kabupaten', '[kota]', '[provinsi]'], '', $cityName));

            // Prioritas 1: Artikel lokal yang relevan dengan kota aktif
            $localArticles = Article::indexable()
                ->with(['categoryRelation', 'subcategoryRelation'])
                ->where(function ($q) use ($pureCity, $cityName) {
                    $q->where('title', 'like', "%{$pureCity}%")
                        ->orWhere('slug', 'like', "%{$pureCity}%")
                        ->orWhere('content', 'like', "%{$pureCity}%");
                    if ($pureCity !== $cityName && ! empty($pureCity)) {
                        $q->orWhere('title', 'like', "%{$cityName}%")
                            ->orWhere('slug', 'like', "%{$cityName}%");
                    }
                })
                ->orderByRaw('COALESCE(published_at, created_at) DESC')
                ->latest('id')
                ->take($limit)
                ->get();

            if ($localArticles->count() < $limit) {
                // Daftar keyword kota lain yang harus di-exclude dari artikel edukasi umum
                $allCityKeywords = [
                    'jakarta', 'jaksel', 'jaktim', 'jakbar', 'jakpus', 'jakut',
                    'bogor', 'depok', 'tangerang', 'tangsel', 'bekasi', 'cikarang', 'cinere',
                    'bandung', 'cimahi',
                    'semarang', 'demak', 'ungaran',
                    'lampung',
                    'bali', 'denpasar', 'badung', 'gianyar', 'tabanan',
                ];

                $excludeKeywords = array_values(array_filter($allCityKeywords, function ($k) use ($pureCity) {
                    return ! str_contains(strtolower($pureCity), $k);
                }));

                // Prioritas 2: Artikel edukasi umum yang TIDAK memuat nama kota lain di title/slug
                $generalEducational = Article::indexable()
                    ->with(['categoryRelation', 'subcategoryRelation'])
                    ->whereNotIn('id', $localArticles->pluck('id'))
                    ->where(function ($q) use ($excludeKeywords) {
                        foreach ($excludeKeywords as $keyword) {
                            $q->where('title', 'not like', "%{$keyword}%")
                              ->where('slug', 'not like', "%{$keyword}%");
                        }
                    })
                    ->orderByRaw('COALESCE(published_at, created_at) DESC')
                    ->latest('id')
                    ->take($limit - $localArticles->count())
                    ->get();

                $localArticles = $localArticles->concat($generalEducational);
            }

            return $localArticles;
        });
    }
}
