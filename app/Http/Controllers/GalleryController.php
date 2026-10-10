<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index(): View
    {
        $galleries = Gallery::with('service')->orderBy('order')->latest()->paginate(10);

        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create(): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.galleries.create', compact('services'));
    }

    /**
     * Store a newly created gallery item in storage.
     */
    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $beforeImage = $validated['before_image_url'] ?? null;
        if ($request->hasFile('before_image')) {
            $beforeImage = $this->uploadDokumentasiImage($request->file('before_image'));
        } elseif (is_string($request->input('before_image')) && !empty($request->input('before_image'))) {
            $beforeImage = $request->input('before_image');
        }

        $afterImage = $validated['after_image_url'] ?? null;
        if ($request->hasFile('after_image')) {
            $afterImage = $this->uploadDokumentasiImage($request->file('after_image'));
        } elseif (is_string($request->input('after_image')) && !empty($request->input('after_image'))) {
            $afterImage = $request->input('after_image');
        }

        $image = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $image = $this->uploadDokumentasiImage($request->file('image'));
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $image = $request->input('image');
        }

        Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? 'rumahan',
            'service_id' => $validated['service_id'] ?? null,
            'before_image' => $beforeImage,
            'after_image' => $afterImage,
            'image' => $image,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$validated['title']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.galleries.edit', compact('gallery', 'services'));
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validated();

        $beforeImage = $gallery->before_image;
        if ($request->hasFile('before_image')) {
            $newBefore = $this->uploadDokumentasiImage($request->file('before_image'));
            if ($gallery->before_image && $gallery->before_image !== $newBefore) {
                $this->deleteDokumentasiFile($gallery->before_image, $gallery->id);
            }
            $beforeImage = $newBefore;
        } elseif (!empty($validated['before_image_url'])) {
            $beforeImage = $validated['before_image_url'];
        }

        $afterImage = $gallery->after_image;
        if ($request->hasFile('after_image')) {
            $newAfter = $this->uploadDokumentasiImage($request->file('after_image'));
            if ($gallery->after_image && $gallery->after_image !== $newAfter) {
                $this->deleteDokumentasiFile($gallery->after_image, $gallery->id);
            }
            $afterImage = $newAfter;
        } elseif (!empty($validated['after_image_url'])) {
            $afterImage = $validated['after_image_url'];
        }

        $image = $gallery->image;
        if ($request->hasFile('image')) {
            $newImage = $this->uploadDokumentasiImage($request->file('image'));
            if ($gallery->image && $gallery->image !== $newImage) {
                $this->deleteDokumentasiFile($gallery->image, $gallery->id);
            }
            $image = $newImage;
        } elseif (!empty($validated['image_url'])) {
            $image = $validated['image_url'];
        }

        $gallery->update([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? $gallery->category ?? 'rumahan',
            'service_id' => $validated['service_id'] ?? null,
            'before_image' => $beforeImage,
            'after_image' => $afterImage,
            'image' => $image,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$gallery->title}' berhasil diperbarui!");
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        $title = $gallery->title;

        // Hapus file fisik gambar yang tersimpan di public/images/dokumentasi
        $this->deleteDokumentasiFile($gallery->image, $gallery->id);
        $this->deleteDokumentasiFile($gallery->before_image, $gallery->id);
        $this->deleteDokumentasiFile($gallery->after_image, $gallery->id);

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$title}' berhasil dihapus.");
    }

    /**
     * Upload uncompressed image to public/images/dokumentasi preserving the original filename intact.
     */
    protected function uploadDokumentasiImage(UploadedFile $file): string
    {
        $targetDir = public_path('images/dokumentasi');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = basename($file->getClientOriginalName());
        $file->move($targetDir, $filename);

        return '/images/dokumentasi/' . $filename;
    }

    /**
     * Delete physical image file from public/images/dokumentasi if it exists and not used elsewhere.
     */
    protected function deleteDokumentasiFile(?string $path, ?int $excludeGalleryId = null): void
    {
        if (empty($path)) {
            return;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        $relativePath = ltrim($parsedPath ?: $path, '/');

        // Pastikan hanya menghapus file di dalam folder images/dokumentasi/
        if (!str_starts_with($relativePath, 'images/dokumentasi/')) {
            return;
        }

        // Cek apakah file ini masih digunakan oleh record galeri lain
        $isUsedElsewhere = Gallery::query()
            ->when($excludeGalleryId, fn ($q) => $q->where('id', '!=', $excludeGalleryId))
            ->where(function ($q) use ($path, $relativePath) {
                $q->where('image', $path)
                    ->orWhere('image', '/' . $relativePath)
                    ->orWhere('image', $relativePath)
                    ->orWhere('before_image', $path)
                    ->orWhere('before_image', '/' . $relativePath)
                    ->orWhere('before_image', $relativePath)
                    ->orWhere('after_image', $path)
                    ->orWhere('after_image', '/' . $relativePath)
                    ->orWhere('after_image', $relativePath);
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
