<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Models\Gallery;
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
                  ->orWhere('province_name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            if (in_array($type, ['province', 'city', 'district'], true)) {
                $query->where('type', $type);
            }
        }

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        $totalCount = CoverageArea::count();
        $provinceCount = CoverageArea::where('type', 'province')->count();
        $cityCount = CoverageArea::where('type', 'city')->count();
        $districtCount = CoverageArea::where('type', 'district')->count();

        $cities = CoverageArea::query()
            ->where('district', '!=', '[PROVINSI]')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $coverageAreas = $query->orderByRaw("CASE type WHEN 'province' THEN 1 WHEN 'city' THEN 2 ELSE 3 END")
            ->orderBy('city')
            ->orderBy('district')
            ->paginate(20)
            ->withQueryString();

        return view('admin.coverage-areas.index', compact(
            'coverageAreas',
            'cities',
            'totalCount',
            'provinceCount',
            'cityCount',
            'districtCount'
        ));
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
        $availableGalleries = Gallery::where('is_active', true)
            ->with('service')
            ->orderBy('order')
            ->latest()
            ->get();

        return view('admin.coverage-areas.create', compact('availableGalleries'));
    }

    /**
     * Store a newly created coverage area in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $type = $request->input('type', 'district');
        if ($type === 'province') {
            $provName = $request->input('province_name') ?: $request->input('city');
            $request->merge([
                'type' => 'province',
                'province_name' => $provName,
                'city' => $provName,
                'district' => '[PROVINSI]',
            ]);
        } elseif ($type === 'city') {
            $request->merge([
                'type' => 'city',
                'district' => '[KOTA]',
            ]);
        }

        $validated = $request->validate([
            'type' => ['nullable', 'string', 'in:province,city,district'],
            'province_name' => ['nullable', 'string', 'max:100'],
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
            'presence_image' => $request->hasFile('presence_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'presence_image_url' => ['nullable', 'string', 'max:255'],
            'presence_description' => ['nullable', 'string'],
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
            'gallery_ids' => ['nullable', 'array'],
            'gallery_ids.*' => ['integer', 'exists:galleries,id'],
            'service_categories' => ['nullable', 'array'],
            'comparison_data' => ['nullable', 'array'],
            'supporting_tags' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (($validated['type'] ?? 'district') === 'province') {
            $rawSlug = Str::slug($validated['province_name'] ?? $validated['city']);
        } elseif (($validated['type'] ?? 'district') === 'city') {
            $rawSlug = Str::slug($validated['city']);
        } else {
            $rawSlug = Str::slug("{$validated['city']}-{$validated['district']}");
        }

        $slug = substr($rawSlug, 0, 255);
        $baseSlug = $slug;
        $counter = 1;
        while (CoverageArea::where('slug', $slug)->exists()) {
            $slug = substr($baseSlug, 0, 255 - strlen("-{$counter}")) . "-{$counter}";
            $counter++;
        }

        $defaultMetaTitle = ($validated['type'] ?? 'district') === 'province'
            ? "Jasa Saluran Pipa Mampet {$validated['city']} - Tanpa Bongkar & Garansi 30 Hari"
            : ((($validated['type'] ?? 'district') === 'city')
                ? "Jasa Saluran Pipa Mampet {$validated['city']} - Tanpa Bongkar & Garansi 30 Hari"
                : "Jasa Saluran Pipa Mampet {$validated['district']}, {$validated['city']} - Tanpa Bongkar & Garansi 30 Hari");

        $defaultMetaDescription = ($validated['type'] ?? 'district') === 'province'
            ? "Layanan pelancaran pipa saluran mampet tanpa bongkar keramik di wilayah {$validated['city']}. Armada siaga di seluruh kota dengan garansi resmi 30 hari."
            : ((($validated['type'] ?? 'district') === 'city')
                ? "Jasa saluran pipa mampet di {$validated['city']} & tukang saluran mampet panggilan 24 jam. Ahli wastafel, WC kloset tersumbat & kuras grease trap tanpa bongkar keramik pakai spiral baja rotary. Garansi 30 hari!"
                : "Jasa saluran pipa mampet di {$validated['district']}, {$validated['city']}. Tukang pipa & WC mampet terdekat pelancar wastafel serta saluran air tanpa bongkar keramik pakai spiral baja rotary. Siaga 24 jam & garansi 30 hari!");

        $metaTitle = !empty($validated['meta_title']) ? $validated['meta_title'] : mb_substr($defaultMetaTitle, 0, 255);
        $metaDescription = !empty($validated['meta_description']) ? $validated['meta_description'] : mb_substr($defaultMetaDescription, 0, 500);

        $faqs = $this->cleanFaqs($validated['faqs'] ?? []);
        $advantages = $this->cleanAdvantages($validated['advantages'] ?? []);
        $serviceCategories = $this->cleanServiceCategories($validated['service_categories'] ?? []);
        $comparisonData = $this->cleanComparison($validated['comparison_data'] ?? []);
        $supportingTags = $this->cleanTags($validated['supporting_tags'] ?? null);
        $galleryIds = $this->cleanGalleryIds($validated['gallery_ids'] ?? []);

        $record = new CoverageArea;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record, $slug, $metaTitle, $metaDescription, $faqs, $advantages, $serviceCategories, $comparisonData, $supportingTags, $galleryIds): void {
            $heroImageUrl = $validated['hero_image_url'] ?? null;
            if ($request->hasFile('hero_image')) {
                $heroImageUrl = $media->upload($request->file('hero_image'), 'images/areas');
            } elseif (is_string($request->input('hero_image')) && !empty($request->input('hero_image'))) {
                $heroImageUrl = $request->input('hero_image');
            }

            $presenceImageUrl = $validated['presence_image_url'] ?? null;
            if ($request->hasFile('presence_image')) {
                $presenceImageUrl = $media->upload($request->file('presence_image'), 'images/areas');
            } elseif (is_string($request->input('presence_image')) && !empty($request->input('presence_image'))) {
                $presenceImageUrl = $request->input('presence_image');
            }

            $record->fill([
                'type' => $validated['type'] ?? 'district',
                'province_name' => $validated['province_name'] ?? null,
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
                'presence_image' => $presenceImageUrl,
                'presence_description' => $validated['presence_description'] ?? null,
                'gallery_ids' => !empty($galleryIds) ? $galleryIds : null,
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
        $availableGalleries = Gallery::where('is_active', true)
            ->with('service')
            ->orderBy('order')
            ->latest()
            ->get();

        return view('admin.coverage-areas.edit', compact('coverageArea', 'availableGalleries'));
    }

    /**
     * Update the specified coverage area in storage.
     */
    public function update(Request $request, CoverageArea $coverageArea): RedirectResponse
    {
        $type = $request->input('type', $coverageArea->type ?: 'district');
        if ($type === 'province') {
            $provName = $request->input('province_name') ?: $coverageArea->province_name ?: $coverageArea->city;
            $request->merge([
                'type' => 'province',
                'province_name' => $provName,
                'city' => $provName,
                'district' => '[PROVINSI]',
            ]);
        } elseif ($type === 'city') {
            $request->merge([
                'type' => 'city',
                'district' => '[KOTA]',
            ]);
        }

        $validated = $request->validate([
            'type' => ['nullable', 'string', 'in:province,city,district'],
            'province_name' => ['nullable', 'string', 'max:100'],
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
            'presence_image' => $request->hasFile('presence_image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'presence_image_url' => ['nullable', 'string', 'max:255'],
            'presence_description' => ['nullable', 'string'],
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
            'gallery_ids' => ['nullable', 'array'],
            'gallery_ids.*' => ['integer', 'exists:galleries,id'],
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
        $galleryIds = $this->cleanGalleryIds($validated['gallery_ids'] ?? []);

        $media = new MediaLifecycle;
        $media->run($coverageArea, function () use ($request, $validated, $media, $coverageArea, $faqs, $advantages, $serviceCategories, $comparisonData, $supportingTags, $galleryIds): void {
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

            $presenceImageUrl = $validated['presence_image_url'] ?? null;
            if ($request->hasFile('presence_image')) {
                $presenceImageUrl = $media->upload($request->file('presence_image'), 'images/areas');
            } elseif (is_string($request->input('presence_image')) && !empty($request->input('presence_image'))) {
                $presenceImageUrl = $request->input('presence_image');
            } elseif (!$presenceImageUrl && !$request->hasFile('presence_image') && $request->filled('remove_presence_image')) {
                $presenceImageUrl = null;
            } else {
                $presenceImageUrl = $presenceImageUrl ?: $coverageArea->presence_image;
            }

            $coverageArea->fill([
                'type' => array_key_exists('type', $validated) ? $validated['type'] : ($coverageArea->type ?: 'district'),
                'province_name' => array_key_exists('province_name', $validated) ? $validated['province_name'] : $coverageArea->province_name,
                'city' => $validated['city'],
                'district' => $validated['district'],
                'postal_code' => array_key_exists('postal_code', $validated) ? $validated['postal_code'] : $coverageArea->postal_code,
                'starting_price' => array_key_exists('starting_price', $validated) ? $validated['starting_price'] : $coverageArea->starting_price,
                'meta_title' => array_key_exists('meta_title', $validated) ? ($validated['meta_title'] ?: null) : $coverageArea->meta_title,
                'meta_description' => array_key_exists('meta_description', $validated) ? ($validated['meta_description'] ?: null) : $coverageArea->meta_description,
                'geo_keywords' => array_key_exists('geo_keywords', $validated) ? ($validated['geo_keywords'] ?: null) : $coverageArea->geo_keywords,
                'latitude' => array_key_exists('latitude', $validated) ? $validated['latitude'] : $coverageArea->latitude,
                'longitude' => array_key_exists('longitude', $validated) ? $validated['longitude'] : $coverageArea->longitude,
                'content' => array_key_exists('content', $validated) ? $validated['content'] : $coverageArea->content,
                'hero_image' => $heroImageUrl,
                'presence_image' => $presenceImageUrl,
                'presence_description' => array_key_exists('presence_description', $validated) ? $validated['presence_description'] : $coverageArea->presence_description,
                'gallery_ids' => !empty($galleryIds) ? $galleryIds : null,
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

    /**
     * Filter and clean gallery IDs.
     *
     * @param array<mixed> $ids
     * @return array<int>
     */
    protected function cleanGalleryIds(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('intval', $ids), fn (int $id): bool => $id > 0)));
    }
}
