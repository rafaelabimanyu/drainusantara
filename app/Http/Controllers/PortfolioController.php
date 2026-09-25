<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        return view('admin.portfolios.create');
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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $imageUrl = Storage::url($request->file('image')->store('portfolios', 'public'));
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $imageUrl = $request->input('image');
        } elseif (!$imageUrl) {
            $imageUrl = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80';
        }

        Portfolio::create([
            'client_name' => $validated['client_name'],
            'client_type' => $validated['client_type'] ?? 'Komersial & B2B',
            'location' => $validated['location'] ?? 'Jabodetabek',
            'image' => $imageUrl,
            'project_title' => $validated['project_title'] ?? 'Pemeliharaan Saluran Pipa Komersial',
            'description' => $validated['description'] ?? 'Penanganan dan pemeliharaan saluran pipa limbah dan grease trap tanpa merusak lantai.',
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Klien B2B '{$validated['client_name']}' berhasil ditambahkan!");
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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $portfolio->image;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $imageUrl = Storage::url($request->file('image')->store('portfolios', 'public'));
        } elseif (!empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $portfolio->update([
            'client_name' => $validated['client_name'],
            'client_type' => $validated['client_type'] ?? $portfolio->client_type,
            'location' => $validated['location'] ?? $portfolio->location,
            'image' => $imageUrl,
            'project_title' => $validated['project_title'] ?? $portfolio->project_title,
            'description' => $validated['description'] ?? $portfolio->description,
            'order' => $validated['order'] ?? $portfolio->order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Portofolio '{$portfolio->client_name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified B2B portfolio from storage.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $clientName = $portfolio->client_name;
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Klien B2B '{$clientName}' berhasil dihapus.");
    }
}
