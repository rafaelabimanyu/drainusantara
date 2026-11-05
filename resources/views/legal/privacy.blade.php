@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8 sm:py-12 lg:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300" aria-hidden="true">/</span>
            <span class="text-slate-800 font-semibold truncate">Kebijakan Privasi</span>
        </nav>

        <!-- Header Card -->
        <header class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 mb-8 shadow-xs">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-3">
                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>DOKUMEN HUKUM RESMI</span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kebijakan Privasi (Privacy Policy)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">
                Terakhir Diperbarui: {{ date('d F Y') }} &bull; PT JAWA JAYA ROOTER (Drainusantara)
            </p>
        </header>

        <!-- Main Body Content -->
        <main class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-8 text-slate-700 text-sm sm:text-base leading-relaxed">
            
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">1</span>
                    <span>Pendahuluan &amp; Komitmen Kami</span>
                </h2>
                <p>
                    PT JAWA JAYA ROOTER selaku pengelola resmi situs web <strong>Drainusantara</strong> (www.drainusantara.id) berkomitmen penuh melindungi hak privasi setiap pengunjung, pelanggan residensial, dan mitra korporat B2B. Dokumen Kebijakan Privasi ini menjelaskan bagaimana data dan informasi pribadi Anda dikumpulkan, digunakan, dilindungi, dan tidak pernah diperjualbelikan kepada pihak ketiga manapun.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">2</span>
                    <span>Informasi yang Kami Kumpulkan</span>
                </h2>
                <p>
                    Kami hanya mengumpulkan informasi yang secara sukarela Anda berikan untuk keperluan pemesanan, penjadwalan armada teknisi, konsultasi masalah pipa saluran, atau penerbitan Berita Acara &amp; Faktur:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-slate-600">
                    <li><strong>Data Kontak:</strong> Nama lengkap, nomor telepon / WhatsApp aktif, dan alamat surel (email).</li>
                    <li><strong>Data Lokasi Layanan:</strong> Alamat lengkap pengerjaan (nama jalan, perumahan, kelurahan, kecamatan, kota) serta patokan lokasi untuk memudahkan kedatangan armada teknisi.</li>
                    <li><strong>Informasi Masalah Teknis:</strong> Foto, video, atau deskripsi singkat mengenai kendala saluran pembuangan (misal wastafel dapur berlemak, kloset mampet, bak kontrol meluap).</li>
                    <li><strong>Data Pembayaran &amp; BAST:</strong> Detail konfirmasi transaksi setelah pekerjaan selesai dinyatakan tuntas dan bergaransi resmi.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">3</span>
                    <span>Penggunaan Informasi</span>
                </h2>
                <p>Informasi yang terkumpul digunakan semata-mata untuk:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Mengatur estimasi waktu kedatangan armada teknisi terdekat ke alamat Anda.</li>
                    <li>Memberikan estimasi biaya transparan sebelum tindakan mekanis dilakukan.</li>
                    <li>Mencatat penerbitan kartu garansi 30 hari kalender agar validitas klaim perbaikan gratis terdata di sistem dispatch kami.</li>
                    <li>Menyediakan layanan administrasi B2B (Faktur Pajak, Berita Acara Pengerjaan resmi).</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">4</span>
                    <span>Analitik &amp; Cookie Situs</span>
                </h2>
                <p>
                    Website kami menggunakan layanan analitik web standar industri seperti Google Analytics untuk memantau performa lalu lintas situs, popularitas artikel edukasi pipa, dan mengoptimalkan kecepatan akses (*Core Web Vitals*). Cookie ini tidak menyimpan data identitas sensitif dan dapat dinonaktifkan melalui pengaturan peramban (*browser*) Anda setiap saat.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">5</span>
                    <span>Keamanan &amp; Perlindungan Data</span>
                </h2>
                <p>
                    Kami menerapkan standar enkripsi Secure Sockets Layer (HTTPS / SSL) di seluruh infrastruktur server Drainusantara. Data Anda disimpan di peladen dengan akses terbatas yang hanya dapat dibuka oleh staf dispatch dan teknisi operasional resmi bertugas.
                </p>
            </section>

            <section class="space-y-3 border-t border-slate-100 pt-6">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">6</span>
                    <span>Hubungi Petugas Privasi Kami</span>
                </h2>
                <p>
                    Apabila Anda memiliki pertanyaan, permintaan penghapusan data kontak, atau klarifikasi terkait kebijakan privasi ini, silakan hubungi tim kami:
                </p>
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs sm:text-sm space-y-1">
                    <p class="font-bold text-slate-900">PT JAWA JAYA ROOTER &bull; Drainusantara Support</p>
                    <p>Hotline &amp; Dispatch 24 Jam: <strong>0856-0900-9009</strong></p>
                    <p>Surel Resmi: <strong>[EMAIL_ADDRESS]</strong></p>
                </div>
            </section>

        </main>
    </div>
</div>
@endsection
