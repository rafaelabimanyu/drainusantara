<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Support\MediaLifecycle;
use Illuminate\Support\Str;
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
        $equipments = Equipment::where('is_active', true)->orderBy('name')->get();

        return view('admin.galleries.create', compact('services', 'equipments'));
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
                'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : null,
                'category' => $validated['category'] ?? 'rumahan',
                'location' => $validated['location'] ?? null,
                'property_type' => $validated['property_type'] ?? null,
                'problem_type' => $validated['problem_type'] ?? null,
                'severity' => $validated['severity'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'price' => $validated['price'] ?? null,
                'method' => $validated['method'] ?? null,
                'drain_type' => $validated['drain_type'] ?? null,
                'diagnosis' => $validated['diagnosis'] ?? null,
                'service_id' => $validated['service_id'] ?? null,
                'before_image' => $beforeImage,
                'after_image' => $afterImage,
                'image' => $image,
                'description' => $validated['description'] ?? null,
                'content' => $validated['content'] ?? null,
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->boolean('is_active'),
            ]);

            $record->equipment()->sync($validated['equipment_ids'] ?? []);
        });

        Cache::forget('galleries.all_active');
        Cache::forget('galleries.top3');
        Cache::forget('landing.galleries');
        if (!empty($record->slug)) {
            Cache::forget('case_study_' . $record->slug);
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$validated['title']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $equipments = Equipment::where('is_active', true)->orderBy('name')->get();

        return view('admin.galleries.edit', compact('gallery', 'services', 'equipments'));
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validated();
        $oldSlug = $gallery->slug;

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
                'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : $gallery->slug,
                'category' => $validated['category'] ?? $gallery->category ?? 'rumahan',
                'location' => array_key_exists('location', $validated) ? $validated['location'] : $gallery->location,
                'property_type' => array_key_exists('property_type', $validated) ? $validated['property_type'] : $gallery->property_type,
                'problem_type' => array_key_exists('problem_type', $validated) ? $validated['problem_type'] : $gallery->problem_type,
                'severity' => array_key_exists('severity', $validated) ? $validated['severity'] : $gallery->severity,
                'duration' => array_key_exists('duration', $validated) ? $validated['duration'] : $gallery->duration,
                'price' => array_key_exists('price', $validated) ? $validated['price'] : $gallery->price,
                'method' => array_key_exists('method', $validated) ? $validated['method'] : $gallery->method,
                'drain_type' => array_key_exists('drain_type', $validated) ? $validated['drain_type'] : $gallery->drain_type,
                'diagnosis' => array_key_exists('diagnosis', $validated) ? $validated['diagnosis'] : $gallery->diagnosis,
                'service_id' => $validated['service_id'] ?? null,
                'before_image' => $beforeImage,
                'after_image' => $afterImage,
                'image' => $image,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : $gallery->description,
                'content' => array_key_exists('content', $validated) ? $validated['content'] : $gallery->content,
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->boolean('is_active'),
            ]);

            $gallery->equipment()->sync($validated['equipment_ids'] ?? []);
        });

        Cache::forget('galleries.all_active');
        Cache::forget('galleries.top3');
        Cache::forget('landing.galleries');
        if ($oldSlug) {
            Cache::forget('case_study_' . $oldSlug);
        }
        if (!empty($gallery->slug)) {
            Cache::forget('case_study_' . $gallery->slug);
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$gallery->title}' berhasil diperbarui!");
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        $title = $gallery->title;
        $slug = $gallery->slug;

        (new MediaLifecycle)->run($gallery, fn () => $gallery->delete());

        Cache::forget('galleries.all_active');
        Cache::forget('galleries.top3');
        Cache::forget('landing.galleries');
        if ($slug) {
            Cache::forget('case_study_' . $slug);
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$title}' berhasil dihapus.");
    }

}
