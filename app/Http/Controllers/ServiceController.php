<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Support\MediaLifecycle;
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
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        $record = new Service;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            // Process image upload
            $imageUrl = 'https://placehold.co/600x400/0284c7/ffffff?text=' . urlencode(mb_strcut($validated['name'], 0, 69, 'UTF-8'));
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
                ]);
                $imageUrl = $media->upload($request->file('image'), 'images/services');
            } elseif (!empty($validated['image_url'])) {
                $imageUrl = $validated['image_url'];
            }

            // Process features from textarea lines into array
            $features = [];
            if (!empty($validated['features_text'])) {
                $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
            }

            // Generate unique slug
            $baseSlug = substr(Str::slug($validated['name']), 0, 255);
            $slug = $baseSlug;
            $counter = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = substr($baseSlug, 0, 255 - strlen("-{$counter}")) . "-{$counter}";
                $counter++;
            }

            $media->save($record, [
                'name' => $validated['name'],
                'slug' => $slug,
                'price_starting_from' => $validated['price_starting_from'] ?? 0,
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? ($validated['short_description'] ?? null),
                'features' => $features,
                'is_active' => $request->boolean('is_active'),
                'order' => !empty($validated['order']) ? (int) $validated['order'] : Service::getNextAvailableOrder(),
                'image' => $imageUrl,
            ]);
        });

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
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        $media = new MediaLifecycle;
        $media->run($service, function () use ($request, $validated, $media, $service): void {
            $imageUrl = $service->image;
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
                ]);

                $imageUrl = $media->upload($request->file('image'), 'images/services');
            } elseif (!empty($validated['image_url'])) {
                $imageUrl = $validated['image_url'];
            }

            $features = [];
            if (!empty($validated['features_text'])) {
                $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_text']))));
            }

            $media->save($service, [
                'name' => $validated['name'],
                'price_starting_from' => $validated['price_starting_from'] ?? 0,
                'short_description' => array_key_exists('short_description', $validated) ? $validated['short_description'] : $service->short_description,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : $service->description,
                'features' => $features,
                'is_active' => $request->boolean('is_active'),
                'order' => $validated['order'] ?? $service->order,
                'image' => $imageUrl,
            ]);
        });

        return redirect()->route('admin.services.index')
            ->with('success', "Layanan '{$service->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {

        $name = $service->name;
        (new MediaLifecycle)->run($service, fn () => $service->delete());


        return redirect()->route('admin.services.index')
            ->with('success', "Layanan '{$name}' berhasil dihapus.");
    }

}
