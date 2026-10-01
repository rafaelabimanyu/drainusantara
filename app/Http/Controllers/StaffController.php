<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    /**
     * Display a listing of staff and technicians.
     */
    public function index(): View
    {
        $staffMembers = Staff::orderBy('order')->latest()->paginate(12);

        return view('admin.staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create(): View
    {
        $nextOrder = Staff::getNextAvailableOrder();

        return view('admin.staff.create', compact('nextOrder'));
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable'],
            'photo_url' => ['nullable', 'string', 'max:500'],
            'initials' => ['nullable', 'string', 'max:10'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $photoUrl = $validated['photo_url'] ?? null;
        if ($request->hasFile('photo')) {
            $request->validate(['photo' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240']]);
            $photoUrl = $this->uploadStaffPhoto($request->file('photo'));
        } elseif (is_string($request->input('photo')) && !empty($request->input('photo'))) {
            $photoUrl = $request->input('photo');
        }

        Staff::create([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? 'Teknisi Lapangan Siaga',
            'photo' => $photoUrl,
            'initials' => $validated['initials'] ?? null,
            'order' => !empty($validated['order']) ? (int) $validated['order'] : Staff::getNextAvailableOrder(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff): View
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable'],
            'photo_url' => ['nullable', 'string', 'max:500'],
            'initials' => ['nullable', 'string', 'max:10'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $photoUrl = $staff->photo;
        if ($request->hasFile('photo')) {
            $request->validate(['photo' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240']]);
            $newPhoto = $this->uploadStaffPhoto($request->file('photo'));
            if ($staff->photo && $staff->photo !== $newPhoto) {
                $this->deleteStaffFile($staff->photo, $staff->id);
            }
            $photoUrl = $newPhoto;
        } elseif (!empty($validated['photo_url'])) {
            $photoUrl = $validated['photo_url'];
        }

        $staff->update([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? $staff->role,
            'photo' => $photoUrl,
            'initials' => $validated['initials'] ?? null,
            'order' => $validated['order'] ?? $staff->order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', "Data staff '{$staff->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(Staff $staff): RedirectResponse
    {
        $name = $staff->name;
        $this->deleteStaffFile($staff->photo, $staff->id);
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$name}' berhasil dihapus.");
    }

    /**
     * Upload uncompressed staff photo to public/images/staff preserving original filename.
     */
    protected function uploadStaffPhoto($file): string
    {
        $targetDir = public_path('images/staff');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = time() . '_' . basename($file->getClientOriginalName());
        $file->move($targetDir, $filename);

        return '/images/staff/' . $filename;
    }

    /**
     * Delete physical staff photo from public/images/staff if it exists and not used elsewhere.
     */
    protected function deleteStaffFile(?string $path, ?int $excludeStaffId = null): void
    {
        if (empty($path)) {
            return;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        $relativePath = ltrim($parsedPath ?: $path, '/');

        if (!str_starts_with($relativePath, 'images/staff/')) {
            return;
        }

        $isUsedElsewhere = Staff::query()
            ->when($excludeStaffId, fn ($q) => $q->where('id', '!=', $excludeStaffId))
            ->where(function ($q) use ($path, $relativePath) {
                $q->where('photo', $path)
                    ->orWhere('photo', '/' . $relativePath)
                    ->orWhere('photo', $relativePath);
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
