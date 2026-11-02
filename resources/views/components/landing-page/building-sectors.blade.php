@props([
    'whatsappNumber' => config('app.whatsapp_number', '6285609009009'),
])

@php
    $sectors = [
        [
            'id' => 'residensial',
            'title' => 'Rumah Tinggal & Residensial',
            'badge' => 'Hunian Pribadi & Klaster',
            'color' => 'sky',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            'typical_issues' => 'Wastafel cuci piring berlemak, floor drain kamar mandi tersumbat rambut rontok, leher angsa kloset meluap.',
            'solution' => 'Spiral rotary fleksibel masuk dari lubang afur tanpa bongkar keramik lantai. Teknisi memakai cover sepatu dan terpal pelindung sanitasi.',
            'features' => ['Tanpa Bongkar Keramik', 'Protokol Higienis Masuk Rumah', 'Garansi Resmi 30 Hari'],
            'wa_text' => 'Halo Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet untuk Rumah Tinggal / Hunian Keluarga.',
        ],
        [
            'id' => 'fnb',
            'title' => 'Restoran, Kafe & F&B',
            'badge' => 'Bisnis Kuliner & Dapur',
            'color' => 'amber',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>',
            'typical_issues' => 'Kerak minyak dan lemak tebal menyumbat sink pencucian piring, grease trap meluap, serta bau got mengganggu kenyamanan pengunjung.',
            'solution' => 'Rotary cable cutter berkecepatan tinggi mengikis kerak lemak beku hingga tuntas. Tersedia opsi pengerjaan malam di luar jam operasional.',
            'features' => ['Pengerjaan Fleksibel di Luar Jam Buka', 'Spesialis Grease Trap & Lemak', 'Tersedia Invoice & Faktur Resmi'],
            'wa_text' => 'Halo Drainusantara, kami butuh penanganan pipa saluran cuci piring & grease trap untuk Restoran / Kafe F&B.',
        ],
        [
            'id' => 'apartemen',
            'title' => 'Apartemen & Kondominium',
            'badge' => 'Hunian Bertingkat',
            'color' => 'indigo',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
            'typical_issues' => 'Sumbatan pipa shaft vertikal antar unit, air buangan meluap balik (backflow) ke unit lantai bawah, risiko komplain tetangga.',
            'solution' => 'Penetrasi spiral presisi bebas getaran yang aman bagi sambungan pipa PVC riser gedung bertingkat, tanpa merusak ubin marmer atau granit.',
            'features' => ['Aman untuk Pipa Riser Vertikal', 'Bebas Getaran & Hentakan', 'Koordinasi Cepat dengan Pengelola (BM)'],
            'wa_text' => 'Halo Drainusantara, saya membutuhkan penanganan pipa saluran air mampet di unit Apartemen / Kondominium.',
        ],
        [
            'id' => 'ruko',
            'title' => 'Ruko Bisnis & Rukan',
            'badge' => 'Kawasan Komersial',
            'color' => 'blue',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>',
            'typical_issues' => 'Pipa pembuangan lantai 1 tersumbat endapan detergen, sisa makanan karyawan, atau bak kontrol ruko yang meluap ke area parkir.',
            'solution' => 'Spiral heavy-duty jangkauan hingga 30 meter menembus belokan pipa utama ruko langsung menuju bak kontrol umum tanpa membongkar lantai toko.',
            'features' => ['Jangkauan Spiral Panjang s/d 30 Meter', 'Tembus Belokan 90 Derajat', 'Operasional Toko Tetap Berjalan'],
            'wa_text' => 'Halo Drainusantara, kami butuh teknisi penanganan pipa mampet untuk Ruko / Rukan Komersial.',
        ],
        [
            'id' => 'perkantoran',
            'title' => 'Gedung Perkantoran & Hotel',
            'badge' => 'Hospitality & Korporat',
            'color' => 'emerald',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
            'typical_issues' => 'Toilet kubikel banyak unit mampet serentak, saluran kitchen hotel bermasalah, kebutuhan mitigasi darurat saat jam kerja.',
            'solution' => 'Dispatch armada siaga prioritas 30-45 menit dengan dokumentasi teknis berita acara, laporan foto sebelum-sesudah, dan inspeksi kamera CCTV.',
            'features' => ['Respon Cepat Prioritas SLA B2B', 'Inspeksi Kamera CCTV IP68', 'Kelengkapan Legalitas & Dokumen Pajak'],
            'wa_text' => 'Halo Drainusantara, kami ingin order / tender penanganan pipa saluran untuk Gedung Perkantoran / Hotel.',
        ],
        [
            'id' => 'industri',
            'title' => 'Area Pabrik & Industri',
            'badge' => 'Manufaktur & Pergudangan',
            'color' => 'slate',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
            'typical_issues' => 'Saluran sanitasi kantin buruh pabrik mampet, pipa pembuangan toilet massal tersumbat, sedimentasi lumpur bak penampungan.',
            'solution' => 'Unit mesin industrial torsi tinggi bertenaga motor induksi berat, mampu menghancurkan sumbatan masif dengan kepatuhan standar K3 ketat.',
            'features' => ['Mesin Industrial Heavy-Duty', 'SOP K3 & APD Lengkap', 'Kapasitas Penanganan Skala Besar'],
            'wa_text' => 'Halo Drainusantara, kami butuh layanan teknisi drainase untuk Kawasan Pabrik & Industri.',
        ],
    ];
@endphp

<section id="sektor-layanan" class="py-14 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-3xl mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                <span>Spesialisasi Lintas Bangunan</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Solusi Saluran Pipa untuk Beragam Kategori Bangunan
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2.5 leading-relaxed">
                Tiap jenis properti memiliki karakter instalasi pipa, tingkat kepadatan limbah, dan regulasi higienitas yang berbeda. Drainusantara menyesuaikan metode kerja, peralatan mesin, dan SOP K3 secara spesifik untuk hasil maksimal tanpa merusak struktur bangunan.
            </p>
        </div>

        <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mb-3 px-1" aria-hidden="true">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            <span>Geser untuk melihat sektor properti lainnya</span>
        </div>

        <!-- Grid 6 Sektor (Responsive Carousel on Mobile) -->
        <div class="flex md:grid md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-4 sm:gap-6 pb-3 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
            @foreach($sectors as $sec)
            <div class="w-[85vw] max-w-[340px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-xl border border-slate-200 shadow-2xs p-5 sm:p-6 flex flex-col justify-between card-lift transition-all hover:border-sky-400 hover:bg-white">
                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700">
                            {{ $sec['badge'] }}
                        </span>
                        <div class="w-9 h-9 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $sec['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    <!-- Judul Sektor -->
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight mb-2.5">
                        {{ $sec['title'] }}
                    </h3>

                    <!-- Masalah Tipikal -->
                    <div class="mb-3.5">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Masalah Umum:</p>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $sec['typical_issues'] }}
                        </p>
                    </div>

                    <!-- Solusi Kami -->
                    <div class="mb-4 bg-white rounded-lg border border-slate-200/80 p-3">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-800 mb-1">Pendekatan Drainusantara:</p>
                        <p class="text-xs text-slate-700 leading-relaxed">
                            {{ $sec['solution'] }}
                        </p>
                    </div>

                    <!-- Fitur Utama -->
                    <div class="space-y-1.5 mb-5">
                        @foreach($sec['features'] as $feat)
                        <div class="flex items-center gap-2 text-[11px] sm:text-xs text-slate-700">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $feat }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer CTA -->
                <div class="pt-3.5 border-t border-slate-200/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500 font-medium">No Cure No Pay</span>
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($sec['wa_text']) }}"
                       target="_blank"
                       rel="noopener"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-sky-700 hover:text-sky-800 bg-white hover:bg-sky-50 px-3 py-1.5 rounded-lg border border-slate-300 hover:border-sky-300 transition-colors btn-press">
                        <span>Konsultasi Sektor Ini</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

