<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Models\Portfolio;
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

        return view('admin.portfolios.create', compact('nextOrder'));
    }

    /**
     * Store a newly created B2B portfolio in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'project_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => $request->hasFile('image') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $record = new Portfolio;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $imageUrl = $validated['image_url'] ?? null;
            if ($request->hasFile('image')) {
                $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
                $imageUrl = $media->upload($request->file('image'), 'images/portfolio');
            } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
                $imageUrl = $request->input('image');
            } elseif (!$imageUrl) {
                $imageUrl = '/images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp';
            }

            $media->save($record, [
                'client_name' => $validated['client_name'],
                'client_type' => $validated['client_type'] ?? 'Restoran & F&B',
                'location' => $validated['location'] ?? 'Jabodetabek',
                'image' => $imageUrl,
                'project_title' => $validated['project_title'] ?? null,
                'description' => $validated['description'] ?? null,
                'order' => !empty($validated['order']) ? (int) $validated['order'] : Portfolio::getNextAvailableOrder(),
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio '{$validated['client_name']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified B2B portfolio.
     */
    public function edit(Portfolio $portfolio): View
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified B2B portfolio in storage.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'project_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => $request->hasFile('image') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $media = new MediaLifecycle;
        $media->run($portfolio, function () use ($request, $validated, $media, $portfolio): void {
            $imageUrl = $portfolio->image;
            if ($request->hasFile('image')) {
                $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
                $newImage = $media->upload($request->file('image'), 'images/portfolio');
                $imageUrl = $newImage;
            } elseif (!empty($validated['image_url'])) {
                $imageUrl = $validated['image_url'];
            }

            $media->save($portfolio, [
                'client_name' => $validated['client_name'],
                'client_type' => array_key_exists('client_type', $validated) ? $validated['client_type'] : $portfolio->client_type,
                'location' => array_key_exists('location', $validated) ? $validated['location'] : $portfolio->location,
                'image' => $imageUrl,
                'project_title' => array_key_exists('project_title', $validated) ? $validated['project_title'] : $portfolio->project_title,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : $portfolio->description,
                'order' => $validated['order'] ?? $portfolio->order,
                'is_active' => $request->boolean('is_active'),
            ]);
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
