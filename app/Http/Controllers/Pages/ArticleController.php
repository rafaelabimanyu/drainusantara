<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use HasPageSeo;

    /**
     * Display the Blog & Education listing page.
     */
    public function articles(): View
    {
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $canonical = route('articles.index', $page > 1 ? ['page' => $page] : []);
        PageMetadata::title('Panduan & Edukasi Perawatan Saluran Pipa');
        SEOMeta::setDescription('Blog resmi Drainusantara: panduan teknis pelancaran wastafel, bahaya soda api pada pipa PVC, teknologi mesin spiral rotary, kamera CCTV drainase, dan tips sanitasi.');
        SEOMeta::setCanonical($canonical);

        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl($canonical);
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addBreadcrumb(['Blog', route('articles.index')]);

        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        $featuredArticle = Article::where('is_published', true)
            ->latest('published_at')
            ->first();

        $youtubeVideos = [
            [
                'id' => 'uE_yM6aK1S0',
                'title' => 'Teknik Rooter Spiral Baja Melancarkan Pipa Wastafel Membatu',
                'description' => 'Melihat langsung daya puntir kabel spiral baja lentur menembus endapan lemak sisa cucian yang membatu di leher angsa pipa tanpa merusak dinding.',
                'duration' => '04:15',
                'tag' => 'Mesin Spiral Rotary',
            ],
            [
                'id' => 'kX9nCjZ0q2U',
                'title' => 'Inspeksi Kamera CCTV IP68 Mendeteksi Sumbatan Titik Terdalam',
                'description' => 'Navigasi lensa kamera endoskopi pipa tahan air untuk mengidentifikasi lokasi sumbatan akar pohon dan keretakan jalur pipa secara akurat.',
                'duration' => '05:30',
                'tag' => 'Inspeksi Kamera CCTV',
            ],
            [
                'id' => 'w4bT1c_d9qQ',
                'title' => 'Penanganan Grease Trap Lemak Beku Restoran Komersial',
                'description' => 'Prosedur pembersihan sedimentasi minyak dan lemak kental pada bak kontrol dapur komersial untuk mencegah luapan air kotor saat jam operasional.',
                'duration' => '06:10',
                'tag' => 'Solusi Restoran & B2B',
            ],
        ];

        return view('articles.index', compact('articles', 'featuredArticle', 'youtubeVideos'));
    }

    /**
     * Display the Article Detail page.
     */
    public function articleDetail(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $sessionKey = 'viewed_article_' . $article->id;
        if (!session()->has($sessionKey)) {
            $article->increment('views_count');
            session()->put($sessionKey, true);
        }

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
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('articles.index')],
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

        // 1. Sidebar: Panduan Lainnya (Artikel terbaru kecuali artikel aktif)
        $recentArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // 2. Bottom Section: Rekomendasi Terkait (Kategori sama, wajib berbeda dari sidebar & artikel aktif)
        $excludedIds = $recentArticles->pluck('id')->push($article->id)->all();

        $relatedArticles = Article::where('is_published', true)
            ->whereNotIn('id', $excludedIds)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $needed = 3 - $relatedArticles->count();
            $combinedExcluded = array_merge($excludedIds, $relatedArticles->pluck('id')->all());
            $fallback = Article::where('is_published', true)
                ->whereNotIn('id', $combinedExcluded)
                ->latest('published_at')
                ->take($needed)
                ->get();
            $relatedArticles = $relatedArticles->concat($fallback);
        }

        return view('articles.show', compact('article', 'recentArticles', 'relatedArticles', 'prevArticle', 'nextArticle'));
    }
}

