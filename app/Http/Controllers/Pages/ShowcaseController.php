<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ShowcaseController extends Controller
{
    use HasPageSeo;

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
     * Display a single Case Study (Studi Kasus) detail page.
     */
    public function showCaseStudy(string $slug): View
    {
        $caseStudy = Cache::remember('case_study_'.$slug, 86400, function () use ($slug) {
            return Gallery::where('slug', $slug)
                ->where('is_active', true)
                ->with(['service', 'equipment'])
                ->firstOrFail();
        });

        $relatedCaseStudies = Gallery::where('is_active', true)
            ->where('id', '!=', $caseStudy->id)
            ->where('category', $caseStudy->category)
            ->with(['service', 'equipment'])
            ->limit(3)
            ->get();

        if ($relatedCaseStudies->count() < 3) {
            $extra = Gallery::where('is_active', true)
                ->where('id', '!=', $caseStudy->id)
                ->whereNotIn('id', $relatedCaseStudies->pluck('id'))
                ->with(['service', 'equipment'])
                ->limit(3 - $relatedCaseStudies->count())
                ->get();
            $relatedCaseStudies = $relatedCaseStudies->concat($extra);
        }

        $summary = Str::limit(strip_tags((string) ($caseStudy->description ?? $caseStudy->content ?? '')), 160);

        PageMetadata::title($caseStudy->title.' | Studi Kasus');
        SEOMeta::setDescription($summary);
        SEOMeta::setCanonical(route('case-study.show', $slug));

        $rawImage = $caseStudy->before_image ?: ($caseStudy->image ?: ($caseStudy->after_image ?: $caseStudy->main_image));
        $imageUrl = $rawImage
            ? (filter_var($rawImage, FILTER_VALIDATE_URL) ? $rawImage : asset($rawImage))
            : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');

        OpenGraph::setDescription($summary);
        OpenGraph::setUrl(route('case-study.show', $slug));
        OpenGraph::addImage($imageUrl);

        TwitterCard::setDescription($summary);
        TwitterCard::setImage($imageUrl);

        $equipmentNames = ($caseStudy->equipment ?? collect())->pluck('name')->filter()->values()->all();
        $articleSchemaValues = [
            'headline' => $caseStudy->title,
            'description' => $summary,
            'image' => $imageUrl,
            'datePublished' => optional($caseStudy->created_at)->toIso8601String() ?? now()->toIso8601String(),
            'dateModified' => optional($caseStudy->updated_at)->toIso8601String() ?? optional($caseStudy->created_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo/WebIcon.webp'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('case-study.show', $slug),
            ],
        ];
        if (! empty($equipmentNames)) {
            $articleSchemaValues['about'] = [
                '@type' => 'ItemList',
                'itemListElement' => array_map(static fn (string $name, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $name,
                ], $equipmentNames, array_keys($equipmentNames)),
            ];
        }

        JsonLdMulti::setTitle($caseStudy->title.' | Studi Kasus Drainusantara');
        JsonLdMulti::setDescription($summary);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addValues($articleSchemaValues);

        $this->addBreadcrumb(['Studi Kasus', route('gallery')], [$caseStudy->title, route('case-study.show', $slug)]);

        $contextualWaMsg = "Halo Tim Drainusantara, saya melihat dokumentasi '{$caseStudy->title}' dan ingin tanya estimasi untuk penanganan serupa.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('studi-kasus.show', compact('caseStudy', 'relatedCaseStudies', 'contextualWaMsg', 'contextualWaUrl'));
    }

    /**
     * Display a single Partnership / Client Portfolio detail page.
     */
    public function showPartnership(string $slug): View
    {
        $partnership = Cache::remember('partnership_'.$slug, 86400, function () use ($slug) {
            return Portfolio::where('slug', $slug)
                ->where('is_active', true)
                ->with('services')
                ->firstOrFail();
        });

        $relatedPartnerships = Portfolio::where('is_active', true)
            ->where('id', '!=', $partnership->id)
            ->where('client_type', $partnership->client_type)
            ->with('services')
            ->limit(3)
            ->get();

        if ($relatedPartnerships->count() < 3) {
            $extra = Portfolio::where('is_active', true)
                ->where('id', '!=', $partnership->id)
                ->whereNotIn('id', $relatedPartnerships->pluck('id'))
                ->with('services')
                ->limit(3 - $relatedPartnerships->count())
                ->get();
            $relatedPartnerships = $relatedPartnerships->concat($extra);
        }

        $serviceNames = $partnership->services->pluck('name')->implode(', ');
        $serviceSuffix = $serviceNames !== '' ? ' | '.$serviceNames : '';
        $locationSuffix = $partnership->location ? ' di '.$partnership->location : '';
        $pageTitle = 'Kemitraan '.$partnership->client_name.$serviceSuffix.$locationSuffix;
        $summary = Str::limit(strip_tags((string) ($partnership->description ?? $partnership->about_client ?? '')), 160);

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription($summary);
        SEOMeta::setCanonical(route('partnership.show', $slug));

        $seoImage = $partnership->image ?: ($partnership->logo ?: asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $seoImageUrl = filter_var($seoImage, FILTER_VALIDATE_URL) ? $seoImage : asset($seoImage);

        OpenGraph::setDescription($summary);
        OpenGraph::setUrl(route('partnership.show', $slug));
        OpenGraph::addImage($seoImageUrl);

        TwitterCard::setDescription($summary);
        TwitterCard::setImage($seoImageUrl);

        JsonLdMulti::setTitle($pageTitle);
        JsonLdMulti::setDescription($summary);
        JsonLdMulti::setType('Article');
        JsonLdMulti::addValues([
            'headline' => 'Kemitraan Pemeliharaan Saluran Drainase: '.$partnership->client_name,
            'description' => $summary,
            'image' => $seoImageUrl,
            'datePublished' => optional($partnership->created_at)->toIso8601String() ?? now()->toIso8601String(),
            'dateModified' => optional($partnership->updated_at)->toIso8601String() ?? optional($partnership->created_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Drainusantara',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo/WebIcon.webp'),
                ],
            ],
            'collaboratedWith' => [
                '@type' => 'Organization',
                'name' => $partnership->client_name,
                'description' => $partnership->client_type ?? 'Mitra Usaha',
                'address' => $partnership->location ?? 'Indonesia',
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('partnership.show', $slug),
            ],
        ]);

        $this->addBreadcrumb(['Kemitraan', route('gallery')], [$partnership->client_name, route('partnership.show', $slug)]);

        $targetTitle = $partnership->project_title ?: $partnership->client_name;
        $contextualWaMsg = "Halo Tim Drainusantara, saya melihat dokumentasi '{$targetTitle}' dan ingin tanya estimasi untuk penanganan serupa.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('kemitraan.show', compact('partnership', 'relatedPartnerships', 'contextualWaMsg', 'contextualWaUrl'));
    }
}

