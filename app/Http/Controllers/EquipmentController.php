<?php

namespace App\Http\Controllers;

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
        return view('admin.equipments.create');
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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'short_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
            $imageUrl = $this->uploadEquipmentImage($request->file('image'));
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $imageUrl = $request->input('image');
        }

        $specsArray = $this->parseSpecsInput($request->input('specs'));

        Equipment::create([
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'image' => $imageUrl,
            'short_description' => $validated['short_description'] ?? null,
            'specs' => $specsArray,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

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
            'image' => ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'short_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageUrl = $equipment->image;
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']]);
            $newImage = $this->uploadEquipmentImage($request->file('image'));
            if ($equipment->image && $equipment->image !== $newImage) {
                $this->deleteEquipmentFile($equipment->image, $equipment->id);
            }
            $imageUrl = $newImage;
        } elseif (!empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $specsArray = $this->parseSpecsInput($request->input('specs'));

        $equipment->update([
            'name' => $validated['name'],
            'category' => $validated['category'] ?? $equipment->category,
            'badge' => $validated['badge'] ?? $equipment->badge,
            'image' => $imageUrl,
            'short_description' => $validated['short_description'] ?? $equipment->short_description,
            'specs' => $specsArray,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.equipments.index')
            ->with('success', "Peralatan '{$equipment->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified equipment from storage.
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $name = $equipment->name;

        // Hapus file fisik gambar yang tersimpan di public/assets/TOOLKIT
        $this->deleteEquipmentFile($equipment->image, $equipment->id);

        $equipment->delete();

        return redirect()->route('admin.equipments.index')
            ->with('success', "Peralatan '{$name}' berhasil dihapus.");
    }

    /**
     * Upload uncompressed image to public/assets/TOOLKIT preserving the original filename intact.
     */
    protected function uploadEquipmentImage($file): string
    {
        $targetDir = public_path('assets/TOOLKIT');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = basename($file->getClientOriginalName());
        $file->move($targetDir, $filename);

        return '/assets/TOOLKIT/' . $filename;
    }

    /**
     * Delete physical image file from public/assets/TOOLKIT if it exists and not used elsewhere.
     */
    protected function deleteEquipmentFile(?string $path, ?int $excludeEquipmentId = null): void
    {
        if (empty($path)) {
            return;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        $relativePath = ltrim($parsedPath ?: $path, '/');

        // Pastikan hanya menghapus file di dalam folder assets/TOOLKIT/
        if (!str_starts_with($relativePath, 'assets/TOOLKIT/')) {
            return;
        }

        // Cek apakah file ini masih digunakan oleh record peralatan lain
        $isUsedElsewhere = Equipment::query()
            ->when($excludeEquipmentId, fn ($q) => $q->where('id', '!=', $excludeEquipmentId))
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
