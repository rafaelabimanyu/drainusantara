<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ArticleSubcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleSubcategoryController extends Controller
{
    /**
     * Store a newly created subcategory.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:article_categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $categoryId = (int) $validated['category_id'];

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $base = $validated['slug'];
            $i = 1;
            while (ArticleSubcategory::where('category_id', $categoryId)->where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = "{$base}-{$i}";
                $i++;
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Validate uniqueness within category
        $request->validate([
            'slug' => [
                Rule::unique('article_subcategories')->where(fn ($query) => $query->where('category_id', $categoryId)),
            ],
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        ArticleSubcategory::create($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Sub-Kategori '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Update the specified subcategory.
     */
    public function update(Request $request, ArticleSubcategory $articleSubcategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('article_subcategories', 'slug')
                    ->where(fn ($q) => $q->where('category_id', $articleSubcategory->category_id))
                    ->ignore($articleSubcategory->id),
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $articleSubcategory->update($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Sub-Kategori '{$articleSubcategory->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified subcategory.
     */
    public function destroy(ArticleSubcategory $articleSubcategory): RedirectResponse
    {
        $name = $articleSubcategory->name;
        $articleSubcategory->delete();

        return redirect()->route('admin.article-categories.index')
            ->with('success', "Sub-Kategori '{$name}' berhasil dihapus.");
    }
}
