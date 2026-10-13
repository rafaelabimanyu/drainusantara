<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
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
        return view('admin.articles.create');
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

            $thumbnailUrl = $validated['thumbnail_url'] ?? null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailUrl = $media->upload($request->file('thumbnail'), 'articles', true);
            } elseif (is_string($request->input('thumbnail')) && !empty($request->input('thumbnail'))) {
                $thumbnailUrl = $request->input('thumbnail');
            } elseif (!$thumbnailUrl) {
                $thumbnailUrl = 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode(mb_strcut($validated['title'], 0, 69, 'UTF-8'));
            }

            $media->save($record, [
                'title' => $validated['title'],
                'slug' => $slug,
                'thumbnail' => $thumbnailUrl,
                'category' => $validated['category'] ?? 'Tips & Edukasi',
                'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 120),
                'content' => $validated['content'],
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'is_published' => $isPublished,
                'published_at' => $isPublished ? now() : null,
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
        return view('admin.articles.edit', compact('article'));
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

            $thumbnailUrl = $article->thumbnail;
            if ($request->hasFile('thumbnail')) {
                $thumbnailUrl = $media->upload($request->file('thumbnail'), 'articles', true);
            } elseif (!empty($validated['thumbnail_url'])) {
                $thumbnailUrl = $validated['thumbnail_url'];
            }

            $media->save($article, [
                'title' => $validated['title'],
                'category' => array_key_exists('category', $validated) ? $validated['category'] : $article->category,
                'thumbnail' => $thumbnailUrl,
                'excerpt' => array_key_exists('excerpt', $validated) ? $validated['excerpt'] : $article->excerpt,
                'content' => $validated['content'],
                'meta_title' => array_key_exists('meta_title', $validated) ? $validated['meta_title'] : $article->meta_title,
                'meta_description' => array_key_exists('meta_description', $validated) ? $validated['meta_description'] : $article->meta_description,
                'is_published' => $isPublished,
                'published_at' => $isPublished ? ($article->published_at ?? now()) : null,
            ]);
        });

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui!");
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
