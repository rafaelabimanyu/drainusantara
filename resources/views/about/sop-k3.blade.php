@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'SOP K3',
    'eyebrow' => 'Keselamatan & Kesehatan Kerja',
    'heading' => 'Standar SOP K3 & Higienitas Kerja Teknisi',
    'subheading' => 'Komitmen tanpa kompromi terhadap keselamatan kerja teknisi, kebersihan ruangan konsumen, dan perlindungan integritas instalasi pipa.'
])

<!-- Main SOP K3 Content -->
<section id="sop-k3" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Protokol Higienitas Lapangan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                4 Disiplin Utama Pelayanan Sanitasi Bersih
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pekerjaan perpipaan sering kali dipandang kotor dan berbau. Di Drainusantara, kami menerapkan protokol higienitas ketat agar area kerja rumah atau tempat usaha Anda tetap steril dan bersih pasca tindakan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12">
            <!-- SOP 1 -->
            <div class="bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-sm shrink-0">
                        01
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">Cover Sepatu Steril &amp; APD Rapi</h3>
                        <span class="text-xs text-emerald-700 font-semibold">Protokol Kebersihan Masuk Rumah</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Setiap teknisi wajib memakai cover sepatu disposable saat memasuki area dalam rumah atau dapur restoran. Dilengkapi sarung tangan nitril tebal anti-bakteri dan seragam resmi beridentitas jelas.
                </p>
            </div>

            <!-- SOP 2 -->
            <div class="bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center font-bold text-sm shrink-0">
                        02
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">Keamanan Kelistrikan GFCI / ELCB</h3>
                        <span class="text-xs text-amber-800 font-semibold">Perlindungan Bahaya Listrik Basah</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Mesin rooter bertenaga listrik dioperasikan menggunakan kabel grounding dan pemutus sirkuit arus bocor (GFCI/ELCB) guna mengeliminasi risiko korsleting atau sengatan listrik di lingkungan basah kamar mandi.
                </p>
            </div>

            <!-- SOP 3 -->
            <div class="bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center font-bold text-sm shrink-0">
                        03
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">Kontrol Torsi Presisi Anti-Pecah Pipa</h3>
                        <span class="text-xs text-sky-700 font-semibold">Perlindungan Pipa PVC &amp; Cor Dinding</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Teknisi kami dilatih mengatur putaran torsi spiral baja sesuai diameter pipa (1.5 inci hingga 6 inci) agar kabel mampu menghancurkan lemak padat tanpa memberi tekanan berlebih pada sambungan elbow pipa.
                </p>
            </div>

            <!-- SOP 4 -->
            <div class="bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center justify-center font-bold text-sm shrink-0">
                        04
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">Uji Alir Volume Penuh &amp; Sanitasi Area</h3>
                        <span class="text-xs text-indigo-700 font-semibold">Validasi Hasil Kerja Tuntas</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Sebelum serah terima pekerjaan, teknisi melakukan flushing uji alir air bertekanan penuh selama minimal 5 menit di hadapan konsumen, lalu membersihkan seluruh cipratan air dan kotoran hingga bersih seperti semula.
                </p>
            </div>
        </div>

        <!-- Next Page Callout -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Penasaran dengan Mesin &amp; Alat yang Digunakan?</h3>
                <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-2xl">
                    Lihat spesifikasi mesin spiral baja Ridgid, kamera inspeksi CCTV pipa resolusi tinggi, dan mata potong khusus.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('about.equipment') }}" class="btn-press inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                    <span>Lihat Peralatan &amp; Teknologi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
