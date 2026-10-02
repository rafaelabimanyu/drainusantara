<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(): View
    {
        $services = Service::orderBy('order')->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        $nextOrder = Service::getNextAvailableOrder();

        return view('admin.services.create', compact('nextOrder'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_starting_from' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'features_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:1'],
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
        ]);

        // Process image upload
        $imageUrl = 'https://placehold.co/600x400/0284c7/ffffff?text=' . urlencode($validated['name']);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            ]);
            $imageUrl = $this->uploadServiceImage($request->file('image'));
        } elseif (!empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        // Process features from textarea lines into array
        $features = [];
        if (!empty($validated['features_text'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
        }

        // Generate unique slug
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        Service::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'price_starting_from' => $validated['price_starting_from'] ?? 0,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? ($validated['short_description'] ?? null),
            'features' => $features,
            'is_active' => $request->boolean('is_active', true),
            'order' => !empty($validated['order']) ? (int) $validated['order'] : Service::getNextAvailableOrder(),
            'image' => $imageUrl,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_starting_from' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'features_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
        ]);

        $imageUrl = $service->image;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            ]);
            $oldImage = $service->image;
            $imageUrl = $this->uploadServiceImage($request->file('image'));
            $this->deleteServiceFile($oldImage, $service->id);
        } elseif (!empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $features = [];
        if (!empty($validated['features_text'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
        }

        $service->update([
            'name' => $validated['name'],
            'price_starting_from' => $validated['price_starting_from'] ?? 0,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? ($validated['short_description'] ?? null),
            'features' => $features,
            'is_active' => $request->boolean('is_active', true),
            'order' => $validated['order'] ?? $service->order,
            'image' => $imageUrl,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan '{$service->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $oldImage = $service->image;
        $name = $service->name;
        $service->delete();
        $this->deleteServiceFile($oldImage);

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan '{$name}' berhasil dihapus.");
    }

    /**
     * Upload uncompressed service image directly to public/images/services preserving original filename.
     */
    protected function uploadServiceImage($file): string
    {
        $targetDir = public_path('images/services');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = basename($file->getClientOriginalName());
        $file->move($targetDir, $filename);

        return '/images/services/' . $filename;
    }

    /**
     * Delete physical image file from public/images/services if it exists and not used elsewhere.
     */
    protected function deleteServiceFile(?string $path, ?int $excludeServiceId = null): void
    {
        if (empty($path)) {
            return;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        $relativePath = ltrim($parsedPath ?: $path, '/');

        // Pastikan hanya menghapus file di dalam folder images/services/
        if (!str_starts_with($relativePath, 'images/services/')) {
            return;
        }

        // Lindungi aset default/seeder agar tidak terhapus tidak sengaja
        $protectedDefaults = [
            'images/services/wastafel-cuci-piring-mampet.webp',
            'images/services/kloset-wc-mampet.webp',
            'images/services/floor-drain-kamar-mandi.webp',
            'images/services/talang-rooftop-pipa-atap.webp',
            'images/services/kuras-grease-trap-lemak.webp',
            'images/services/inspeksi-kamera-cctv-pipa.webp',
        ];

        if (in_array($relativePath, $protectedDefaults, true)) {
            return;
        }

        // Cek apakah file ini masih digunakan oleh record layanan lain
        $isUsedElsewhere = Service::query()
            ->when($excludeServiceId, fn ($q) => $q->where('id', '!=', $excludeServiceId))
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
