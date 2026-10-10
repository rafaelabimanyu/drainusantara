<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MediaLifecycle;

use App\Http\Requests\Admin\StoreReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of customer reviews.
     */
    public function index(Request $request): View
    {
        $query = Review::with('service');

        if ($request->filled('rating')) {
            $query->where('rating', $request->integer('rating'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $reviews = $query->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.reviews.create', compact('services'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $record = new Review;
        $media = new MediaLifecycle;
        $media->run($record, function () use ($request, $validated, $media, $record): void {
            $avatarUrl = $validated['avatar_url'] ?? null;
            if ($request->hasFile('avatar')) {
                $avatarUrl = $media->upload($request->file('avatar'), 'reviews', true);
            }

            $media->save($record, [
                'customer_name' => $validated['customer_name'],
                'customer_role_or_location' => $validated['customer_role_or_location'] ?? null,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'service_id' => $validated['service_id'] ?? null,
                'avatar' => $avatarUrl,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.reviews.index')
            ->with('success', "Testimoni dari '{$validated['customer_name']}' berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('admin.reviews.edit', compact('review', 'services'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        $validated = $request->validated();

        $media = new MediaLifecycle;
        $media->run($review, function () use ($request, $validated, $media, $review): void {
            $avatarUrl = $review->avatar;
            if ($request->hasFile('avatar')) {
                $avatarUrl = $media->upload($request->file('avatar'), 'reviews', true);
            } elseif (!empty($validated['avatar_url'])) {
                $avatarUrl = $validated['avatar_url'];
            }

            $media->save($review, [
                'customer_name' => $validated['customer_name'],
                'customer_role_or_location' => array_key_exists('customer_role_or_location', $validated) ? $validated['customer_role_or_location'] : $review->customer_role_or_location,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'service_id' => $validated['service_id'] ?? null,
                'avatar' => $avatarUrl,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('admin.reviews.index')
            ->with('success', "Testimoni '{$review->customer_name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $name = $review->customer_name;
        (new MediaLifecycle)->run($review, fn () => $review->delete());

        return redirect()->route('admin.reviews.index')
            ->with('success', "Testimoni '{$name}' berhasil dihapus.");
    }
}
