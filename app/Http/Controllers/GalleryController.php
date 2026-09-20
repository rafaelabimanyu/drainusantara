<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'before_image' => ['nullable'],
            'before_image_url' => ['nullable', 'string', 'max:500'],
            'after_image' => ['nullable'],
            'after_image_url' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $beforeImage = $validated['before_image_url'] ?? null;
        if ($request->hasFile('before_image')) {
            $request->validate(['before_image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $beforeImage = Storage::url($request->file('before_image')->store('galleries', 'public'));
        } elseif (is_string($request->input('before_image')) && !empty($request->input('before_image'))) {
            $beforeImage = $request->input('before_image');
        }

        $afterImage = $validated['after_image_url'] ?? null;
        if ($request->hasFile('after_image')) {
            $request->validate(['after_image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $afterImage = Storage::url($request->file('after_image')->store('galleries', 'public'));
        } elseif (is_string($request->input('after_image')) && !empty($request->input('after_image'))) {
            $afterImage = $request->input('after_image');
        }

        $image = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $image = Storage::url($request->file('image')->store('galleries', 'public'));
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $image = $request->input('image');
        }

        Gallery::create([
            'title' => $validated['title'],
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
    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'before_image' => ['nullable'],
            'before_image_url' => ['nullable', 'string', 'max:500'],
            'after_image' => ['nullable'],
            'after_image_url' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $beforeImage = $gallery->before_image;
        if ($request->hasFile('before_image')) {
            $request->validate(['before_image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $beforeImage = Storage::url($request->file('before_image')->store('galleries', 'public'));
        } elseif (!empty($validated['before_image_url'])) {
            $beforeImage = $validated['before_image_url'];
        }

        $afterImage = $gallery->after_image;
        if ($request->hasFile('after_image')) {
            $request->validate(['after_image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $afterImage = Storage::url($request->file('after_image')->store('galleries', 'public'));
        } elseif (!empty($validated['after_image_url'])) {
            $afterImage = $validated['after_image_url'];
        }

        $image = $gallery->image;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120']]);
            $image = Storage::url($request->file('image')->store('galleries', 'public'));
        } elseif (!empty($validated['image_url'])) {
            $image = $validated['image_url'];
        }

        $gallery->update([
            'title' => $validated['title'],
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
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', "Item galeri '{$title}' berhasil dihapus.");
    }
}
