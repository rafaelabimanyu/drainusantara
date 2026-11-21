@props([
    'channelCode' => 'wa',
    'channelSlug' => null,
    'channelName' => 'WhatsApp',
    'whatsappNumber' => '6285609009009',
    'regionSelectorData' => [],
    'ctaLabel' => 'Hubungi Admin Drainusantara',
    'heading' => 'Pilih Daerah Anda untuk Format Pesan Otomatis',
    'subheading' => 'Pilih kota dan kecamatan agar admin langsung mengecek posko teknisi terdekat.',
    'problemOptions' => [
        'Wastafel & Bak Cuci Piring',
        'Kloset / WC Duduk & Jongkok',
        'Floor Drain Kamar Mandi',
        'Talang Air Hujan & Roof Drain',
        'Bak Kontrol & Pipa Utama',
        'Grease Trap Dapur Usaha',
    ],
    'trackLocation' => 'cs_wa_builder',
    'surface' => 'light',
    'layout' => 'card',
])

@php
    $isDark = $surface === 'dark';
    $cleanWaNumber = preg_replace('/[^0-9]/', '', (string) $whatsappNumber) ?: '6285609009009';
    $defaultMessage = "Hallo admin {$channelCode} drainusantara, saluran saya mampet di daerah (mohon info posko terdekat)";
    $fallbackWaUrl = "https://wa.me/{$cleanWaNumber}?text=".rawurlencode($defaultMessage);
    $uid = 'wa-builder-'.preg_replace('/[^a-z0-9_-]/i', '', $channelCode);
    $slugMap = [
        'wa' => 'whatsapp',
        'ig' => 'instagram',
        'tiktok' => 'tiktok',
        'fb' => 'facebook',
        'youtube' => 'youtube',
        'linkedin' => 'linkedin',
    ];
    $resolvedSlug = $channelSlug ?: ($slugMap[$channelCode] ?? 'whatsapp');
    $accentIconBox = match ($resolvedSlug) {
        'instagram' => $isDark ? 'bg-rose-950/80 text-rose-300 border-rose-800' : 'bg-rose-50 text-rose-700 border-rose-200',
        'tiktok' => $isDark ? 'bg-slate-800 text-cyan-300 border-cyan-700/70' : 'bg-slate-900 text-cyan-300 border-slate-800',
        'facebook' => $isDark ? 'bg-blue-950/80 text-blue-300 border-blue-800' : 'bg-blue-50 text-blue-700 border-blue-200',
        'youtube' => $isDark ? 'bg-red-950/80 text-red-300 border-red-800' : 'bg-red-50 text-red-700 border-red-200',
        'linkedin' => $isDark ? 'bg-sky-950/80 text-sky-300 border-sky-800' : 'bg-sky-50 text-sky-800 border-sky-200',
        default => $isDark ? 'bg-emerald-950/80 text-emerald-300 border-emerald-800' : 'bg-emerald-50 text-emerald-800 border-emerald-200',
    };
@endphp

<div x-data="{
        channelCode: @js($channelCode),
        whatsappNumber: @js($cleanWaNumber),
        regions: @js($regionSelectorData),
        selectedCity: '',
        selectedDistrict: '',
        selectedProblem: '',
        copied: false,
        init() {
            this.$watch('selectedCity', () => {
                this.selectedDistrict = '';
            });
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
        get selectedPoskoAddress() {
            if (!this.selectedCity) return '';
            for (const prov of this.regions) {
                for (const city of (prov.cities || [])) {
                    if (city.name === this.selectedCity) {
                        return city.posko_address || '';
                    }
                }
            }
            return '';
        },
        get selectedAreaLabel() {
            if (this.selectedCity && this.selectedDistrict) {
                return `${this.selectedDistrict}, ${this.selectedCity}`;
            }
            if (this.selectedCity) {
                return this.selectedCity;
            }
            return '';
        },
        get messageText() {
            const area = this.selectedAreaLabel || '(mohon info posko terdekat)';
            const base = `Hallo admin ${this.channelCode} drainusantara, saluran saya mampet di daerah ${area}`;
            if (this.selectedProblem) {
                return `${base} (titik saluran: ${this.selectedProblem})`;
            }
            return base;
        },
        get waUrl() {
            return 'https://wa.me/' + this.whatsappNumber + '?text=' + encodeURIComponent(this.messageText);
        },
        copyTemplate() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.messageText).then(() => {
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2200);
                });
            }
        }
    }"
    @if($layout === 'bar')
        class="{{ $isDark ? 'bg-slate-900 border border-slate-700 text-slate-100' : 'bg-white border border-slate-200 text-slate-900' }} rounded-lg p-4 sm:p-6 shadow-sm space-y-4"
    @elseif($layout === 'ribbon')
        class="{{ $isDark ? 'bg-slate-900 border border-slate-700 text-slate-100' : 'bg-white border border-slate-200 text-slate-900' }} rounded-lg p-4 sm:p-7 shadow-xs space-y-5"
    @else
        class="{{ $isDark ? 'bg-slate-800 border border-slate-700 text-slate-100' : 'bg-white border border-slate-200 text-slate-900' }} rounded-lg p-4 sm:p-6 shadow-xs space-y-4"
    @endif>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-md border flex items-center justify-center shrink-0 {{ $accentIconBox }}">
                <x-customer-service.channel-icon :channel="$resolvedSlug" class="w-5 h-5" />
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-extrabold tracking-tight {{ $isDark ? 'text-white' : 'text-slate-900' }}">
                    {{ $heading }}
                </h2>
                <p class="text-xs sm:text-sm leading-relaxed {{ $isDark ? 'text-slate-300' : 'text-slate-600' }}">
                    {{ $subheading }}
                </p>
            </div>
        </div>
        <div x-show="selectedPoskoAddress" x-cloak class="shrink-0 max-w-full break-words {{ $isDark ? 'bg-slate-800 border-slate-700 text-sky-300' : 'bg-sky-50 border-sky-200 text-sky-900' }} border rounded-md px-3 py-2 text-xs font-semibold">
            Siaga: <span x-text="selectedPoskoAddress"></span>
        </div>
    </div>

    @if($layout === 'bar')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
            <div class="lg:col-span-3">
                <label for="{{ $uid }}-city" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    1. Kota / Wilayah
                </label>
                <select id="{{ $uid }}-city"
                        x-model="selectedCity"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Pilih kota terdekat</option>
                    @foreach($regionSelectorData as $prov)
                        <optgroup label="{{ $prov['name'] }}">
                            @foreach($prov['cities'] as $city)
                                <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3">
                <label for="{{ $uid }}-district" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    2. Kecamatan (Opsional)
                </label>
                <select id="{{ $uid }}-district"
                        x-model="selectedDistrict"
                        :disabled="!selectedCity || availableDistricts.length === 0"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 disabled:bg-slate-100 disabled:text-slate-500 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="" x-text="selectedCity ? 'Semua area ' + selectedCity : 'Pilih kota dulu'"></option>
                    <template x-for="dist in availableDistricts" :key="dist">
                        <option :value="dist" x-text="dist"></option>
                    </template>
                </select>
            </div>

            <div class="lg:col-span-3">
                <label for="{{ $uid }}-problem" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    3. Titik Saluran (Opsional)
                </label>
                <select id="{{ $uid }}-problem"
                        x-model="selectedProblem"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Konsultasi umum</option>
                    @foreach($problemOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3">
                <a href="{{ $fallbackWaUrl }}"
                   :href="waUrl"
                   target="_blank"
                   rel="noopener noreferrer"
                   data-track-location="{{ $trackLocation }}"
                   class="w-full min-h-12 inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-sm px-4 py-3 rounded-md border border-emerald-800 transition-colors btn-press focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 {{ $isDark ? 'focus-visible:ring-offset-slate-900' : 'focus-visible:ring-offset-white' }}">
                    <x-customer-service.channel-icon channel="whatsapp" class="w-4 h-4" />
                    <span>{{ $ctaLabel }}</span>
                </a>
            </div>
        </div>

        <div class="{{ $isDark ? 'bg-slate-950 border-slate-800' : 'bg-slate-50 border-slate-200' }} border rounded-md px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="min-w-0">
                <span class="text-xs font-bold block {{ $isDark ? 'text-slate-300' : 'text-slate-700' }}">Format Pesan Siap Kirim:</span>
                <p class="text-xs sm:text-sm break-words mt-0.5 {{ $isDark ? 'text-slate-100' : 'text-slate-800' }}" x-text="messageText">
                    {{ $defaultMessage }}
                </p>
            </div>
            <button type="button"
                    @click="copyTemplate()"
                    class="w-full sm:w-auto min-h-11 px-3.5 py-2 rounded-md text-xs font-bold shrink-0 transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ $isDark ? 'bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-600' : 'bg-white hover:bg-slate-100 text-slate-800 border border-slate-300' }}">
                <span x-text="copied ? 'Teks Tersalin' : 'Salin Pesan'">Salin Pesan</span>
            </button>
        </div>
    @elseif($layout === 'ribbon')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="{{ $uid }}-city" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Langkah 1: Pilih Kota Layanan
                </label>
                <select id="{{ $uid }}-city"
                        x-model="selectedCity"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Pilih kota terdekat</option>
                    @foreach($regionSelectorData as $prov)
                        <optgroup label="{{ $prov['name'] }}">
                            @foreach($prov['cities'] as $city)
                                <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="{{ $uid }}-district" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Langkah 2: Pilih Kecamatan (Opsional)
                </label>
                <select id="{{ $uid }}-district"
                        x-model="selectedDistrict"
                        :disabled="!selectedCity || availableDistricts.length === 0"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 disabled:bg-slate-100 disabled:text-slate-500 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="" x-text="selectedCity ? 'Semua area ' + selectedCity : 'Pilih kota dulu'"></option>
                    <template x-for="dist in availableDistricts" :key="dist">
                        <option :value="dist" x-text="dist"></option>
                    </template>
                </select>
            </div>

            <div>
                <label for="{{ $uid }}-problem" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Langkah 3: Titik Saluran (Opsional)
                </label>
                <select id="{{ $uid }}-problem"
                        x-model="selectedProblem"
                        class="w-full min-h-12 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Belum memilih titik saluran (konsultasi umum)</option>
                    @foreach($problemOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center pt-1">
            <div class="lg:col-span-8 order-2 lg:order-1 {{ $isDark ? 'bg-slate-950 border-slate-800' : 'bg-slate-50 border-slate-200' }} border rounded-md p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="min-w-0">
                    <span class="text-xs font-bold block {{ $isDark ? 'text-slate-300' : 'text-slate-700' }}">Pratinjau Pesan Admin {{ $channelName }}</span>
                    <p class="text-xs sm:text-sm break-words mt-0.5 {{ $isDark ? 'text-slate-100' : 'text-slate-800' }}" x-text="messageText">
                        {{ $defaultMessage }}
                    </p>
                </div>
                <button type="button"
                        @click="copyTemplate()"
                        class="w-full sm:w-auto min-h-11 px-3 py-2 rounded-md text-xs font-bold shrink-0 transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ $isDark ? 'bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-600' : 'bg-white hover:bg-slate-100 text-slate-800 border border-slate-300' }}">
                    <span x-text="copied ? 'Teks Tersalin' : 'Salin Pesan'">Salin Pesan</span>
                </button>
            </div>

            <div class="lg:col-span-4 order-1 lg:order-2">
                <a href="{{ $fallbackWaUrl }}"
                   :href="waUrl"
                   target="_blank"
                   rel="noopener noreferrer"
                   data-track-location="{{ $trackLocation }}"
                   class="w-full min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-sm sm:text-base px-5 py-3 rounded-lg border border-emerald-800 transition-colors btn-press focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 {{ $isDark ? 'focus-visible:ring-offset-slate-900' : 'focus-visible:ring-offset-white' }}">
                    <x-customer-service.channel-icon channel="whatsapp" class="w-5 h-5" />
                    <span>{{ $ctaLabel }}</span>
                </a>
            </div>
        </div>
    @else
        <div class="space-y-3.5">
            <div>
                <label for="{{ $uid }}-city" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Kota / Kabupaten Proyek
                </label>
                <select id="{{ $uid }}-city"
                        x-model="selectedCity"
                        class="w-full min-h-11 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Pilih kota terdekat</option>
                    @foreach($regionSelectorData as $prov)
                        <optgroup label="{{ $prov['name'] }}">
                            @foreach($prov['cities'] as $city)
                                <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="{{ $uid }}-district" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Kecamatan / Kawasan (Opsional)
                </label>
                <select id="{{ $uid }}-district"
                        x-model="selectedDistrict"
                        :disabled="!selectedCity || availableDistricts.length === 0"
                        class="w-full min-h-11 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 disabled:bg-slate-100 disabled:text-slate-500 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="" x-text="selectedCity ? 'Semua area ' + selectedCity : 'Pilih kota dulu'"></option>
                    <template x-for="dist in availableDistricts" :key="dist">
                        <option :value="dist" x-text="dist"></option>
                    </template>
                </select>
            </div>

            <div>
                <label for="{{ $uid }}-problem" class="block text-xs font-bold mb-1.5 {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">
                    Titik Saluran Tersumbat (Opsional)
                </label>
                <select id="{{ $uid }}-problem"
                        x-model="selectedProblem"
                        class="w-full min-h-11 rounded-md border border-slate-300 bg-white px-3 py-2 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <option value="">Belum memilih titik saluran (konsultasi umum)</option>
                    @foreach($problemOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="{{ $isDark ? 'bg-slate-950 border-slate-700' : 'bg-slate-50 border-slate-200' }} border rounded-md p-3.5 space-y-2">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-bold {{ $isDark ? 'text-slate-300' : 'text-slate-700' }}">
                    Pratinjau Pesan Admin {{ $channelName }}
                </span>
                <button type="button"
                        @click="copyTemplate()"
                        class="min-h-11 px-3 py-1.5 rounded-md text-xs font-bold transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 {{ $isDark ? 'bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-600' : 'bg-white hover:bg-slate-100 text-slate-800 border border-slate-300' }}">
                    <span x-text="copied ? 'Teks Tersalin' : 'Salin Pesan'">Salin Pesan</span>
                </button>
            </div>
            <p class="text-xs sm:text-sm leading-relaxed break-words {{ $isDark ? 'text-slate-100' : 'text-slate-800' }}" x-text="messageText">
                {{ $defaultMessage }}
            </p>
        </div>

        <a href="{{ $fallbackWaUrl }}"
           :href="waUrl"
           target="_blank"
           rel="noopener noreferrer"
           data-track-location="{{ $trackLocation }}"
           class="w-full min-h-12 inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-sm sm:text-base px-5 py-3 rounded-lg border border-emerald-800 transition-colors btn-press focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 {{ $isDark ? 'focus-visible:ring-offset-slate-800' : 'focus-visible:ring-offset-white' }}">
            <x-customer-service.channel-icon channel="whatsapp" class="w-5 h-5" />
            <span>{{ $ctaLabel }}</span>
        </a>
    @endif
</div>
