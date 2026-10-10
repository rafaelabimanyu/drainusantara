<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

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
            'photo' => $request->hasFile('photo') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'initials' => ['nullable', 'string', 'max:10'],
            'order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $record = new Staff;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $photoUrl = $validated['photo_url'] ?? null;
            if ($request->hasFile('photo')) {
                $request->validate(['photo' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240']]);
                $photoUrl = $media->upload($request->file('photo'), 'images/staff');
            } elseif (is_string($request->input('photo')) && !empty($request->input('photo'))) {
                $photoUrl = $request->input('photo');
            }

            $media->save($record, [
                'name' => $validated['name'],
                'role' => $validated['role'] ?? 'Teknisi Lapangan Siaga',
                'photo' => $photoUrl,
                'initials' => $validated['initials'] ?? null,
                'order' => !empty($validated['order']) ? (int) $validated['order'] : Staff::getNextAvailableOrder(),
                'is_active' => $request->boolean('is_active'),
            ]);
        });

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
            'photo' => $request->hasFile('photo') ? ['nullable'] : ['nullable', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'initials' => ['nullable', 'string', 'max:10'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $media = new MediaLifecycle;
        $media->run($staff, function () use ($request, $validated, $media, $staff): void {
            $photoUrl = $staff->photo;
            if ($request->hasFile('photo')) {
                $request->validate(['photo' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240']]);
                $newPhoto = $media->upload($request->file('photo'), 'images/staff');
                $photoUrl = $newPhoto;
            } elseif (!empty($validated['photo_url'])) {
                $photoUrl = $validated['photo_url'];
            }

            $media->save($staff, [
                'name' => $validated['name'],
                'role' => array_key_exists('role', $validated) ? $validated['role'] : $staff->role,
                'photo' => $photoUrl,
                'initials' => array_key_exists('initials', $validated) ? $validated['initials'] : $staff->initials,
                'order' => $validated['order'] ?? $staff->order,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.staff.index')
            ->with('success', "Data staff '{$staff->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(Staff $staff): RedirectResponse
    {
        $name = $staff->name;

        (new MediaLifecycle)->run($staff, fn () => $staff->delete());

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$name}' berhasil dihapus.");
    }

}
