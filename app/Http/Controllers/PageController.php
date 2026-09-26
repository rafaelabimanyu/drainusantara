<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Service;
use App\Services\RegionService;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display the Drainusantara landing page.
     */
    public function index(): View
    {
        // 1. Configure SEOMeta for Drainusantara
        SEOMeta::setTitle('Jasa Saluran Pipa Mampet Tanpa Bongkar');
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

        // 2. Configure OpenGraph & Twitter
        OpenGraph::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        OpenGraph::setDescription('Layanan pelancar pipa mampet wastafel & kloset pakai mesin spiral baja. 100% tanpa bongkar keramik, garansi nota 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        TwitterCard::setDescription('Pelancar saluran wastafel & kloset tanpa bongkar keramik di Jabodetabek, Semarang & Lampung. Bergaransi 30 hari.');
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        // 3. Configure JsonLdMulti (Rich Snippet Local Business & PlumbingService)
        JsonLdMulti::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        JsonLdMulti::setDescription('Jasa pelancaran saluran pipa mampet profesional, mesin rooter spiral baja, dan inspeksi kamera CCTV pipa bergaransi 30 hari.');
        JsonLdMulti::setType('PlumbingService');
        JsonLdMulti::addValues([
            'name' => 'Drainusantara',
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
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

        $articles = \App\Models\Article::where('is_published', true)
            ->latest('published_at')
            ->latest()
            ->take(3)
            ->get();

        $portfolios = \App\Models\Portfolio::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('welcome', compact('services', 'reviews', 'galleries', 'articles', 'portfolios'));
    }

    /**
     * Display all provinces and cities coverage directory.
     */
    public function areasIndex(): View
    {
        SEOMeta::setTitle('Wilayah Jangkauan Teknisi Pipa Mampet');
        SEOMeta::setDescription('Daftar jangkauan posko siaga teknisi pipa mampet Drainusantara di Jabodetabek, Semarang, & Lampung. Siaga 24 jam respon cepat & garansi 30 hari.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Wilayah Jangkauan Teknisi Pipa Mampet - Drainusantara');
        OpenGraph::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle('Wilayah Jangkauan Teknisi Pipa Mampet - Drainusantara');
        TwitterCard::setDescription('Armada siaga teknisi pelancar saluran pipa mampet di Jabodetabek, Semarang, dan Bandar Lampung.');
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        JsonLdMulti::setTitle('Wilayah Jangkauan Layanan Drainusantara');
        JsonLdMulti::setType('PlumbingService');
        JsonLdMulti::addValues([
            'name' => 'Drainusantara - Wilayah Jangkauan Layanan',
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung'],
            'priceRange' => 'Mulai Rp 400.000',
        ]);

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

        $title = "Jasa Saluran Mampet {$provinceData['name']}";
        $description = "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$provinceData['name']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari.";

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

        OpenGraph::setTitle("Jasa Saluran Mampet {$provinceData['name']} - Drainusantara");
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle("Jasa Saluran Mampet {$provinceData['name']} - Drainusantara");
        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        JsonLdMulti::setTitle("Drainusantara Provinsi {$provinceData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('PlumbingService');
        JsonLdMulti::addValues([
            'name' => "Drainusantara Provinsi {$provinceData['name']}",
            'areaServed' => $provinceData['name'],
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
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
                'eta_minutes' => 'Respon Cepat',
                'districts' => ['Pusat Kota', 'Wilayah Sekitar'],
            ];
        }

        $title = "Jasa Pipa Mampet {$cityData['name']}";
        $description = "Pelancaran wastafel, kloset, & floor drain mampet di {$cityData['name']} tanpa bongkar keramik. Armada siaga respon cepat 15 menit, garansi resmi 30 hari.";

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

        OpenGraph::setTitle("Jasa Pipa Mampet {$cityData['name']} - Drainusantara");
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle("Jasa Pipa Mampet {$cityData['name']} - Drainusantara");
        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        JsonLdMulti::setTitle("Drainusantara {$cityData['name']}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('PlumbingService');
        JsonLdMulti::addValues([
            'name' => "Drainusantara {$cityData['name']}",
            'areaServed' => "{$cityData['name']}, {$cityData['province_name']}",
            'telephone' => $cityData['phone'] ?? config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $cityData['posko_address'] ?? "Posko Siaga {$cityData['name']}",
                'addressLocality' => $cityData['name'],
                'addressRegion' => $cityData['province_name'],
                'addressCountry' => 'ID',
            ],
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
                    'meta_title' => "Jasa Saluran Mampet {$districtFormatted}, {$cityFormatted}",
                    'meta_description' => "Jasa pipa mampet wastafel, toilet, & talang air di {$districtFormatted}, {$cityFormatted}. 100% tanpa bongkar keramik pakai spiral baja, garansi nota 30 hari.",
                    'content' => "Layanan penanganan saluran pipa mampet berstandar profesional di area {$districtFormatted}, {$cityFormatted} dan sekitarnya.",
                    'is_active' => true,
                ]
            );
        }

        $rawTitle = $area->meta_title ?: "Jasa Saluran Mampet {$area->district}, {$area->city}";
        $cleanTitle = trim(str_replace([' - Drainusantara Bergaransi', ' | Drainusantara', ' - Drainusantara'], '', $rawTitle));
        $cleanTitle = preg_replace('/^Jasa Saluran Mampet di /i', 'Jasa Saluran Mampet ', $cleanTitle);
        $description = $area->meta_description ?: "Jasa pipa mampet wastafel, toilet, & talang air di {$area->district}, {$area->city}. 100% tanpa bongkar keramik pakai spiral baja, garansi nota 30 hari.";

        // 1. Dynamic SEOMeta
        SEOMeta::setTitle($cleanTitle);
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

        // 2. Dynamic OpenGraph & Twitter
        OpenGraph::setTitle("{$cleanTitle} - Drainusantara");
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle("{$cleanTitle} - Drainusantara");
        TwitterCard::setDescription($description);
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        // 3. Dynamic JsonLdMulti Local Business & PlumbingService Schema
        JsonLdMulti::setTitle("Drainusantara - Area {$area->district}, {$area->city}");
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('PlumbingService');
        JsonLdMulti::addValues([
            'name' => "Drainusantara {$area->district}",
            'areaServed' => "{$area->district}, {$area->city}",
            'telephone' => config('app.whatsapp_number', '+6281234567890'),
            'priceRange' => 'Mulai Rp 400.000',
            'openingHours' => 'Mo-Su 00:00-24:00',
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
        SEOMeta::setTitle('Dokumentasi Hasil Pengerjaan Pipa Mampet');
        SEOMeta::setDescription('Foto bukti sebelum & sesudah pelancaran wastafel, kloset, & floor drain tersumbat. Inspeksi visual kamera CCTV pipa 30 meter tanpa bongkar keramik.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Dokumentasi Hasil Pengerjaan Pipa Mampet - Drainusantara');
        OpenGraph::setDescription('Hasil nyata pelancaran pipa mampet dengan mesin spiral mekanis berstandar profesional. 100% tanpa bongkar keramik & bergaransi 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle('Dokumentasi Hasil Pengerjaan Pipa Mampet - Drainusantara');
        TwitterCard::setDescription('Hasil nyata pelancaran pipa mampet dengan mesin spiral mekanis. 100% tanpa bongkar keramik, garansi nota 30 hari.');
        TwitterCard::setImage(asset('images/hero-technician.webp'));

        JsonLdMulti::setTitle('Galeri Pengerjaan Saluran Pipa Mampet - Drainusantara');
        JsonLdMulti::setDescription('Dokumentasi proyek pengerjaan pembersihan pipa tersumbat dan inspeksi CCTV pipa.');
        JsonLdMulti::setType('PlumbingService');

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
        SEOMeta::setTitle('Panduan & Edukasi Perawatan Saluran Pipa');
        SEOMeta::setDescription('Kumpulan artikel teknis: cara melancarkan wastafel, bahaya soda api pada pipa PVC cor, dan perawatan sanitasi rumah tangga tanpa bongkar keramik.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Panduan & Edukasi Saluran Pipa - Drainusantara');
        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(asset('images/hero-technician.webp'));

        TwitterCard::setTitle('Panduan & Edukasi Saluran Pipa - Drainusantara');
        TwitterCard::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        TwitterCard::setImage(asset('images/hero-technician.webp'));

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

        $rawTitle = $article->meta_title ?: $article->title;
        $cleanTitle = trim(str_replace([' - Drainusantara', ' | Drainusantara'], '', $rawTitle));
        $metaDescription = $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 150));
        $thumbnailUrl = $article->thumbnail ? (filter_var($article->thumbnail, FILTER_VALIDATE_URL) ? $article->thumbnail : asset($article->thumbnail)) : asset('images/hero-technician.webp');

        SEOMeta::setTitle($cleanTitle);
        SEOMeta::setDescription($metaDescription);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle("{$cleanTitle} - Drainusantara");
        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addImage($thumbnailUrl);

        TwitterCard::setTitle("{$cleanTitle} - Drainusantara");
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
                '@type' => 'Organization',
                'name' => 'Tim Ahli Drainusantara',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'url' => url('/'),
            ],
        ]);

        $recentArticles = \App\Models\Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'recentArticles'));
    }

    /**
     * Generate dynamic sitemap.xml for all public indexable routes.
     */
    public function sitemap(): Response
    {
        $urls = [];
        $now = now()->toAtomString();

        // 1. Static Core Landing & Directory Pages
        $urls[] = ['loc' => url('/'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => url('/area'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.9'];
        $urls[] = ['loc' => url('/galeri'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => url('/pengetahuan'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.8'];

        // 2. Dynamic Provinces, Cities & Districts
        $provinces = RegionService::all();
        foreach ($provinces as $provSlug => $prov) {
            $urls[] = [
                'loc' => route('area.province', ['province' => $provSlug]),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];

            foreach ($prov['cities'] as $citySlug => $city) {
                $urls[] = [
                    'loc' => route('area.city', ['city' => $citySlug]),
                    'lastmod' => $now,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];

                foreach ($city['districts'] as $district) {
                    $districtSlug = Str::slug($district);
                    $urls[] = [
                        'loc' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                        'lastmod' => $now,
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            }
        }

        // 3. Dynamic Published Articles
        $articles = \App\Models\Article::where('is_published', true)->get();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('articles.show', ['slug' => $article->slug]),
                'lastmod' => ($article->updated_at ?? $article->created_at)->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        // Build XML Output
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}

