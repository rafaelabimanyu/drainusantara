@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $profileWaText = urlencode("Halo Admin Drainusantara, saya ingin berkonsultasi mengenai profil layanan dan penjadwalan teknisi pelancar saluran mampet.");
    $profileWaUrl = "https://wa.me/{$whatsappNumber}?text={$profileWaText}";
@endphp

<x-about.subnav 
    active-title="Profil Perusahaan"
    eyebrow="Profil Entitas"
    heading="Profil Resmi Drainusantara"
    subheading="Drainusantara merupakan entitas bisnis resmi yang beroperasi secara sah di bawah naungan J&J Group, didukung oleh kelengkapan legalitas dan ketaatan pada regulasi yang berlaku."
    :bg-image="asset('assets/banner/hero-profil-perusahaan-drainusantara.webp')"
/>

<section id="profil" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <div class="lg:col-span-7 reveal-soft">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                    PROFIL RESMI DRAINUSANTARA
                </span>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Mitra Terpercaya Properti Residensial &amp; Sektor Komersial B2B
                </h2>
                
                <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                    <p>
                        Sejak awal beroperasi, Drainusantara menerapkan metode perbaikan pipa mekanis tanpa pembongkaran struktur. Sebagai bagian dari J&amp;J Group, seluruh operasional kami didukung legalitas usaha yang sah, siap melayani pengadaan B2B, penerbitan SPK serta Faktur PPN resmi, dan penyesuaian terhadap kualifikasi SLA gedung/fasilitas.
                    </p>
                    <p>
                        Kami hadir menyelesaikan keresahan pemilik properti terhadap metode konvensional yang berisiko merusak instalasi, mulai dari pembongkaran keramik lantai berbiaya mahal hingga penggunaan soda api yang memicu panas eksotermik pelunak pipa PVC. Mengandalkan unit mesin spiral rotary berstandar industri dan kamera endoskopi pipa CCTV IP68 jangkauan 30 meter, setiap penanganan diselesaikan secara presisi, higienis, dan terukur.
                    </p>
                </div>

                <!-- 3 Pilar Integritas Teknis (Mobile Carousel, Tablet/Desktop Grid) -->
                <div x-data="{
                         active: 0,
                         total: 3,
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
                             const slider = this.$refs.pilarSlider;
                             if (slider && slider.children[idx]) {
                                 slider.scrollTo({
                                     left: slider.children[idx].offsetLeft - slider.offsetLeft,
                                     behavior: 'smooth'
                                 });
                             }
                         },
                         onScroll() {
                             const slider = this.$refs.pilarSlider;
                             if (!slider || !slider.firstElementChild) return;
                             const cardWidth = slider.firstElementChild.offsetWidth + 16;
                             this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                         }
                     }" 
                     class="mt-8">
                    
                    <div x-ref="pilarSlider"
                         @scroll.passive="onScroll()"
                         @touchstart="pause()"
                         @touchend="resume()"
                         @mouseenter="pause()"
                         @mouseleave="resume()"
                         class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-3 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 sm:overflow-visible sm:pb-0">
                        
                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-1">
                            <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-sky-100">
                                01
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">100% Non-Destruktif</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pengerjaan langsung dari lubang pipa eksisting tanpa membongkar keramik lantai, marmer, atau dinding cor.
                            </p>
                        </div>

                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-emerald-100">
                                02
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">Bebas Bahan Kimia</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Aman untuk seluruh jenis pipa PVC kelas AW maupun D tanpa risiko pelunakan sambungan fitting atau kebocoran.
                            </p>
                        </div>

                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-amber-100">
                                03
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">Garansi 30 Hari</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dilindungi bukti nota garansi tertulis 30 hari kalender dengan komitmen No Cure No Pay yang nyata.
                            </p>
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

            <!-- Kolom Kanan: Fact Sheet Entitas Operasional -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs card-lift reveal-soft">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">
                        DATA ENTITAS BISNIS &amp; OPERASIONAL
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                
                <div class="space-y-3.5 text-xs sm:text-sm">
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Nama Brand</span>
                        <span class="font-bold text-slate-900">Drainusantara</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Induk Ekosistem</span>
                        <span class="font-bold text-sky-800">J&amp;J Group</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Legalitas &amp; Pajak</span>
                        <span class="font-bold text-slate-900 text-right">NIB OSS &bull; PKP e-Faktur PPN</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Spesialisasi</span>
                        <span class="font-bold text-slate-900 text-right">Pipa Mampet &amp; Inspeksi CCTV</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Cakupan Posko</span>
                        <span class="font-bold text-slate-900 text-right">Jabodetabek, Semarang, Lampung</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Waktu Operasional</span>
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">24 Jam Siaga Darurat</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Prinsip Layanan</span>
                        <span class="font-bold text-slate-900">No Cure No Pay</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 space-y-2.5">
                    <a href="{{ route('about.holding') }}" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors min-h-[44px] shadow-2xs">
                        <span>Pelajari Struktur Holding J&amp;J Group</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ $profileWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-colors min-h-[44px] shadow-2xs">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Teknis via WhatsApp</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<section id="standar-pelayanan" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                DISIPLIN KERJA &amp; HIGIENITAS
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                4 Standar Mutu Pelayanan Teknisi Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Setiap kunjungan teknisi ke hunian privat maupun area komersial B2B dijalankan dengan protokol sanitasi ketat untuk melindungi kebersihan dan kenyamanan ruangan Anda.
            </p>
        </div>

        <!-- 4 Standar Mutu Pelayanan (Mobile Carousel, Tablet/Desktop Grid) -->
        <div x-data="{
                 active: 0,
                 total: 4,
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
                     const slider = this.$refs.standarPelayananSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({
                             left: slider.children[idx].offsetLeft - slider.offsetLeft,
                             behavior: 'smooth'
                         });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.standarPelayananSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 24;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }">
            <div x-ref="standarPelayananSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-6 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 lg:grid-cols-4 md:overflow-visible md:pb-0">
                
                <!-- Standar 01 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-1 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Protokol APD &amp; Cover Sepatu</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Teknisi wajib mengenakan seragam resmi, sarung tangan steril, dan pelindung sepatu khusus saat melangkah ke dalam ruangan Anda guna mencegah jejak kotor.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Perlindungan Sanitasi Ruangan
                    </div>
                </div>

                <!-- Standar 02 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-2 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Peralatan Spiral Terkalibrasi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kabel spiral baja rotary dibersihkan dan disanitasi berkala pasca operasional, mencegah perpindahan kotoran atau kontaminasi silang antar lokasi kerja.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Higienitas Unit Mesin Terjaga
                    </div>
                </div>

                <!-- Standar 03 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-3 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Uji Alir Air Bersama</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Sebelum pekerjaan dinyatakan selesai, teknisi melakukan tes debit air deras bersama Anda untuk memastikan pipa benar-benar plong dan lancar sempurna.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Verifikasi Langsung di Tempat
                    </div>
                </div>

                <!-- Standar 04 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-4 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Nota Garansi 30 Hari</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Penerbitan nota resmi fisik atau digital dengan nomor registrasi yang tercatat di sistem pusat. Jika mampet kembali, teknisi datang tanpa biaya tambahan.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Jaminan Purna Jual Tertulis
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
                            :aria-label="'Standar ' + i">
                    </button>
                </template>
            </div>
        </div>

    </div>
</section>

<!-- Subsection: Staff Kami -->
<section id="staff-kami" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-10 reveal-soft">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                TIM &amp; TEKNISI KAMI
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Staff &amp; Teknisi Lapangan Siaga
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Tenaga kerja profesional dan berdedikasi tinggi yang siap melayani penanganan saluran pipa mampet Anda dengan respon cepat dan standar kerja higienis.
            </p>
        </div>

        @php
            if (!isset($staffMembers) || (is_countable($staffMembers) && count($staffMembers) === 0)) {
                $staffMembers = [
                    (object)[
                        'name' => 'Agus Santoso',
                        'role' => 'Teknisi Senior Rooter Spiral',
                        'initials' => 'AS',
                        'photo' => null,
                    ],
                    (object)[
                        'name' => 'Bambang Wijaya',
                        'role' => 'Spesialis Inspeksi CCTV Pipa',
                        'initials' => 'BW',
                        'photo' => null,
                    ],
                    (object)[
                        'name' => 'Rian Pratama',
                        'role' => 'Teknisi Pelancar Kloset & Floor Drain',
                        'initials' => 'RP',
                        'photo' => null,
                    ],
                    (object)[
                        'name' => 'Hendra Kusuma',
                        'role' => 'Teknisi Grease Trap & Restoran',
                        'initials' => 'HK',
                        'photo' => null,
                    ],
                    (object)[
                        'name' => 'Dedi Kurniawan',
                        'role' => 'Teknisi Saluran Talang & Pipa Atap',
                        'initials' => 'DK',
                        'photo' => null,
                    ],
                    (object)[
                        'name' => 'Fajar Nugraha',
                        'role' => 'Teknisi Hydro Jetting Komersial',
                        'initials' => 'FN',
                        'photo' => null,
                    ],
                ];
            }
        @endphp

        <!-- Staff Cards Grid & Mobile Carousel -->
        <div x-data="{
                 active: 0,
                 total: {{ count($staffMembers) }},
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
                     const slider = this.$refs.staffSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({
                             left: slider.children[idx].offsetLeft - slider.offsetLeft,
                             behavior: 'smooth'
                         });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.staffSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 16;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }">
            <div x-ref="staffSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 lg:grid-cols-6 sm:overflow-visible sm:pb-0">
                @foreach($staffMembers as $member)
                    @php
                        $mName = is_object($member) ? $member->name : ($member['name'] ?? '');
                        $mRole = is_object($member) ? ($member->role ?? 'Teknisi Lapangan Siaga') : ($member['role'] ?? 'Teknisi Lapangan Siaga');
                        $mPhoto = is_object($member) ? $member->photo : ($member['photo'] ?? null);
                        $mInitials = is_object($member) ? $member->initials : ($member['initials'] ?? 'ST');
                    @endphp
                    <div class="w-[58vw] sm:w-auto shrink-0 snap-center bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-2xs hover:shadow-md hover:border-sky-300 transition-all duration-300 flex flex-col items-center text-center group card-lift h-full reveal-soft stagger-{{ ($loop->iteration % 6) + 1 }}">
                        <!-- Foto / Avatar Staf -->
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 mb-3.5 relative flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            @if(!empty($mPhoto))
                                <img src="{{ $mPhoto }}" alt="{{ $mName }}" width="112" height="112" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-b from-sky-50 to-slate-100 text-sky-800">
                                    <svg class="w-12 h-12 text-sky-700/80 mb-0.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 font-mono">{{ $mInitials }}</span>
                                </div>
                            @endif
                            <span class="absolute bottom-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white" title="Siaga Aktif"></span>
                        </div>
                        
                        <!-- Nama Staf -->
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight group-hover:text-sky-700 transition-colors line-clamp-1">
                            {{ $mName }}
                        </h3>

                        <!-- Spesialisasi / Peran -->
                        <p class="text-[11px] font-medium text-slate-600 leading-snug mt-1 line-clamp-2">
                            {{ $mRole }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Mobile Carousel Dots Indicator -->
            <div class="flex items-center justify-center gap-1.5 mt-5 sm:hidden">
                @foreach($staffMembers as $idx => $m)
                    <button type="button" 
                            @click="goTo({{ $idx }})"
                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                            :class="active === {{ $idx }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                            aria-label="Staff {{ $idx + 1 }}">
                    </button>
                @endforeach
            </div>
        </div>

    </div>
</section>

<section id="ekosistem" class="py-14 lg:py-16 bg-slate-900 text-white relative overflow-hidden reveal-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-md uppercase tracking-wider mb-2">
                    SINERGI EKOSISTEM HOLDING
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Integritas Korporat di Bawah Naungan J&amp;J Group
                </h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-2 leading-relaxed">
                    Pelajari lebih dalam tata kelola administrasi legal, armada logistik, serta standar keselamatan kerja yang diterapkan pada seluruh jaringan operasional Drainusantara.
                </p>
            </div>
            
            <div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('about.holding') }}" 
                   class="min-h-[48px] inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-lg shadow-sm transition-all btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-500">
                    <span>Struktur Holding J&amp;J Group</span>
                    <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="{{ route('about.k3') }}" 
                   class="min-h-[48px] inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-700 transition-colors btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <span>Standar SOP K3</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
