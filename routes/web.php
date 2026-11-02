<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyPageController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CoverageAreaController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Pages;
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
Route::get('/', [Pages\HomeController::class, 'index'])->name('home');

// Cara Kerja & Standar Proses Non-Destruktif
Route::get('/cara-kerja', [Pages\AboutController::class, 'howItWorks'])->name('how-it-works');
Route::get('/proses-kerja', fn () => redirect()->route('how-it-works', [], 301));

// Hierarchical Area Routes: Index -> Province -> City -> District
Route::get('/area', [Pages\AreaController::class, 'areasIndex'])->name('area.index');
Route::get('/area/provinsi/{province}', [Pages\AreaController::class, 'province'])->name('area.province');
Route::get('/area/{city}', [Pages\AreaController::class, 'city'])->name('area.city');
Route::get('/area/{city}/{district}', [Pages\AreaController::class, 'area'])->name('area.detail');

// Galeri & Portofolio
Route::get('/galeri', [Pages\ShowcaseController::class, 'gallery'])->name('gallery');
Route::get('/studi-kasus/{slug}', [Pages\ShowcaseController::class, 'showCaseStudy'])->name('case-study.show');
Route::get('/kemitraan/{slug}', [Pages\ShowcaseController::class, 'showPartnership'])->name('partnership.show');
// Pratinjau komponen internal (hanya aktif di local & testing environment)
if (app()->environment('local', 'testing')) {
    Route::get('/preview-studi-kasus', function () {
        $caseStudy = \App\Models\Gallery::with(['service', 'equipment'])->whereNotNull('slug')->first();
        if ($caseStudy) {
            return redirect()->route('case-study.show', $caseStudy->slug);
        }
        return redirect()->route('gallery');
    });
    Route::get('/preview-kemitraan', function () {
        $partnership = \App\Models\Portfolio::with('services')->whereNotNull('slug')->first();
        if ($partnership) {
            return redirect()->route('partnership.show', $partnership->slug);
        }
        return redirect()->route('gallery');
    });
    Route::get('/preview-cards', fn () => view('preview-cards'))->name('preview.cards');
}

// Blog, Artikel & Edukasi Pengetahuan
Route::get('/pengetahuan', [Pages\ArticleController::class, 'articles'])->name('articles.index');
Route::get('/blog', fn () => redirect()->route('articles.index', [], 301))->name('articles.blog');
Route::get('/artikel', fn () => redirect()->route('articles.index', [], 301))->name('articles.legacy');
Route::get('/artikel/{slug}', [Pages\ArticleController::class, 'articleDetail'])->name('articles.show');

// Human HTML Sitemap & Dynamic XML Sitemap
Route::get('/sitemap', [Pages\SitemapController::class, 'htmlSitemap'])->name('sitemap.html');
Route::get('/peta-situs', fn () => redirect()->route('sitemap.html', [], 301));
Route::get('/sitemap.xml', [Pages\SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [Pages\SitemapController::class, 'robots'])->name('robots');

// llms.txt for AI crawlers (llmstxt.org)
Route::get('/llms.txt', [Pages\SitemapController::class, 'llms'])->name('llms');

// Agentic Resource Discovery (ARD v1.0) AI Catalog
Route::get('/.well-known/ai-catalog.json', [Pages\AiCatalogController::class, 'catalog'])->name('ai-catalog.well-known');
Route::get('/ai-catalog.json', [Pages\AiCatalogController::class, 'catalog'])->name('ai-catalog');

// Corporate & About Sub-Pages
Route::prefix('tentang-kami')->group(function () {
    Route::get('/', [Pages\AboutController::class, 'about'])->name('about');
    Route::get('/profil', [Pages\AboutController::class, 'aboutProfile'])->name('about.profile');
    Route::get('/staff', fn () => redirect('/tentang-kami/profil#staff-kami', 301))->name('about.staff');
    Route::get('/holding', [Pages\AboutController::class, 'aboutHolding'])->name('about.holding');
    Route::get('/holding-jj-group', fn () => redirect()->route('about.holding', [], 301));
    Route::get('/sop-k3', [Pages\AboutController::class, 'aboutK3'])->name('about.k3');
    Route::get('/peralatan', [Pages\AboutController::class, 'aboutEquipment'])->name('about.equipment');
    Route::get('/peralatan/{slug}', [Pages\AboutController::class, 'equipmentDetail'])->name('equipment.show');
    Route::get('/portofolio', [Pages\AboutController::class, 'aboutPortfolio'])->name('about.portfolio');
    Route::get('/garansi', [Pages\AboutController::class, 'aboutWarranty'])->name('about.warranty');
    Route::get('/faq', [Pages\AboutController::class, 'aboutFaq'])->name('about.faq');
});
Route::get('/peralatan/{slug}', fn ($slug) => redirect()->route('equipment.show', ['slug' => $slug], 301));
Route::get('/area-layanan', fn () => redirect('/#area'))->name('areas.anchor');
Route::get('/layanan', fn () => redirect('/#layanan', 301))->name('services.anchor');

// Halaman Kontak & Form Permohonan Layanan
Route::get('/kontak', [Pages\ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [Pages\ContactController::class, 'submit'])->middleware('throttle:10,1')->name('contact.submit');
Route::get('/hubungi-kami', fn () => redirect()->route('contact', [], 301));

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
    Route::post('system/refresh-cache', [AdminController::class, 'refreshCache'])->name('system.refresh-cache');

    Route::resource('services', ServiceController::class)->except('show');
    Route::post('coverage-areas/sync', [CoverageAreaController::class, 'syncFromMaster'])->name('coverage-areas.sync');
    Route::resource('coverage-areas', CoverageAreaController::class)->except('show');
    Route::resource('galleries', GalleryController::class)->except('show');
    Route::resource('portfolios', PortfolioController::class)->except('show');
    Route::resource('staff', StaffController::class)->except('show');
    Route::resource('equipments', EquipmentController::class)->except('show');
    Route::resource('articles', ArticleController::class)->except('show');
    Route::resource('reviews', ReviewController::class)->except('show');
    Route::resource('company-pages', CompanyPageController::class)->only(['index', 'edit', 'update']);
    Route::post('faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');
    Route::resource('faqs', FaqController::class)->except('show');
    Route::resource('contacts', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
});
