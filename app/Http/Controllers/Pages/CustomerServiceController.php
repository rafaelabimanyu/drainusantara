<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;

class CustomerServiceController extends Controller
{
    use HasPageSeo;

    /**
     * Display the Customer Service Hub directory across all official channels.
     */
    public function index(): View
    {
        $channelsConfig = config('customer_service.channels', []);
        $channels = [];
        foreach ($channelsConfig as $slug => $channel) {
            $channels[$slug] = [
                ...$channel,
                'social_url' => config("services.social.{$channel['social_config_key']}"),
                'resolved_whatsapp' => $this->resolveWhatsappNumber($channel),
            ];
        }

        $provinces = RegionService::all();
        $hubFaqs = config('customer_service.hub_faqs', []);
        $whatsappNumber = (string) (config('app.whatsapp_number') ?: '6285609009009');
        $contextualWaMsg = 'Halo Admin Drainusantara, saya menghubungi dari halaman Pusat Customer Service dan membutuhkan info teknisi terdekat.';
        $contextualWaUrl = "https://wa.me/{$whatsappNumber}?text=".rawurlencode($contextualWaMsg);

        $pageTitle = 'Pusat Customer Service Resmi & Verifikasi Akun Media Sosial';
        $metaDesc = 'Direktori resmi customer service Drainusantara di WhatsApp, Instagram, TikTok, Facebook, YouTube, LinkedIn, dan X (Twitter). Pilih kanal layanan sesuai kebutuhan hunian atau korporat B2B Anda.';

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription($metaDesc);
        SEOMeta::setCanonical(route('customer-service.index'));
        SEOMeta::addKeyword([
            'customer service drainusantara',
            'admin resmi drainusantara',
            'kontak media sosial drainusantara',
            'verifikasi akun drainusantara',
            'jasa saluran mampet 24 jam',
        ]);

        OpenGraph::setDescription($metaDesc);
        OpenGraph::setUrl(route('customer-service.index'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($metaDesc);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($pageTitle.' - Drainusantara');
        JsonLdMulti::setType('ContactPage');
        JsonLdMulti::addValues([
            'url' => route('customer-service.index'),
            'mainEntity' => [
                '@type' => 'Plumber',
                'name' => 'Drainusantara',
                'telephone' => $this->formatInternationalPhone(),
                'url' => route('customer-service.index'),
                'address' => $this->getHeadquartersAddress(),
                'geo' => $this->getHeadquartersGeo(),
                'sameAs' => $this->getSameAsUrls(),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $this->formatInternationalPhone(),
                    'contactType' => 'customer service',
                    'availableLanguage' => ['Indonesian', 'English'],
                    'areaServed' => ['Jabodetabek', 'Bandung', 'Semarang', 'Demak', 'Lampung', 'Bali'],
                ],
            ],
        ]);

        $this->addBreadcrumb(['Customer Service', route('customer-service.index')]);
        $this->attachFaqSchema($hubFaqs);

        return view('customer-service.index', compact(
            'channels',
            'provinces',
            'hubFaqs',
            'whatsappNumber',
            'contextualWaMsg',
            'contextualWaUrl'
        ));
    }

    /**
     * Display a dedicated, channel-specific customer service landing page.
     */
    public function show(string $socialMedia): View
    {
        $channel = config("customer_service.channels.{$socialMedia}");
        abort_if(! is_array($channel), 404);

        $whatsappNumber = $this->resolveWhatsappNumber($channel);
        $socialUrl = (string) config("services.social.{$channel['social_config_key']}", '');
        $canonicalUrl = route('customer-service.show', ['socialMedia' => $socialMedia]);

        $contextualWaMsg = $this->buildDefaultWaMessage($channel['admin_code']);
        $contextualWaUrl = "https://wa.me/{$whatsappNumber}?text=".rawurlencode($contextualWaMsg);

        PageMetadata::title($channel['seo_title']);
        SEOMeta::setDescription($channel['seo_description']);
        SEOMeta::setCanonical($canonicalUrl);
        SEOMeta::addKeyword($channel['seo_keywords']);

        OpenGraph::setDescription($channel['seo_description']);
        OpenGraph::setUrl($canonicalUrl);
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($channel['seo_description']);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        $sameAs = array_values(array_unique(array_filter([
            $socialUrl !== '' ? $socialUrl : null,
            ...$this->getSameAsUrls(),
        ])));

        $intlPhone = '+'.preg_replace('/[^0-9]/', '', $whatsappNumber);

        JsonLdMulti::setTitle($channel['seo_title'].' - Drainusantara');
        JsonLdMulti::setType('ContactPage');
        JsonLdMulti::addValues([
            'url' => $canonicalUrl,
            'mainEntity' => [
                '@type' => 'Plumber',
                'name' => 'Drainusantara',
                'url' => $canonicalUrl,
                'telephone' => $intlPhone,
                'address' => $this->getHeadquartersAddress(),
                'geo' => $this->getHeadquartersGeo(),
                'sameAs' => $sameAs,
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $intlPhone,
                    'contactType' => "customer service {$channel['name']}",
                    'availableLanguage' => ['Indonesian', 'English'],
                    'areaServed' => ['Jabodetabek', 'Bandung', 'Semarang', 'Demak', 'Lampung', 'Bali'],
                ],
            ],
        ]);

        $this->addBreadcrumb(
            ['Customer Service', route('customer-service.index')],
            [$channel['breadcrumb_label'], $canonicalUrl]
        );
        $this->attachFaqSchema($channel['faqs'] ?? []);

        $provinces = RegionService::all();
        $regionSelectorData = $this->buildRegionSelectorData($provinces);
        $allChannels = config('customer_service.channels', []);
        $otherChannels = array_values(array_filter(
            $allChannels,
            static fn (array $item): bool => ($item['slug'] ?? '') !== $socialMedia
        ));

        $viewData = [
            'channel' => $channel,
            'whatsappNumber' => $whatsappNumber,
            'socialUrl' => $socialUrl,
            'contextualWaMsg' => $contextualWaMsg,
            'contextualWaUrl' => $contextualWaUrl,
            'provinces' => $provinces,
            'regionSelectorData' => $regionSelectorData,
            'otherChannels' => $otherChannels,
        ];

        $viewData = match ($socialMedia) {
            'whatsapp' => [
                ...$viewData,
                'services' => Service::where('is_active', true)->orderBy('order')->limit(6)->get(),
            ],
            'instagram' => [
                ...$viewData,
                'galleries' => Gallery::where('is_active', true)->orderBy('order')->latest('id')->limit(6)->get(),
            ],
            'tiktok' => [
                ...$viewData,
                'services' => Service::where('is_active', true)->orderBy('order')->get(),
                'durationAnswer' => (string) config('service_facts.duration_answer'),
            ],
            'facebook' => [
                ...$viewData,
                'reviews' => Review::where('is_active', true)->with('service:id,name')->latest('id')->limit(6)->get(),
            ],
            'youtube' => [
                ...$viewData,
                'equipments' => Equipment::where('is_active', true)->orderBy('order')->limit(6)->get(),
            ],
            'linkedin' => [
                ...$viewData,
                'portfolios' => Portfolio::where('is_active', true)->with('services:id,name')->orderBy('order')->limit(6)->get(),
            ],
            'x' => [
                ...$viewData,
                'articles' => Article::where('is_published', true)
                    ->with(['categoryRelation', 'subcategoryRelation'])
                    ->latest('published_at')
                    ->latest('id')
                    ->limit(6)
                    ->get(),
            ],
            default => $viewData,
        };

        return view("customer-service.{$socialMedia}", $viewData);
    }

    /**
     * Resolve channel-specific WhatsApp number with global fallback.
     */
    private function resolveWhatsappNumber(array $channel): string
    {
        $raw = (string) ($channel['whatsapp_number'] ?? '');
        $digits = preg_replace('/[^0-9]/', '', $raw);
        if ($digits !== '') {
            return $digits;
        }

        $fallback = (string) (config('app.whatsapp_number') ?: '6285609009009');
        $fallbackDigits = preg_replace('/[^0-9]/', '', $fallback);

        return $fallbackDigits !== '' ? $fallbackDigits : '6285609009009';
    }

    /**
     * Build standard WhatsApp greeting per channel.
     */
    private function buildDefaultWaMessage(string $adminCode, ?string $area = null): string
    {
        $region = $area !== null && trim($area) !== '' ? trim($area) : '(mohon info posko terdekat)';

        return "Hallo admin {$adminCode} drainusantara, saluran saya mampet di daerah {$region}";
    }

    /**
     * Compact region dataset for Alpine area pickers and posko search.
     */
    private function buildRegionSelectorData(array $provinces): array
    {
        $result = [];
        foreach ($provinces as $provSlug => $prov) {
            $cities = [];
            foreach ($prov['cities'] ?? [] as $citySlug => $city) {
                $cities[] = [
                    'slug' => $city['slug'] ?? $citySlug,
                    'name' => $city['name'],
                    'posko_address' => $city['posko_address'] ?? ('Posko Armada Siaga '.$city['name']),
                    'districts' => array_values($city['districts'] ?? []),
                ];
            }
            $result[] = [
                'slug' => $prov['slug'] ?? $provSlug,
                'name' => $prov['name'],
                'cities' => $cities,
            ];
        }

        return $result;
    }

    /**
     * Attach FAQPage JSON-LD schema from Q&A items.
     */
    private function attachFaqSchema(array $faqs): void
    {
        if (empty($faqs)) {
            return;
        }

        $faqSchema = JsonLdMulti::newJsonLd();
        $faqSchema->setType('FAQPage');
        $faqSchema->addValues([
            'mainEntity' => array_values(array_map(static fn (array $faq): array => [
                '@type' => 'Question',
                'name' => (string) ($faq['question'] ?? ''),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => (string) ($faq['answer'] ?? ''),
                ],
            ], $faqs)),
        ]);
    }
}
