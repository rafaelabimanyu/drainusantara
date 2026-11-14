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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use HasPageSeo;

    /**
     * Display the Blog & Education listing page.
     */
    public function articles(Request $request): View
    {
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $searchTerm = trim((string) ($request->input('q') ?: $request->input('search')));

        $canonicalParams = [];
        if ($page > 1) {
            $canonicalParams['page'] = $page;
        }
        if ($searchTerm !== '') {
            $canonicalParams['q'] = $searchTerm;
        }
        $canonical = route('articles.index', $canonicalParams);

        $pageTitle = $searchTerm !== ''
            ? "Pencarian '{$searchTerm}' - Panduan Perawatan Pipa"
            : 'Panduan & Edukasi Perawatan Saluran Pipa';

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription('Blog resmi Drainusantara: panduan teknis pelancaran wastafel, bahaya soda api pada pipa PVC, teknologi mesin spiral rotary, kamera CCTV drainase, dan tips sanitasi.');
        SEOMeta::setCanonical($canonical);

        OpenGraph::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        OpenGraph::setUrl($canonical);
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tips ahli dan panduan seputar perawatan saluran pembuangan air, wastafel, toilet, dan drainase rumah.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addBreadcrumb(['Blog', route('articles.index')]);

        $query = Article::where('is_published', true)->with(['categoryRelation', 'subcategoryRelation']);
        if ($searchTerm !== '') {
            $like = '%' . $searchTerm . '%';
            $query->where(function ($q) use ($like) {
                $q->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like)
                    ->orWhere('content', 'like', $like)
                    ->orWhere('tags', 'like', $like);
            });
        }

        if ($request->filled('category')) {
            $catParam = strtolower((string) $request->input('category'));
            if ($catParam !== 'all') {
                $query->where(function ($q) use ($catParam) {
                    $q->whereHas('categoryRelation', fn ($rel) => $rel->where('slug', $catParam)->orWhereRaw('LOWER(name) = ?', [$catParam]))
                      ->orWhereRaw('LOWER(category) = ?', [$catParam])
                      ->orWhere('category', 'like', "%{$catParam}%");
                });
            }
        }

        if ($request->filled('sub')) {
            $subParam = strtolower((string) $request->input('sub'));
            if ($subParam !== 'all') {
                $query->where(function ($q) use ($subParam) {
                    $q->whereHas('subcategoryRelation', fn ($rel) => $rel->where('slug', $subParam)->orWhereRaw('LOWER(name) = ?', [$subParam]))
                      ->orWhereRaw('LOWER(sub_category) = ?', [$subParam])
                      ->orWhere('sub_category', 'like', "%{$subParam}%");
                });
            }
        }

        $articles = $query->latest('published_at')->paginate(12)->withQueryString();

        $featuredArticle = ($searchTerm !== '' || ($request->filled('category') && strtolower((string) $request->input('category')) !== 'all') || ($request->filled('sub') && strtolower((string) $request->input('sub')) !== 'all'))
            ? null
            : Article::where('is_published', true)
                ->with(['categoryRelation', 'subcategoryRelation'])
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
     * Display the Article Detail page via URL Silo structure: /edukasi/{category}/{subcategory}/{slug}
     */
    public function articleSiloDetail(string $category, string $subcategory, string $slug): View|RedirectResponse
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->firstOrFail();

        // Enforce strict category and subcategory slug match. If mismatched, 301 redirect to canonical silo URL
        if ($category !== $article->category_slug || $subcategory !== $article->subcategory_slug) {
            return redirect()->to($article->silo_url, 301);
        }

        return $this->renderArticleView($article);
    }

    /**
     * Legacy article detail route (/artikel/{slug}): 301 Permanent Redirect to official Silo URL.
     */
    public function articleDetail(string $slug): RedirectResponse
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->firstOrFail();

        return redirect()->to($article->silo_url, 301);
    }

    /**
     * Render the full Article Detail view with optimized metadata, canonical, and schemas.
     */
    protected function renderArticleView(Article $article): View
    {
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
        SEOMeta::setCanonical($article->silo_url);

        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl($article->silo_url);
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
                '@type' => 'Organization',
                'name' => 'Tim Ahli Teknis Drainusantara (PT Jawa Jaya Rooter)',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'PT JAWA JAYA ROOTER',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'),
                ],
            ],
            'articleSection' => $article->category_label ?? 'Edukasi',
            'inLanguage' => 'id-ID',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $article->silo_url,
            ],
        ]);

        $breadcrumbElements = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Edukasi', 'item' => route('articles.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $article->category_label, 'item' => url('/edukasi/' . $article->category_slug)],
        ];

        if (!empty($article->sub_category)) {
            $breadcrumbElements[] = [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $article->sub_category,
                'item' => url('/edukasi/' . $article->category_slug . '/' . $article->subcategory_slug),
            ];
            $breadcrumbElements[] = [
                '@type' => 'ListItem',
                'position' => 5,
                'name' => $article->title,
                'item' => $article->silo_url,
            ];
        } else {
            $breadcrumbElements[] = [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $article->title,
                'item' => $article->silo_url,
            ];
        }

        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => $breadcrumbElements,
        ]);

        $prevArticle = Article::where('is_published', true)
            ->where('published_at', '<', $article->published_at ?? $article->created_at)
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->orderByDesc('published_at')
            ->first();

        $nextArticle = Article::where('is_published', true)
            ->where('published_at', '>', $article->published_at ?? $article->created_at)
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->orderBy('published_at')
            ->first();

        // 1. Sidebar: Panduan Lainnya (Artikel terbaru kecuali artikel aktif)
        $recentArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->latest('published_at')
            ->take(3)
            ->get();

        // 2. Bottom Section: Rekomendasi Terkait (Kategori sama, wajib berbeda dari sidebar & artikel aktif)
        $excludedIds = $recentArticles->pluck('id')->push($article->id)->all();

        $relatedArticles = Article::where('is_published', true)
            ->whereNotIn('id', $excludedIds)
            ->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))
            ->when(!$article->category_id && $article->category, fn ($q) => $q->where('category', $article->category))
            ->with(['categoryRelation', 'subcategoryRelation'])
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $needed = 3 - $relatedArticles->count();
            $combinedExcluded = array_merge($excludedIds, $relatedArticles->pluck('id')->all());
            $fallback = Article::where('is_published', true)
                ->whereNotIn('id', $combinedExcluded)
                ->with(['categoryRelation', 'subcategoryRelation'])
                ->latest('published_at')
                ->take($needed)
                ->get();
            $relatedArticles = $relatedArticles->concat($fallback);
        }

        $contextualWaMsg = "Halo Tim Drainusantara, saya sedang membaca artikel '{$article->title}' dan ingin konsultasi penanganan saluran pipa di tempat saya.";
        $contextualWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($contextualWaMsg);

        return view('articles.show', compact('article', 'recentArticles', 'relatedArticles', 'prevArticle', 'nextArticle', 'contextualWaMsg', 'contextualWaUrl'));
    }
}

