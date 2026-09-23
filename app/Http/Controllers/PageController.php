<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Service;
use App\Services\RegionService;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display the Drainusantara landing page.
     */
    public function index(): View
    {
        // 1. Configure SEOMeta for Drainusantara
        SEOMeta::setTitle('Jasa Saluran Pipa Mampet Tanpa Bongkar & Bergaransi 30 Hari');
        SEOMeta::setDescription('Solusi ahli pipa mampet, wastafel, kloset, dan floor drain tanpa bongkar keramik di Jabodetabek, Semarang, & Bandar Lampung. Menggunakan mesin rooter spiral modern dan inspeksi CCTV pipa 30 meter dengan garansi 30 hari.');
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

        // 2. Configure OpenGraph
        OpenGraph::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar & Bergaransi 30 Hari');
        OpenGraph::setDescription('Layanan profesional pelancaran saluran pipa mampet dengan mesin spiral mekanis & kamera CCTV 30 meter. 100% tanpa bongkar lantai & bergaransi resmi 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');

        // 3. Configure JsonLd (Rich Snippet Local Business)
        JsonLd::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        JsonLd::setDescription('Jasa pelancaran saluran pipa mampet profesional, mesin rooter spiral, dan inspeksi kamera CCTV pipa bergaransi 30 hari.');
        JsonLd::setType('HomeAndConstructionBusiness');
        JsonLd::addValues([
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
        ]);

        // 4. Retrieve Services, Reviews, and Galleries from Database
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        $reviews = Review::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->with('service')
            ->orderBy('order')
            ->take(4)
            ->get();

        return view('welcome', compact('services', 'reviews', 'galleries'));
    }

    /**
     * Display all provinces and cities coverage directory.
     */
    public function areasIndex(): View
    {
        SEOMeta::setTitle('Wilayah Jangkauan Layanan Pipa Mampet - Drainusantara');
        SEOMeta::setDescription('Daftar lengkap cakupan posko teknisi pipa mampet Drainusantara di DKI Jakarta, Jawa Barat, Banten, Jawa Tengah, dan Lampung. Layanan cepat 24 jam bergaransi 30 hari.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Wilayah Jangkauan Layanan Pipa Mampet - Drainusantara');
        OpenGraph::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        OpenGraph::setUrl(url()->current());

        JsonLd::setTitle('Wilayah Jangkauan Layanan Drainusantara');
        JsonLd::setType('HomeAndConstructionBusiness');

        $provinces = RegionService::all();
        $services = Service::where('is_active', true)->orderBy('order')->get();

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

        $title = "Jasa Saluran Pipa Mampet Provinsi {$provinceData['name']} - Drainusantara Bergaransi";
        $description = "Layanan penanganan saluran pipa mampet tanpa bongkar keramik di Provinsi {$provinceData['name']}. Armada siaga tersebar di " . count($provinceData['cities']) . " wilayah dengan garansi 30 hari.";

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            "jasa saluran mampet {$provinceData['name']}",
            "pipa mampet {$provinceData['name']}",
            "wastafel mampet {$provinceData['name']}",
            "kloset mampet {$provinceData['name']}",
            "tanpa bongkar keramik",
            "garansi 30 hari",
        ]);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('HomeAndConstructionBusiness');
        JsonLd::addValues([
            'name' => "Drainusantara Provinsi {$provinceData['name']}",
            'areaServed' => $provinceData['name'],
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
        ]);

        $services = Service::where('is_active', true)->orderBy('order')->get();
        $reviews = Review::where('is_active', true)->latest()->take(3)->get();

        return view('areas.province', compact('provinceData', 'services', 'reviews'));
    }

    /**
     * Display city/kabupaten level coverage area page.
     */
    public function city(string $city): View
    {
        $cityData = RegionService::findCity($city);

        if (! $cityData) {
            $cityFormatted = ucwords(str_replace('-', ' ', $city));
            $cityData = [
                'name' => $cityFormatted,
                'slug' => Str::slug($city),
                'type' => 'Kota / Wilayah',
                'province_name' => 'Indonesia',
                'province_slug' => 'dki-jakarta',
                'posko_address' => "Posko Siaga {$cityFormatted}",
                'phone' => config('app.whatsapp_number', '0812-3456-7890'),
                'eta_minutes' => '30 - 45 Menit',
                'districts' => ['Pusat Kota', 'Wilayah Sekitar'],
            ];
        }

        $title = "Jasa Saluran Mampet di {$cityData['name']} - Tanpa Bongkar & Garansi 30 Hari";
        $description = "Spesialis pelancaran pipa wastafel, toilet kloset, dan floor drain mampet di {$cityData['name']} ({$cityData['province_name']}). Armada siaga 24 jam dengan respon cepat {$cityData['eta_minutes']}.";

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            "jasa saluran mampet {$cityData['name']}",
            "pipa mampet {$cityData['name']}",
            "wastafel mampet {$cityData['name']}",
            "toilet mampet {$cityData['name']}",
            "sedot lemak {$cityData['name']}",
            "tanpa bongkar keramik",
            "garansi 30 hari",
        ]);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('HomeAndConstructionBusiness');
        JsonLd::addValues([
            'name' => "Drainusantara {$cityData['name']}",
            'areaServed' => "{$cityData['name']}, {$cityData['province_name']}",
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
        ]);

        $services = Service::where('is_active', true)->orderBy('order')->get();
        $reviews = Review::where('is_active', true)->latest()->take(4)->get();

        return view('areas.city', compact('cityData', 'services', 'reviews'));
    }

    /**
     * Display coverage area SEO detail page (Kecamatan level).
     */
    public function area(string $city, string $district): View
    {
        $cityAliases = [
            'jaksel' => 'Jakarta Selatan',
            'jaktim' => 'Jakarta Timur',
            'jakut' => 'Jakarta Utara',
            'jakpus' => 'Jakarta Pusat',
            'jakbar' => 'Jakarta Barat',
            'tangsel' => 'Tangerang Selatan',
            'semarang' => 'Kota Semarang',
            'lampung' => 'Bandar Lampung',
        ];

        $lowerCity = strtolower($city);
        $cityFormatted = $cityAliases[$lowerCity] ?? ucwords(str_replace('-', ' ', $city));
        $districtFormatted = ucwords(str_replace('-', ' ', $district));
        $combinedSlug = Str::slug("{$cityFormatted}-{$districtFormatted}");

        // Query CoverageArea based on slug or city and district names
        $area = CoverageArea::where('is_active', true)
            ->where(function ($query) use ($city, $district, $combinedSlug, $cityFormatted, $districtFormatted) {
                $query->where('slug', $combinedSlug)
                    ->orWhere('slug', Str::slug($district))
                    ->orWhere(function ($q) use ($cityFormatted, $districtFormatted) {
                        $q->whereRaw('LOWER(city) = ?', [strtolower($cityFormatted)])
                          ->whereRaw('LOWER(district) = ?', [strtolower($districtFormatted)]);
                    });
            })
            ->first();

        // If not yet present in DB, create or retrieve to support all local SEO areas dynamically
        if (! $area) {
            $area = CoverageArea::firstOrCreate(
                ['slug' => $combinedSlug],
                [
                    'city' => $cityFormatted,
                    'district' => $districtFormatted,
                    'meta_title' => "Jasa Saluran Mampet di {$districtFormatted}, {$cityFormatted} - Drainusantara Bergaransi",
                    'meta_description' => "Jasa pelancaran pipa wastafel, toilet, dan floor drain mampet di {$districtFormatted}, {$cityFormatted} tanpa bongkar keramik & garansi 30 hari. Hubungi teknisi terdekat sekarang!",
                    'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di area {$districtFormatted}, {$cityFormatted} dan sekitarnya.",
                    'is_active' => true,
                ]
            );
        }

        $title = $area->meta_title ?: "Jasa Saluran Mampet di {$area->district}, {$area->city} - Drainusantara Bergaransi";
        $description = $area->meta_description ?: "Jasa pelancaran pipa wastafel, toilet, dan floor drain mampet di {$area->district}, {$area->city} tanpa bongkar keramik & garansi 30 hari. Hubungi teknisi terdekat sekarang!";

        // 1. Dynamic SEOMeta
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            "jasa saluran mampet {$area->district}",
            "pipa mampet {$area->district}",
            "wastafel mampet {$area->district}",
            "toilet wc mampet {$area->district}",
            "saluran mampet {$area->city}",
            "tanpa bongkar keramik",
            "garansi 30 hari",
            "drainusantara",
        ]);

        // 2. Dynamic OpenGraph
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');

        // 3. Dynamic JsonLd Local Business Schema
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('HomeAndConstructionBusiness');
        JsonLd::addValues([
            'name' => "Drainusantara - Area {$area->district}, {$area->city}",
            'areaServed' => "{$area->district}, {$area->city}",
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
        ]);

        // 4. Fetch cityData from RegionService for breadcrumb & neighboring districts
        $cityData = RegionService::findCity($city);

        // 5. Fetch services for local recommendations
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        $reviews = Review::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('area', compact('area', 'services', 'reviews', 'cityData'));
    }

    /**
     * Display the Gallery & Portfolio page.
     */
    public function gallery(): View
    {
        SEOMeta::setTitle('Galeri & Portofolio Pengerjaan Saluran Mampet - Drainusantara');
        SEOMeta::setDescription('Dokumentasi foto sebelum dan sesudah pelancaran pipa wastafel, kloset mampet, floor drain, dan hasil rekaman inspeksi kamera CCTV pipa 30 meter tanpa bongkar keramik.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Galeri & Portofolio Pengerjaan Saluran Mampet - Drainusantara');
        OpenGraph::setDescription('Hasil nyata pelancaran pipa mampet dengan mesin spiral mekanis berstandar profesional. 100% tanpa bongkar keramik & bergaransi 30 hari.');
        OpenGraph::setUrl(url()->current());

        JsonLd::setTitle('Galeri Pengerjaan Saluran Pipa Mampet - Drainusantara');
        JsonLd::setDescription('Dokumentasi proyek pengerjaan pembersihan pipa tersumbat dan inspeksi CCTV pipa.');

        $galleries = \App\Models\Gallery::where('is_active', true)
            ->with('service')
            ->orderBy('order')
            ->latest()
            ->get();

        return view('gallery', compact('galleries'));
    }

    /**
     * Display the Articles & Education listing page.
     */
    public function articles(): View
    {
        SEOMeta::setTitle('Artikel & Tips Perawatan Pipa Saluran Mampet - Drainusantara');
        SEOMeta::setDescription('Kumpulan panduan praktis, tips merawat wastafel dapur, bahaya penggunaan soda api pada pipa PVC, dan solusi pipa mampet tanpa bongkar keramik.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Artikel & Edukasi Plumbing - Drainusantara');
        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl(url()->current());

        $articles = \App\Models\Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        $featuredArticle = \App\Models\Article::where('is_published', true)
            ->latest('published_at')
            ->first();

        return view('articles.index', compact('articles', 'featuredArticle'));
    }

    /**
     * Display the Article Detail page.
     */
    public function articleDetail(string $slug): View
    {
        $article = \App\Models\Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $metaTitle = $article->meta_title ?: "{$article->title} - Drainusantara";
        $metaDescription = $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 150));

        SEOMeta::setTitle($metaTitle);
        SEOMeta::setDescription($metaDescription);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($metaTitle);
        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        if ($article->thumbnail) {
            OpenGraph::addImage($article->thumbnail);
        }

        JsonLd::setTitle($metaTitle);
        JsonLd::setDescription($metaDescription);
        JsonLd::setType('Article');
        JsonLd::addValues([
            'headline' => $article->title,
            'datePublished' => $article->published_at?->toIso8601String() ?? $article->created_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Tim Ahli Drainusantara',
            ],
        ]);

        $recentArticles = \App\Models\Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'recentArticles'));
    }
}

