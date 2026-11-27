@extends('layouts.app')

@section('content')
<section class="bg-slate-950 text-slate-100 border-b border-slate-800 py-7 sm:py-14 overflow-x-clip"
         x-data="{
            activeSymptom: 'wastafel',
            regions: @js($regionSelectorData),
            selectedCity: '',
            selectedDistrict: '',
            copied: false,
            whatsappNumber: @js($whatsappNumber),
            symptoms: {
                wastafel: {
                    label: 'Wastafel Berlemak',
                    badge: 'Dapur & Bak Cuci Piring',
                    photo: @js(asset('images/dokumentasi/drain-cleaner-spiral-baja-wastafel.webp')),
                    alt: 'Kabel spiral baja membersihkan lemak beku di saluran wastafel dapur',
                    cause: 'Minyak goreng dan sisa bumbu mengeras membentuk gumpalan lemak padat (fatberg) di sepanjang pipa mendatar dan leher angsa sifon.',
                    avoid: 'Jangan menuang air mendidih bersama soda api karena lemak hanya meleleh sesaat lalu membeku lebih keras di belokan pipa jauh.',
                    tool: 'Mesin Spiral Rotary Ridgid K-50 dengan kabel fleksibel 16mm untuk mengikis kerak lemak dari dalam dinding pipa.',
                    problemTag: 'Wastafel & Bak Cuci Piring'
                },
                floordrain: {
                    label: 'Floor Drain Kamar Mandi',
                    badge: 'Saluran Lantai & Mesin Cuci',
                    photo: @js(asset('images/dokumentasi/proses-ridgid-spiral-floor-drain.webp')),
                    alt: 'Penanganan sumbatan floor drain kamar mandi dengan spiral rotary tanpa bongkar keramik',
                    cause: 'Gumpalan rambut rontok bercampur endapan busa deterjen dan kerak sabun menyumbat perangkap air lantai.',
                    avoid: 'Hindari menyodok memakai kawat gantungan baju atau selang plastik keras yang bisa menyangkut atau melubangi sambungan pipa PVC.',
                    tool: 'Kabel spiral lentur melewati belokan sempit dan menarik ikatan rambut keluar tanpa membongkar keramik lantai.',
                    problemTag: 'Floor Drain Kamar Mandi'
                },
                kloset: {
                    label: 'Kloset / WC Meluap',
                    badge: 'Toilet Duduk & Jongkok',
                    photo: @js(asset('images/dokumentasi/pelancaran-kloset-spiral-baja-profesional.webp')),
                    alt: 'Pelancaran kloset tersumbat memakai alat mekanis spiral baja',
                    cause: 'Tisu basah, pembalut, kapas, atau benda padat tersangkut di lekukan leher angsa porselen atau jalur menuju septic tank.',
                    avoid: 'Jangan terus menyiram dengan ember besar karena air kotor dapat meluap ke lantai kamar mandi.',
                    tool: 'Rooter torsi tinggi dengan pelindung leher angsa agar porselen kloset tetap aman dan tidak dicabut.',
                    problemTag: 'Kloset / WC Duduk & Jongkok'
                },
                sodaapi: {
                    label: 'Telanjur Tuang Soda Api',
                    badge: 'Penanganan Khusus PVC',
                    photo: @js(asset('images/dokumentasi/inspeksi-kamera-cctv-pipa-tersumbat.webp')),
                    alt: 'Inspeksi kamera endoskopi pipa untuk memeriksa kondisi PVC pasca pemakaian soda api',
                    cause: 'Reaksi panas kimia NaOH membuat kerak lemak membatu sekeras semen sekaligus melunakkan dinding pipa PVC.',
                    avoid: 'Segera hentikan penambahan cairan kimia tambahan agar tidak menimbulkan uap berbahaya dan perubahan bentuk sambungan lem PVC.',
                    tool: 'Penanganan mekanis dengan APD lengkap untuk memecah gumpalan kimia mengeras dan memulihkan aliran air.',
                    problemTag: 'Penanganan Pipa Pasca Soda Api'
                }
            },
            init() {
                this.$watch('selectedCity', () => {
                    this.selectedDistrict = '';
                });
            },
            get currentSymptom() {
                return this.symptoms[this.activeSymptom];
            },
            get availableDistricts() {
                if (!this.selectedCity) return [];
                for (const prov of this.regions) {
                    for (const city of (prov.cities || [])) {
                        if (city.name === this.selectedCity) {
                            return city.districts || [];
                        }
                    }
                }
                return [];
            },
            get selectedAreaLabel() {
                if (this.selectedCity && this.selectedDistrict) {
                    return `${this.selectedDistrict}, ${this.selectedCity}`;
                }
                return this.selectedCity || '';
            },
            get tiktokMessage() {
                const area = this.selectedAreaLabel || '(mohon info posko terdekat)';
                return `Hallo admin tiktok drainusantara, saluran saya mampet di daerah ${area} (keluhan: ${this.currentSymptom.problemTag})`;
            },
            get symptomWaUrl() {
                return 'https://wa.me/' + this.whatsappNumber + '?text=' + encodeURIComponent(this.tiktokMessage);
            },
            copyMsg() {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(this.tiktokMessage).then(() => {
                        this.copied = true;
                        setTimeout(() => { this.copied = false; }, 2200);
                    });
                }
            }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 sm:mb-6 font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-cyan-300 transition-colors">Beranda</a>
            <span class="text-slate-500">/</span>
            <a href="{{ route('customer-service.index') }}" class="hover:text-cyan-300 transition-colors">Customer Service</a>
            <span class="text-slate-500">/</span>
            <span class="text-cyan-300 font-bold">Customer Service TikTok</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-10 items-start">
            <div class="lg:col-span-5 space-y-4 sm:space-y-5">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-slate-900 border border-cyan-500/40 text-cyan-300 text-xs font-bold">
                    <x-customer-service.channel-icon channel="tiktok" class="w-4 h-4" />
                    <span>Tautan Resmi Bio TikTok {{ $channel['handle'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Customer Service Resmi TikTok @drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Pilih gejala saluran yang sesuai, tentukan kota atau kecamatan Anda, lalu langsung kirim pesan ke admin TikTok Drainusantara tanpa membongkar keramik.
                </p>

                <div class="rounded-lg overflow-hidden border border-slate-800 bg-slate-900">
                    <div class="aspect-[16/9] sm:aspect-[16/11] overflow-hidden relative">
                        <img :src="currentSymptom.photo"
                             src="{{ asset('images/dokumentasi/drain-cleaner-spiral-baja-wastafel.webp') }}"
                             :alt="currentSymptom.alt"
                             alt="Dokumentasi pengerjaan saluran mampet oleh tim Drainusantara"
                             width="800"
                             height="600"
                             loading="eager"
                             decoding="async"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/95 via-slate-950/70 to-transparent p-3.5 sm:p-4">
                            <span class="text-xs font-bold text-cyan-300 block" x-text="currentSymptom.badge">Dapur &amp; Bak Cuci Piring</span>
                            <p class="text-xs text-slate-200 mt-0.5" x-text="currentSymptom.alt">Kabel spiral baja membersihkan lemak beku di saluran wastafel dapur</p>
                        </div>
                    </div>
                </div>

                @if(!empty($socialUrl))
                    <a href="{{ $socialUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md border border-slate-700 bg-slate-900 hover:bg-slate-800 text-xs sm:text-sm font-bold text-slate-100 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-cyan-400">
                        <x-customer-service.channel-icon channel="tiktok" class="w-4 h-4 text-cyan-300" />
                        <span>Buka Profil TikTok {{ $channel['handle'] }}</span>
                    </a>
                @endif
            </div>

            <div class="lg:col-span-7 bg-slate-900 border border-slate-800 rounded-lg p-4 sm:p-7 space-y-5 min-w-0">
                <div class="space-y-1">
                    <h2 class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                        1. Pilih Gejala Masalah Saluran Anda
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300">
                        Diagnosis singkat agar Anda tidak keliru menuang soda api sebelum teknisi tiba.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-2" role="tablist" aria-label="Pilih gejala saluran mampet">
                    <template x-for="(item, key) in symptoms" :key="key">
                        <button type="button"
                                role="tab"
                                aria-controls="tiktok-triage-panel"
                                :aria-selected="activeSymptom === key ? 'true' : 'false'"
                                @click="activeSymptom = key"
                                :class="activeSymptom === key ? 'bg-sky-700 text-white border-sky-500' : 'bg-slate-950 text-slate-200 border-slate-800 hover:border-cyan-500/60'"
                                class="min-h-10 px-2.5 sm:px-3 py-2 rounded-md border text-left text-xs font-bold transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-cyan-400"
                                x-text="item.label">
                        </button>
                    </template>
                </div>

                <div id="tiktok-triage-panel" role="tabpanel" class="bg-slate-950 border border-slate-800 rounded-md p-3.5 sm:p-4 space-y-3 overflow-x-clip">
                    <h3 class="text-base font-extrabold text-white" x-text="currentSymptom.label">Wastafel Berlemak</h3>
                    <div class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-2.5 pb-1 sm:grid sm:grid-cols-3 sm:gap-3 sm:overflow-visible sm:pb-0 text-xs leading-relaxed">
                        <div class="w-[74vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3 rounded-sm bg-slate-900 border border-slate-800">
                            <span class="font-bold text-sky-300 block mb-1">Penyebab</span>
                            <p class="text-slate-300" x-text="currentSymptom.cause"></p>
                        </div>
                        <div class="w-[74vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3 rounded-sm bg-slate-900 border border-slate-800">
                            <span class="font-bold text-rose-300 block mb-1">Hindari</span>
                            <p class="text-slate-300" x-text="currentSymptom.avoid"></p>
                        </div>
                        <div class="w-[74vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3 rounded-sm bg-slate-900 border border-slate-800">
                            <span class="font-bold text-emerald-300 block mb-1">Alat Kami</span>
                            <p class="text-slate-300" x-text="currentSymptom.tool"></p>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-300 sm:hidden">
                        Geser ke samping untuk baca Penyebab, Hindari, dan Alat Kami.
                    </p>
                </div>

                @php
                    $tiktokCityGroups = array_values(array_map(static fn (array $prov): array => [
                        'label' => (string) ($prov['name'] ?? ''),
                        'options' => array_values(array_map(static fn (array $city): array => [
                            'value' => (string) ($city['name'] ?? ''),
                            'label' => (string) ($city['name'] ?? ''),
                        ], $prov['cities'] ?? [])),
                    ], $regionSelectorData));
                @endphp
                <div class="space-y-2.5 pt-2 border-t border-slate-800">
                    <p class="text-sm font-extrabold text-white">2. Pilih Wilayah Anda untuk Menghubungi Admin TikTok</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div>
                            <label for="wa-builder-tiktok-city" class="block text-xs font-bold text-slate-200 mb-1">
                                Kota / Kabupaten
                            </label>
                            <x-ui.compact-select
                                id="wa-builder-tiktok-city"
                                x-model="selectedCity"
                                :groups="$tiktokCityGroups"
                                placeholder="Pilih kota terdekat"
                                :searchable="true"
                                search-placeholder="Cari kota layanan..."
                                ring-class="focus-visible:ring-cyan-400"
                            />
                        </div>

                        <div>
                            <label for="wa-builder-tiktok-district" class="block text-xs font-bold text-slate-200 mb-1">
                                Kecamatan (Opsional)
                            </label>
                            <x-ui.compact-select
                                id="wa-builder-tiktok-district"
                                x-model="selectedDistrict"
                                options-expr="availableDistricts"
                                disabled-expr="!selectedCity || availableDistricts.length === 0"
                                placeholder="Pilih kota dulu"
                                placeholder-expr="selectedCity ? 'Semua area ' + selectedCity : 'Pilih kota dulu'"
                                :searchable="true"
                                search-placeholder="Cari kecamatan..."
                                ring-class="focus-visible:ring-cyan-400"
                            />
                        </div>
                    </div>

                    <div class="bg-slate-950 border border-slate-800 rounded-md p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        <p class="text-xs sm:text-sm text-slate-100 break-words" x-text="tiktokMessage">
                            {{ $contextualWaMsg }}
                        </p>
                        <button type="button"
                                @click="copyMsg()"
                                class="w-full sm:w-auto min-h-11 px-3 py-1.5 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-700 text-xs font-bold shrink-0 cursor-pointer">
                            <span x-text="copied ? 'Teks Tersalin' : 'Salin Pesan'">Salin Pesan</span>
                        </button>
                    </div>

                    <a href="{{ $contextualWaUrl }}"
                       :href="symptomWaUrl"
                       target="_blank"
                       rel="noopener noreferrer"
                       data-track-location="cs_tiktok_triage"
                       class="w-full min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-sm sm:text-base px-5 py-3 rounded-lg border border-emerald-800 transition-colors btn-press focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-400">
                        <x-customer-service.channel-icon channel="whatsapp" class="w-5 h-5" />
                        <span>Hubungi Admin Drainusantara</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $comparisonRows = [
        [
            'parameter' => 'Dampak ke Keramik & Pipa',
            'ridgid' => '0% tanpa bongkar tegel, aman untuk sambungan PVC',
            'soda' => 'Panas kimia melunakkan pipa PVC hingga melengkung',
            'bongkar' => 'Keramik dan adukan semen dipecah',
        ],
        [
            'parameter' => 'Efektivitas Kerak Lemak',
            'ridgid' => 'Terkikis mekanis dan terangkat tuntas keluar',
            'soda' => 'Sering membuat lemak membatu lebih keras',
            'bongkar' => 'Pipa lama diganti baru dengan biaya renovasi',
        ],
        [
            'parameter' => 'Keamanan Penghuni',
            'ridgid' => 'Aman tanpa uap kimia atau gas beracun',
            'soda' => 'Risiko percikan luka bakar dan uap beracun',
            'bongkar' => 'Debu bongkaran dan suara bising beberapa hari',
        ],
        [
            'parameter' => 'Garansi Pengerjaan',
            'ridgid' => 'Garansi nota resmi tertulis 30 hari kalender',
            'soda' => 'Tidak ada garansi hasil',
            'bongkar' => 'Tergantung kesepakatan tukang harian',
        ],
    ];
@endphp

<section class="py-9 sm:py-16 bg-white overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-4 space-y-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Fakta Lapangan vs Soda Api &amp; Bongkar Lantai
            </h2>
            <p class="text-sm text-slate-700 leading-relaxed">
                {{ $durationAnswer }}
            </p>
            <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-900 aspect-[16/10]">
                <img src="{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}"
                     alt="Mesin rooter Ridgid K-50 dengan kabel spiral baja fleksibel"
                     width="800"
                     height="500"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <div class="lg:col-span-8 min-w-0">
            <div class="md:hidden" x-data="mobileCarousel({{ count($comparisonRows) }}, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Perbandingan metode spiral Ridgid vs soda api dan bongkar keramik"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2">
                    @foreach($comparisonRows as $row)
                        <article class="w-[84vw] max-w-[330px] shrink-0 snap-start bg-white border border-slate-200 rounded-lg p-4 space-y-3">
                            <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-200 pb-2">
                                {{ $row['parameter'] }}
                            </h3>
                            <div class="p-3 rounded-md bg-sky-50 border border-sky-200">
                                <span class="text-xs font-extrabold text-sky-900 block">Mesin Spiral Ridgid Drainusantara</span>
                                <p class="text-xs font-medium text-slate-900 mt-1 leading-relaxed">{{ $row['ridgid'] }}</p>
                            </div>
                            <div class="p-3 rounded-md bg-slate-50 border border-slate-200">
                                <span class="text-xs font-bold text-slate-900 block">Soda Api (Kimia Korosif)</span>
                                <p class="text-xs text-slate-700 mt-1 leading-relaxed">{{ $row['soda'] }}</p>
                            </div>
                            <div class="p-3 rounded-md bg-slate-50 border border-slate-200">
                                <span class="text-xs font-bold text-slate-900 block">Bongkar Keramik Konvensional</span>
                                <p class="text-xs text-slate-700 mt-1 leading-relaxed">{{ $row['bongkar'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <x-customer-service.carousel-controls label="Perbandingan" surface="light" hide-at="md" :count="count($comparisonRows)" />
            </div>

            <div class="hidden md:block overflow-x-auto border border-slate-200 rounded-lg bg-white">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead class="bg-slate-900 text-white">
                        <tr>
                            <th class="p-4 font-bold">Parameter</th>
                            <th class="p-4 font-bold text-sky-300">Mesin Spiral Ridgid Drainusantara</th>
                            <th class="p-4 font-bold">Soda Api (Kimia Korosif)</th>
                            <th class="p-4 font-bold">Bongkar Keramik Konvensional</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @foreach($comparisonRows as $row)
                            <tr>
                                <td class="p-4 font-bold text-slate-900">{{ $row['parameter'] }}</td>
                                <td class="p-4 font-medium text-slate-900">{{ $row['ridgid'] }}</td>
                                <td class="p-4">{{ $row['soda'] }}</td>
                                <td class="p-4">{{ $row['bongkar'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab dari Penonton TikTok Drainusantara"
    subheading="Jawaban seputar penggunaan kabel spiral di belokan pipa, penanganan pasca soda api, dan cakupan wilayah."
    channel-slug="tiktok"
    variant="compact"
/>
@endsection
