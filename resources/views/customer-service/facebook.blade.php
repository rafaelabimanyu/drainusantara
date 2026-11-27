@extends('layouts.app')

@section('content')
<section class="bg-white border-b border-slate-200 py-7 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-ui.breadcrumb :items="[
            ['label' => 'Customer Service', 'url' => route('customer-service.index')],
            ['label' => 'Facebook'],
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-10 items-center">
            <div class="lg:col-span-7 space-y-4 sm:space-y-5">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-blue-50 border border-blue-200 text-blue-800 text-xs font-bold">
                    <x-customer-service.channel-icon channel="facebook" class="w-4 h-4" />
                    <span>Halaman Facebook Resmi {{ $channel['handle'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Layanan Pelanggan Facebook Drainusantara
                </h1>
                <p class="text-sm sm:text-lg text-slate-700 leading-relaxed">
                    Untuk pemilik rumah dan keluarga yang membutuhkan penanganan saluran mampet yang rapi, bersih, dan tanpa bongkar keramik. Anda bisa langsung menelepon operator kami atau memilih kota pada langkah mudah di bawah.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}"
                       data-track-location="cs_facebook_phone"
                       class="min-h-14 p-3.5 sm:p-4 rounded-lg bg-sky-700 hover:bg-sky-800 text-white transition-colors btn-press flex flex-col justify-center focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-offset-2">
                        <span class="text-xs font-semibold text-sky-100 block">Telepon Langsung Operator (24 Jam)</span>
                        <span class="text-xl font-extrabold mt-0.5">0856-0900-9009</span>
                    </a>

                    @if(!empty($socialUrl))
                        <a href="{{ $socialUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="min-h-14 p-3.5 sm:p-4 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-300 text-slate-900 transition-colors flex flex-col justify-center focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            <span class="text-xs font-bold text-blue-700 block">Halaman Resmi Facebook</span>
                            <span class="text-base font-extrabold mt-0.5">{{ $channel['handle'] }}</span>
                        </a>
                    @endif
                </div>

                <div class="p-3.5 sm:p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-700">
                    <span class="font-bold text-slate-900">Alamat Workshop Pusat:</span>
                    PT Jawa Jaya Rooter, Jl. Manunggal XVII No. 104, Lubang Buaya, Cipayung, Kota Jakarta Timur 13810.
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 space-y-3">
                    <div class="aspect-[16/11] rounded-md overflow-hidden bg-slate-900 border border-slate-200">
                        <img src="{{ asset('assets/banner/hero-k3-drainusantara.webp') }}"
                             alt="Teknisi Drainusantara menggunakan seragam kerja, sarung tangan, dan cover sepatu bersih saat masuk rumah"
                             width="800"
                             height="550"
                             loading="eager"
                             decoding="async"
                             class="w-full h-full object-cover">
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-slate-700 px-1">
                        Teknisi mengenakan seragam resmi dan pelindung sepatu agar lantai rumah tetap bersih selama pengerjaan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-7 sm:py-10 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-customer-service.wa-area-builder
            layout="ribbon"
            channel-code="fb"
            channel-slug="facebook"
            channel-name="Facebook"
            :whatsapp-number="$whatsappNumber"
            :region-selector-data="$regionSelectorData"
            heading="Pesan WhatsApp Mudah ke Admin Facebook"
            subheading="Ikuti 3 langkah di bawah agar pesan Anda langsung menyebutkan wilayah rumah Anda."
            track-location="cs_facebook_hero"
            surface="light"
        />
    </div>
</section>

<section class="py-9 sm:py-16 bg-white border-b border-slate-200 overflow-x-clip"
         x-data="{
            query: '',
            activeProvince: 'all',
            provinces: @js($regionSelectorData),
            cityIndex: 0,
            _cityProgrammatic: false,
            _cityTimer: null,
            init() {
                this.$watch('query', () => {
                    this.cityIndex = 0;
                    this.$nextTick(() => this.$refs.citySlider?.scrollTo({ left: 0, behavior: 'auto' }));
                });
                this.$watch('activeProvince', () => {
                    this.cityIndex = 0;
                    this.$nextTick(() => this.$refs.citySlider?.scrollTo({ left: 0, behavior: 'auto' }));
                });
            },
            get filteredCities() {
                const q = this.query.trim().toLowerCase();
                const list = [];
                for (const prov of this.provinces) {
                    if (this.activeProvince !== 'all' && prov.slug !== this.activeProvince) {
                        continue;
                    }
                    for (const city of (prov.cities || [])) {
                        const districts = city.districts || [];
                        const matchCity = !q || city.name.toLowerCase().includes(q) || prov.name.toLowerCase().includes(q);
                        const matchedDistricts = q ? districts.filter(d => d.toLowerCase().includes(q)) : districts.slice(0, 6);
                        if (matchCity || matchedDistricts.length > 0) {
                            list.push({
                                slug: city.slug,
                                name: city.name,
                                province: prov.name,
                                posko: city.posko_address,
                                districts: matchedDistricts.length > 0 ? matchedDistricts : districts.slice(0, 6),
                                url: '/area/' + city.slug
                            });
                        }
                    }
                }
                return list;
            },
            get totalCitySlides() {
                return Math.min(this.filteredCities.length, 9);
            },
            updateCityIndex() {
                if (this._cityProgrammatic) return;
                const container = this.$refs.citySlider;
                if (!container) return;
                const slides = Array.from(container.querySelectorAll('[data-city-slide]'));
                if (!slides.length) {
                    this.cityIndex = 0;
                    return;
                }
                const scrollLeft = container.scrollLeft;
                const maxScroll = container.scrollWidth - container.clientWidth;
                if (scrollLeft <= 15) {
                    this.cityIndex = 0;
                    return;
                }
                if (scrollLeft >= maxScroll - 15) {
                    this.cityIndex = slides.length - 1;
                    return;
                }
                const center = scrollLeft + (container.clientWidth / 2);
                let closest = 0;
                let minDiff = Infinity;
                slides.forEach((slide, idx) => {
                    const slideCenter = (slide.offsetLeft - container.offsetLeft) + (slide.clientWidth / 2);
                    const diff = Math.abs(center - slideCenter);
                    if (diff < minDiff) {
                        minDiff = diff;
                        closest = idx;
                    }
                });
                this.cityIndex = closest;
            },
            goCity(targetIdx) {
                const container = this.$refs.citySlider;
                if (!container) return;
                const slides = Array.from(container.querySelectorAll('[data-city-slide]'));
                if (!slides.length) return;
                const clamped = Math.max(0, Math.min(slides.length - 1, targetIdx));
                this.cityIndex = clamped;
                this._cityProgrammatic = true;
                clearTimeout(this._cityTimer);
                this._cityTimer = setTimeout(() => {
                    this._cityProgrammatic = false;
                }, 500);
                let targetLeft = 0;
                if (clamped === slides.length - 1) {
                    targetLeft = container.scrollWidth - container.clientWidth;
                } else if (clamped > 0) {
                    const slide = slides[clamped];
                    targetLeft = slide.offsetLeft - container.offsetLeft - (container.clientWidth - slide.clientWidth) / 2;
                }
                const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                container.scrollTo({
                    left: Math.max(0, targetLeft),
                    behavior: reduced ? 'instant' : 'smooth',
                });
            }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 sm:space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
            <div class="lg:col-span-7">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Cek Posko Armada di Sekitar Rumah Anda
                </h2>
                <p class="mt-1.5 text-sm sm:text-base text-slate-600">
                    Pilih provinsi atau ketik nama kecamatan Anda (misal: Tebet, Cibubur, Bekasi, Bandung, Semarang, Denpasar).
                </p>
            </div>
            <div class="lg:col-span-5">
                <label for="fb-posko-search" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Cari Kota atau Kecamatan
                </label>
                <input id="fb-posko-search"
                       type="search"
                       x-model="query"
                       placeholder="Ketik kecamatan atau kota..."
                       class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
            </div>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto scroll-px-4 no-scrollbar -mx-4 px-4 pb-1 sm:mx-0 sm:px-0 sm:flex-wrap sm:overflow-visible sm:pb-0">
            <button type="button"
                    @click="activeProvince = 'all'"
                    :aria-pressed="activeProvince === 'all' ? 'true' : 'false'"
                    :class="activeProvince === 'all' ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 text-slate-800 border-slate-300 hover:bg-slate-100'"
                    class="shrink-0 whitespace-nowrap min-h-11 px-3.5 py-2 rounded-md border text-xs sm:text-sm font-bold cursor-pointer transition-colors">
                Semua Wilayah
            </button>
            @foreach($regionSelectorData as $prov)
                <button type="button"
                        @click="activeProvince = '{{ $prov['slug'] }}'"
                        :aria-pressed="activeProvince === '{{ $prov['slug'] }}' ? 'true' : 'false'"
                        :class="activeProvince === '{{ $prov['slug'] }}' ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 text-slate-800 border-slate-300 hover:bg-slate-100'"
                        class="shrink-0 whitespace-nowrap min-h-11 px-3.5 py-2 rounded-md border text-xs sm:text-sm font-bold cursor-pointer transition-colors">
                    {{ $prov['name'] }}
                </button>
            @endforeach
        </div>

        <div x-show="filteredCities.length > 0">
            <div x-ref="citySlider"
                 tabindex="0"
                 role="region"
                 aria-label="Daftar posko armada kota"
                 @scroll.passive="updateCityIndex()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-4 md:overflow-visible md:pb-0">
                <template x-for="city in filteredCities.slice(0, 9)" :key="city.slug">
                    <article data-city-slide class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-slate-50 border border-slate-200 rounded-lg p-4 sm:p-5 flex flex-col justify-between gap-3">
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-sky-700 block" x-text="city.province"></span>
                            <h3 class="text-base font-extrabold text-slate-900" x-text="city.name"></h3>
                            <p class="text-xs text-slate-600" x-text="city.posko"></p>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Kecamatan: <span x-text="city.districts.join(', ')"></span>
                            </p>
                        </div>
                        <a :href="city.url"
                           class="min-h-11 inline-flex items-center justify-center px-4 py-2 rounded-md bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-bold transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            <span x-text="'Lihat Posko ' + city.name"></span>
                        </a>
                    </article>
                </template>
            </div>

            <div x-show="totalCitySlides > 1" class="flex items-center justify-between gap-3 mt-3 md:hidden">
                <div class="text-xs text-slate-600 flex items-center gap-2 min-w-0">
                    <span class="font-semibold">Posko <strong class="text-slate-900" x-text="Math.min(cityIndex + 1, totalCitySlides)">1</strong> / <span x-text="totalCitySlides"></span></span>
                    <span aria-hidden="true">&bull;</span>
                    <span>Geser kartu</span>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button"
                            @click="goCity(cityIndex - 1)"
                            :disabled="cityIndex === 0"
                            aria-label="Posko sebelumnya"
                            class="min-h-11 min-w-11 inline-flex items-center justify-center rounded-md border bg-white border-slate-300 text-slate-800 hover:bg-slate-100 transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button"
                            @click="goCity(cityIndex + 1)"
                            :disabled="cityIndex >= totalCitySlides - 1"
                            aria-label="Posko berikutnya"
                            class="min-h-11 min-w-11 inline-flex items-center justify-center rounded-md border bg-white border-slate-300 text-slate-800 hover:bg-slate-100 transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="filteredCities.length === 0" x-cloak class="bg-slate-50 border border-slate-200 rounded-lg p-6 text-center space-y-3">
            <p class="text-sm font-bold text-slate-900">
                Wilayah "<span x-text="query"></span>" tidak ditemukan dalam daftar kecamatan utama.
            </p>
            <p class="text-sm text-slate-600">
                Anda tetap dapat menanyakan jangkauan armada langsung ke admin Facebook via WhatsApp atau reset filter pencarian.
            </p>
            <button type="button"
                    @click="query = ''; activeProvince = 'all'"
                    class="min-h-11 px-4 py-2 rounded-md border border-slate-300 bg-white hover:bg-slate-100 text-sm font-bold text-slate-800 cursor-pointer">
                Tampilkan Semua Kota
            </button>
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="max-w-2xl">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Pengalaman Pelanggan &amp; Dokumentasi Hunian
            </h2>
            <p class="mt-1.5 text-sm sm:text-base text-slate-600">
                Catatan pelanggan terverifikasi dan hasil pengerjaan saluran rumah tinggal tanpa bongkar keramik.
            </p>
        </div>

        @if($reviews->isNotEmpty())
            <div x-data="mobileCarousel({{ $reviews->count() }}, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Pengalaman pelanggan terverifikasi"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                    @foreach($reviews as $rev)
                        <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-white flex flex-col justify-between gap-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-sm">
                                        Rating {{ (int) ($rev->rating ?: 5) }}/5
                                    </span>
                                    @if($rev->service)
                                        <span class="text-xs font-semibold text-sky-700">{{ $rev->service->name }}</span>
                                    @endif
                                </div>
                                <p class="text-sm text-slate-700 leading-relaxed">
                                    "{{ $rev->comment }}"
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-200">
                                <p class="text-sm font-extrabold text-slate-900">{{ $rev->customer_name }}</p>
                                @if($rev->customer_role_or_location)
                                    <p class="text-xs text-slate-600">{{ $rev->customer_role_or_location }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <x-customer-service.carousel-controls label="Ulasan" surface="light" hide-at="md" :count="$reviews->count()" />
            </div>
        @else
            <div x-data="mobileCarousel(2, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Dokumentasi pengerjaan hunian"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 md:gap-6 md:overflow-visible md:pb-0">
                    <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden">
                        <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                            <img src="{{ asset('images/dokumentasi/pelancaran-wastafel-mampet-rumah-warga.webp') }}" alt="Pelancaran saluran wastafel mampet di rumah warga" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 sm:p-5 flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Pelancaran Wastafel Rumah Tinggal</h3>
                                <p class="text-xs text-slate-600 mt-0.5">Area dapur bersih tanpa perlu membongkar meja granit atau pipa bawah.</p>
                            </div>
                        </div>
                    </article>
                    <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden">
                        <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                            <img src="{{ asset('images/dokumentasi/pelancar-bak-kontrol-perumahan-warga.webp') }}" alt="Pelancaran bak kontrol saluran utama di perumahan warga" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Bak Kontrol &amp; Saluran Utama Perumahan</h3>
                                <p class="text-xs text-slate-600 mt-0.5">Membersihkan sumbatan jalur induk menuju got depan rumah hingga tuntas.</p>
                            </div>
                            <a href="{{ route('gallery') }}" class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center px-3.5 py-2 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold shrink-0">
                                Galeri Lengkap
                            </a>
                        </div>
                    </article>
                </div>

                <x-customer-service.carousel-controls label="Dokumentasi" surface="light" hide-at="md" :count="2" />
            </div>
        @endif
    </div>
</section>

<section class="py-10 sm:py-16 bg-slate-900 text-slate-100 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="max-w-2xl">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Standar Kebersihan Teknisi saat Masuk Rumah
            </h2>
            <p class="mt-2 text-sm sm:text-base text-slate-300 leading-relaxed">
                Kenyamanan penghuni rumah dan keamanan lantai bersih menjadi bagian dari SOP wajib seluruh tim lapangan.
            </p>
        </div>

        <div x-data="mobileCarousel(4, 5500)" x-init="stopped = true">
            <div x-ref="slider"
                 tabindex="0"
                 role="region"
                 aria-label="Standar kebersihan teknisi"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 sm:overflow-visible sm:pb-0">
                <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start p-4 sm:p-5 rounded-lg bg-slate-950/60 border border-slate-800 space-y-1.5">
                    <h3 class="text-sm font-bold text-sky-300">Seragam &amp; Identitas Rapi</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Teknisi datang menggunakan seragam kerja resmi Drainusantara yang mudah dikenali keluarga di rumah.</p>
                </div>
                <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start p-4 sm:p-5 rounded-lg bg-slate-950/60 border border-slate-800 space-y-1.5">
                    <h3 class="text-sm font-bold text-sky-300">Pelindung Sepatu (Cover Shoes)</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Melindungi lantai ruang tamu, dapur, dan kamar mandi agar tidak kotor oleh jejak sepatu luar.</p>
                </div>
                <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start p-4 sm:p-5 rounded-lg bg-slate-950/60 border border-slate-800 space-y-1.5">
                    <h3 class="text-sm font-bold text-sky-300">Sarung Tangan Kerja Higienis</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Penanganan kabel spiral dan area pembuangan memakai perlengkapan pelindung diri standar K3.</p>
                </div>
                <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start p-4 sm:p-5 rounded-lg bg-slate-950/60 border border-slate-800 space-y-1.5">
                    <h3 class="text-sm font-bold text-sky-300">Area Dibersihkan Kembali</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Setelah tes aliran air dinyatakan lancar, area sekitar saluran dibersihkan dan nota garansi 30 hari diserahkan.</p>
                </div>
            </div>

            <x-customer-service.carousel-controls label="SOP" surface="dark" hide-at="sm" :count="4" />
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab Pelanggan Halaman Facebook"
    subheading="Panduan telepon langsung, standar kebersihan di dalam rumah, serta prosedur garansi 30 hari."
    channel-slug="facebook"
    variant="compact"
/>
@endsection
