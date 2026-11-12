<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use App\Models\Service;
use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index(): View
    {
        $articles = Article::latest('published_at')->latest()->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        $categories = ArticleCategory::ensureDefaults();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $cities = RegionService::allCities();

        return view('admin.articles.create', compact('categories', 'services', 'cities'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $record = new Article;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $slug = substr(Str::slug($validated['title']), 0, 255);
            $baseSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = substr($baseSlug, 0, 255 - strlen("-{$counter}")) . "-{$counter}";
                $counter++;
            }

            $metaTitle = !empty($validated['meta_title']) ? $validated['meta_title'] : mb_substr("{$validated['title']} - Drainusantara", 0, 255);
            $metaDescription = !empty($validated['meta_description']) ? $validated['meta_description'] : Str::limit(strip_tags($validated['content']), 150);

            $isPublished = $request->boolean('is_published');
            $publishedAt = null;
            if ($isPublished) {
                $publishedAt = !empty($validated['published_at']) ? \Carbon\Carbon::parse($validated['published_at']) : now();
            }

            $thumbnailUrl = $validated['thumbnail_url'] ?? null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailUrl = $media->upload($request->file('thumbnail'), 'articles', true);
            } elseif (is_string($request->input('thumbnail')) && !empty($request->input('thumbnail'))) {
                $thumbnailUrl = $request->input('thumbnail');
            } elseif (!$thumbnailUrl) {
                $thumbnailUrl = 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode(mb_strcut($validated['title'], 0, 69, 'UTF-8'));
            }

            $contentImages = [];
            for ($i = 1; $i <= 3; $i++) {
                $imgFile = $request->file("content_image_{$i}");
                $caption = $request->input("content_caption_{$i}");
                $path = null;
                if ($imgFile) {
                    $path = $media->upload($imgFile, 'articles', true);
                } elseif ($request->filled("content_image_{$i}") && is_string($request->input("content_image_{$i}"))) {
                    $path = $request->input("content_image_{$i}");
                }
                if ($path) {
                    $contentImages[] = [
                        'path' => $path,
                        'caption' => $caption ?: '',
                    ];
                }
            }

            $categoryId = !empty($validated['category_id']) ? (int) $validated['category_id'] : null;
            $subcategoryId = !empty($validated['subcategory_id']) ? (int) $validated['subcategory_id'] : null;
            $categoryName = array_key_exists('category', $validated) ? ($validated['category'] ?: null) : null;
            $subCategoryName = array_key_exists('sub_category', $validated) ? ($validated['sub_category'] ?: null) : null;

            if ($categoryId) {
                $cat = ArticleCategory::find($categoryId);
                if ($cat) {
                    $categoryName = $cat->name;
                }
            } elseif ($categoryName) {
                $cat = ArticleCategory::where('name', $categoryName)->orWhere('slug', Str::slug($categoryName))->first();
                if ($cat) {
                    $categoryId = $cat->id;
                    $categoryName = $cat->name;
                }
            }

            if ($subcategoryId) {
                $sub = ArticleSubcategory::find($subcategoryId);
                if ($sub) {
                    $subCategoryName = $sub->name;
                    if (!$categoryId) {
                        $categoryId = $sub->category_id;
                        $categoryName = $sub->category->name ?? $categoryName;
                    }
                }
            } elseif ($subCategoryName && $categoryId) {
                $sub = ArticleSubcategory::where('category_id', $categoryId)
                    ->where(function ($q) use ($subCategoryName): void {
                        $q->where('name', $subCategoryName)->orWhere('slug', Str::slug($subCategoryName));
                    })->first();
                if ($sub) {
                    $subcategoryId = $sub->id;
                    $subCategoryName = $sub->name;
                }
            }

            $media->save($record, [
                'title' => $validated['title'],
                'slug' => $slug,
                'thumbnail' => $thumbnailUrl,
                'image_placement' => $validated['image_placement'] ?? 'content',
                'content_images' => !empty($contentImages) ? $contentImages : null,
                'category' => $categoryName,
                'sub_category' => $subCategoryName,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'service_id' => $validated['service_id'] ?? null,
                'city' => $validated['city'] ?? null,
                'tags' => $validated['tags'] ?? null,
                'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 120),
                'content' => $validated['content'],
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'is_published' => $isPublished,
                'published_at' => $publishedAt,
            ]);
        });

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$validated['title']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article): View
    {
        $categories = ArticleCategory::ensureDefaults();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $cities = RegionService::allCities();

        return view('admin.articles.edit', compact('article', 'categories', 'services', 'cities'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $validated = $request->validated();

        $media = new MediaLifecycle;
        $media->run($article, function () use ($request, $validated, $media, $article): void {
            $isPublished = $request->boolean('is_published');
            $publishedAt = null;
            if ($isPublished) {
                if (!empty($validated['published_at'])) {
                    $publishedAt = \Carbon\Carbon::parse($validated['published_at']);
                } else {
                    $publishedAt = $article->published_at ?? now();
                }
            }

            $thumbnailUrl = $article->thumbnail;
            if ($request->boolean('remove_thumbnail')) {
                $thumbnailUrl = null;
            } elseif ($request->hasFile('thumbnail')) {
                $thumbnailUrl = $media->upload($request->file('thumbnail'), 'articles', true);
            } elseif (!empty($validated['thumbnail_url'])) {
                $thumbnailUrl = $validated['thumbnail_url'];
            }

            $existingImages = is_array($article->content_images) ? array_values($article->content_images) : [];
            $contentImages = [];
            for ($i = 1; $i <= 3; $i++) {
                $existingItem = $existingImages[$i - 1] ?? null;
                $remove = $request->boolean("remove_content_image_{$i}");
                $imgFile = $request->file("content_image_{$i}");
                $caption = $request->input("content_caption_{$i}");

                if ($remove) {
                    continue;
                }

                $path = null;
                if ($imgFile) {
                    $path = $media->upload($imgFile, 'articles', true);
                } elseif ($request->filled("content_image_{$i}") && is_string($request->input("content_image_{$i}"))) {
                    $path = $request->input("content_image_{$i}");
                } elseif (!empty($existingItem['path'])) {
                    $path = $existingItem['path'];
                }

                if ($path) {
                    $contentImages[] = [
                        'path' => $path,
                        'caption' => !is_null($caption) ? (string) $caption : ($existingItem['caption'] ?? ''),
                    ];
                }
            }

            $hasCatKey = array_key_exists('category', $validated);
            $categoryName = $hasCatKey ? ($validated['category'] ?: null) : $article->category;

            $hasSubKey = array_key_exists('sub_category', $validated);
            $subCategoryName = $hasSubKey ? ($validated['sub_category'] ?: null) : $article->sub_category;

            $categoryId = array_key_exists('category_id', $validated)
                ? (!empty($validated['category_id']) ? (int) $validated['category_id'] : null)
                : $article->category_id;
            $subcategoryId = array_key_exists('subcategory_id', $validated)
                ? (!empty($validated['subcategory_id']) ? (int) $validated['subcategory_id'] : null)
                : $article->subcategory_id;

            if ($categoryId && $categoryName) {
                $cat = ArticleCategory::find($categoryId);
                if ($cat) {
                    $categoryName = $cat->name;
                }
            } elseif ($categoryName) {
                $cat = ArticleCategory::where('name', $categoryName)->orWhere('slug', Str::slug($categoryName))->first();
                if ($cat) {
                    $categoryId = $cat->id;
                    $categoryName = $cat->name;
                }
            } elseif ($hasCatKey && is_null($categoryName)) {
                $categoryId = null;
            }

            if ($subcategoryId && $subCategoryName) {
                $sub = ArticleSubcategory::find($subcategoryId);
                if ($sub) {
                    $subCategoryName = $sub->name;
                    if (!$categoryId) {
                        $categoryId = $sub->category_id;
                        $categoryName = $sub->category->name ?? $categoryName;
                    }
                }
            } elseif ($subCategoryName && $categoryId) {
                $sub = ArticleSubcategory::where('category_id', $categoryId)
                    ->where(function ($q) use ($subCategoryName): void {
                        $q->where('name', $subCategoryName)->orWhere('slug', Str::slug($subCategoryName));
                    })->first();
                if ($sub) {
                    $subcategoryId = $sub->id;
                    $subCategoryName = $sub->name;
                }
            } elseif ($hasSubKey && is_null($subCategoryName)) {
                $subcategoryId = null;
            }

            $media->save($article, [
                'title' => $validated['title'],
                'category' => $categoryName,
                'sub_category' => $subCategoryName,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'service_id' => array_key_exists('service_id', $validated) ? $validated['service_id'] : $article->service_id,
                'city' => array_key_exists('city', $validated) ? $validated['city'] : $article->city,
                'thumbnail' => $thumbnailUrl,
                'image_placement' => $validated['image_placement'] ?? ($article->image_placement ?? 'content'),
                'content_images' => !empty($contentImages) ? $contentImages : null,
                'tags' => array_key_exists('tags', $validated) ? $validated['tags'] : $article->tags,
                'excerpt' => array_key_exists('excerpt', $validated) ? $validated['excerpt'] : $article->excerpt,
                'content' => $validated['content'],
                'meta_title' => array_key_exists('meta_title', $validated) ? $validated['meta_title'] : $article->meta_title,
                'meta_description' => array_key_exists('meta_description', $validated) ? $validated['meta_description'] : $article->meta_description,
                'is_published' => $isPublished,
                'published_at' => $publishedAt,
            ]);
        });

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui!");
    }

    /**
     * Upload an inline image from TinyMCE/Rich Editor, converted to WebP.
     */
    public function uploadEditorImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:20480'],
        ]);

        $file = $request->file('file');
        if (! $file || ! $file->isValid()) {
            return response()->json(['error' => 'Berkas gambar tidak valid atau gagal diunggah.'], 422);
        }

        $media = new MediaLifecycle;
        try {
            $path = $media->upload($file, 'articles', true);
            $url = asset(ltrim($path, '/'));

            return response()->json([
                'location' => $url,
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Gagal memproses dan mengonversi gambar ke WebP: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $title = $article->title;
        (new MediaLifecycle)->run($article, fn () => $article->delete());

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$title}' berhasil dihapus.");
    }
}
