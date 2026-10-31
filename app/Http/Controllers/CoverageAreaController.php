<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Rules\OptimizedImage;
use App\Support\MediaLifecycle;
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

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        $totalCount = CoverageArea::count();
        $cities = CoverageArea::query()
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $coverageAreas = $query->orderBy('city')->orderBy('district')->paginate(20)->withQueryString();

        return view('admin.coverage-areas.index', compact('coverageAreas', 'cities', 'totalCount'));
    }

    /**
     * Synchronize master regions from RegionService into the database.
     */
    public function syncFromMaster(): RedirectResponse
    {
        $result = CoverageArea::syncFromMaster();

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Sinkronisasi berhasil! {$result['created']} area baru ditambahkan. Total saat ini: {$result['total']} area.");
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
            'hero_image' => $request->hasFile('hero_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'hero_image_url' => ['nullable', 'string', 'max:255'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string', 'max:255'],
            'faqs.*.answer' => ['nullable', 'string', 'max:2000'],
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

        $faqs = [];
        if (!empty($validated['faqs']) && is_array($validated['faqs'])) {
            foreach ($validated['faqs'] as $item) {
                $q = trim((string)($item['question'] ?? ''));
                $a = trim((string)($item['answer'] ?? ''));
                if ($q !== '' && $a !== '') {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        $record = new CoverageArea;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record, $slug, $metaTitle, $metaDescription, $faqs): void {
            $heroImageUrl = $validated['hero_image_url'] ?? null;
            if ($request->hasFile('hero_image')) {
                $heroImageUrl = $media->upload($request->file('hero_image'), 'images/areas');
            } elseif (is_string($request->input('hero_image')) && !empty($request->input('hero_image'))) {
                $heroImageUrl = $request->input('hero_image');
            }

            $record->fill([
                'city' => $validated['city'],
                'district' => $validated['district'],
                'slug' => $slug,
                'postal_code' => $validated['postal_code'] ?? null,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'content' => $validated['content'] ?? null,
                'hero_image' => $heroImageUrl,
                'faqs' => !empty($faqs) ? $faqs : null,
                'is_active' => $request->boolean('is_active'),
            ])->save();
        });

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
            'hero_image' => $request->hasFile('hero_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'hero_image_url' => ['nullable', 'string', 'max:255'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string', 'max:255'],
            'faqs.*.answer' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faqs = [];
        if (!empty($validated['faqs']) && is_array($validated['faqs'])) {
            foreach ($validated['faqs'] as $item) {
                $q = trim((string)($item['question'] ?? ''));
                $a = trim((string)($item['answer'] ?? ''));
                if ($q !== '' && $a !== '') {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        $media = new MediaLifecycle;
        $media->run($coverageArea, function () use ($request, $validated, $media, $coverageArea, $faqs): void {
            $heroImageUrl = $validated['hero_image_url'] ?? null;
            if ($request->hasFile('hero_image')) {
                $heroImageUrl = $media->upload($request->file('hero_image'), 'images/areas');
            } elseif (is_string($request->input('hero_image')) && !empty($request->input('hero_image'))) {
                $heroImageUrl = $request->input('hero_image');
            } elseif (!$heroImageUrl && !$request->hasFile('hero_image') && $request->filled('remove_hero_image')) {
                $heroImageUrl = null;
            } else {
                $heroImageUrl = $heroImageUrl ?: $coverageArea->hero_image;
            }

            $coverageArea->fill([
                'city' => $validated['city'],
                'district' => $validated['district'],
                'postal_code' => array_key_exists('postal_code', $validated) ? $validated['postal_code'] : $coverageArea->postal_code,
                'meta_title' => array_key_exists('meta_title', $validated) ? $validated['meta_title'] : $coverageArea->meta_title,
                'meta_description' => array_key_exists('meta_description', $validated) ? $validated['meta_description'] : $coverageArea->meta_description,
                'content' => array_key_exists('content', $validated) ? $validated['content'] : $coverageArea->content,
                'hero_image' => $heroImageUrl,
                'faqs' => !empty($faqs) ? $faqs : null,
                'is_active' => $request->boolean('is_active'),
            ])->save();
        });

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Area '{$coverageArea->district}' berhasil diperbarui!");
    }

    /**
     * Remove the specified coverage area from storage.
     */
    public function destroy(CoverageArea $coverageArea): RedirectResponse
    {
        $name = "{$coverageArea->district}, {$coverageArea->city}";
        (new MediaLifecycle)->run($coverageArea, fn () => $coverageArea->delete());

        return redirect()->route('admin.coverage-areas.index')
            ->with('success', "Area '{$name}' berhasil dihapus.");
    }
}
