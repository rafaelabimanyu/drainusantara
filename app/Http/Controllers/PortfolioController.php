<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
            $imageUrl = $this->uploadPortfolioImage($request->file('image'));
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $imageUrl = $request->input('image');
        } elseif (!$imageUrl) {
            $imageUrl = '/images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp';
        }

        Portfolio::create([
            'client_name' => $validated['client_name'],
            'client_type' => $validated['client_type'] ?? 'Restoran & F&B',
            'location' => $validated['location'] ?? 'Jabodetabek',
            'image' => $imageUrl,
            'project_title' => $validated['project_title'] ?? null,
            'description' => $validated['description'] ?? null,
            'order' => !empty($validated['order']) ? (int) $validated['order'] : Portfolio::getNextAvailableOrder(),
            'is_active' => $request->boolean('is_active', true),
        ]);

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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $portfolio->image;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
            $newImage = $this->uploadPortfolioImage($request->file('image'));
            if ($portfolio->image && $portfolio->image !== $newImage) {
                $this->deletePortfolioFile($portfolio->image, $portfolio->id);
            }
            $imageUrl = $newImage;
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

        // Hapus file fisik gambar yang tersimpan di public/images/portfolio
        $this->deletePortfolioFile($portfolio->image, $portfolio->id);

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', "Klien B2B '{$clientName}' berhasil dihapus.");
    }

    /**
     * Upload uncompressed image to public/images/portfolio preserving the original filename intact.
     */
    protected function uploadPortfolioImage(UploadedFile $file): string
    {
        $targetDir = public_path('images/portfolio');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = basename($file->getClientOriginalName());
        $file->move($targetDir, $filename);

        return '/images/portfolio/' . $filename;
    }

    /**
     * Delete physical image file from public/images/portfolio if it exists and not used elsewhere.
     */
    protected function deletePortfolioFile(?string $path, ?int $excludePortfolioId = null): void
    {
        if (empty($path)) {
            return;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        $relativePath = ltrim($parsedPath ?: $path, '/');

        // Pastikan hanya menghapus file di dalam folder images/portfolio/
        if (!str_starts_with($relativePath, 'images/portfolio/')) {
            return;
        }

        // Cek apakah file ini masih digunakan oleh record portofolio lain
        $isUsedElsewhere = Portfolio::query()
            ->when($excludePortfolioId, fn ($q) => $q->where('id', '!=', $excludePortfolioId))
            ->where(function ($q) use ($path, $relativePath) {
                $q->where('image', $path)
                    ->orWhere('image', '/' . $relativePath)
                    ->orWhere('image', $relativePath);
            })
            ->exists();

        if ($isUsedElsewhere) {
            return;
        }

        $fullPath = public_path($relativePath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
