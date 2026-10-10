@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $b2bWaText = urlencode("Halo Tim Administrasi Drainusantara (J&J Group), kami ingin berkonsultasi mengenai pengadaan jasa sanitasi pipa komersial dan kelengkapan administrasi faktur pajak / SPK.");
    $b2bWaUrl = "https://wa.me/{$whatsappNumber}?text={$b2bWaText}";
@endphp

<x-about.subnav 
    active-title="Struktur Holding"
    eyebrow="Tata Kelola & Ekosistem Korporat"
    heading="Sinergi Ekosistem J&J Group"
    subheading="Drainusantara beroperasi sebagai unit spesialis pelancaran pipa mekanis terpadu di bawah naungan ekosistem J&J Group, memadukan keandalan teknis lapangan dengan tata kelola administrasi korporat yang akuntabel."
    :bg-image="asset('assets/banner/hero-JnJ-drainusantara.webp')"
/>

<section id="holding" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                SINERGI EKOSISTEM BISNIS
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Sinergi Infrastruktur Industri &amp; Layanan Presisi Tanpa Bongkar
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Sebagai bagian terintegrasi dari J&amp;J Group, Drainusantara memadukan disiplin manajemen korporat yang akuntabel dengan keahlian rekayasa sanitasi modern. Kami hadir untuk menuntaskan permasalahan saluran pipa tersumbat secara mekanis tanpa membongkar keramik lantai maupun struktur beton hunian.
            </p>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Dukungan manajemen pusat dari J&amp;J Group memungkinkan Drainusantara menyediakan armada teknisi siaga yang terstandarisasi APD K3 lengkap, legalitas administrasi e-Faktur PPN resmi, serta perlindungan garansi pengerjaan 30 hari kalender.
            </p>
        </div>

        <!-- 4 Pilar Sinergi Holding (Carousel on Mobile, Grid on Tablet/Desktop) -->
        <div x-data="mobileCarousel(4, 4000)">
            <div x-ref="slider" tabindex="0" role="region" aria-label="Pilar holding — geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6 sm:overflow-visible sm:pb-0">
                
                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-1">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                            01
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Transparansi Harga Total</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Skema tuntas baru bayar. Tidak ada hidden fees atau biaya siluman. Estimasi biaya diberikan transparan di awal sebelum teknisi memulai pengerjaan di lokasi.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-2">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                            02
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Teknologi Tanpa Bongkar</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Menggunakan mesin spiral rotary heavy-duty dengan kepala kabel lentur. Menjangkau sumbatan hingga kedalaman 30 meter tanpa merusak instalasi pipa PVC, keramik, atau beton.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-3">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                            03
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Standardisasi K3 &amp; Higienis</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Teknisi dilengkapi APD keselamatan kerja standar K3 dan cover sepatu khusus saat masuk bangunan. 100% bebas penggunaan bahan kimia korosif yang merusak pipa PVC.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                            04
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Jangkauan Luas &amp; Cepat</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pos armada teknisi siaga terkoordinasi melayani seluruh wilayah DKI Jakarta, Bodetabek, Kota Semarang, dan Kota Bandar Lampung dengan respon cepat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mobile Carousel Indicators -->
            <div class="flex items-center justify-center gap-2 mt-4 sm:hidden">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'Pilar ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span></button>
                </template>
            </div>
        </div>
    </div>
</section>

<section id="administrasi" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                AKUNTABILITAS &amp; KEPATUHAN BISNIS
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Formalitas Kelengkapan Administrasi &amp; Kemitraan Korporat
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Kami memenuhi standar tata kelola pengadaan (procurement) untuk sektor perkantoran, pusat perbelanjaan, kawasan industri, hotel bintang, dan jaringan restoran F&amp;B. Seluruh transaksi didukung dokumen legalitas sah dan kepatuhan perpajakan yang tertib.
            </p>
        </div>

        <!-- 3 Kartu Kelengkapan Dokumen Legalitas & Pajak (Mobile Carousel, Tablet/Desktop Grid) -->
        <div x-data="mobileCarousel(3, 4000)"
             class="mb-12">
            <div x-ref="slider" tabindex="0" role="region" aria-label="Dokumen legalitas — geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-3 md:gap-6 md:overflow-visible md:pb-0">
                
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft stagger-1 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">NIB (Nomor Induk Berusaha)</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Identitas legalitas usaha resmi yang terdaftar pada sistem Online Single Submission (OSS) Kementerian Investasi/BKPM. Memiliki izin operasional dan klasifikasi bidang usaha (KBLI) yang sesuai untuk pekerjaan sanitasi dan instalasi perpipaan.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft stagger-2 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">NPWP &amp; SPPKP Perusahaan</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Badan usaha terdaftar aktif pada Direktorat Jenderal Pajak dengan Nomor Pokok Wajib Pajak (NPWP) valid dan Surat Pengukuhan Pengusaha Kena Pajak (SPPKP). Memenuhi standar verifikasi rekanan vendor untuk instansi pemerintah maupun swasta.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft stagger-3 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Faktur Pajak PPN 11%</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Setiap transaksi pengadaan jasa sanitasi komersial dan korporat disertai penerbitan e-Faktur resmi dari Ditjen Pajak. Dokumen langsung terbit dan dapat dikreditkan sebagai pajak masukan dalam pelaporan keuangan perusahaan Anda.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Mobile Carousel Indicators -->
            <div class="flex items-center justify-center gap-2 mt-4 md:hidden">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'Dokumen ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span></button>
                </template>
            </div>
        </div>

        <div class="mt-12 bg-slate-900 text-white p-6 sm:p-8 rounded-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6 reveal-soft">
            <div class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-1">
                    Pengadaan Resmi &amp; Kemitraan Korporat
                </span>
                <h3 class="text-xl font-bold text-white tracking-tight">
                    Butuh Penawaran Jasa Sanitasi Pipa &amp; Dokumen Perpajakan Lengkap?
                </h3>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 leading-relaxed">
                    Tim administrasi kami siap menerbitkan Surat Penawaran Resmi, SPK, dan e-Faktur PPN 11% untuk kebutuhan audit pengadaan instansi dan perusahaan Anda.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ $b2bWaUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors min-h-[44px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi Pengadaan via WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
