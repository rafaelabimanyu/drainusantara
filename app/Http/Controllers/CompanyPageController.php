<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CompanyPage;
use App\Services\CacheService;
use App\Services\SearchEnginePingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyPageController extends Controller
{
    /**
     * Display a listing of company pages in CMS.
     */
    public function index(): View
    {
        $keys = [
            'profil',
            'cara-kerja',
            'holding',
            'sop-k3',
            'peralatan',
            'kemitraan',
            'garansi',
        ];

        // Ensure all 7 pages exist
        foreach ($keys as $k) {
            CompanyPage::getByKey($k);
        }

        $pages = CompanyPage::orderBy('id')->get();

        return view('admin.company-pages.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified company page.
     */
    public function edit(CompanyPage $companyPage): View
    {
        return view('admin.company-pages.edit', compact('companyPage'));
    }

    /**
     * Update the specified company page in storage.
     */
    public function update(Request $request, CompanyPage $companyPage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'sections_data_raw' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $sectionsData = $companyPage->sections_data ?? [];
        if (! empty($validated['sections_data_raw'])) {
            $decoded = json_decode($validated['sections_data_raw'], true);
            if (is_array($decoded)) {
                $sectionsData = $decoded;
            }
        }

        $companyPage->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'hero_image' => $validated['hero_image'] ?? null,
            'content' => $validated['content'] ?? null,
            'sections_data' => $sectionsData,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
        ]);

        CacheService::clearPublicCache();
        SearchEnginePingService::pingAll(route(match ($companyPage->page_key) {
            'profil' => 'about.profile',
            'cara-kerja' => 'how-it-works',
            'holding' => 'about.holding',
            'sop-k3' => 'about.k3',
            'peralatan' => 'about.equipment',
            'kemitraan' => 'about.portfolio',
            'garansi' => 'about.warranty',
            default => 'about',
        }));

        return redirect()
            ->route('admin.company-pages.index')
            ->with('success', "Halaman '{$companyPage->title}' berhasil diperbarui dan sinyal SEO telah dikirim.");
    }
}

