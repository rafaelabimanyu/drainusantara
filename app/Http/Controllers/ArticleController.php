<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable'],
            'thumbnail_url' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $metaTitle = !empty($validated['meta_title']) ? $validated['meta_title'] : "{$validated['title']} - Drainusantara";
        $metaDescription = !empty($validated['meta_description']) ? $validated['meta_description'] : Str::limit(strip_tags($validated['content']), 150);

        $isPublished = $request->boolean('is_published', true);

        $thumbnailUrl = $validated['thumbnail_url'] ?? null;
        if ($request->hasFile('thumbnail')) {
            $request->validate(['thumbnail' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $thumbnailUrl = Storage::url($request->file('thumbnail')->store('articles', 'public'));
        } elseif (is_string($request->input('thumbnail')) && !empty($request->input('thumbnail'))) {
            $thumbnailUrl = $request->input('thumbnail');
        } elseif (!$thumbnailUrl) {
            $thumbnailUrl = 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode($validated['title']);
        }

        Article::create([
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
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable'],
            'thumbnail_url' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $isPublished = $request->boolean('is_published', true);

        $thumbnailUrl = $article->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $request->validate(['thumbnail' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $thumbnailUrl = Storage::url($request->file('thumbnail')->store('articles', 'public'));
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnailUrl = $validated['thumbnail_url'];
        }

        $article->update([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? 'Tips & Edukasi',
            'thumbnail' => $thumbnailUrl,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 120),
            'content' => $validated['content'],
            'meta_title' => $validated['meta_title'] ?? $article->meta_title,
            'meta_description' => $validated['meta_description'] ?? $article->meta_description,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? ($article->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui!");
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $title = $article->title;
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel '{$title}' berhasil dihapus.");
    }
}
