<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Contracts\View\View;

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
            'total_gallery_portfolio' => Gallery::count() + Portfolio::count(),
            'total_articles' => Article::count(),
            'total_reviews' => Review::count(),
        ];

        $recentServices = Service::orderBy('order')->take(5)->get();
        $recentAreas = CoverageArea::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentServices', 'recentAreas'));
    }
}
