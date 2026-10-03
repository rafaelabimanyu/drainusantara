@extends('layouts.app')

@section('content')
<x-about.subnav 
    active-title="Ketentuan Garansi"
    eyebrow="Perlindungan Konsumen"
    heading="Ketentuan Resmi Garansi 30 Hari"
    subheading="Drainusantara memberikan kepastian hasil dengan uji alir debit air di depan pelanggan, invoice & sertifikat garansi digital resmi berstempel, serta kunjungan ulang tanpa biaya jika terjadi kendala pada titik yang sama selama masa garansi."
/>

<section id="garansi" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Jaminan Kualitas
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                4 Pilar Jaminan Garansi Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Sebagai penyedia jasa profesional, Drainusantara memberikan kepastian hasil pengerjaan yang terukur melalui 4 pilar utama jaminan garansi berikut:
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
            <!-- Left: 4 Ketentuan Garansi Pokok (Mobile Carousel, Desktop Stack) -->
            <div class="lg:col-span-7"
                 x-data="{
                     active: 0,
                     total: 4,
                     timer: null,
                     init() {
                         if (typeof window === 'undefined') return;
                         if (window.innerWidth < 1024) this.startAuto();
                     },
                     startAuto() {
                         if (window.innerWidth >= 1024) return;
                         this.pause();
                         this.timer = setInterval(() => { this.next(); }, 4000);
                     },
                     pause() {
                         if (this.timer) { clearInterval(this.timer); this.timer = null; }
                     },
                     resume() {
                         if (window.innerWidth >= 1024) return;
                         this.startAuto();
                     },
                     next() {
                         this.goTo((this.active + 1) % this.total);
                     },
                     goTo(idx) {
                         this.active = idx;
                         const slider = this.$refs.pilarSlider;
                         if (slider && slider.children[idx]) {
                             slider.scrollTo({ left: slider.children[idx].offsetLeft - slider.offsetLeft, behavior: 'smooth' });
                         }
                     },
                     onScroll() {
                         const slider = this.$refs.pilarSlider;
                         if (!slider || !slider.firstElementChild) return;
                         const cardWidth = slider.firstElementChild.offsetWidth + 16;
                         this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                     }
                 }">
                <div x-ref="pilarSlider"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @mouseenter="pause()"
                     @mouseleave="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 lg:flex-col lg:space-y-4 lg:gap-0 lg:overflow-visible lg:pb-0">
                    <div class="w-[85vw] sm:w-[340px] lg:w-full shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-1">
                        <span class="text-xs font-bold text-sky-700 block mb-1">100% No Result No Pay</span>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                           Jika saluran air tidak lancar sempurna sesuai standar uji alir debit air di depan Anda, Anda bebas biaya pengerjaan sama sekali.
                        </p>
                    </div>
                    <div class="w-[85vw] sm:w-[340px] lg:w-full shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-2">
                        <span class="text-xs font-bold text-sky-700 block mb-1">Masa Proteksi 30 Hari</span>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                          Jaminan pelancaran ulang gratis tanpa biaya tambahan jika saluran yang sama kembali mampet dalam masa garansi resmi 30 hari.
                        </p>
                    </div>
                    <div class="w-[85vw] sm:w-[340px] lg:w-full shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-3">
                        <span class="text-xs font-bold text-sky-700 block mb-1">Invoice & Stempel Resmi</span>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                           Setiap pengerjaan dilengkapi Digital Invoice resmi berstempel Drainusantara yang tersimpan aman di database sistem kami.
                        </p>
                    </div>
                    <div class="w-[85vw] sm:w-[340px] lg:w-full shrink-0 snap-center bg-white p-6 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-4">
                        <span class="text-xs font-bold text-sky-700 block mb-1">Respon Klaim &lt; 24 Jam</span>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Prosedur klaim mudah tanpa birokrasi rumit. Tim teknisi dispatch segera dijadwalkan ulang dalam kurun waktu kurang dari 24 jam.
                        </p>
                    </div>
                </div>

                <!-- Dots indicator for 4 pilar on mobile/tablet -->
                <div class="flex lg:hidden justify-center items-center gap-1.5 mt-3">
                    <template x-for="i in total" :key="i">
                        <button type="button" 
                                @click="goTo(i - 1)"
                                class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                                :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                :aria-label="'Pilar ' + i">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Right: 3 Langkah Klaim Garansi -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs card-lift reveal-soft delay-150">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-4">
                    Alur Klaim 3 Langkah Cepat
                </span>

                <div class="space-y-6 text-xs sm:text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            1
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Kirim Foto / Invoice via WA</span>
                            <p class="text-slate-600 text-xs mt-0.5">Hubungi Customer Care WhatsApp kami dan sebutkan nomor WA terdaftar saat pemesanan awal.
</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            2
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Verifikasi Data Sistem</span>
                            <p class="text-slate-600 text-xs mt-0.5">Tim dispatch Drainusantara memverifikasi tanggal pengerjaan &amp; histori digital invoice Anda secara instan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            3
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Teknisi Datang ke Lokasi</span>
                            <p class="text-slate-600 text-xs mt-0.5">Teknisi senior segera diluncurkan ke alamat Anda untuk melakukan pelancaran ulang tanpa biaya.
</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6281234567890' }}?text={{ urlencode('Halo Admin Drainusantara, saya ingin konsultasi garansi pengerjaan saluran.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                        <span>Hubungi Layanan Garansi</span>
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="syarat-ketentuan-garansi" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Pedoman Transparansi Layanan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Syarat &amp; Ketentuan Klaim Garansi
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Parameter perlindungan purna jual 30 hari kalender. Kami membedakan secara tegas kondisi yang ditanggung, batas pengecualian teknis, dan verifikasi administratif.
            </p>
        </div>

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
                     if (this.timer) { clearInterval(this.timer); this.timer = null; }
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
                     const slider = this.$refs.syaratSlider;
                     if (slider && slider.children[idx]) {
                         slider.scrollTo({ left: slider.children[idx].offsetLeft - slider.offsetLeft, behavior: 'smooth' });
                     }
                 },
                 onScroll() {
                     const slider = this.$refs.syaratSlider;
                     if (!slider || !slider.firstElementChild) return;
                     const cardWidth = slider.firstElementChild.offsetWidth + 20;
                     this.active = Math.min(this.total - 1, Math.max(0, Math.round(slider.scrollLeft / cardWidth)));
                 }
             }">
            <div x-ref="syaratSlider"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-3 md:gap-6 lg:gap-8 md:overflow-visible md:pb-0">
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-lg border border-slate-200 p-6 sm:p-7 flex flex-col justify-between card-lift reveal-soft stagger-1">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">
                            Cakupan Garansi
                        </h3>
                        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
                            Kendala teknis yang timbul kembali pada titik pengerjaan semula selama masa proteksi aktif.
                        </p>

                        <dl class="space-y-4 text-xs sm:text-sm">
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Area Jangkauan Pengerjaan</dt>
                                <dd class="text-slate-600 leading-relaxed">Berlaku khusus untuk titik lokasi pipa dan jalur pembuangan yang telah dikerjakan teknisi.</dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Residu Endapan Lama</dt>
                                <dd class="text-slate-600 leading-relaxed">Mencakup sumbatan ulang akibat gumpalan lemak sisa pengerjaan atau sedimen yang mengendap kembali dalam 30 hari.
    </dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Bebas Biaya Total</dt>
                                <dd class="text-slate-600 leading-relaxed">Bebas biaya kunjungan ulang teknisi (tanpa biaya kurir/transpor).
    </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-lg border border-slate-200 p-6 sm:p-7 flex flex-col justify-between card-lift reveal-soft stagger-2">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">
                            Prosedur Klaim Cepat
                        </h3>
                        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
                            Tata cara pengajuan kunjungan teknisi ulang jika saluran kembali bermasalah dalam masa garansi.
                        </p>

                        <dl class="space-y-4 text-xs sm:text-sm">
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">1. Hubungi WhatsApp Resmi</dt>
                                <dd class="text-slate-600 leading-relaxed">Sampaikan kendala ke Customer Service WhatsApp resmi Drainusantara dengan melampirkan foto/video dan nomor nota invoice pengerjaan awal.</dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">2. Verifikasi Data Pelanggan</dt>
                                <dd class="text-slate-600 leading-relaxed">Tim dispatch Drainusantara memverifikasi riwayat tanggal pengerjaan dan titik saluran yang dijamin garansi.</dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">3. Jadwal Kunjungan Ulang</dt>
                                <dd class="text-slate-600 leading-relaxed">Tim teknisi segera dijadwalkan ulang untuk kunjungan maksimal 1x24 jam tanpa biaya jasa maupun transportasi.</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-lg border border-slate-200 p-6 sm:p-7 flex flex-col justify-between card-lift reveal-soft stagger-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">
                            Pengecualian / Batasan Klaim
                        </h3>
                        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
                            Batasan perlindungan layanan purna jual yang mengacu pada faktor penyebab baru serta kondisi kerusakan instalasi eksternal.
                        </p>

                        <dl class="space-y-4 text-xs sm:text-sm">
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Kerusakan Pipa Akibat Usia</dt>
                                <dd class="text-slate-600 leading-relaxed">Kerusakan fisik pipa PVC tua yang pecah/ambles akibat usia struktur bangunan lama.</dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Penyumbatan Benda Asing</dt>
                                <dd class="text-slate-600 leading-relaxed">Sumbatan baru yang disengaja dimasukkan pasca pengerjaan (seperti sisa puing semen, kain, atau mainan anak).</dd>
                            </div>
                            <div class="border-t border-slate-200/80 pt-3">
                                <dt class="font-bold text-slate-900 mb-0.5">Jalur Pipa Baru</dt>
                                <dd class="text-slate-600 leading-relaxed">Jalur pipa baru yang tidak termasuk dalam kesepakatan SPK/Invoice pengerjaan awal.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Dots indicator for 3 cards on mobile -->
            <div class="flex md:hidden justify-center items-center gap-1.5 mt-5">
                <template x-for="i in total" :key="i">
                    <button type="button" 
                            @click="goTo(i - 1)"
                            class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75"
                            :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                            :aria-label="'Syarat ' + i">
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>
@endsection
