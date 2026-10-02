@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $faqWaText = urlencode("Halo Admin Drainusantara, saya ingin bertanya lebih lanjut mengenai penanganan saluran pipa dan estimasi biaya.");
    $faqWaUrl = "https://wa.me/{$whatsappNumber}?text={$faqWaText}";
@endphp

<x-about.subnav 
    active-title="FAQ"
    eyebrow="Pusat Bantuan & Konsultasi"
    heading="Tanya Jawab Seputar Layanan & Prosedur Pengerjaan"
    subheading="Keterbukaan informasi seputar metode mekanis tanpa bongkar, armada mesin Ridgid & Hydro-Jetting, estimasi biaya transparan, legalitas, serta jaminan garansi 30 hari."
    :bg-image="asset('assets/banner/Drainusantara-jasa-saluran-mampet-profesional-desktop.webp')"
/>

<section id="faq-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ openFaq: 1, activeCategory: 'all' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Informasi Transparan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Jawaban Langsung dari Tim Teknis Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Kami menjunjung tinggi kejelasan metode, keamanan instalasi pipa properti, serta kepastian garansi sebelum teknisi diberangkatkan ke lokasi Anda.
            </p>
        </div>

        @php
            $faqs = [
                [
                    'id' => 1,
                    'category' => 'teknis',
                    'q' => 'Apakah benar proses pengerjaan 100% tanpa membongkar keramik lantai atau dinding?',
                    'a' => 'Benar 100%. Teknisi Drainusantara menggunakan unit mesin spiral rotary Ridgid Amerika dengan kabel baja lentur berkecepatan putar terukur serta nozel Hydro-Jetting bertekanan air. Akses pengerjaan langsung melalui lubang afur wastafel, floor drain, kloset, atau bak kontrol eksisting sehingga ubin keramik, marmer, dan struktur dinding Anda tetap utuh tanpa risiko retak atau pembongkaran.'
                ],
                [
                    'id' => 2,
                    'category' => 'teknis',
                    'q' => 'Mengapa pemakaian soda api sangat dilarang keras untuk pipa pembuangan PVC?',
                    'a' => 'Soda api (Natrium Hidroksida / NaOH) memicu reaksi eksotermik panas ekstrem hingga di atas 90°C saat bereaksi dengan air. Suhu ini langsung melunakkan pipa PVC dan merusak sambungan lem elbow. Selain itu, bila soda api gagal melarutkan gumpalan lemak beku, residu kimianya akan mengalami saponifikasi dan mengeras menjadi kerak kapur padat seperti batu semen di dasar saluran yang jauh lebih sulit ditembus.'
                ],
                [
                    'id' => 3,
                    'category' => 'teknis',
                    'q' => 'Berapa lama rata-rata durasi pengerjaan pelancaran saluran pipa?',
                    'a' => 'Untuk kasus sumbatan standar residensial (wastafel dapur, floor drain kamar mandi, leher angsa kloset), proses pelancaran mekanis biasanya tuntas dalam 30 hingga 45 menit. Untuk sumbatan lemak beku berat pada grease trap restoran komersial, instalasi pipa utama gedung, atau penarikan akar pohon di jalur pipa luar, durasi berkisar antara 1 hingga 2 jam.'
                ],
                [
                    'id' => 4,
                    'category' => 'biaya',
                    'q' => 'Bagaimana sistem penentuan biaya jasa dan apakah ada risiko biaya tersembunyi?',
                    'a' => 'Drainusantara menerapkan sistem harga transparan. Estimasi biaya jasa dihitung berdasarkan jenis titik saluran (wastafel, kamar mandi, talang, pipa utama) dan estimasi panjang jangkauan meteran pipa. Seluruh rincian biaya dikonfirmasi di awal sebelum teknisi mulai melakukan tindakan mekanis. Kami memegang teguh komitmen No Result No Pay: jika saluran tidak berhasil lancar sempurna, Anda tidak dikenakan biaya jasa pelancaran.'
                ],
                [
                    'id' => 5,
                    'category' => 'garansi',
                    'q' => 'Bagaimana prosedur dan ketentuan klaim garansi 30 hari resmi?',
                    'a' => 'Setiap pengerjaan dilengkapi digital invoice resmi berstempel. Klaim garansi sangat mudah: cukup hubungi WhatsApp Customer Service dengan menyebutkan nomor kontak saat pemesanan awal. Jika titik pipa yang sama mengalami sumbatan berulang dalam 30 hari kalender, tim teknisi segera dijadwalkan ulang untuk kunjungan revisi 100% gratis tanpa biaya jasa maupun transportasi.'
                ],
                [
                    'id' => 6,
                    'category' => 'layanan',
                    'q' => 'Apakah Drainusantara melayani pengerjaan malam hari (after-hours) untuk restoran, kafe, atau hotel?',
                    'a' => 'Ya, kami menyediakan layanan khusus shift malam (after-hours service) bagi mitra bisnis seperti restoran mall, food court, kafe, dan perhotelan. Pengerjaan pelancaran pipa lemak dapur (kitchen sink) dan grease trap dapat dijadwalkan setelah jam operasional tutup agar operasional bisnis dan kenyamanan pengunjung tidak terganggu.'
                ],
                [
                    'id' => 7,
                    'category' => 'administrasi',
                    'q' => 'Apakah Drainusantara dapat menerbitkan Faktur Pajak PPN 11% dan Surat Perintah Kerja (SPK)?',
                    'a' => 'Tentu. Sebagai unit usaha di bawah naungan PT Jayadi Mitra Group dengan legalitas NIB dan SPPKP lengkap, kami siap menerbitkan Surat Penawaran Resmi, SPK, Berita Acara Penyelesaian Pekerjaan (BAPP), serta e-Faktur Pajak PPN 11% untuk kebutuhan audit pengadaan properti korporat, pengelola gedung, maupun jaringan F&B komersial.'
                ],
                [
                    'id' => 8,
                    'category' => 'layanan',
                    'q' => 'Wilayah operasional mana saja yang dijangkau oleh armada siaga teknisi?',
                    'a' => 'Armada teknisi siaga Drainusantara melayani seluruh wilayah Jabodetabek (DKI Jakarta Pusat, Selatan, Barat, Timur, Utara, serta Bogor, Depok, Tangerang, Tangerang Selatan, dan Bekasi), serta posko operasional di Kota Semarang dan Bandar Lampung dengan radius dispatch cepat ke lokasi properti Anda.'
                ],
            ];
        @endphp

        <div class="flex items-center justify-center gap-2 flex-wrap mb-8 reveal-soft delay-100">
            <button type="button" 
                    @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Semua Tanya Jawab
            </button>
            <button type="button" 
                    @click="activeCategory = 'teknis'"
                    :class="activeCategory === 'teknis' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Metode &amp; Teknis Pipa
            </button>
            <button type="button" 
                    @click="activeCategory = 'biaya'"
                    :class="activeCategory === 'biaya' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Biaya &amp; Pembayaran
            </button>
            <button type="button" 
                    @click="activeCategory = 'garansi'"
                    :class="activeCategory === 'garansi' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Garansi 30 Hari
            </button>
            <button type="button" 
                    @click="activeCategory = 'administrasi'"
                    :class="activeCategory === 'administrasi' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Legalitas &amp; Faktur PPN
            </button>
        </div>

        <div class="space-y-3.5 mb-12">
            @foreach($faqs as $item)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $item['category'] }}'"
                     class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs transition-all card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                    <button type="button" 
                            @click="openFaq = (openFaq === {{ $item['id'] }} ? null : {{ $item['id'] }})"
                            class="w-full flex items-center justify-between p-4 sm:p-5 text-left text-xs sm:text-sm font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer min-h-[48px]">
                        <span class="pr-4 leading-snug">{{ $item['q'] }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" 
                             :class="{ 'rotate-180 text-sky-700': openFaq === {{ $item['id'] }} }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === {{ $item['id'] }}" x-collapse>
                        <div class="px-4 sm:px-5 pb-5 pt-1 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $item['a'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6 reveal-soft">
            <div class="text-center sm:text-left max-w-xl">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                    Layanan Konsultasi Bebas Biaya
                </span>
                <h3 class="text-lg font-bold text-slate-900">Pertanyaan Anda Belum Terjawab di Sini?</h3>
                <p class="text-slate-600 text-xs sm:text-sm mt-1 leading-relaxed">
                    Sampaikan kendala saluran mampet Anda kepada tim teknis Drainusantara. Kami berikan diagnosa awal dan estimasi pengerjaan via WhatsApp.
                </p>
            </div>
            <a href="{{ $faqWaUrl }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-xs transition-colors shrink-0 min-h-[44px]">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Tanya Teknisi via WhatsApp</span>
            </a>
        </div>

    </div>
</section>
@endsection
