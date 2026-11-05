<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('deploy:check', function () {
    $number = config('app.whatsapp_number');
    if (!is_string($number) || !preg_match('/^628[0-9]{8,11}$/D', $number) || $number === '6281234567890') {
        $this->error('WHATSAPP_NUMBER tidak valid. Isi nomor WhatsApp asli dengan format 628xxxxxxxx.');
        return 1;
    }

    $this->info('Konfigurasi WhatsApp valid.');
    return 0;
})->purpose('Periksa konfigurasi sebelum deploy');

Artisan::command('sitemap:generate', function (\App\Http\Controllers\Pages\SitemapController $controller) {
    $this->info('Mengompilasi dan mengoptimasi sitemap.xml...');
    $start = microtime(true);
    $xml = $controller->generateSitemapXml();
    $path = public_path('sitemap.xml');
    file_put_contents($path, $xml);
    \Illuminate\Support\Facades\Cache::put('sitemap.xml', $xml, 86400);
    $time = round(microtime(true) - $start, 3);
    $this->info("sitemap.xml berhasil di-generate dalam {$time}s pada {$path} (" . strlen($xml) . " bytes)");
    return 0;
})->purpose('Pre-generate public sitemap.xml file and warm the cache');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
