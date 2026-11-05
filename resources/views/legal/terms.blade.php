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
            <span class="text-slate-800 font-semibold truncate">Syarat &amp; Ketentuan</span>
        </nav>

        <!-- Header Card -->
        <header class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 mb-8 shadow-xs">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-3">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>STANDAR KONTRAK &amp; OPERASIONAL RESMI</span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Syarat &amp; Ketentuan Layanan (Terms of Service)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">
                Berlaku untuk seluruh penanganan teknis &bull; PT JAWA JAYA ROOTER (Drainusantara)
            </p>
        </header>

        <!-- Main Body Content -->
        <main class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-8 text-slate-700 text-sm sm:text-base leading-relaxed">
            
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">1</span>
                    <span>Ketentuan Umum &amp; Definisi Layanan</span>
                </h2>
                <p>
                    Syarat dan Ketentuan ini mengikat antara pelanggan (pemilik hunian, pengelola ruko, manajemen restoran/gedung) dengan <strong>PT JAWA JAYA ROOTER</strong> yang beroperasi dengan merek dagang <strong>Drainusantara</strong>. Dengan memesan layanan kedatangan teknisi melalui sambungan telepon, formulir situs web, atau obrolan resmi WhatsApp, Anda dianggap telah membaca, memahami, dan menyetujui seluruh butir ketentuan di bawah ini.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">2</span>
                    <span>Metode Pengerjaan Tanpa Bongkar</span>
                </h2>
                <p>
                    Drainusantara mengedepankan metode rekayasa pembersihan pipa non-destruktif:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-slate-600">
                    <li>Pengerjaan dilakukan langsung dari titik akses alami pipa (lubang saringan afur wastafel, floor drain, lubang kloset duduk/jongkok, atau bak kontrol).</li>
                    <li>Kami menggunakan mesin mekanis spiral rotary baja elastis dan/atau water jetting hydro pressure tanpa membongkar keramik lantai atau membobol dinding.</li>
                    <li>Teknisi dilarang keras menuangkan bahan kimia korosif seperti soda api murni (*sodium hydroxide*) atau asam pekat yang berpotensi merusak konstruksi pipa PVC.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">3</span>
                    <span>Transparansi Biaya &amp; Kebijakan No Cure No Pay</span>
                </h2>
                <p>
                    Kami menjamin keterbukaan biaya pengerjaan:
                </p>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Estimasi biaya awal diinformasikan di awal sebelum teknisi mulai melakukan penetrasi mesin.</li>
                    <li><strong>Kebijakan No Cure No Pay:</strong> Apabila saluran pipa tetap tidak berhasil dilancarkan sama sekali karena kendala struktur permanen (misal: pipa pecah tertimpa reruntuhan pondasi atau pipa tertutup semen cor padat yang mustahil ditembus alat mekanis), Anda tidak dikenakan biaya jasa pelancaran.</li>
                    <li>Pelanggan wajib melakukan uji coba alir air bersama (*flushing test*) di hadapan teknisi sebelum penandatanganan BAST dan pembayaran.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">4</span>
                    <span>Ketentuan Garansi 30 Hari Kalender</span>
                </h2>
                <p>
                    Setiap pengerjaan pelancaran pipa yang telah selesai dilindungi Garansi Tertulis 30 Hari Kalender resmi dari PT JAWA JAYA ROOTER:
                </p>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Klaim garansi berlaku jika titik pipa yang sama mengalami sumbatan kembali dalam masa garansi tanpa adanya benda asing baru yang sengaja dimasukkan (seperti kain lap, semen cor, atau sampah padat baru pasca pekerjaan).</li>
                    <li>Untuk mengajukan garansi, cukup kirimkan nomor nota / bukti order WhatsApp kepada admin dispatch kami. Armada terdekat akan dijadwalkan ulang tanpa biaya jasa tambahan.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">5</span>
                    <span>Keselamatan Kerja &amp; K3</span>
                </h2>
                <p>
                    Seluruh teknisi kami diwajibkan mematuhi SOP K3: mengenakan sarung tangan isolasi mekanis, sepatu pelindung tahan licin, dan sanitasi area kerja setelah operasional tuntas demi menjaga higienitas tempat tinggal atau area bisnis Anda.
                </p>
            </section>

            <section class="space-y-3 border-t border-slate-100 pt-6">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">6</span>
                    <span>Pusat Informasi &amp; Kontak Resmi</span>
                </h2>
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs sm:text-sm space-y-1">
                    <p class="font-bold text-slate-900">PT JAWA JAYA ROOTER &bull; Divisi Legal &amp; Kemitraan</p>
                    <p>Hotline 24 Jam: <strong>0856-0900-9009 / (021) 8560-9009</strong></p>
                    <p>Alamat Kantor: Sesuai posko dispatch regional yang tercantum pada nota layanan resmi.</p>
                </div>
            </section>

        </main>
    </div>
</div>
@endsection

