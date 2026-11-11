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
        SEOMeta::setDescription('Jasa pelancar saluran pipa mampet wastafel & kloset tanpa bongkar keramik di Jabodetabek, Bandung, Semarang, Lampung & Bali. Mesin spiral baja, garansi 30 hari.');
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
            'bandung',
            'semarang',
            'bandar lampung',
            'bali',
            'denpasar',
        ]);

        OpenGraph::setDescription('Layanan pelancar pipa mampet wastafel & kloset pakai mesin spiral baja tanpa bongkar keramik di Jabodetabek, Bandung, Semarang, Lampung & Bali, garansi nota 30 hari.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addProperty('site_name', 'Drainusantara');
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Pelancar saluran wastafel & kloset tanpa bongkar keramik di Jabodetabek, Bandung, Semarang, Lampung & Bali. Bergaransi 30 hari.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Drainusantara - Jasa Saluran Pipa Mampet Tanpa Bongkar');
        JsonLdMulti::setDescription('Jasa pelancaran saluran pipa mampet profesional, mesin rooter spiral baja, dan inspeksi kamera CCTV pipa bergaransi 30 hari.');
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            '@id' => url('/#organization'),
            'name' => 'Drainusantara - Jasa Saluran Pipa Mampet',
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => url('/'),
            'logo' => asset('images/logo/WebIcon.webp'),
            'image' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'priceRange' => 'Mulai Rp 400.000',
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
            'geo' => $this->getHeadquartersGeo(),
            'sameAs' => $this->getSameAsUrls(),
            'hasMap' => config('services.company.google_maps_url') ?: null,
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
            'serviceType' => [
                'Jasa Saluran Pipa Mampet',
                'Inspeksi Kamera CCTV Pipa 30M',
                'Pelancaran Kloset & WC Toilet',
                'Pelancaran Wastafel Cuci Piring',
                'Pembersihan Lemak Pipa & Grease Trap',
            ],
        ]);

        $serviceJsonLd = JsonLdMulti::newJsonLd();
        $serviceJsonLd->setType('Service');
        $serviceJsonLd->addValues([
            '@id' => url('/#service-pelancaran-pipa'),
            'name' => 'Jasa Saluran Pipa Mampet Tanpa Bongkar',
            'serviceType' => 'Plumbing Service',
            'description' => 'Layanan pelancaran saluran pipa wastafel, kloset toilet, floor drain, dan talang air dengan mesin spiral rotary Ridgid tanpa bongkar keramik bergaransi 30 hari.',
            'provider' => [
                '@id' => url('/#organization'),
            ],
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
            'offers' => [
                '@type' => 'Offer',
                'price' => '400000',
                'priceCurrency' => 'IDR',
                'availability' => 'https://schema.org/InStock',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => '400000',
                    'priceCurrency' => 'IDR',
                ],
            ],
        ]);

        $webSiteJsonLd = JsonLdMulti::newJsonLd();
        $webSiteJsonLd->setType('WebSite');
        $webSiteJsonLd->addValues([
            '@id' => url('/#website'),
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

