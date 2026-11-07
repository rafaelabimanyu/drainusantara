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
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    use HasPageSeo;

    /**
     * Display all provinces and cities coverage directory.
     */
    public function areasIndex(): View
    {
        PageMetadata::title('Wilayah Jangkauan Teknisi Pipa Mampet');
        SEOMeta::setDescription('Daftar jangkauan posko siaga teknisi pipa mampet Drainusantara di Jabodetabek, Semarang, & Lampung. Siaga 24 jam respon cepat & garansi 30 hari.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Wilayah Jangkauan Layanan Drainusantara');
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => 'Drainusantara - Wilayah Jangkauan Layanan',
            'url' => route('area.index'),
            'image' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
            'telephone' => $this->formatInternationalPhone(),
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
            'priceRange' => 'Mulai Rp 400.000',
        ]);

        $this->addBreadcrumb(['Area Layanan', route('area.index')]);

        $provinces = RegionService::all();
        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });

        return view('areas.index', compact('provinces', 'services'));
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
                'meta_title' => "Jasa Saluran Mampet {$provinceData['name']}",
                'meta_description' => "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.",
                'content' => "Layanan pelancaran saluran pipa mampet profesional untuk wilayah Provinsi {$provinceData['name']}.",
                'is_active' => true,
            ]);
        }

        $rawTitle = $area->meta_title ?: "Jasa Saluran Mampet {$provinceData['name']}";
        $cleanTitle = PageMetadata::cleanTitle($rawTitle);
        $description = $area->meta_description ?: "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.";

        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            "jasa saluran mampet {$provinceData['name']}",
            "pipa mampet {$provinceData['name']}",
            "wastafel mampet {$provinceData['name']}",
            "kloset mampet {$provinceData['name']}",
            'tanpa bongkar keramik',
            'garansi 30 hari',
        ]);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        $firstCityKey = array_key_first($provinceData['cities'] ?? []);
        $provCentroid = RegionService::centroid($firstCityKey ?? 'jakarta-timur');

        JsonLdMulti::setTitle("Drainusantara Provinsi {$provinceData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => "Drainusantara Provinsi {$provinceData['name']}",
            'url' => url()->current(),
            'image' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
            'areaServed' => $provinceData['name'],
            'telephone' => $this->formatInternationalPhone(),
            'priceRange' => 'Mulai Rp ' . number_format($area->resolved_price, 0, ',', '.'),
            'openingHours' => 'Mo-Su 00:00-24:00',
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => 65,
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $provCentroid['lat'],
                'longitude' => $provCentroid['lng'],
            ],
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'PT JAWA JAYA ROOTER',
                'url' => url('/'),
            ],
        ]);

        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Area Layanan', 'item' => route('area.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $provinceData['name'], 'item' => route('area.province', ['province' => $province])],
            ],
        ]);

        $faqs = $area->resolved_faqs;
        if (! empty($faqs)) {
            $faqSchema = JsonLdMulti::newJsonLd();
            $faqSchema->setType('FAQPage');
            $faqSchema->addValues([
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

        $articles = Article::published()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->latest('id')
            ->take(3)
            ->get();

        return view('areas.province', compact('provinceData', 'services', 'reviews', 'galleries', 'area', 'faqs', 'equipments', 'articles'));
    }

    /**
     * Display city/kabupaten level coverage area page.
     */
    public function city(string $city): View|RedirectResponse
    {
        $normalizedCity = Str::slug($city);
        $cityAliases = [
            'jaksel' => 'jakarta-selatan',
            'jaktim' => 'jakarta-timur',
            'jakbar' => 'jakarta-barat',
            'jakut' => 'jakarta-utara',
            'jakpus' => 'jakarta-pusat',
            'tangsel' => 'tangerang-selatan',
            'tangerang' => 'tangerang-kota',
            'depok' => 'depok-cinere',
            'bekasi' => 'bekasi-cikarang',
            'cikarang' => 'bekasi-cikarang',
            'kota-semarang' => 'semarang',
            'kota-bandung' => 'bandung',
        ];

        if (isset($cityAliases[$normalizedCity])) {
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

        if (! $area) {
            $area = new CoverageArea([
                'type' => 'city',
                'province_name' => $cityData['province_name'] ?? null,
                'city' => $cityData['name'],
                'district' => '[KOTA]',
                'slug' => $cityData['slug'],
                'meta_title' => "Jasa Pipa Mampet {$cityData['name']}",
                'meta_description' => "Jasa pelancaran wastafel, kloset toilet, dan saluran mampet di {$cityData['name']} tanpa bongkar keramik & garansi 30 hari. Hubungi teknisi terdekat sekarang!",
                'content' => "Layanan penanganan saluran pipa mampet di seluruh wilayah {$cityData['name']} dan sekitarnya.",
                'is_active' => true,
            ]);
        }

        $rawTitle = $area->meta_title ?: "Jasa Pipa Mampet {$cityData['name']}";
        $cleanTitle = PageMetadata::cleanTitle($rawTitle);
        $description = $area->meta_description ?: "Pelancaran wastafel, kloset, & floor drain mampet di {$cityData['name']} tanpa bongkar keramik. Layanan respons chat sigap via WhatsApp, garansi resmi 30 hari.";

        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            "jasa saluran mampet {$cityData['name']}",
            "pipa mampet {$cityData['name']}",
            "wastafel mampet {$cityData['name']}",
            "toilet mampet {$cityData['name']}",
            "sedot lemak {$cityData['name']}",
            'tanpa bongkar keramik',
            'garansi 30 hari',
        ]);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        $resolvedCoords = $area->resolved_coordinates;
        $districtsServed = array_map(fn ($d) => [
            '@type' => 'AdministrativeArea',
            'name' => "Kecamatan {$d}",
        ], $cityData['districts'] ?? []);

        $jsonLdValues = [
            'name' => "Drainusantara {$cityData['name']}",
            'url' => url()->current(),
            'image' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
            'areaServed' => !empty($districtsServed) ? $districtsServed : "{$cityData['name']}, {$cityData['province_name']}",
            'telephone' => $this->formatInternationalPhone(),
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
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => 48,
                'bestRating' => '5',
                'worstRating' => '1',
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
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'PT JAWA JAYA ROOTER',
                'url' => url('/'),
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Layanan Pelancaran Pipa Mampet',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Pelancaran Saluran Pipa Tanpa Bongkar',
                            'description' => "Penanganan wastafel, kloset, dan floor drain di seluruh wilayah {$cityData['name']}.",
                        ],
                        'priceSpecification' => [
                            '@type' => 'PriceSpecification',
                            'price' => $area->resolved_price,
                            'priceCurrency' => 'IDR',
                        ],
                    ],
                ],
            ],
        ];

        JsonLdMulti::setTitle("Drainusantara {$cityData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues($jsonLdValues);

        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Area Layanan', 'item' => route('area.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $cityData['province_name'], 'item' => route('area.province', ['province' => $cityData['province_slug']])],
                ['@type' => 'ListItem', 'position' => 4, 'name' => $cityData['name'], 'item' => route('area.city', ['city' => $cityData['slug']])],
            ],
        ]);

        $faqs = $area->resolved_faqs;
        if (! empty($faqs)) {
            $faqSchema = JsonLdMulti::newJsonLd();
            $faqSchema->setType('FAQPage');
            $faqSchema->addValues([
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

        $galleries = $area->getResolvedGalleries(3);
        if ($galleries->isEmpty()) {
            $galleries = Gallery::where('is_active', true)
                ->with('service')
                ->where('location', 'like', "%{$cityData['name']}%")
                ->latest()
                ->take(3)
                ->get();

            if ($galleries->count() < 3) {
                $fallbackGalleries = Gallery::where('is_active', true)
                    ->with('service')
                    ->whereNotIn('id', $galleries->pluck('id'))
                    ->orderBy('order')
                    ->latest()
                    ->take(3 - $galleries->count())
                    ->get();
                $galleries = $galleries->concat($fallbackGalleries);
            }
        }

        $articles = Article::published()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->latest('id')
            ->take(3)
            ->get();

        return view('areas.city', compact('cityData', 'services', 'reviews', 'area', 'faqs', 'equipments', 'galleries', 'articles'));
    }

    /**
     * Display coverage area SEO detail page (Kecamatan level).
     */
    public function area(string $city, string $district): View|RedirectResponse
    {
        $cityAliases = [
            'jaksel' => 'jakarta-selatan',
            'jaktim' => 'jakarta-timur',
            'jakut' => 'jakarta-utara',
            'jakpus' => 'jakarta-pusat',
            'jakbar' => 'jakarta-barat',
            'tangsel' => 'tangerang-selatan',
            'tangerang' => 'tangerang-kota',
            'depok' => 'depok-cinere',
            'bekasi' => 'bekasi-cikarang',
            'cikarang' => 'bekasi-cikarang',
            'semarang' => 'semarang',
            'kota-semarang' => 'semarang',
            'kota-bandung' => 'bandung',
            'lampung' => 'bandar-lampung',
        ];

        $lowerCity = strtolower($city);
        if (isset($cityAliases[$lowerCity]) && $cityAliases[$lowerCity] !== $lowerCity) {
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

        if (! $area) {
            $area = new CoverageArea([
                'slug' => $combinedSlug,
                'city' => $cityFormatted,
                'district' => $districtFormatted,
                'meta_title' => "Jasa Saluran Mampet {$districtFormatted}, {$cityFormatted}",
                'meta_description' => "Jasa pipa mampet wastafel, toilet, & talang air di {$districtFormatted}, {$cityFormatted}. Tanpa bongkar keramik pakai spiral baja, respons chat via WhatsApp & garansi 30 hari.",
                'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di area {$districtFormatted}, {$cityFormatted} dan sekitarnya.",
                'is_active' => true,
            ]);
        }

        $rawTitle = $area->meta_title ?: "Jasa Saluran Mampet {$area->district}, {$area->city}";
        $cleanTitle = PageMetadata::cleanTitle($rawTitle);
        $cleanTitle = preg_replace('/^Jasa Saluran Mampet di /i', 'Jasa Saluran Mampet ', $cleanTitle);
        $description = $area->meta_description ?: "Jasa pipa mampet wastafel, toilet, & talang air di {$area->district}, {$area->city}. Tanpa bongkar keramik pakai spiral baja, respons chat via WhatsApp & garansi 30 hari.";

        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        $keywords = [
            "jasa saluran mampet {$area->district}",
            "pipa mampet {$area->district}",
            "wastafel mampet {$area->district}",
            "toilet wc mampet {$area->district}",
            "saluran mampet {$area->city}",
            'tanpa bongkar keramik',
            'garansi 30 hari',
            'drainusantara',
        ];

        if (! empty($area->geo_keywords)) {
            $extraKeywords = array_filter(array_map('trim', explode(',', $area->geo_keywords)));
            $keywords = array_merge($keywords, $extraKeywords);
        }

        SEOMeta::addKeyword($keywords);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        $cityData = RegionService::findCity($city);
        $provinceSlug = $cityData['province_slug'] ?? 'dki-jakarta';
        $provinceName = $cityData['province_name'] ?? 'DKI Jakarta';

        $resolvedCoords = $area->resolved_coordinates;

        JsonLdMulti::setTitle("Drainusantara - Area {$area->district}, {$area->city}");
        JsonLdMulti::setDescription($description);
        $jsonLdValues = [
            'name' => "Drainusantara {$area->district}",
            'url' => url()->current(),
            'image' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
            'telephone' => $this->formatInternationalPhone(),
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
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => 38,
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => "Kecamatan {$area->district}",
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
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'PT JAWA JAYA ROOTER',
                'url' => url('/'),
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Layanan Pelancaran Pipa Mampet',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Pelancaran Saluran Pipa Tanpa Bongkar',
                            'description' => "Penanganan wastafel, kloset, dan floor drain di {$area->district} dengan mesin spiral rotary.",
                        ],
                        'priceSpecification' => [
                            '@type' => 'PriceSpecification',
                            'price' => $area->resolved_price,
                            'priceCurrency' => 'IDR',
                        ],
                    ],
                ],
            ],
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

        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Area Layanan', 'item' => route('area.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $provinceName, 'item' => route('area.province', ['province' => $provinceSlug])],
                ['@type' => 'ListItem', 'position' => 4, 'name' => $area->city, 'item' => route('area.city', ['city' => Str::slug($city)])],
                ['@type' => 'ListItem', 'position' => 5, 'name' => $area->district, 'item' => route('area.detail', ['city' => $city, 'district' => $district])],
            ],
        ]);

        $faqs = $area->resolved_faqs;
        if (! empty($faqs)) {
            $faqSchema = JsonLdMulti::newJsonLd();
            $faqSchema->setType('FAQPage');
            $faqSchema->addValues([
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
            $galleries = Gallery::where('is_active', true)
                ->with('service')
                ->where(function ($q) use ($area) {
                    $q->where('location', 'like', "%{$area->district}%")
                      ->orWhere('location', 'like', "%{$area->city}%");
                })
                ->latest()
                ->take(3)
                ->get();

            if ($galleries->count() < 3) {
                $fallbackGalleries = Gallery::where('is_active', true)
                    ->with('service')
                    ->whereNotIn('id', $galleries->pluck('id'))
                    ->orderBy('order')
                    ->latest()
                    ->take(3 - $galleries->count())
                    ->get();
                $galleries = $galleries->concat($fallbackGalleries);
            }
        }

        $articles = Article::published()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->latest('id')
            ->take(3)
            ->get();

        return view('areas.district', compact('area', 'services', 'reviews', 'cityData', 'equipments', 'galleries', 'articles'));
    }
}

