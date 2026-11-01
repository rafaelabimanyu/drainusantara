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
            ->limit(3)
            ->get();

        if ($relatedCaseStudies->count() < 3) {
            $extra = Gallery::where('is_active', true)
                ->where('id', '!=', $caseStudy->id)
                ->whereNotIn('id', $relatedCaseStudies->pluck('id'))
                ->limit(3 - $relatedCaseStudies->count())
                ->get();
            $relatedCaseStudies = $relatedCaseStudies->concat($extra);
        }

        PageMetadata::title($caseStudy->title.' | Studi Kasus Drainusantara');
        SEOMeta::setDescription(Str::limit(strip_tags((string) ($caseStudy->description ?? $caseStudy->content ?? '')), 160));
        SEOMeta::setCanonical(route('case-study.show', $slug));

        $imageUrl = asset($caseStudy->main_image ?? 'images/default.webp');

        OpenGraph::setDescription(Str::limit(strip_tags((string) ($caseStudy->description ?? $caseStudy->content ?? '')), 160));
        OpenGraph::setUrl(route('case-study.show', $slug));
        OpenGraph::addImage($imageUrl);

        TwitterCard::setDescription(Str::limit(strip_tags((string) ($caseStudy->description ?? $caseStudy->content ?? '')), 160));
        TwitterCard::setImage($imageUrl);

        JsonLdMulti::setTitle($caseStudy->title.' | Studi Kasus Drainusantara');
        JsonLdMulti::setDescription(Str::limit(strip_tags((string) ($caseStudy->description ?? $caseStudy->content ?? '')), 160));
        JsonLdMulti::setType('Article');

        $this->addBreadcrumb(['Studi Kasus', route('gallery')], [$caseStudy->title, route('case-study.show', $slug)]);

        return view('studi-kasus.show', compact('caseStudy', 'relatedCaseStudies'));
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
            ->limit(3)
            ->get();

        if ($relatedPartnerships->count() < 3) {
            $extra = Portfolio::where('is_active', true)
                ->where('id', '!=', $partnership->id)
                ->whereNotIn('id', $relatedPartnerships->pluck('id'))
                ->limit(3 - $relatedPartnerships->count())
                ->get();
            $relatedPartnerships = $relatedPartnerships->concat($extra);
        }

        $serviceNames = $partnership->services->pluck('name')->implode(', ');
        $serviceSuffix = $serviceNames !== '' ? ' | '.$serviceNames : '';
        $locationSuffix = $partnership->location ? ' di '.$partnership->location : '';
        $pageTitle = 'Kerjasama Drainusantara x '.$partnership->client_name.$serviceSuffix.$locationSuffix;

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription(Str::limit(strip_tags((string) ($partnership->description ?? $partnership->about_client ?? '')), 160));
        SEOMeta::setCanonical(route('partnership.show', $slug));

        $seoImage = $partnership->image ?: ($partnership->logo ?: asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $seoImageUrl = filter_var($seoImage, FILTER_VALIDATE_URL) ? $seoImage : asset($seoImage);

        OpenGraph::setDescription(Str::limit(strip_tags((string) ($partnership->description ?? $partnership->about_client ?? '')), 160));
        OpenGraph::setUrl(route('partnership.show', $slug));
        OpenGraph::addImage($seoImageUrl);

        TwitterCard::setDescription(Str::limit(strip_tags((string) ($partnership->description ?? $partnership->about_client ?? '')), 160));
        TwitterCard::setImage($seoImageUrl);

        JsonLdMulti::setTitle($pageTitle);
        JsonLdMulti::setDescription(Str::limit(strip_tags((string) ($partnership->description ?? $partnership->about_client ?? '')), 160));
        JsonLdMulti::setType('Article');

        $this->addBreadcrumb(['Kemitraan', route('gallery')], [$partnership->client_name, route('partnership.show', $slug)]);

        return view('kemitraan.show', compact('partnership', 'relatedPartnerships'));
    }
}

