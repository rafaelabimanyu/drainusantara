@props([
    'cityHub' => null,
    'service' => null,
])

@if(!empty($cityHub) || !empty($service))
<section class="bg-slate-50 rounded-lg border border-slate-200 p-5 sm:p-6" aria-label="Tautan Area dan Layanan Terkait">
    <div class="mb-4">
        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-800 mb-1">
            Layanan &amp; Area Terkait
        </p>
        <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
            Butuh Penanganan Serupa di Lokasi Anda?
        </h2>
    </div>

    <div class="grid grid-cols-1 {{ (!empty($cityHub) && !empty($service)) ? 'sm:grid-cols-2' : '' }} gap-4">
        @if(!empty($cityHub))
            <div class="bg-white rounded-lg border border-slate-200 p-4 flex flex-col justify-between gap-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        Posko Wilayah Siaga
                    </span>
                    <h3 class="text-sm font-bold text-slate-900 leading-snug">
                        <a href="{{ $cityHub['city_url'] }}" class="hover:text-sky-800 transition-colors">
                            Jasa Saluran Pipa Mampet {{ $cityHub['city_name'] }}
                        </a>
                    </h3>
                    <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                        Lihat jadwal armada terdekat, daftar kecamatan layanan, dan prosedur pembersihan tanpa bongkar keramik di {{ $cityHub['city_name'] }}.
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2">
                    <a href="{{ $cityHub['city_url'] }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold transition-colors">
                        Buka Area {{ $cityHub['city_name'] }}
                    </a>
                    @if(!empty($cityHub['district_url']) && !empty($cityHub['district_name']))
                        <a href="{{ $cityHub['district_url'] }}"
                           class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-800 hover:text-sky-800 text-xs font-semibold transition-colors">
                            Area {{ $cityHub['district_name'] }}
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if(!empty($service))
            <div class="bg-white rounded-lg border border-slate-200 p-4 flex flex-col justify-between gap-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        {{ $service['badge'] ?? 'Layanan Spesialis' }}
                    </span>
                    <h3 class="text-sm font-bold text-slate-900 leading-snug">
                        <a href="{{ $service['url'] }}" class="hover:text-sky-800 transition-colors">
                            {{ $service['name'] }}
                        </a>
                    </h3>
                    <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                        Pelajari spesifikasi pengerjaan mesin spiral rotary, standar K3 higienis, estimasi tarif dasar, serta garansi nota resmi 30 hari.
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2">
                    <a href="{{ $service['url'] }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors">
                        Lihat Detail Layanan
                    </a>
                    <a href="{{ route('services.index') }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-800 hover:text-sky-800 text-xs font-semibold transition-colors">
                        Semua Layanan
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endif
