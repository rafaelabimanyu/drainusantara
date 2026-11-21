<?php

use App\Http\Controllers\Pages\SitemapController;
use App\Services\SearchEnginePingService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

Artisan::command('deploy:check', function () {
    $number = config('app.whatsapp_number');
    if (!is_string($number) || !preg_match('/^628[0-9]{8,11}$/D', $number) || $number === '6281234567890') {
        $this->error('WHATSAPP_NUMBER tidak valid. Isi nomor WhatsApp asli dengan format 628xxxxxxxx.');
        return 1;
    }

    $this->info('Konfigurasi WhatsApp valid.');
    return 0;
})->purpose('Periksa konfigurasi sebelum deploy');

Artisan::command('sitemap:generate {--ping : Kirim sinyal ping SEO/IndexNow setelah cache sitemap diperbarui}', function (SitemapController $controller) {
    $this->info('Mengompilasi dan memperbarui cache sitemap.xml...');
    $start = microtime(true);

    $staticPath = public_path('sitemap.xml');
    if (is_file($staticPath) && @unlink($staticPath)) {
        $this->warn("File statis lama {$staticPath} dihapus agar rute dinamis /sitemap.xml tidak ter-bypass.");
    }

    $xml = $controller->generateSitemapXml();
    Cache::put('sitemap_xml', $xml, 86400);
    Cache::put('sitemap.xml', $xml, 86400);
    Cache::forget('sitemap.html_data');

    $time = round(microtime(true) - $start, 3);
    $this->info("Cache sitemap.xml berhasil diperbarui dalam {$time}s (" . strlen($xml) . ' bytes)');

    if ($this->option('ping')) {
        $ping = SearchEnginePingService::pingAll();
        $this->info($ping['message']);
    }

    return 0;
})->purpose('Warm dynamic sitemap.xml cache and remove stale static public/sitemap.xml');

Schedule::command('sitemap:generate --ping')
    ->dailyAt('02:00')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
