<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Models\Review;
use App\Models\Service;
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

        // 4. Retrieve Services and Reviews from Database
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        $reviews = Review::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('services', 'reviews'));
    }

    /**
     * Display coverage area SEO detail page.
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
            'priceRange' => 'Rp 400.000 - Rp 650.000',
        ]);

        // 4. Fetch services for local recommendations
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        $reviews = Review::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('area', compact('area', 'services', 'reviews'));
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

