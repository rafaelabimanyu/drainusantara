<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CoverageAreaController extends Controller
{
    /**
     * Display a listing of coverage areas.
     */
    public function index(Request $request): View
    {
        $query = CoverageArea::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $coverageAreas = $query->latest()->paginate(15)->withQueryString();

        return view('admin.coverage-areas.index', compact('coverageAreas'));
    }

    /**
     * Show the form for creating a new coverage area.
     */
    public function create(): View
    {
        return view('admin.coverage-areas.create');
    }

    /**
     * Store a newly created coverage area in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100', Rule::unique('coverage_areas')->where(fn ($query) => $query->where('city', $request->input('city')))],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = substr(Str::slug("{$validated['city']}-{$validated['district']}"), 0, 255);
        $baseSlug = $slug;
        $counter = 1;
        while (CoverageArea::where('slug', $slug)->exists()) {
            $slug = substr($baseSlug, 0, 255 - strlen("-{$counter}")) . "-{$counter}";
            $counter++;
        }

        $metaTitle = !empty($validated['meta_title']) ? $validated['meta_title'] : mb_substr("Jasa Saluran Mampet di {$validated['district']}, {$validated['city']} - Drainusantara Bergaransi", 0, 255);
        $metaDescription = !empty($validated['meta_description']) ? $validated['meta_description'] : "Jasa pelancaran pipa wastafel, toilet, dan floor drain mampet di {$validated['district']}, {$validated['city']} tanpa bongkar keramik & garansi 30 hari. Hubungi teknisi terdekat sekarang!";

        CoverageArea::create([
            'city' => $validated['city'],
            'district' => $validated['district'],
            'slug' => $slug,
            'postal_code' => $validated['postal_code'] ?? null,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'content' => $validated['content'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Area '{$validated['district']}, {$validated['city']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified coverage area.
     */
    public function edit(CoverageArea $coverageArea): View
    {
        return view('admin.coverage-areas.edit', compact('coverageArea'));
    }

    /**
     * Update the specified coverage area in storage.
     */
    public function update(Request $request, CoverageArea $coverageArea): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100', Rule::unique('coverage_areas')->where(fn ($query) => $query->where('city', $request->input('city')))->ignore($coverageArea->id)],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $coverageArea->update([
            'city' => $validated['city'],
            'district' => $validated['district'],
            'postal_code' => array_key_exists('postal_code', $validated) ? $validated['postal_code'] : $coverageArea->postal_code,
            'meta_title' => array_key_exists('meta_title', $validated) ? $validated['meta_title'] : $coverageArea->meta_title,
            'meta_description' => array_key_exists('meta_description', $validated) ? $validated['meta_description'] : $coverageArea->meta_description,
            'content' => array_key_exists('content', $validated) ? $validated['content'] : $coverageArea->content,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Area '{$coverageArea->district}' berhasil diperbarui!");
    }

    /**
     * Remove the specified coverage area from storage.
     */
    public function destroy(CoverageArea $coverageArea): RedirectResponse
    {
        $name = "{$coverageArea->district}, {$coverageArea->city}";
        $coverageArea->delete();

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Area '{$name}' berhasil dihapus.");
    }
}
