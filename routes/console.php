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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
