<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of categories and subcategories.
     */
    public function index(): View
    {
        $categories = ArticleCategory::with(['subcategories' => function ($q): void {
            $q->withCount('articles');
        }])
        ->withCount('articles')
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

        return view('admin.article-categories.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:article_categories,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $base = $validated['slug'];
            $i = 1;
            while (ArticleCategory::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = "{$base}-{$i}";
                $i++;
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        ArticleCategory::create($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, ArticleCategory $articleCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('article_categories', 'slug')->ignore($articleCategory->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $articleCategory->update($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Kategori '{$articleCategory->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified category.
     */
    public function destroy(ArticleCategory $articleCategory): RedirectResponse
    {
        $name = $articleCategory->name;
        $articleCategory->delete();

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Kategori '{$name}' dan sub-kategorinya berhasil dihapus.");
    }

    /**
     * API/AJAX: Get subcategories for a given category.
     */
    public function subcategories(ArticleCategory $articleCategory): JsonResponse
    {
        $subs = $articleCategory->subcategories()
            ->select('id', 'category_id', 'name', 'slug')
            ->get();

        return response()->json([
            'success' => true,
            'category_id' => $articleCategory->id,
            'category_name' => $articleCategory->name,
            'subcategories' => $subs,
        ]);
    }
}
