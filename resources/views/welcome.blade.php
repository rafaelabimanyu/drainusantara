@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $generalWaText = urlencode("Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.");
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text={$generalWaText}";

    $problemCatalogs = [
        [
            'code' => 'DN-01',
            'title' => 'Wastafel & Cuci Piring',
            'category' => 'Dapur & Residensial',
            'badge' => 'Paling Sering',
            'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
            'tool_tag' => 'Mesin Spiral Rotary K-50 Ridgid',
            'cable_spec' => 'Spiral Lentur 16mm Khusus Sifon PVC',
            'problem_desc' => 'Air bak cuci piring meluap atau lambat surut karena tumpukan minyak goreng beku, lemak sisa masakan, dan ampas makanan yang membatu di leher angsa.',
            'specs' => [
                'Mengikis kerak minyak & lemak hingga tuntas',
                'Aman untuk pipa leher angsa sifon PVC',
                'Pengerjaan rapi 30–45 menit tanpa kotor',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan untuk Wastafel & Bak Cuci Piring mampet. Mohon info estimasi biaya dan jadwal teknisi terdekat.',
        ],
        [
            'code' => 'DN-02',
            'title' => 'Kloset & WC Meluap',
            'category' => 'Toilet & Kamar Mandi',
            'badge' => 'Darurat 24 Jam',
            'badge_color' => 'bg-red-100 text-red-800 border-red-200',
            'tool_tag' => 'Rooter Heavy Duty Rigid K-60',
            'cable_spec' => 'Spiral Torsi Meliuk Anti-Kinking',
            'problem_desc' => 'Kloset duduk atau jongkok meluap saat disiram akibat sumbatan tisu basah, pembalut, kain, atau kerak kotoran yang tersangkut di lekukan porselen.',
            'specs' => [
                'Metode mekanis tanpa membongkar dudukan kloset porselen',
                'Daya putar meliuk aman di leher angsa keramik',
                'Teknisi ber-APD bersih, bersarung tangan & sepatu cover',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon info estimasi biaya dan kedatangan teknisi.',
        ],
        [
            'code' => 'DN-03',
            'title' => 'Floor Drain Kamar Mandi',
            'category' => 'Kamar Mandi & Saluran Lantai',
            'badge' => 'Solusi Higienis',
            'badge_color' => 'bg-sky-100 text-sky-800 border-sky-200',
            'tool_tag' => 'Rooter Fleksibel Spiral Karbon',
            'cable_spec' => 'Spiral Baja Anti-Karat & Tahan Lekukan',
            'problem_desc' => 'Air mandi menggenang di lantai dan memicu bau got tak sedap karena jalinan rambut rontok dan residu busa sabun yang menebal di jalur pipa pembuangan.',
            'specs' => [
                'Melilit & menarik gumpalan rambut dan kerak sabun',
                'Menghilangkan bau got & melancarkan aliran air',
                'Melayani pipa diameter 2 hingga 4 inch',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang. Mohon info estimasi biaya dan jadwal teknisi terdekat.',
        ],
        [
            'code' => 'DN-04',
            'title' => 'Talang Rooftop & Pipa Atap',
            'category' => 'Rooftop & Eksterior Gedung',
            'badge' => 'Musim Hujan',
            'badge_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'tool_tag' => 'Spiral Baja Jangkauan Panjang 22mm',
            'cable_spec' => 'Kabel Spiral Heavy Duty Hingga 30 Meter',
            'problem_desc' => 'Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir dak semen, dan dedaunan kering yang memicu kebocoran plafon rumah.',
            'specs' => [
                'Jangkauan kabel panjang menembus pipa vertikal',
                'Membersihkan endapan lumpur, lumut, & dedaunan',
                'Mencegah rembesan air hujan ke plafon hunian',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, pipa talang rooftop kami tersumbat dedaunan dan meluap. Mohon info estimasi biaya dan jadwal teknisi.',
        ],
        [
            'code' => 'DN-05',
            'title' => 'Kuras Grease Trap & Lemak',
            'category' => 'Komersial F&B & Restoran',
            'badge' => 'B2B & Restoran',
            'badge_color' => 'bg-purple-100 text-purple-800 border-purple-200',
            'tool_tag' => 'Ekstraksi Vakum & Rotary Degreaser',
            'cable_spec' => 'Pembersih Dinding Pipa Minyak Komersial',
            'problem_desc' => 'Bak perangkap lemak (grease trap) dapur resto, kafe, atau rumah penuh kerak minyak padat berbau menyengat dan mengancam kelancaran operasional.',
            'specs' => [
                'Pembersihan lemak jenuh & sisa minyak komersial',
                'Perawatan berkala bebas bau untuk dapur resto & kafe',
                'Tersedia faktur pajak resmi & dokumen B2B',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, kami ingin konsultasi pembersihan Grease Trap / Sedot Lemak untuk restoran/kafe kami. Mohon info penawaran dan rincian biaya.',
        ],
        [
            'code' => 'DN-06',
            'title' => 'Inspeksi CCTV Pipa 30M',
            'category' => 'Diagnostik & Investigasi',
            'badge' => 'Teknologi Presisi',
            'badge_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'tool_tag' => 'Endoscopic Push-Camera IP68 HD 1080P',
            'cable_spec' => 'Kabel Dorong Fiber Optic 30 Meter',
            'problem_desc' => 'Investigasi visual kamera kedap air untuk melihat langsung posisi tepat pipa retak, pecah, sambungan lepas, kemiringan kurang, atau intrusi akar di dalam tanah.',
            'specs' => [
                'Kamera tahan air IP68 dengan lampu LED 1080P HD',
                'Layar monitor realtime & dokumentasi rekaman video',
                'Menemukan titik masalah presisi tanpa tebak-tebak',
                'Disertai laporan hasil inspeksi teknis lengkap',
            ],
            'price' => 400000,
            'wa_text' => 'Halo Drainusantara, saya ingin konsultasi Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran yang sering mampet. Mohon info ketersediaan unit dan biayanya.',
        ],
    ];
@endphp

    <x-landing-page.hero :general-wa-url="$generalWaUrl" :whatsapp-number="$whatsappNumber" />
    <x-landing-page.how-it-works />
    <x-landing-page.services :services="$services ?? null" :problem-catalogs="$problemCatalogs" :whatsapp-number="$whatsappNumber" />
   
    <x-landing-page.advantages />
    <x-landing-page.documentation :galleries="$galleries ?? null" />
    <x-landing-page.portfolio-b2b :portfolios="$portfolios ?? null" :whatsapp-number="$whatsappNumber" />
    <x-landing-page.articles :articles="$articles ?? []" />
    <x-landing-page.coverage-areas :whatsapp-number="$whatsappNumber" />
    <x-landing-page.equipment />
    <x-landing-page.testimonials :reviews="$reviews ?? null" />
    <x-landing-page.faq />
    <x-landing-page.bottom-cta :general-wa-url="$generalWaUrl" />
@endsection
