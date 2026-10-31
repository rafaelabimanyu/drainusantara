<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Models\Portfolio;
use App\Models\Service;
use App\Rules\OptimizedImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Display a listing of B2B portfolios.
     */
    public function index(): View
    {
        $portfolios = Portfolio::orderBy('order')->latest()->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new B2B portfolio.
     */
    public function create(): View
    {
        $nextOrder = Portfolio::getNextAvailableOrder();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.portfolios.create', compact('nextOrder', 'services'));
    }

    /**
     * Store a newly created B2B portfolio in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_type' => ['nullable', 'string', 'max:100'],
            'partnership_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'project_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'about_client' => ['nullable', 'string'],
            'scope_of_work' => ['nullable', 'string'],
            'results_benefit' => ['nullable', 'string'],
            'testimoni_quote' => ['nullable', 'string'],
            'testimoni_name' => ['nullable', 'string', 'max:255'],
            'testimoni_title' => ['nullable', 'string', 'max:255'],
            'image' => $request->hasFile('image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'logo' => $request->hasFile('logo') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string', 'max:255'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $record = new Portfolio;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $imageUrl = $validated['image_url'] ?? null;
            if ($request->hasFile('image')) {
                $imageUrl = $media->upload($request->file('image'), 'images/portfolio');
            } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
                $imageUrl = $request->input('image');
            } elseif (!$imageUrl) {
                $imageUrl = '/images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp';
            }

            $logoUrl = $validated['logo_url'] ?? null;
            if ($request->hasFile('logo')) {
                $logoUrl = $media->upload($request->file('logo'), 'images/portfolio');
            } elseif (is_string($request->input('logo')) && !empty($request->input('logo'))) {
                $logoUrl = $request->input('logo');
            }

            $media->save($record, [
                'client_name' => $validated['client_name'],
                'client_type' => $validated['client_type'] ?? 'Restoran & F&B',
                'partnership_type' => $validated['partnership_type'] ?? null,
                'location' => $validated['location'] ?? 'Jabodetabek',
                'duration' => $validated['duration'] ?? null,
                'image' => $imageUrl,
                'logo' => $logoUrl,
                'project_title' => $validated['project_title'] ?? null,
                'description' => $validated['description'] ?? null,
                'about_client' => $validated['about_client'] ?? null,
                'scope_of_work' => $validated['scope_of_work'] ?? null,
                'results_benefit' => $validated['results_benefit'] ?? null,
                'testimoni_quote' => $validated['testimoni_quote'] ?? null,
                'testimoni_name' => $validated['testimoni_name'] ?? null,
                'testimoni_title' => $validated['testimoni_title'] ?? null,
                'order' => !empty($validated['order']) ? (int) $validated['order'] : Portfolio::getNextAvailableOrder(),
                'is_active' => $request->boolean('is_active'),
            ]);

            $record->services()->sync($validated['service_ids'] ?? []);
        });

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio '{$validated['client_name']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified B2B portfolio.
     */
    public function edit(Portfolio $portfolio): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'services'));
    }

    /**
     * Update the specified B2B portfolio in storage.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_type' => ['nullable', 'string', 'max:100'],
            'partnership_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'project_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'about_client' => ['nullable', 'string'],
            'scope_of_work' => ['nullable', 'string'],
            'results_benefit' => ['nullable', 'string'],
            'testimoni_quote' => ['nullable', 'string'],
            'testimoni_name' => ['nullable', 'string', 'max:255'],
            'testimoni_title' => ['nullable', 'string', 'max:255'],
            'image' => $request->hasFile('image') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'logo' => $request->hasFile('logo') ? [new OptimizedImage] : ['nullable', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string', 'max:255'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $media = new MediaLifecycle;
        $media->run($portfolio, function () use ($request, $validated, $media, $portfolio): void {
            $imageUrl = $portfolio->image;
            if ($request->hasFile('image')) {
                $newImage = $media->upload($request->file('image'), 'images/portfolio');
                $imageUrl = $newImage;
            } elseif (!empty($validated['image_url'])) {
                $imageUrl = $validated['image_url'];
            }

            $logoUrl = $portfolio->logo;
            if ($request->hasFile('logo')) {
                $newLogo = $media->upload($request->file('logo'), 'images/portfolio');
                $logoUrl = $newLogo;
            } elseif (!empty($validated['logo_url'])) {
                $logoUrl = $validated['logo_url'];
            }

            $media->save($portfolio, [
                'client_name' => $validated['client_name'],
                'client_type' => array_key_exists('client_type', $validated) ? $validated['client_type'] : $portfolio->client_type,
                'partnership_type' => array_key_exists('partnership_type', $validated) ? $validated['partnership_type'] : $portfolio->partnership_type,
                'location' => array_key_exists('location', $validated) ? $validated['location'] : $portfolio->location,
                'duration' => array_key_exists('duration', $validated) ? $validated['duration'] : $portfolio->duration,
                'image' => $imageUrl,
                'logo' => $logoUrl,
                'project_title' => array_key_exists('project_title', $validated) ? $validated['project_title'] : $portfolio->project_title,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : $portfolio->description,
                'about_client' => array_key_exists('about_client', $validated) ? $validated['about_client'] : $portfolio->about_client,
                'scope_of_work' => array_key_exists('scope_of_work', $validated) ? $validated['scope_of_work'] : $portfolio->scope_of_work,
                'results_benefit' => array_key_exists('results_benefit', $validated) ? $validated['results_benefit'] : $portfolio->results_benefit,
                'testimoni_quote' => array_key_exists('testimoni_quote', $validated) ? $validated['testimoni_quote'] : $portfolio->testimoni_quote,
                'testimoni_name' => array_key_exists('testimoni_name', $validated) ? $validated['testimoni_name'] : $portfolio->testimoni_name,
                'testimoni_title' => array_key_exists('testimoni_title', $validated) ? $validated['testimoni_title'] : $portfolio->testimoni_title,
                'order' => $validated['order'] ?? $portfolio->order,
                'is_active' => $request->boolean('is_active'),
            ]);

            $portfolio->services()->sync($validated['service_ids'] ?? []);
        });

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio '{$portfolio->client_name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified B2B portfolio from storage.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $clientName = $portfolio->client_name;



        (new MediaLifecycle)->run($portfolio, fn () => $portfolio->delete());

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Klien B2B '{$clientName}' berhasil dihapus.");
    }

}
