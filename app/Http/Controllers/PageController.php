<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Models\Staff;
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display the Drainusantara landing page.
     */
    public function index(): View
    {
        PageMetadata::title('Jasa Saluran Pipa Mampet Tanpa Bongkar');
        SEOMeta::setDescription('Jasa pelancar saluran pipa mampet wastafel & kloset tanpa bongkar keramik di Jabodetabek, Semarang & Lampung. Mesin spiral baja, garansi 30 hari.');
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            'jasa saluran pipa mampet',
            'pelancar pipa tersumbat',
            'tanpa bongkar keramik',
            'drain cleaner rooter',
            'jasa wastafel mampet',
            'jasa kloset mampet',
            'inspeksi cctv pipa',
            'garansi 30 hari',
            'drainusantara',
            'jabodetabek',
            'semarang',
            'bandar lampung',
        ]);

        OpenGraph::setDescription('Layanan pelancar pipa mampet wastafel & kloset pakai mesin spiral baja tanpa bongkar keramik, garansi nota 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Pelancar saluran wastafel & kloset tanpa bongkar keramik di Jabodetabek, Semarang & Lampung. Bergaransi 30 hari.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        JsonLdMulti::setDescription('Jasa pelancaran saluran pipa mampet profesional, mesin rooter spiral baja, dan inspeksi kamera CCTV pipa bergaransi 30 hari.');
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => 'Drainusantara',
            'telephone' => $this->formatInternationalPhone(),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung'],
            'serviceType' => [
                'Pelancaran Saluran Mampet',
                'Inspeksi Kamera CCTV Pipa',
                'Pelancaran Kloset & WC',
                'Pelancaran Wastafel & Sink',
                'Pembersihan Lemak Pipa',
            ],
        ]);

        $services = Cache::remember('landing.services', 86400, function () {
            return Service::where('is_active', true)
                ->orderBy('order')
                ->get();
        });

        $reviews = Cache::remember('landing.reviews', 86400, function () {
            return Review::where('is_active', true)
                ->latest()
                ->take(6)
                ->get();
        });

        $galleries = Cache::remember('landing.galleries', 86400, function () {
            return Gallery::where('is_active', true)
                ->with('service')
                ->orderBy('order')
                ->take(4)
                ->get();
        });

        $articles = Cache::remember('landing.articles', 86400, function () {
            return Article::where('is_published', true)
                ->latest('published_at')
                ->latest()
                ->take(3)
                ->get();
        });

        $portfolios = Cache::remember('landing.portfolios', 86400, function () {
            return Portfolio::where('is_active', true)
                ->orderBy('order')
                ->get();
        });

        return view('welcome', compact('services', 'reviews', 'galleries', 'articles', 'portfolios'));
    }

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
            'telephone' => $this->formatInternationalPhone(),
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung'],
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

        $title = "Jasa Saluran Mampet {$provinceData['name']}";
        $description = "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.";

        PageMetadata::title($title);
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

        JsonLdMulti::setTitle("Drainusantara Provinsi {$provinceData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => "Drainusantara Provinsi {$provinceData['name']}",
            'areaServed' => $provinceData['name'],
            'telephone' => $this->formatInternationalPhone(),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
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

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });
        $reviews = Cache::remember('reviews.top3', 86400, function () {
            return Review::where('is_active', true)->latest()->take(3)->get();
        });
        $galleries = Cache::remember('galleries.top3', 86400, function () {
            return Gallery::where('is_active', true)
                ->with('service')
                ->orderBy('order')
                ->take(3)
                ->get();
        });

        return view('areas.province', compact('provinceData', 'services', 'reviews', 'galleries'));
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

        $title = "Jasa Pipa Mampet {$cityData['name']}";
        $description = "Pelancaran wastafel, kloset, & floor drain mampet di {$cityData['name']} tanpa bongkar keramik. Layanan respons chat sigap via WhatsApp, garansi resmi 30 hari.";

        PageMetadata::title($title);
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

        JsonLdMulti::setTitle("Drainusantara {$cityData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => "Drainusantara {$cityData['name']}",
            'areaServed' => "{$cityData['name']}, {$cityData['province_name']}",
            'telephone' => $this->formatInternationalPhone(),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $cityData['name'],
                'addressRegion' => $cityData['province_name'],
                'addressCountry' => 'ID',
            ],
        ]);

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

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });
        $reviews = Cache::remember('reviews.top4', 86400, function () {
            return Review::where('is_active', true)->latest()->take(4)->get();
        });

        return view('areas.city', compact('cityData', 'services', 'reviews'));
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
        SEOMeta::addKeyword([
            "jasa saluran mampet {$area->district}",
            "pipa mampet {$area->district}",
            "wastafel mampet {$area->district}",
            "toilet wc mampet {$area->district}",
            "saluran mampet {$area->city}",
            'tanpa bongkar keramik',
            'garansi 30 hari',
            'drainusantara',
        ]);

        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle("Drainusantara - Area {$area->district}, {$area->city}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            'name' => "Drainusantara {$area->district}",
            'areaServed' => "{$area->district}, {$area->city}",
            'telephone' => $this->formatInternationalPhone(),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $area->district,
                'addressRegion' => $area->city,
                'addressCountry' => 'ID',
            ],
        ]);

        $cityData = RegionService::findCity($city);
        $provinceSlug = $cityData['province_slug'] ?? 'dki-jakarta';
        $provinceName = $cityData['province_name'] ?? 'DKI Jakarta';

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

        $services = Cache::remember('services.all_active', 86400, function () {
            return Service::where('is_active', true)->orderBy('order')->get();
        });

        $reviews = Cache::remember('reviews.top3', 86400, function () {
            return Review::where('is_active', true)->latest()->take(3)->get();
        });

        return view('areas.district', compact('area', 'services', 'reviews', 'cityData'));
    }

    /**
     * Display the Gallery & Portfolio page.
     */
    public function gallery(): View
    {
        PageMetadata::title('Dokumentasi Hasil Pengerjaan Pipa Mampet');
        SEOMeta::setDescription('Dokumentasi foto teknis pelancaran saluran pipa tersumbat sektor rumahan dan komersial B2B. Inspeksi visual kamera CCTV pipa 30 meter tanpa bongkar keramik.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setDescription('Hasil nyata pelancaran pipa mampet dengan mesin spiral mekanis berstandar profesional. Tanpa bongkar keramik dan bergaransi 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Hasil nyata pelancaran pipa mampet dengan mesin spiral mekanis. Tanpa bongkar keramik, garansi nota 30 hari.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Galeri Pengerjaan Saluran Pipa Mampet - Drainusantara');
        JsonLdMulti::setDescription('Dokumentasi proyek pengerjaan pembersihan pipa tersumbat dan inspeksi CCTV pipa.');
        JsonLdMulti::setType('Plumber');
        $this->addBreadcrumb(['Galeri', route('gallery')]);

        $galleries = Cache::remember('galleries.all_active', 86400, function () {
            return Gallery::where('is_active', true)
                ->with('service')
                ->orderBy('order')
                ->latest()
                ->get();
        });

        return view('gallery', compact('galleries'));
    }

    /**
     * Display the Articles & Education listing page.
     */
    public function articles(): View
    {
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $canonical = route('articles.index', $page > 1 ? ['page' => $page] : []);
        PageMetadata::title('Panduan & Edukasi Perawatan Saluran Pipa');
        SEOMeta::setDescription('Kumpulan artikel teknis: cara melancarkan wastafel, bahaya soda api pada pipa PVC cor, dan perawatan sanitasi rumah tangga tanpa bongkar keramik.');
        SEOMeta::setCanonical($canonical);

        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl($canonical);
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addBreadcrumb(['Pengetahuan & Edukasi', route('articles.index')]);

        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        $featuredArticle = Article::where('is_published', true)
            ->latest('published_at')
            ->first();

        return view('articles.index', compact('articles', 'featuredArticle'));
    }

    /**
     * Display the Article Detail page.
     */
    public function articleDetail(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $rawTitle = $article->meta_title ?: $article->title;
        $cleanTitle = PageMetadata::cleanTitle($rawTitle);
        $metaDescription = $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 150));
        $thumbnailUrl = $article->thumbnail ? (filter_var($article->thumbnail, FILTER_VALIDATE_URL) ? $article->thumbnail : asset($article->thumbnail)) : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');

        PageMetadata::title($cleanTitle);
        SEOMeta::setDescription($metaDescription);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addImage($thumbnailUrl);

        TwitterCard::setDescription($metaDescription);
        TwitterCard::setImage($thumbnailUrl);

        JsonLdMulti::setTitle($cleanTitle);
        JsonLdMulti::setDescription($metaDescription);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addValues([
            'headline' => $article->title,
            'datePublished' => $article->published_at?->toIso8601String() ?? $article->created_at->toIso8601String(),
            'dateModified' => $article->updated_at->toIso8601String(),
            'image' => $thumbnailUrl,
            'author' => [
                '@type' => 'Person',
                'name' => 'Tim Ahli Drainusantara',
                'jobTitle' => 'Spesialis Drainase & Pemipaan',
                'worksFor' => [
                    '@type' => 'Organization',
                    'name' => 'Drainusantara',
                    'url' => url('/'),
                ],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
                ],
            ],
            'articleSection' => $article->category ?? 'Tips & Edukasi',
            'inLanguage' => 'id-ID',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
        ]);

        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Pengetahuan & Edukasi', 'item' => route('articles.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $article->title, 'item' => url()->current()],
            ],
        ]);

        $prevArticle = Article::where('is_published', true)
            ->where('published_at', '<', $article->published_at ?? $article->created_at)
            ->orderByDesc('published_at')
            ->first();

        $nextArticle = Article::where('is_published', true)
            ->where('published_at', '>', $article->published_at ?? $article->created_at)
            ->orderBy('published_at')
            ->first();

        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $fallback = Article::where('is_published', true)
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->concat($fallback);
        }

        $recentArticles = $relatedArticles;

        return view('articles.show', compact('article', 'recentArticles', 'relatedArticles', 'prevArticle', 'nextArticle'));
    }

    /**
     * Generate dynamic sitemap.xml for all public indexable routes.
     */
    public function sitemap(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = [];
            // ponytail: omit lastmod without tracked content history; add it when dates are recorded.

            // Core static pages
            $urls[] = ['loc' => url('/'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '1.0'];
            $urls[] = ['loc' => route('about.profile'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.holding'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.k3'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.equipment'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.portfolio'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.warranty'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.faq'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => url('/area'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.9'];
            $urls[] = ['loc' => url('/galeri'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => url('/pengetahuan'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '0.8'];

            // Regional landing routes
            $provinces = RegionService::all();
            $coverageAreas = CoverageArea::orderBy('id')->get();
            foreach ($provinces as $provSlug => $prov) {
                $urls[] = [
                    'loc' => route('area.province', ['province' => $provSlug]),
                    'lastmod' => null,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];

                foreach ($prov['cities'] as $citySlug => $city) {
                    $urls[] = [
                        'loc' => route('area.city', ['city' => $citySlug]),
                        'lastmod' => null,
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];

                    foreach ($city['districts'] as $district) {
                        $area = $coverageAreas->first(fn (CoverageArea $area) =>
                            in_array($area->city, [$city['name'], ucwords(str_replace('-', ' ', $citySlug))], true)
                            && Str::lower($area->district) === Str::lower($district)
                        );
                        if ($area && ! $area->is_active) {
                            continue;
                        }

                        $districtSlug = Str::slug($district);
                        $urls[] = [
                            'loc' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                            'lastmod' => ($area?->updated_at ?? $area?->created_at)?->toAtomString(),
                            'changefreq' => 'weekly',
                            'priority' => '0.8',
                        ];
                    }
                }
            }

            // Published knowledge articles
            $articles = Article::where('is_published', true)->get();
            foreach ($articles as $article) {
                $urls[] = [
                    'loc' => route('articles.show', ['slug' => $article->slug]),
                    'lastmod' => ($article->updated_at ?? $article->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $xmlString .= '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'."\n";
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
            foreach ($urls as $u) {
                $xmlString .= "  <url>\n";
                $xmlString .= '    <loc>'.htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8')."</loc>\n";
                if (! empty($u['lastmod'])) {
                    $xmlString .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
                }
                $xmlString .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
                $xmlString .= "    <priority>{$u['priority']}</priority>\n";
                $xmlString .= "  </url>\n";
            }
            $xmlString .= '</urlset>';

            return $xmlString;
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Display the About Us main entry page (delegates to Profil Perusahaan).
     */
    public function about(): View
    {
        return $this->aboutProfile();
    }

    /**
     * Sub-Page 1: Profil Perusahaan
     */
    public function aboutProfile(): View
    {
        PageMetadata::title('Profil Perusahaan: Spesialis Pipa Tanpa Bongkar');
        SEOMeta::setDescription('Profil resmi Drainusantara: spesialis pelancaran pipa mampet tanpa bongkar keramik berstandar mutu tinggi, integritas teknis, dan jaminan garansi 30 hari.');
        SEOMeta::setCanonical(route('about.profile'));

        OpenGraph::setDescription('Mengenal integritas, visi, misi, dan pilar keunggulan teknik Drainusantara dalam melayani perumahan dan komersial.');
        OpenGraph::setUrl(route('about.profile'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Spesialis pelancaran pipa mampet tanpa bongkar keramik bergaransi 30 hari.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Profil Perusahaan Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Profil Perusahaan', 'about.profile');

        $staffMembers = Cache::remember('staff.all_active', 86400, function () {
            return Staff::where('is_active', true)
                ->orderBy('order')
                ->latest('id')
                ->get();
        });

        return view('about.profile', compact('staffMembers'));
    }

    /**
     * Sub-Page 2: Struktur Holding J&J Group
     */
    public function aboutHolding(): View
    {
        PageMetadata::title('Struktur Ekosistem Holding J&J Group');
        SEOMeta::setDescription('Drainusantara bernaung di bawah ekosistem holding J&J Group. Sinergi rantai pasok mesin mekanik impor, kendali mutu, dan standarisasi operasional terpadu.');
        SEOMeta::setCanonical(route('about.holding'));

        OpenGraph::setDescription('Fondasi korporasi kokoh di bawah naungan J&J Group dengan jaringan logistik armada dan pengawasan mutu sanitasi.');
        OpenGraph::setUrl(route('about.holding'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Ekosistem holding sanitasi dan drainase modern di Indonesia.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Struktur Holding J&J Group - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Struktur Holding', 'about.holding');

        return view('about.holding');
    }

    /**
     * Sub-Page 3: Standar Operasional Prosedur (SOP) K3
     */
    public function aboutK3(): View
    {
        PageMetadata::title('Standar SOP K3 & Higienitas Teknisi');
        SEOMeta::setDescription('Protokol K3 resmi teknisi Drainusantara: pemakaian APD steril, cover sepatu saat masuk hunian, keamanan kelistrikan GFCI, dan uji alir sanitasi.');
        SEOMeta::setCanonical(route('about.k3'));

        OpenGraph::setDescription('Disiplin keselamatan kerja dan perlindungan sanitasi ruangan konsumen pada setiap penanganan pipa.');
        OpenGraph::setUrl(route('about.k3'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Protokol higienis, cover sepatu, sarung tangan nitril, dan keamanan kelistrikan.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Standar SOP K3 Teknisi - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('SOP K3', 'about.k3');

        return view('about.sop-k3');
    }

    /**
     * Sub-Page 4: Peralatan & Teknologi
     */
    public function aboutEquipment(): View
    {
        PageMetadata::title('Peralatan & Teknologi Mesin Pipa Modern');
        SEOMeta::setDescription('Spesifikasi mesin drain rooter Ridgid spiral baja rotary, kamera inspeksi visual CCTV IP68 jangkauan 30 meter, dan water jetting pembersih grease trap.');
        SEOMeta::setCanonical(route('about.equipment'));

        OpenGraph::setDescription('Teknologi mekanis spiral baja elastis dan visualisasi kondisi internal pipa dengan kamera endoskopi digital.');
        OpenGraph::setUrl(route('about.equipment'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Mesin spiral Ridgid K-50/K-60 dan kamera pipa CCTV IP68.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addAboutBreadcrumb('Peralatan & Teknologi', 'about.equipment');

        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });

        return view('about.equipment', compact('equipments'));
    }

    /**
     * Sub-Page 5: Klien & Portofolio Rekam Jejak
     */
    public function aboutPortfolio(): View
    {
        PageMetadata::title('Klien & Portofolio Proyek B2B');
        SEOMeta::setDescription('Daftar portofolio klien komersial B2B dan hunian residensial Drainusantara: restoran F&B, hotel bintang, food court, ruko, dan gedung perkantoran.');
        SEOMeta::setCanonical(route('about.portfolio'));

        OpenGraph::setDescription('Kepercayaan puluhan entitas komersial F&B dan perhotelan terhadap solusi drainase tanpa bongkar keramik.');
        OpenGraph::setUrl(route('about.portfolio'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Portofolio pembersihan pipa dan grease trap resto, hotel, dan gedung komersial.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Klien & Portofolio Proyek - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Klien & Portofolio', 'about.portfolio');

        $portfolios = Cache::remember('landing.portfolios', 86400, function () {
            return Portfolio::where('is_active', true)
                ->orderBy('order')
                ->get();
        });

        return view('about.portfolio', compact('portfolios'));
    }

    /**
     * Sub-Page 6: Ketentuan Garansi 30 Hari
     */
    public function aboutWarranty(): View
    {
        PageMetadata::title('Ketentuan Resmi Garansi 30 Hari Kalender');
        SEOMeta::setDescription('Syarat dan ketentuan resmi jaminan garansi 30 hari kalender Drainusantara, komitmen No Cure No Pay, serta alur klaim kunjungan ulang bebas biaya.');
        SEOMeta::setCanonical(route('about.warranty'));

        OpenGraph::setDescription('Perlindungan purna jual nyata: nota digital resmi, komitmen No Cure No Pay, dan respon klaim prioritas.');
        OpenGraph::setUrl(route('about.warranty'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Jaminan garansi 30 hari kalender dan komitmen No Cure No Pay.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Ketentuan Resmi Garansi 30 Hari - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Ketentuan Garansi', 'about.warranty');

        return view('about.warranty');
    }

    /**
     * Sub-Page 7: FAQ (Tanya Jawab Seputar Layanan)
     */
    public function aboutFaq(): View
    {
        PageMetadata::title('Tanya Jawab (FAQ) Pelancaran Pipa');
        SEOMeta::setDescription('Kumpulan tanya jawab teknis: mengapa soda api merusak pipa PVC, durasi pengerjaan rooter spiral, transparansi biaya, dan cara klaim garansi.');
        SEOMeta::setCanonical(route('about.faq'));

        OpenGraph::setDescription('Informasi transparan seputar metode pengerjaan tanpa bongkar keramik, peralatan, dan jaminan keamanan sanitasi.');
        OpenGraph::setUrl(route('about.faq'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tanya jawab teknis seputar pelancaran pipa tanpa bongkar keramik.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Tanya Jawab (FAQ) - Drainusantara');
        JsonLdMulti::setType('FAQPage');
        JsonLdMulti::addValues([
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Mengapa Drainusantara melarang keras penggunaan soda api?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Soda api memicu reaksi eksotermik panas ekstrem hingga di atas 100°C yang melunakkan, merusak lem, dan memecahkan pipa PVC cor di dalam lantai, serta memadatkan endapan lemak menjadi sekeras semen.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Berapa lama estimasi waktu pengerjaan pelancaran pipa?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => config('service_facts.duration_answer'),
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Apakah penanganan saluran memerlukan pembongkaran lantai atau keramik?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Tidak perlu. Metode mekanis spiral baja elastis masuk mengikuti jalur belokan pipa langsung dari lubang saringan atau leher angsa porselen tanpa membongkar keramik.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Bagaimana ketentuan jaminan garansi 30 hari kalender?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Setiap pengerjaan tuntas dilindungi nota digital garansi 30 hari. Jika saluran mampet kembali dalam masa garansi akibat residu titik yang sama, teknisi datang melancarkan ulang tanpa biaya tambahan.',
                    ],
                ],
            ],
        ]);

        $this->addAboutBreadcrumb('FAQ', 'about.faq');

        return view('about.faq');
    }

    private function addAboutBreadcrumb(string $name, string $route): void
    {
        $this->addBreadcrumb(['Tentang Kami', route('about')], [$name, route($route)]);
    }

    private function addBreadcrumb(array ...$entries): void
    {
        $items = [['Beranda', url('/')], ...$entries];
        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => array_map(
                static fn (array $entry, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $entry[0],
                    'item' => $entry[1],
                ],
                $items,
                array_keys($items)
            ),
        ]);
    }

    /**
     * Plain-text llms.txt (llmstxt.org) for AI crawlers.
     */
    public function llms(): Response
    {
        $body = Cache::remember('llms.txt', 600, function (): string {
            $services = Service::where('is_active', true)
                ->orderBy('order')
                ->get(['name', 'slug', 'short_description', 'price_starting_from']);

            return view('llms', [
                'services' => $services,
                'whatsappNumber' => config('app.whatsapp_number', '6285609009009'),
            ])->render();
        });

        return response($body, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=600');
    }

    /**
     * Plain-text dynamic robots.txt for search engines.
     */
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');
        $content = "User-agent: *\nDisallow: /admin/\nDisallow: /login\n\nSitemap: {$sitemapUrl}\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Format official hotline phone into E.164 international format for Schema JSON-LD.
     */
    private function formatInternationalPhone(): string
    {
        $raw = (string) config('app.whatsapp_number', '6285609009009');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        return '+'.($digits !== '' ? $digits : '6285609009009');
    }
}
