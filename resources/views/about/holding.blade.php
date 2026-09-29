@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $b2bWaText = urlencode("Halo Tim Administrasi Drainusantara (J&J Group), kami ingin berkonsultasi mengenai pengadaan jasa sanitasi pipa komersial dan kelengkapan administrasi faktur pajak / SPK.");
    $b2bWaUrl = "https://wa.me/{$whatsappNumber}?text={$b2bWaText}";
@endphp

@include('about.partials.nav', [
    'activeTitle' => 'Struktur Holding',
    'eyebrow' => 'Tata Kelola & Ekosistem Korporat',
    'heading' => 'Sinergi Ekosistem J&J Group',
    'subheading' => 'Drainusantara beroperasi sebagai unit spesialis pelancaran pipa mekanis terpadu di bawah naungan ekosistem J&J Group, memadukan keandalan teknis lapangan dengan tata kelola administrasi korporat yang akuntabel.'
])

<!-- ====================================================================
     SECTION 1: SINERGI HOLDING & 4 PILAR UTAMA
==================================================================== -->
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
        <div x-data="{
                 active: 0,
                 total: 4,
                 timer: null,
                 init() {
                     if (typeof window === 'undefined') return;
                     if (window.innerWidth < 640) this.startAuto();
                 },
                 startAuto() {
                     if (window.innerWidth >= 640) return;
                     this.pause();
                     this.timer = setInterval(() => { this.next(); }, 4000);
                 },
                 pause() {
                     if (this.timer) {
                         clearInterval(this.timer);
                         this.timer = null;
                     }
                 },
                 resume() {
                     if (window.innerWidth >= 640) return;
                     this.startAuto();
                 },
                 next() {
                     this.goTo((this.active + 1) % this.total);
                 },
                 goTo(idx) {
                     this.active = idx;
                     const slider = this.$refs.holdingPilarSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({
                             left: slider.children[idx].offsetLeft - slider.offsetLeft,
                             behavior: 'smooth'
                         });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.holdingPilarSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 20;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }">
            <div x-ref="holdingPilarSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6 sm:overflow-visible sm:pb-0">
                
                <!-- Pilar 01 -->
                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft delay-50">
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

                <!-- Pilar 02 -->
                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft delay-100">
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

                <!-- Pilar 03 -->
                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft delay-150">
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

                <!-- Pilar 04 -->
                <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between card-lift reveal-soft delay-200">
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
                    <button type="button"
                            @click="goTo(i - 1)"
                            class="h-2 rounded-full transition-all duration-300"
                            :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                            :aria-label="'Pilar ' + i">
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     SECTION 2: FORMALITAS KELENGKAPAN ADMINISTRASI KORPORAT (B2B)
==================================================================== -->
<section id="administrasi" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section Administrasi -->
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
        <div x-data="{
                 active: 0,
                 total: 3,
                 timer: null,
                 init() {
                     if (typeof window === 'undefined') return;
                     if (window.innerWidth < 768) this.startAuto();
                 },
                 startAuto() {
                     if (window.innerWidth >= 768) return;
                     this.pause();
                     this.timer = setInterval(() => { this.next(); }, 4000);
                 },
                 pause() {
                     if (this.timer) {
                         clearInterval(this.timer);
                         this.timer = null;
                     }
                 },
                 resume() {
                     if (window.innerWidth >= 768) return;
                     this.startAuto();
                 },
                 next() {
                     this.goTo((this.active + 1) % this.total);
                 },
                 goTo(idx) {
                     this.active = idx;
                     const slider = this.$refs.legalitasSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({
                             left: slider.children[idx].offsetLeft - slider.offsetLeft,
                             behavior: 'smooth'
                         });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.legalitasSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 20;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }"
             class="mb-12">
            <div x-ref="legalitasSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-3 md:gap-6 md:overflow-visible md:pb-0">
                
                <!-- Dokumen 01: NIB (Nomor Induk Berusaha) -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft delay-50 flex flex-col justify-between">
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

                <!-- Dokumen 02: NPWP & SPPKP Perusahaan -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft delay-100 flex flex-col justify-between">
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

                <!-- Dokumen 03: Faktur Pajak PPN 11% -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 hover:bg-white p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-xs transition-all card-lift reveal-soft delay-150 flex flex-col justify-between">
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
                    <button type="button"
                            @click="goTo(i - 1)"
                            class="h-2 rounded-full transition-all duration-300"
                            :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                            :aria-label="'Dokumen ' + i">
                    </button>
                </template>
            </div>
        </div>

        <!-- Banner Kontak Khusus Tim Pengadaan B2B -->
       

    </div>
</section>
@endsection
