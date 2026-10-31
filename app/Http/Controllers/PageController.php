<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\AreaController;
use App\Http\Controllers\Pages\ArticleController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\ShowcaseController;
use App\Http\Controllers\Pages\SitemapController;
use App\Http\Controllers\Traits\HasPageSeo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * Delegator / Proxy Controller for backward compatibility.
 * Specific actions are modularized under App\Http\Controllers\Pages.
 */
class PageController extends Controller
{
    use HasPageSeo;

    public function index(): View
    {
        return app(HomeController::class)->index();
    }

    public function areasIndex(): View
    {
        return app(AreaController::class)->areasIndex();
    }

    public function province(string $province): View
    {
        return app(AreaController::class)->province($province);
    }

    public function city(string $city): View|RedirectResponse
    {
        return app(AreaController::class)->city($city);
    }

    public function area(string $city, string $district): View|RedirectResponse
    {
        return app(AreaController::class)->area($city, $district);
    }

    public function gallery(): View
    {
        return app(ShowcaseController::class)->gallery();
    }

    public function showCaseStudy(string $slug): View
    {
        return app(ShowcaseController::class)->showCaseStudy($slug);
    }

    public function showPartnership(string $slug): View
    {
        return app(ShowcaseController::class)->showPartnership($slug);
    }

    public function articles(): View
    {
        return app(ArticleController::class)->articles();
    }

    public function articleDetail(string $slug): View
    {
        return app(ArticleController::class)->articleDetail($slug);
    }

    public function htmlSitemap(): View
    {
        return app(SitemapController::class)->htmlSitemap();
    }

    public function sitemap(): Response
    {
        return app(SitemapController::class)->sitemap();
    }

    public function llms(): Response
    {
        return app(SitemapController::class)->llms();
    }

    public function robots(): Response
    {
        return app(SitemapController::class)->robots();
    }

    public function about(): View
    {
        return app(AboutController::class)->about();
    }

    public function aboutProfile(): View
    {
        return app(AboutController::class)->aboutProfile();
    }

    public function aboutHolding(): View
    {
        return app(AboutController::class)->aboutHolding();
    }

    public function aboutK3(): View
    {
        return app(AboutController::class)->aboutK3();
    }

    public function aboutEquipment(): View
    {
        return app(AboutController::class)->aboutEquipment();
    }

    public function equipmentDetail(string $slug): View
    {
        return app(AboutController::class)->equipmentDetail($slug);
    }

    public function aboutPortfolio(): View
    {
        return app(AboutController::class)->aboutPortfolio();
    }

    public function aboutWarranty(): View
    {
        return app(AboutController::class)->aboutWarranty();
    }

    public function aboutFaq(): View
    {
        return app(AboutController::class)->aboutFaq();
    }
}
