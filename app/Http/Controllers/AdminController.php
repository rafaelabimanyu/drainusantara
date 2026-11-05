<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Services\CacheService;
use App\Services\SearchEnginePingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Display the CMS Admin Dashboard overview.
     */
    public function index(): View
    {
        $stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_coverage_areas' => CoverageArea::count(),
            'total_galleries' => Gallery::count(),
            'total_portfolios' => Portfolio::count(),
            'total_equipments' => Equipment::count(),
            'total_gallery_portfolio' => Gallery::count() + Portfolio::count(),
            'total_articles' => Article::count(),
            'total_reviews' => Review::count(),
            'total_contacts' => ContactMessage::count(),
            'new_contacts' => ContactMessage::where('status', 'new')->count(),
        ];

        $recentServices = Service::orderBy('order')->take(5)->get();
        $recentAreas = CoverageArea::latest()->take(6)->get();
        $recentContacts = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentServices', 'recentAreas', 'recentContacts'));
    }

    /**
     * Clear all public caches and ping search engines with freshness signal.
     */
    public function refreshCache(): RedirectResponse
    {
        CacheService::clearPublicCache();
        $pingResult = SearchEnginePingService::pingAll();

        $statusMsg = "Cache sistem berhasil disegarkan & Sinyal pembaruan SEO berhasil dikirim ke Google & IndexNow ({$pingResult['timestamp']}).";

        return redirect()->back()->with('success', $statusMsg);
    }
}
