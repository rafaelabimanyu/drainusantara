<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use App\Support\MediaLifecycle;
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

        $record = new Gallery;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $beforeImage = $validated['before_image_url'] ?? null;
            if ($request->hasFile('before_image')) {
                $beforeImage = $media->upload($request->file('before_image'), 'images/dokumentasi');
            } elseif (is_string($request->input('before_image')) && !empty($request->input('before_image'))) {
                $beforeImage = $request->input('before_image');
            }

            $afterImage = $validated['after_image_url'] ?? null;
            if ($request->hasFile('after_image')) {
                $afterImage = $media->upload($request->file('after_image'), 'images/dokumentasi');
            } elseif (is_string($request->input('after_image')) && !empty($request->input('after_image'))) {
                $afterImage = $request->input('after_image');
            }

            $image = $validated['image_url'] ?? null;
            if ($request->hasFile('image')) {
                $image = $media->upload($request->file('image'), 'images/dokumentasi');
            } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
                $image = $request->input('image');
            }

            $media->save($record, [
                'title' => $validated['title'],
                'category' => $validated['category'] ?? 'rumahan',
                'service_id' => $validated['service_id'] ?? null,
                'before_image' => $beforeImage,
                'after_image' => $afterImage,
                'image' => $image,
                'description' => $validated['description'] ?? null,
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

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

        $media = new MediaLifecycle;
        $media->run($gallery, function () use ($request, $validated, $media, $gallery): void {
            $beforeImage = $gallery->before_image;
            if ($request->hasFile('before_image')) {
                $newBefore = $media->upload($request->file('before_image'), 'images/dokumentasi');
                $beforeImage = $newBefore;
            } elseif (!empty($validated['before_image_url'])) {
                $beforeImage = $validated['before_image_url'];
            }

            $afterImage = $gallery->after_image;
            if ($request->hasFile('after_image')) {
                $newAfter = $media->upload($request->file('after_image'), 'images/dokumentasi');
                $afterImage = $newAfter;
            } elseif (!empty($validated['after_image_url'])) {
                $afterImage = $validated['after_image_url'];
            }

            $image = $gallery->image;
            if ($request->hasFile('image')) {
                $newImage = $media->upload($request->file('image'), 'images/dokumentasi');
                $image = $newImage;
            } elseif (!empty($validated['image_url'])) {
                $image = $validated['image_url'];
            }

            $media->save($gallery, [
                'title' => $validated['title'],
                'category' => $validated['category'] ?? $gallery->category ?? 'rumahan',
                'service_id' => $validated['service_id'] ?? null,
                'before_image' => $beforeImage,
                'after_image' => $afterImage,
                'image' => $image,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : $gallery->description,
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$gallery->title}' berhasil diperbarui!");
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        $title = $gallery->title;





        (new MediaLifecycle)->run($gallery, fn () => $gallery->delete());

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$title}' berhasil dihapus.");
    }

}
