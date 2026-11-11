<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\Pages\SitemapController();
$xml = $controller->generateSitemapXml();

preg_match_all('/<loc>(.*?)<\/loc>/', $xml, $matches);
$urls = $matches[1] ?? [];
echo "Total URLs in Sitemap XML: " . count($urls) . PHP_EOL;

// Check categories of URLs
$types = [];
foreach ($urls as $url) {
    if (str_contains($url, '/area/')) {
        $parts = explode('/area/', $url);
        $subparts = explode('/', $parts[1] ?? '');
        if (count($subparts) === 1) {
            $types['city_or_province'] = ($types['city_or_province'] ?? 0) + 1;
        } else {
            $types['district_detail'] = ($types['district_detail'] ?? 0) + 1;
        }
    } elseif (str_contains($url, '/layanan/')) {
        $types['service'] = ($types['service'] ?? 0) + 1;
    } elseif (str_contains($url, '/artikel/')) {
        $types['article'] = ($types['article'] ?? 0) + 1;
    } elseif (str_contains($url, '/studi-kasus/')) {
        $types['gallery'] = ($types['gallery'] ?? 0) + 1;
    } else {
        $types['static_pages'] = ($types['static_pages'] ?? 0) + 1;
    }
}
print_r($types);
