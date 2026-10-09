<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoverageAreaController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Drainusantara Platform
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [PageController::class, 'index'])->name('home');

// Hierarchical Area Routes: Index -> Province -> City -> District
Route::get('/area', [PageController::class, 'areasIndex'])->name('area.index');
Route::get('/area/provinsi/{province}', [PageController::class, 'province'])->name('area.province');
Route::get('/area/{city}', [PageController::class, 'city'])->name('area.city');
Route::get('/area/{city}/{district}', [PageController::class, 'area'])->name('area.detail');

// Galeri & Portofolio
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');

// Artikel & Edukasi Pengetahuan
Route::get('/pengetahuan', [PageController::class, 'articles'])->name('articles.index');
Route::get('/artikel', fn () => redirect()->route('articles.index', [], 301))->name('articles.legacy');
Route::get('/artikel/{slug}', [PageController::class, 'articleDetail'])->name('articles.show');

// Dynamic XML Sitemap & Robots.txt for SEO Crawlers
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots');

// llms.txt for AI crawlers (llmstxt.org)
Route::get('/llms.txt', [PageController::class, 'llms'])->name('llms');

// Corporate & About Sub-Pages
Route::prefix('tentang-kami')->group(function () {
    Route::get('/', [PageController::class, 'about'])->name('about');
    Route::get('/profil', [PageController::class, 'aboutProfile'])->name('about.profile');
    Route::get('/staff', fn () => redirect('/tentang-kami/profil#staff-kami', 301))->name('about.staff');
    Route::get('/holding', [PageController::class, 'aboutHolding'])->name('about.holding');
    Route::get('/holding-jj-group', fn () => redirect()->route('about.holding', [], 301));
    Route::get('/sop-k3', [PageController::class, 'aboutK3'])->name('about.k3');
    Route::get('/peralatan', [PageController::class, 'aboutEquipment'])->name('about.equipment');
    Route::get('/portofolio', [PageController::class, 'aboutPortfolio'])->name('about.portfolio');
    Route::get('/garansi', [PageController::class, 'aboutWarranty'])->name('about.warranty');
    Route::get('/faq', [PageController::class, 'aboutFaq'])->name('about.faq');
});
Route::get('/area-layanan', fn () => redirect('/#area'))->name('areas.anchor');

// CMS Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/login', fn () => redirect()->route('login'));

// Custom CMS Admin Routes (Protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('services', ServiceController::class);
    Route::resource('coverage-areas', CoverageAreaController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('equipments', EquipmentController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('reviews', ReviewController::class);
});
