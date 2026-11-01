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
            'starting_price' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'geo_keywords' => ['nullable', 'string', 'max:2000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'content' => ['nullable', 'string'],
            'hero_image' => $request->hasFile('hero_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'hero_image_url' => ['nullable', 'string', 'max:255'],
            'posko_name' => ['nullable', 'string', 'max:255'],
            'posko_address' => ['nullable', 'string', 'max:1000'],
            'posko_coverage_radius' => ['nullable', 'string', 'max:255'],
            'cta_headline' => ['nullable', 'string', 'max:255'],
            'cta_button_text' => ['nullable', 'string', 'max:255'],
            'cta_whatsapp_text' => ['nullable', 'string', 'max:1000'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string', 'max:255'],
            'faqs.*.answer' => ['nullable', 'string', 'max:2000'],
            'advantages' => ['nullable', 'array'],
            'service_categories' => ['nullable', 'array'],
            'comparison_data' => ['nullable', 'array'],
            'supporting_tags' => ['nullable'],
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

        $faqs = $this->cleanFaqs($validated['faqs'] ?? []);
        $advantages = $this->cleanAdvantages($validated['advantages'] ?? []);
        $serviceCategories = $this->cleanServiceCategories($validated['service_categories'] ?? []);
        $comparisonData = $this->cleanComparison($validated['comparison_data'] ?? []);
        $supportingTags = $this->cleanTags($validated['supporting_tags'] ?? null);

        $record = new CoverageArea;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record, $slug, $metaTitle, $metaDescription, $faqs, $advantages, $serviceCategories, $comparisonData, $supportingTags): void {
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
                'starting_price' => $validated['starting_price'] ?? null,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'geo_keywords' => $validated['geo_keywords'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'content' => $validated['content'] ?? null,
                'hero_image' => $heroImageUrl,
                'posko_name' => $validated['posko_name'] ?? null,
                'posko_address' => $validated['posko_address'] ?? null,
                'posko_coverage_radius' => $validated['posko_coverage_radius'] ?? null,
                'cta_headline' => $validated['cta_headline'] ?? null,
                'cta_button_text' => $validated['cta_button_text'] ?? null,
                'cta_whatsapp_text' => $validated['cta_whatsapp_text'] ?? null,
                'faqs' => !empty($faqs) ? $faqs : null,
                'advantages' => !empty($advantages) ? $advantages : null,
                'service_categories' => !empty($serviceCategories) ? $serviceCategories : null,
                'comparison_data' => !empty($comparisonData) ? $comparisonData : null,
                'supporting_tags' => !empty($supportingTags) ? $supportingTags : null,
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
            'starting_price' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'geo_keywords' => ['nullable', 'string', 'max:2000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'content' => ['nullable', 'string'],
            'hero_image' => $request->hasFile('hero_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'hero_image_url' => ['nullable', 'string', 'max:255'],
            'posko_name' => ['nullable', 'string', 'max:255'],
            'posko_address' => ['nullable', 'string', 'max:1000'],
            'posko_coverage_radius' => ['nullable', 'string', 'max:255'],
            'cta_headline' => ['nullable', 'string', 'max:255'],
            'cta_button_text' => ['nullable', 'string', 'max:255'],
            'cta_whatsapp_text' => ['nullable', 'string', 'max:1000'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string', 'max:255'],
            'faqs.*.answer' => ['nullable', 'string', 'max:2000'],
            'advantages' => ['nullable', 'array'],
            'service_categories' => ['nullable', 'array'],
            'comparison_data' => ['nullable', 'array'],
            'supporting_tags' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faqs = $this->cleanFaqs($validated['faqs'] ?? []);
        $advantages = $this->cleanAdvantages($validated['advantages'] ?? []);
        $serviceCategories = $this->cleanServiceCategories($validated['service_categories'] ?? []);
        $comparisonData = $this->cleanComparison($validated['comparison_data'] ?? []);
        $supportingTags = $this->cleanTags($validated['supporting_tags'] ?? null);

        $media = new MediaLifecycle;
        $media->run($coverageArea, function () use ($request, $validated, $media, $coverageArea, $faqs, $advantages, $serviceCategories, $comparisonData, $supportingTags): void {
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
                'starting_price' => array_key_exists('starting_price', $validated) ? $validated['starting_price'] : $coverageArea->starting_price,
                'meta_title' => array_key_exists('meta_title', $validated) ? $validated['meta_title'] : $coverageArea->meta_title,
                'meta_description' => array_key_exists('meta_description', $validated) ? $validated['meta_description'] : $coverageArea->meta_description,
                'geo_keywords' => array_key_exists('geo_keywords', $validated) ? $validated['geo_keywords'] : $coverageArea->geo_keywords,
                'latitude' => array_key_exists('latitude', $validated) ? $validated['latitude'] : $coverageArea->latitude,
                'longitude' => array_key_exists('longitude', $validated) ? $validated['longitude'] : $coverageArea->longitude,
                'content' => array_key_exists('content', $validated) ? $validated['content'] : $coverageArea->content,
                'hero_image' => $heroImageUrl,
                'posko_name' => array_key_exists('posko_name', $validated) ? $validated['posko_name'] : $coverageArea->posko_name,
                'posko_address' => array_key_exists('posko_address', $validated) ? $validated['posko_address'] : $coverageArea->posko_address,
                'posko_coverage_radius' => array_key_exists('posko_coverage_radius', $validated) ? $validated['posko_coverage_radius'] : $coverageArea->posko_coverage_radius,
                'cta_headline' => array_key_exists('cta_headline', $validated) ? $validated['cta_headline'] : $coverageArea->cta_headline,
                'cta_button_text' => array_key_exists('cta_button_text', $validated) ? $validated['cta_button_text'] : $coverageArea->cta_button_text,
                'cta_whatsapp_text' => array_key_exists('cta_whatsapp_text', $validated) ? $validated['cta_whatsapp_text'] : $coverageArea->cta_whatsapp_text,
                'faqs' => !empty($faqs) ? $faqs : null,
                'advantages' => !empty($advantages) ? $advantages : null,
                'service_categories' => !empty($serviceCategories) ? $serviceCategories : null,
                'comparison_data' => !empty($comparisonData) ? $comparisonData : null,
                'supporting_tags' => !empty($supportingTags) ? $supportingTags : null,
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

    /**
     * Filter and clean FAQs.
     */
    protected function cleanFaqs(array $faqs): array
    {
        $cleaned = [];
        foreach ($faqs as $item) {
            $q = trim((string) ($item['question'] ?? ''));
            $a = trim((string) ($item['answer'] ?? ''));
            if ($q !== '' && $a !== '') {
                $cleaned[] = ['question' => $q, 'answer' => $a];
            }
        }
        return $cleaned;
    }

    /**
     * Filter and clean advantages.
     */
    protected function cleanAdvantages(array $advantages): array
    {
        $cleaned = [];
        foreach ($advantages as $item) {
            $title = trim((string) ($item['title'] ?? ''));
            $desc = trim((string) ($item['description'] ?? ''));
            if ($title !== '') {
                $cleaned[] = [
                    'title' => $title,
                    'description' => $desc,
                    'icon' => $item['icon'] ?? 'check',
                ];
            }
        }
        return $cleaned;
    }

    /**
     * Filter and clean service categories.
     */
    protected function cleanServiceCategories(array $categories): array
    {
        $cleaned = [];
        foreach ($categories as $item) {
            $title = trim((string) ($item['title'] ?? ''));
            if ($title !== '') {
                $cleaned[] = [
                    'key' => Str::slug($item['key'] ?? $title),
                    'title' => $title,
                    'scope' => trim((string) ($item['scope'] ?? '')),
                    'problem' => trim((string) ($item['problem'] ?? '')),
                    'solution' => trim((string) ($item['solution'] ?? '')),
                ];
            }
        }
        return $cleaned;
    }

    /**
     * Filter and clean comparison data.
     */
    protected function cleanComparison(array $comparisons): array
    {
        $cleaned = [];
        foreach ($comparisons as $item) {
            $aspect = trim((string) ($item['aspect'] ?? ''));
            if ($aspect !== '') {
                $cleaned[] = [
                    'aspect' => $aspect,
                    'tukang' => trim((string) ($item['tukang'] ?? '')),
                    'drainusantara' => trim((string) ($item['drainusantara'] ?? '')),
                ];
            }
        }
        return $cleaned;
    }

    /**
     * Parse supporting tags from array or comma-separated string.
     */
    protected function cleanTags(mixed $tags): array
    {
        if (is_array($tags)) {
            return array_values(array_filter(array_map('trim', $tags)));
        }

        if (is_string($tags) && trim($tags) !== '') {
            $exploded = explode(',', $tags);
            return array_values(array_filter(array_map('trim', $exploded)));
        }

        return [];
    }
}
