<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the equipment.
     */
    public function index(): View
    {
        $equipments = Equipment::orderBy('order')->latest()->paginate(10);

        return view('admin.equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new equipment.
     */
    public function create(): View
    {
        $nextOrder = Equipment::getNextAvailableOrder();

        return view('admin.equipments.create', compact('nextOrder'));
    }

    /**
     * Store a newly created equipment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:100'],
            'image' => $request->hasFile('image') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $record = new Equipment;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $imageUrl = $validated['image_url'] ?? null;
            if ($request->hasFile('image')) {
                $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
                $imageUrl = $media->upload($request->file('image'), 'assets/TOOLKIT');
            } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
                $imageUrl = $request->input('image');
            }

            $specsArray = $this->parseSpecsInput($request->input('specs'));

            $media->save($record, [
                'name' => $validated['name'],
                'category' => $validated['category'] ?? null,
                'badge' => $validated['badge'] ?? null,
                'image' => $imageUrl,
                'short_description' => $validated['short_description'] ?? null,
                'specs' => $specsArray,
                'order' => !empty($validated['order']) ? (int) $validated['order'] : Equipment::getNextAvailableOrder(),
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.equipments.index')
            ->with('success', "Peralatan '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified equipment.
     */
    public function edit(Equipment $equipment): View
    {
        return view('admin.equipments.edit', compact('equipment'));
    }

    /**
     * Update the specified equipment in storage.
     */
    public function update(Request $request, Equipment $equipment): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:100'],
            'image' => $request->hasFile('image') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $media = new MediaLifecycle;
        $media->run($equipment, function () use ($request, $validated, $media, $equipment): void {
            $imageUrl = $equipment->image;
            if ($request->hasFile('image')) {
                $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
                $newImage = $media->upload($request->file('image'), 'assets/TOOLKIT');
                $imageUrl = $newImage;
            } elseif (!empty($validated['image_url'])) {
                $imageUrl = $validated['image_url'];
            }

            $specsArray = $this->parseSpecsInput($request->input('specs'));

            $media->save($equipment, [
                'name' => $validated['name'],
                'category' => array_key_exists('category', $validated) ? $validated['category'] : $equipment->category,
                'badge' => array_key_exists('badge', $validated) ? $validated['badge'] : $equipment->badge,
                'image' => $imageUrl,
                'short_description' => array_key_exists('short_description', $validated) ? $validated['short_description'] : $equipment->short_description,
                'specs' => $specsArray,
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.equipments.index')
            ->with('success', "Peralatan '{$equipment->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified equipment from storage.
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $name = $equipment->name;



        (new MediaLifecycle)->run($equipment, fn () => $equipment->delete());

        return redirect()->route('admin.equipments.index')
            ->with('success', "Peralatan '{$name}' berhasil dihapus.");
    }

    /**
     * Parse textarea specs input (one per line) into an array.
     */
    protected function parseSpecsInput(?string $specsInput): array
    {
        if (empty($specsInput)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", $specsInput))));
    }
}
