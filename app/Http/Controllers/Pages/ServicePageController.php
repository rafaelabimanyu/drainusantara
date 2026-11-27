<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Service;
use App\Services\RegionService;
use App\Services\ServiceCatalogRegistry;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ServicePageController extends Controller
{
    use HasPageSeo;

    /**
     * Display the Dedicated Services Index Catalog (/layanan).
     */
    public function index(): View
    {
        $title = 'Katalog Layanan Jasa Saluran Pipa Mampet - Drainusantara';
        $desc = 'Layanan spesialis pelancaran pipa saluran wastafel, kloset WC, floor drain kamar mandi, hydro jetting pipa, talang air, dan inspeksi CCTV pipa tanpa bongkar bergaransi 30 hari.';

        PageMetadata::title('Katalog Layanan Jasa Saluran Pipa Mampet Tanpa Bongkar');
        SEOMeta::setDescription($desc);
        SEOMeta::setCanonical(route('services.index'));
        SEOMeta::addKeyword([
            'jasa saluran pipa mampet',
            'tukang pipa mampet',
            'jasa wastafel mampet',
            'jasa wc mampet',
            'floor drain mampet',
            'hydro jetting pipa',
            'inspeksi cctv pipa',
            'kuras grease trap',
            'talang air mampet',
            'tanpa bongkar keramik',
            'garansi 30 hari',
            'no cure no pay',
            'drainusantara',
        ]);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($desc);
        OpenGraph::setUrl(route('services.index'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($desc);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($title);
        JsonLdMulti::setDescription($desc);
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::addValues([
            '@id' => route('services.index') . '#localbusiness',
            'name' => 'Drainusantara - Layanan Jasa Saluran Pipa Mampet',
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => route('services.index'),
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'address' => $this->getHeadquartersAddress(),
        ]);

        $this->addBreadcrumb(['Layanan', route('services.index')]);

        $services = $this->syncImagesFromDatabase(ServiceCatalogRegistry::all());

        $majorCities = Cache::remember('services.index.major_cities', 86400, function () {
            return CoverageArea::where('type', 'city')
                ->where('is_active', true)
                ->orderBy('city')
                ->take(12)
                ->get();
        });

        $featuredArticles = Cache::remember('services.index.articles', 86400, function () {
            return Article::indexable()
                ->with(['categoryRelation', 'subcategoryRelation'])
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        $contextualWaMsg = 'Halo Tim Drainusantara, saya ingin konsultasi mengenai katalog layanan pelancaran pipa mampet.';
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('services.index', compact('services', 'majorCities', 'featuredArticles', 'contextualWaMsg', 'contextualWaUrl'));
    }

    /**
     * Display a Dedicated Service Landing Page (/layanan/{slug}).
     */
    public function show(string $slug): View|RedirectResponse
    {
        $resolution = ServiceCatalogRegistry::resolve($slug);

        if ($resolution['should_redirect'] && $resolution['canonical_slug']) {
            return redirect()->route('services.show', ['slug' => $resolution['canonical_slug']], 301);
        }

        $service = $resolution['service'];
        $dbImageMap = $this->getDatabaseServiceImageMap();
        if ($service && isset($dbImageMap[$service['slug']])) {
            $service['image'] = $dbImageMap[$service['slug']];
        }

        // Fallback: check database model if not in registry
        if (! $service) {
            $dbService = Service::where('slug', $slug)->where('is_active', true)->first();
            abort_unless($dbService, 404);

            $service = [
                'name' => $dbService->name,
                'slug' => $dbService->slug,
                'h1' => "Jasa Pelancaran {$dbService->name} Tanpa Bongkar Keramik",
                'meta_title' => "Jasa {$dbService->name} Mampet Tanpa Bongkar | Drainusantara",
                'meta_description' => $dbService->short_description ?: "Jasa pelancaran {$dbService->name} bergaransi resmi 30 hari.",
                'price_starting_from' => $dbService->price_starting_from ?: 400000,
                'badge' => 'Layanan Spesialis',
                'icon' => 'tool',
                'image' => $dbService->image ?: '/images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'target_keywords' => ["jasa {$dbService->slug}", 'tukang pipa mampet', 'tanpa bongkar'],
                'hero_excerpt' => $dbService->description ?: 'Layanan mekanis modern pelancaran pipa mampet bergaransi 30 hari.',
                'symptoms' => [
                    'Aliran air pembuangan mengalir lambat dan mengeluarkan suara berdeguk',
                    'Terjadi luapan air kotor ke lantai ruangan saat digunakan',
                    'Aroma bau got atau sisa endapan tercium dari lubang saluran',
                ],
                'causes' => [
                    'Penumpukan lemak, sisa makanan, rambut, atau kerak deterjen',
                    'Sambungan siku pipa leher angsa yang memerangkap kotoran',
                ],
                'methods' => [
                    'Pembersihan mekanis spiral baja rotary Ridgid 400 RPM tanpa bongkar lantai',
                    'Pengujian flushing debit air maksimal dan garansi tertulis 30 hari kalender',
                ],
                'faqs' => [
                    [
                        'question' => "Berapa lama pengerjaan {$dbService->name}?",
                        'answer' => 'Rata-rata pengerjaan tuntas dalam 30–45 menit langsung di lokasi Anda.',
                    ],
                    [
                        'question' => "Apakah pengerjaan {$dbService->name} membongkar lantai keramik?",
                        'answer' => 'Sama sekali tidak (100% tanpa bongkar ubin/keramik).',
                    ],
                ],
            ];
        }

        $canonicalUrl = route('services.show', ['slug' => $service['slug']]);

        PageMetadata::title($service['h1']);
        SEOMeta::setDescription($service['meta_description']);
        SEOMeta::setCanonical($canonicalUrl);
        SEOMeta::addKeyword(array_merge($service['target_keywords'], [
            'tanpa bongkar keramik',
            'garansi 30 hari',
            'no cure no pay',
            'drainusantara',
        ]));

        $serviceImageUrl = $this->resolveImageUrl($service['image'] ?? null);

        OpenGraph::setTitle($service['meta_title']);
        OpenGraph::setDescription($service['meta_description']);
        OpenGraph::setUrl($canonicalUrl);
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage($serviceImageUrl);

        TwitterCard::setTitle($service['meta_title']);
        TwitterCard::setDescription($service['meta_description']);
        TwitterCard::setImage($serviceImageUrl);

        // Index 0: Complete Plumber provider schema (prevents empty default Plumber block leak)
        JsonLdMulti::setType('Plumber');
        JsonLdMulti::setTitle($service['meta_title']);
        JsonLdMulti::setDescription($service['meta_description']);
        JsonLdMulti::addValues([
            '@id' => url('/#organization'),
            'name' => 'Drainusantara',
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => url('/'),
            'image' => $serviceImageUrl,
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'address' => $this->getHeadquartersAddress(),
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
        ]);

        // Schema JSON-LD Service
        $serviceJsonLd = JsonLdMulti::newJsonLd();
        $serviceJsonLd->setType('Service');
        $serviceJsonLd->addValues([
            '@id' => $canonicalUrl . '#service',
            'name' => $service['name'],
            'serviceType' => 'Plumbing Service',
            'description' => $service['meta_description'],
            'provider' => [
                '@id' => url('/#organization'),
            ],
            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $service['price_starting_from'],
                'priceCurrency' => 'IDR',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => (string) $service['price_starting_from'],
                    'priceCurrency' => 'IDR',
                ],
            ],
        ]);

        // Schema JSON-LD FAQPage
        if (! empty($service['faqs'])) {
            $faqJsonLd = JsonLdMulti::newJsonLd();
            $faqJsonLd->setType('FAQPage');
            $faqJsonLd->addValues([
                '@id' => $canonicalUrl . '#faq',
                'mainEntity' => array_map(static fn (array $faq): array => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ], $service['faqs']),
            ]);
        }

        $this->addBreadcrumb(['Layanan', route('services.index')], [$service['name'], $canonicalUrl]);

        $contextualWaMsg = "Halo Tim Drainusantara, saya membutuhkan layanan {$service['name']}. Mohon info estimasi biaya dan ketersediaan teknisi.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        $majorCities = Cache::remember('services.show.major_cities', 86400, function () {
            return CoverageArea::where('type', 'city')
                ->where('is_active', true)
                ->orderBy('city')
                ->take(8)
                ->get();
        });

        $relatedArticles = Cache::remember('services.show.articles.' . $service['slug'], 86400, function () {
            return Article::indexable()
                ->with(['categoryRelation', 'subcategoryRelation'])
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        $allServices = $this->syncImagesFromDatabase(ServiceCatalogRegistry::all());
        $otherServices = array_filter($allServices, fn ($s) => $s['slug'] !== $service['slug']);

        return view('services.show', compact('service', 'contextualWaMsg', 'contextualWaUrl', 'majorCities', 'relatedArticles', 'otherServices'));
    }

    /**
     * Overlay active CMS service images from the database onto registry definitions
     * so /layanan and /layanan/{slug} stay synchronized with home and /area/* cards.
     *
     * @param  array<string, array<string, mixed>>  $services
     * @return array<string, array<string, mixed>>
     */
    private function syncImagesFromDatabase(array $services): array
    {
        $dbImageMap = $this->getDatabaseServiceImageMap();

        foreach ($services as $slug => &$service) {
            if (isset($dbImageMap[$slug])) {
                $service['image'] = $dbImageMap[$slug];
            }
        }
        unset($service);

        return $services;
    }

    /**
     * Build a canonical_slug => image path map from active database Service records.
     *
     * @return array<string, string>
     */
    private function getDatabaseServiceImageMap(): array
    {
        try {
            $map = [];
            $dbServices = Service::where('is_active', true)
                ->orderBy('order')
                ->orderBy('id')
                ->get(['slug', 'image']);

            foreach ($dbServices as $svc) {
                $image = trim((string) ($svc->image ?? ''));
                if ($image === '' || str_contains($image, 'placehold.co') || str_contains($image, 'unsplash.com')) {
                    continue;
                }

                $canonicalSlug = $svc->canonical_slug;
                if (! isset($map[$canonicalSlug])) {
                    $map[$canonicalSlug] = $image;
                }
            }

            return $map;
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Resolve a local asset path or absolute image URL safely for meta tags and schemas.
     */
    private function resolveImageUrl(?string $image): string
    {
        $raw = trim((string) ($image ?? ''));
        if ($raw === '' || str_contains($raw, 'placehold.co') || str_contains($raw, 'unsplash.com')) {
            return asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        return asset(ltrim($raw, '/'));
    }
}
