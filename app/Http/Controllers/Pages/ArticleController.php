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
     * Display the Articles & Education listing page.
     */
    public function articles(): View
    {
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $canonical = route('articles.index', $page > 1 ? ['page' => $page] : []);
        PageMetadata::title('Panduan & Edukasi Perawatan Saluran Pipa');
        SEOMeta::setDescription('Kumpulan artikel teknis: cara melancarkan wastafel, bahaya soda api pada pipa PVC cor, dan perawatan sanitasi rumah tangga tanpa bongkar keramik.');
        SEOMeta::setCanonical($canonical);

        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl($canonical);
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addBreadcrumb(['Pengetahuan & Edukasi', route('articles.index')]);

        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        $featuredArticle = Article::where('is_published', true)
            ->latest('published_at')
            ->first();

        return view('articles.index', compact('articles', 'featuredArticle'));
    }

    /**
     * Display the Article Detail page.
     */
    public function articleDetail(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

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
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Pengetahuan & Edukasi', 'item' => route('articles.index')],
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

        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $fallback = Article::where('is_published', true)
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->concat($fallback);
        }

        $recentArticles = $relatedArticles;

        return view('articles.show', compact('article', 'recentArticles', 'relatedArticles', 'prevArticle', 'nextArticle'));
    }
}

