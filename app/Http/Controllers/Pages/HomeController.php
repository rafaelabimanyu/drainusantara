<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    use HasPageSeo;

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

        $webSiteJsonLd = JsonLdMulti::newJsonLd();
        $webSiteJsonLd->setType('WebSite');
        $webSiteJsonLd->addValues([
            'name' => 'Drainusantara',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/pengetahuan?q={search_term_string}'),
                'query-input' => 'required name=search_term_string',
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
}

