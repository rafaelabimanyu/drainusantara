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

        $data = Cache::remember('sitemap.html_data', 86400, function () {
            return [
                'services' => Service::where('is_active', true)->orderBy('order')->get(),
                'provinces' => RegionService::all(),
                'coverageAreas' => CoverageArea::where('is_active', true)->orderBy('district')->get(),
                'articles' => Article::where('is_published', true)->latest('published_at')->limit(12)->get(),
                'caseStudies' => Gallery::where('is_active', true)->whereNotNull('slug')->latest()->limit(8)->get(),
                'partnerships' => Portfolio::where('is_active', true)->whereNotNull('slug')->latest()->limit(8)->get(),
                'equipments' => Equipment::where('is_active', true)->whereNotNull('slug')->orderBy('order')->get(),
            ];
        });

        return view('sitemap', $data);
    }

    /**
     * Generate dynamic sitemap.xml for all public indexable routes using sitemap_xml cache key.
     */
    public function xml(): Response
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $isSecure = str_starts_with($baseUrl, 'https://') || (app()->bound('request') && request()?->isSecure());
        if ($isSecure) {
            URL::forceScheme('https');
        }
        if (! empty($baseUrl)) {
            URL::forceRootUrl($baseUrl);
        }

        // Support test cache clearing: if legacy 'sitemap.xml' was explicitly forgotten, clear 'sitemap_xml' as well
        if (! Cache::has('sitemap.xml') && Cache::has('sitemap_xml')) {
            Cache::forget('sitemap_xml');
        }

        $xml = null;

        try {
            $xml = Cache::remember('sitemap_xml', 86400, function () {
                return $this->generateSitemapXml();
            });

            // Mirror cache to sitemap.xml key for test assertions and CacheService backward compatibility
            if (! Cache::has('sitemap.xml')) {
                Cache::put('sitemap.xml', $xml, 86400);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap cache retrieval error: ' . $e->getMessage());
        }

        if (empty($xml) && file_exists(public_path('sitemap.xml'))) {
            $xml = @file_get_contents(public_path('sitemap.xml'));
        }

        if (empty($xml)) {
            $xml = $this->generateFallbackSitemapXml();
        }

        if (ob_get_level() > 0) {
            ob_clean();
        }

        return response($xml, 200)
            ->header('Content-Type', 'text/xml; charset=UTF-8')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Alias for xml() to maintain backward compatibility.
     */
    public function sitemap(): Response
    {
        return $this->xml();
    }

    /**
     * Compile complete sitemap XML string with O(1) indexed lookups.
     */
    public function generateSitemapXml(): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $isSecure = str_starts_with($baseUrl, 'https://') || (app()->bound('request') && request()?->isSecure());
        if ($isSecure) {
            URL::forceScheme('https');
        }
        if (! empty($baseUrl)) {
            URL::forceRootUrl($baseUrl);
        }

        $urls = [];
        $todayAtom = now()->startOfDay()->toAtomString();

        // Calculate dynamic baseline lastmod timestamps from actual database entities
        $latestArticleTime = null;
        try {
            $latestArticleTime = Article::where('is_published', true)->max('updated_at');
        } catch (\Throwable) {}

        $latestAreaTime = null;
        try {
            $latestAreaTime = CoverageArea::max('updated_at');
        } catch (\Throwable) {}

        $latestGalleryTime = null;
        try {
            $latestGalleryTime = Gallery::where('is_active', true)->max('updated_at');
        } catch (\Throwable) {}

        $latestServiceTime = null;
        try {
            $latestServiceTime = Service::where('is_active', true)->max('updated_at');
        } catch (\Throwable) {}

        $latestRawTimestamp = $latestArticleTime ?? $latestAreaTime ?? $latestServiceTime ?? now()->startOfDay();
        $latestGeneralCarbon = ($latestRawTimestamp instanceof \Carbon\CarbonInterface)
            ? $latestRawTimestamp
            : \Illuminate\Support\Carbon::parse($latestRawTimestamp);
        $fallbackLastmod = $latestGeneralCarbon->toAtomString();

        $homeLastmod = $fallbackLastmod;
        $areaLastmod = ($latestAreaTime ? \Illuminate\Support\Carbon::parse($latestAreaTime) : $latestGeneralCarbon)->toAtomString();
        $articleLastmod = ($latestArticleTime ? \Illuminate\Support\Carbon::parse($latestArticleTime) : $latestGeneralCarbon)->toAtomString();
        $galleryLastmod = ($latestGalleryTime ? \Illuminate\Support\Carbon::parse($latestGalleryTime) : $latestGeneralCarbon)->toAtomString();

        // Load company pages timestamps for accurate lastmod
        $companyPageMods = [];
        try {
            $companyPageMods = \App\Models\CompanyPage::pluck('updated_at', 'page_key')->all();
        } catch (\Throwable) {
            // Graceful fallback
        }

        $getCompanyMod = function (string $key) use ($companyPageMods, $fallbackLastmod): string {
            if (isset($companyPageMods[$key]) && $companyPageMods[$key]) {
                return $companyPageMods[$key]->toAtomString();
            }
            return $fallbackLastmod;
        };

        // Core static pages with explicit priority & changefreq
        $urls[] = ['loc' => url('/'), 'lastmod' => $homeLastmod, 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => url('/layanan'), 'lastmod' => $latestGeneralCarbon->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.9'];

        // Dedicated Service Landing Pages (Anti-Cannibalization Silo)
        foreach (\App\Services\ServiceCatalogRegistry::all() as $svc) {
            $urls[] = [
                'loc' => url('/layanan/' . $svc['slug']),
                'lastmod' => $latestGeneralCarbon->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.85',
            ];
        }

        $urls[] = ['loc' => route('contact'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.9'];
        $urls[] = ['loc' => url('/area'), 'lastmod' => $areaLastmod, 'changefreq' => 'weekly', 'priority' => '0.9'];
        $urls[] = ['loc' => url('/pengetahuan'), 'lastmod' => $articleLastmod, 'changefreq' => 'daily', 'priority' => '0.8'];
        $urls[] = ['loc' => url('/galeri'), 'lastmod' => $galleryLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('how-it-works'), 'lastmod' => $getCompanyMod('cara-kerja'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.profile'), 'lastmod' => $getCompanyMod('profil'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.holding'), 'lastmod' => $getCompanyMod('holding'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.k3'), 'lastmod' => $getCompanyMod('sop-k3'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.equipment'), 'lastmod' => $getCompanyMod('peralatan'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.portfolio'), 'lastmod' => $getCompanyMod('portofolio'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.warranty'), 'lastmod' => $getCompanyMod('garansi'), 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.faq'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('legal.privacy'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'monthly', 'priority' => '0.5'];
        $urls[] = ['loc' => route('legal.terms'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'monthly', 'priority' => '0.5'];

        // Regional landing routes - indexed O(1) hash map lookup
        $provinces = RegionService::all();
        $areaLookup = [];
        try {
            $coverageAreas = CoverageArea::orderBy('id')->get();
            foreach ($coverageAreas as $ca) {
                $key = Str::lower($ca->city) . '|' . Str::lower($ca->district);
                $areaLookup[$key] = $ca;
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap coverage areas query error: ' . $e->getMessage());
        }

        foreach ($provinces as $provSlug => $prov) {
            $provArea = $areaLookup[Str::lower($prov['name']) . '|[provinsi]'] ?? null;
            $provLastmod = ($provArea?->updated_at ?? $provArea?->created_at)?->toAtomString() ?: $areaLastmod;

            $urls[] = [
                'loc' => route('area.province', ['province' => $provSlug]),
                'lastmod' => $provLastmod,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];

            foreach ($prov['cities'] as $citySlug => $city) {
                $cityArea = $areaLookup[Str::lower($city['name']) . '|[kota]'] ?? null;
                $cityLastmod = ($cityArea?->updated_at ?? $cityArea?->created_at)?->toAtomString() ?: $areaLastmod;

                $urls[] = [
                    'loc' => route('area.city', ['city' => $citySlug]),
                    'lastmod' => $cityLastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.9',
                ];

                foreach ($city['districts'] as $district) {
                    $key1 = Str::lower($city['name']) . '|' . Str::lower($district);
                    $key2 = Str::lower(str_replace('-', ' ', $citySlug)) . '|' . Str::lower($district);
                    $area = $areaLookup[$key1] ?? $areaLookup[$key2] ?? null;

                    if ($area && ! $area->is_active) {
                        continue;
                    }

                    $districtSlug = Str::slug($district);
                    $districtLastmod = ($area?->updated_at ?? $area?->created_at)?->toAtomString() ?: $areaLastmod;
                    $urls[] = [
                        'loc' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                        'lastmod' => $districtLastmod,
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            }
        }

        // Published knowledge articles (Silo Structure)
        try {
            $articles = Article::where('is_published', true)
                ->with(['categoryRelation', 'subcategoryRelation'])
                ->get();
            foreach ($articles as $article) {
                $urls[] = [
                    'loc' => $article->silo_url,
                    'lastmod' => ($article->updated_at ?? $article->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap articles query error: ' . $e->getMessage());
        }

        // Educational Categories Silo Landing Pages
        try {
            $categories = \App\Models\ArticleCategory::orderBy('sort_order')->get();
            foreach ($categories as $cat) {
                $urls[] = [
                    'loc' => url("/edukasi/{$cat->slug}"),
                    'lastmod' => ($cat->updated_at ?? $cat->created_at)?->toAtomString() ?: $articleLastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap categories query error: ' . $e->getMessage());
        }

        // Case Studies (Studi Kasus)
        try {
            $caseStudies = Gallery::where('is_active', true)->whereNotNull('slug')->get(['slug', 'updated_at', 'created_at']);
            foreach ($caseStudies as $study) {
                $urls[] = [
                    'loc' => route('case-study.show', ['slug' => $study->slug]),
                    'lastmod' => ($study->updated_at ?? $study->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap case studies query error: ' . $e->getMessage());
        }

        // Partnerships (Kemitraan)
        try {
            $partnerships = Portfolio::where('is_active', true)->whereNotNull('slug')->get(['slug', 'updated_at', 'created_at']);
            foreach ($partnerships as $partner) {
                $urls[] = [
                    'loc' => route('partnership.show', ['slug' => $partner->slug]),
                    'lastmod' => ($partner->updated_at ?? $partner->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Sitemap partnerships query error: ' . $e->getMessage());
        }

        // Equipment Units (Peralatan)
        try {
            $equipments = Equipment::where('is_active', true)->whereNotNull('slug')->get(['slug', 'updated_at', 'created_at']);
            foreach ($equipments as $equip) {
                $urls[] = [
                    'loc' => route('equipment.show', ['slug' => $equip->slug]),
                    'lastmod' => ($equip->updated_at ?? $equip->created_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable) {}

        return $this->formatSitemapXml($urls);
    }

    /**
     * Fallback zero-DB sitemap generation ensuring 200 OK under all circumstances.
     */
    public function generateFallbackSitemapXml(): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $isSecure = str_starts_with($baseUrl, 'https://') || (app()->bound('request') && request()?->isSecure());
        if ($isSecure) {
            URL::forceScheme('https');
        }
        if (! empty($baseUrl)) {
            URL::forceRootUrl($baseUrl);
        }

        $urls = [];
        $fallbackLastmod = now()->startOfDay()->toAtomString();

        // Core static pages
        $urls[] = ['loc' => url('/'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => route('contact'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.9'];
        $urls[] = ['loc' => url('/area'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.9'];
        $urls[] = ['loc' => url('/pengetahuan'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'daily', 'priority' => '0.8'];
        $urls[] = ['loc' => url('/galeri'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('how-it-works'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.profile'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.holding'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.k3'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.equipment'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.portfolio'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.warranty'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('about.faq'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'weekly', 'priority' => '0.8'];
        $urls[] = ['loc' => route('legal.privacy'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'monthly', 'priority' => '0.5'];
        $urls[] = ['loc' => route('legal.terms'), 'lastmod' => $fallbackLastmod, 'changefreq' => 'monthly', 'priority' => '0.5'];

        $provinces = RegionService::all();
        foreach ($provinces as $provSlug => $prov) {
            $urls[] = [
                'loc' => route('area.province', ['province' => $provSlug]),
                'lastmod' => $fallbackLastmod,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];

            foreach ($prov['cities'] as $citySlug => $city) {
                $urls[] = [
                    'loc' => route('area.city', ['city' => $citySlug]),
                    'lastmod' => $fallbackLastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.9',
                ];

                foreach ($city['districts'] as $district) {
                    $districtSlug = Str::slug($district);
                    $urls[] = [
                        'loc' => route('area.detail', ['city' => $citySlug, 'district' => $districtSlug]),
                        'lastmod' => $fallbackLastmod,
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            }
        }

        return $this->formatSitemapXml($urls);
    }

    /**
     * Format URL array to valid XML sitemap string.
     */
    private function formatSitemapXml(array $urls): string
    {
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
     * Plain-text dynamic robots.txt for search engines & AI crawlers (GEO).
     */
    public function robots(): Response
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        if (empty($baseUrl) || str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1')) {
            $baseUrl = request()->getSchemeAndHttpHost();
        }

        $sitemapUrl = "{$baseUrl}/sitemap.xml";
        $aiCatalogUrl = "{$baseUrl}/.well-known/ai-catalog.json";

        $lines = [
            'User-agent: *',
            'Disallow: /admin/',
            'Disallow: /api/',
            'Disallow: /login',
            'Disallow: /preview-*',
            'Allow: /llms.txt',
            'Allow: /.well-known/ai-catalog.json',
            '',
            '# Generative Engine Optimization (GEO) & AI Crawlers',
            'User-agent: Google-Extended',
            'Allow: /',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            '',
            'User-agent: ChatGPT-User',
            'Allow: /',
            '',
            'User-agent: Claude-Bot',
            'Allow: /',
            '',
            'User-agent: PerplexityBot',
            'Allow: /',
            '',
            '# Dynamic Discovery Sitemaps & AI Catalogs',
            "Sitemap: {$sitemapUrl}",
            "# AI-Catalog: {$aiCatalogUrl}",
            '',
        ];

        $content = implode("\n", $lines);

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}

