<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of incoming contact messages in CMS.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('city', 'like', $term)
                    ->orWhere('district', 'like', $term)
                    ->orWhere('message', 'like', $term);
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => ContactMessage::count(),
            'new' => ContactMessage::where('status', 'new')->count(),
            'in_progress' => ContactMessage::where('status', 'in_progress')->count(),
            'completed' => ContactMessage::where('status', 'completed')->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'counts'));
    }

    /**
     * Display the specified contact message detail.
     */
    public function show(ContactMessage $contact): View
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update status and notes for the specified contact message.
     */
    public function update(Request $request, ContactMessage $contact): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,completed,cancelled'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $contact->update($validated);

        return redirect()->back()->with('success', 'Status permohonan layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Pesan permohonan berhasil dihapus.');
    }
}

