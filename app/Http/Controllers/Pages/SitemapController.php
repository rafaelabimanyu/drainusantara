<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Service;
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    use HasPageSeo;

    /**
     * Display a comprehensive, human-friendly HTML Sitemap.
     */
    public function htmlSitemap(): View
    {
        PageMetadata::title('Peta Situs Resmi | Navigasi Lengkap Drainusantara');
        SEOMeta::setDescription('Peta situs resmi Drainusantara: panduan navigasi lengkap menuju katalog layanan pelancar pipa mampet, cakupan wilayah, portofolio, dan artikel edukasi.');
        SEOMeta::setCanonical(url('/sitemap'));

        OpenGraph::setTitle('Peta Situs Resmi | Navigasi Lengkap Drainusantara');
        OpenGraph::setDescription('Peta situs resmi Drainusantara: panduan navigasi lengkap menuju katalog layanan pelancar pipa mampet, cakupan wilayah, portofolio, dan artikel edukasi.');
        OpenGraph::setUrl(url('/sitemap'));

        $this->addBreadcrumb(['Peta Situs', url('/sitemap')]);

        $services = Service::where('is_active', true)->orderBy('order')->get();
        $provinces = RegionService::all();
        $coverageAreas = CoverageArea::where('is_active', true)->orderBy('district')->get();
        $articles = Article::where('is_published', true)->latest('published_at')->limit(12)->get();
        $caseStudies = Gallery::where('is_active', true)->whereNotNull('slug')->latest()->limit(8)->get();
        $partnerships = Portfolio::where('is_active', true)->whereNotNull('slug')->latest()->limit(8)->get();
        $equipments = Equipment::where('is_active', true)->whereNotNull('slug')->orderBy('order')->get();

        return view('sitemap', compact(
            'services',
            'provinces',
            'coverageAreas',
            'articles',
            'caseStudies',
            'partnerships',
            'equipments'
        ));
    }

    /**
     * Generate dynamic sitemap.xml for all public indexable routes.
     */
    public function sitemap(): Response
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        if (str_starts_with($baseUrl, 'https://')) {
            URL::forceScheme('https');
        }
        if (! empty($baseUrl)) {
            URL::forceRootUrl($baseUrl);
        }

        $xml = Cache::remember('sitemap.xml', 3600, function () use ($baseUrl) {
            if (str_starts_with($baseUrl, 'https://')) {
                URL::forceScheme('https');
            }
            if (! empty($baseUrl)) {
                URL::forceRootUrl($baseUrl);
            }

            $urls = [];

            // Core static pages
            $urls[] = ['loc' => url('/'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '1.0'];
            $urls[] = ['loc' => route('about.profile'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.holding'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.k3'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.equipment'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.portfolio'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.warranty'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => route('about.faq'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => url('/area'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.9'];
            $urls[] = ['loc' => url('/galeri'), 'lastmod' => null, 'changefreq' => 'weekly', 'priority' => '0.8'];
            $urls[] = ['loc' => url('/pengetahuan'), 'lastmod' => null, 'changefreq' => 'daily', 'priority' => '0.8'];

            // Regional landing routes
            $provinces = RegionService::all();
            $coverageAreas = CoverageArea::orderBy('id')->get();
            foreach ($provinces as $provSlug => $prov) {
                $urls[] = [
                    'loc' => route('area.province', ['province' => $provSlug]),
                    'lastmod' => null,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];

                foreach ($prov['cities'] as $citySlug => $city) {
                    $urls[] = [
                        'loc' => route('area.city', ['city' => $citySlug]),
                        'lastmod' => null,
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];

                    foreach ($city['districts'] as $district) {
                        $area = $coverageAreas->first(fn (CoverageArea $area) =>
                            in_array($area->city, [$city['name'], ucwords(str_replace('-', ' ', $citySlug))], true)
                            && Str::lower($area->district) === Str::lower($district)
                        );
                        if ($area && ! $area->is_active) {
                            continue;
                        }

                        $districtSlug = Str::slug($district);
                        $urls[] = [
                            'loc' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                            'lastmod' => ($area?->updated_at ?? $area?->created_at)?->toAtomString(),
                            'changefreq' => 'weekly',
                            'priority' => '0.8',
                        ];
                    }
                }
            }

            // Published knowledge articles
            $articles = Article::where('is_published', true)->get();
            foreach ($articles as $article) {
                $urls[] = [
                    'loc' => route('articles.show', ['slug' => $article->slug]),
                    'lastmod' => ($article->updated_at ?? $article->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            // Case Studies (Studi Kasus)
            $caseStudies = Gallery::where('is_active', true)->whereNotNull('slug')->get();
            foreach ($caseStudies as $study) {
                $urls[] = [
                    'loc' => route('case-study.show', ['slug' => $study->slug]),
                    'lastmod' => ($study->updated_at ?? $study->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            // Partnerships (Kemitraan)
            $partnerships = Portfolio::where('is_active', true)->whereNotNull('slug')->get();
            foreach ($partnerships as $partner) {
                $urls[] = [
                    'loc' => route('partnership.show', ['slug' => $partner->slug]),
                    'lastmod' => ($partner->updated_at ?? $partner->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            // Equipment Units (Peralatan)
            $equipments = Equipment::where('is_active', true)->whereNotNull('slug')->get();
            foreach ($equipments as $equip) {
                $urls[] = [
                    'loc' => route('equipment.show', ['slug' => $equip->slug]),
                    'lastmod' => ($equip->updated_at ?? $equip->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
            foreach ($urls as $u) {
                $xmlString .= "  <url>\n";
                $xmlString .= '    <loc>'.htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8')."</loc>\n";
                if (! empty($u['lastmod'])) {
                    $xmlString .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
                }
                $xmlString .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
                $xmlString .= "    <priority>{$u['priority']}</priority>\n";
                $xmlString .= "  </url>\n";
            }
            $xmlString .= '</urlset>';

            return trim($xmlString);
        });

        if (ob_get_level() > 0) {
            ob_clean();
        }

        return response($xml, 200)
            ->header('Content-Type', 'text/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Plain-text llms.txt (llmstxt.org) for AI crawlers.
     */
    public function llms(): Response
    {
        $body = Cache::remember('llms.txt', 600, function (): string {
            $services = Service::where('is_active', true)
                ->orderBy('order')
                ->get(['name', 'slug', 'short_description', 'price_starting_from']);

            return view('llms', [
                'services' => $services,
                'whatsappNumber' => config('app.whatsapp_number', '6285609009009'),
            ])->render();
        });

        return response($body, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=600');
    }

    /**
     * Plain-text dynamic robots.txt for search engines.
     */
    public function robots(): Response
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $sitemapUrl = ! empty($baseUrl) ? "{$baseUrl}/sitemap.xml" : url('/sitemap.xml');
        $content = "User-agent: *\nDisallow: /admin/\nDisallow: /login\n\nSitemap: {$sitemapUrl}\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}

