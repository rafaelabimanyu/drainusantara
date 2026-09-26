<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoverageAreaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
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
Route::get('/artikel', [PageController::class, 'articles'])->name('articles.legacy');
Route::get('/artikel/{slug}', [PageController::class, 'articleDetail'])->name('articles.show');

// Dynamic XML Sitemap for SEO Crawlers
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

// Friendly redirects for navbar sections
Route::get('/layanan', fn () => redirect('/#layanan'))->name('services.anchor');
Route::get('/tentang-kami', fn () => redirect('/#keunggulan'))->name('about.anchor');
Route::get('/area-layanan', fn () => redirect('/#area'))->name('areas.anchor');

// CMS Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/login', fn () => redirect()->route('login'));

// Custom CMS Admin Routes (Protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('services', ServiceController::class);  
    Route::resource('coverage-areas', CoverageAreaController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('articles', ArticleController::class);
});
