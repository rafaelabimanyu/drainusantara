@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $generalWaText = urlencode("Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.");
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text={$generalWaText}";

    // 6 Problem Catalogs for Asymmetrical Bento Grid
    $problemCatalogs = [
        [
            'code' => 'DN-01',
            'title' => 'Wastafel & Bak Cuci Piring',
            'category' => 'Dapur & Residensial',
            'badge' => 'Paling Sering',
            'badge_color' => 'bg-amber-100 text-amber-900 border-amber-200',
            'tool_tag' => 'Mesin Rotary Rigid K-50',
            'cable_spec' => 'Spiral Lentur 16mm Sifon PVC',
            'problem_desc' => 'Air bak cuci piring meluap akibat tumpukan minyak beku, lemak sisa masakan, dan ampas makanan yang membatu di leher angsa.',
            'specs' => [
                'Mengikis kerak minyak & lemak 100% tuntas',
                'Aman untuk pipa leher angsa sifon PVC',
                'Pengerjaan 30–45 menit tanpa kotor',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'price_unit' => '/ titik',
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan untuk Wastafel & Bak Cuci Piring mampet. Mohon info jadwal teknisi terdekat.',
        ],
        [
            'code' => 'DN-02',
            'title' => 'Kloset & WC Meluap',
            'category' => 'Toilet & Porselen',
            'badge' => 'Darurat 24 Jam',
            'badge_color' => 'bg-red-100 text-red-900 border-red-200',
            'tool_tag' => 'Rooter Heavy Duty Rigid K-60',
            'cable_spec' => 'Spiral Torsi Meliuk Anti-Kinking',
            'problem_desc' => 'Kloset duduk atau jongkok meluap akibat sumbatan tisu basah, pembalut, atau benda keras di lekukan porselen.',
            'specs' => [
                '100% tanpa membongkar kloset porselen',
                'Daya putar meliuk aman di leher angsa',
                'Teknisi ber-APD bersih & sarung tangan',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'price_unit' => '/ titik',
            'wa_text' => 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon segera kirim teknisi.',
        ],
        [
            'code' => 'DN-03',
            'title' => 'Floor Drain Kamar Mandi',
            'category' => 'Kamar Mandi',
            'badge' => 'Higienis',
            'badge_color' => 'bg-blue-100 text-blue-900 border-blue-200',
            'tool_tag' => 'Rooter Fleksibel Karbon',
            'cable_spec' => 'Spiral Baja Tahan Lekukan',
            'problem_desc' => 'Air mandi menggenang dan memicu bau got akibat jalinan rambut rontok dan residu busa sabun padat.',
            'specs' => [
                'Melilit & menarik gumpalan rambut',
                'Menghilangkan bau got & melancarkan air',
                'Melayani pipa diameter 2 s/d 4 inch',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'price_unit' => '/ titik',
            'wa_text' => 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang dan berbau got. Mohon info teknisi terdekat.',
        ],
        [
            'code' => 'DN-04',
            'title' => 'Talang Rooftop & Pipa Atap',
            'category' => 'Rooftop & Eksterior',
            'badge' => 'Musim Hujan',
            'badge_color' => 'bg-emerald-100 text-emerald-900 border-emerald-200',
            'tool_tag' => 'Spiral Baja 22mm Jangkauan Panjang',
            'cable_spec' => 'Kabel Heavy Duty s/d 30 Meter',
            'problem_desc' => 'Pipa pembuangan talang atap meluap oleh endapan lumut tebal, pasir semen, dan dedaunan kering.',
            'specs' => [
                'Jangkauan kabel panjang menembus pipa vertikal',
                'Membersihkan endapan lumpur & dedaunan',
                'Mencegah rembesan air hujan ke plafon',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'price_unit' => '/ titik',
            'wa_text' => 'Halo Drainusantara, pipa talang rooftop kami tersumbat dedaunan dan meluap. Mohon info teknisi untuk penanganan.',
        ],
        [
            'code' => 'DN-05',
            'title' => 'Kuras Grease Trap & Lemak Resto',
            'category' => 'Komersial F&B',
            'badge' => 'B2B & Restoran',
            'badge_color' => 'bg-purple-100 text-purple-900 border-purple-200',
            'tool_tag' => 'Vakum Ekstraksi & Rotary Degreaser',
            'cable_spec' => 'Pembersih Dinding Pipa Minyak',
            'problem_desc' => 'Perangkap lemak (grease trap) dapur resto penuh kerak minyak padat berbau menyengat.',
            'specs' => [
                'Pembersihan lemak jenuh & minyak komersial',
                'Perawatan berkala bebas bau dapur resto',
                'Tersedia faktur pajak resmi B2B',
                'Garansi resmi 30 hari nota tertulis',
            ],
            'price' => 400000,
            'price_unit' => '/ unit',
            'wa_text' => 'Halo Drainusantara, kami ingin memesan pembersihan Grease Trap / Sedot Lemak untuk restoran/kafe kami. Mohon info penawaran.',
        ],
        [
            'code' => 'DN-06',
            'title' => 'Inspeksi Kamera CCTV Pipa 30M',
            'category' => 'Diagnostik Sonar',
            'badge' => 'Presisi IP68',
            'badge_color' => 'bg-indigo-100 text-indigo-900 border-indigo-200',
            'tool_tag' => 'Push-Camera IP68 HD 1080P',
            'cable_spec' => 'Kabel Fiber Optic 30 Meter',
            'problem_desc' => 'Investigasi visual kamera kedap air untuk melihat langsung posisi tepat pipa retak, pecah, atau akar.',
            'specs' => [
                'Kamera tahan air IP68 dengan LED 1080P HD',
                'Layar monitor realtime & rekaman video',
                'Menemukan titik masalah presisi tanpa tebak',
                'Disertai laporan hasil inspeksi teknis',
            ],
            'price' => 400000,
            'price_unit' => '/ sesi',
            'wa_text' => 'Halo Drainusantara, saya ingin menjadwalkan Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran. Mohon info ketersediaan unit.',
        ],
    ];
@endphp

    @include('partials.home.hero')
    @include('partials.home.flow')
    @include('partials.home.services')
    @include('partials.home.features')
    @include('partials.home.proof')
    @include('partials.home.safety-audit')
    @include('partials.home.coverage')
    @include('partials.home.reviews')
    @include('partials.home.faq')
    @include('partials.home.cta')
@endsection
