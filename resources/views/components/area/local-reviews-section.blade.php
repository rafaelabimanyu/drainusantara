@props([
    'area',
    'locationName',
    'reviews' => [],
    'whatsappUrl' => null,
])

@php
    $displayLocation = $locationName ?? ($area->district ? "{$area->district}, {$area->city}" : $area->city);
    $waUrl = $whatsappUrl ?? ($area->resolved_cta['whatsapp_url'] ?? "https://wa.me/" . (config('app.whatsapp_number') ?: '6285609009009') . "?text=" . urlencode("Halo Tim Drainusantara, saya ingin konsultasi jasa pelancaran saluran pipa mampet di area {$displayLocation}."));
    $listReviews = !empty($reviews) ? $reviews : ($area->resolved_local_reviews ?? []);
    $googleMapsSearchUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode('Drainusantara Jasa Saluran Pipa Mampet ' . $displayLocation);
@endphp

<section id="ulasan-pelanggan-lokal" data-section="ulasan-lokal" class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="max-w-3xl mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-2">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>ULASAN &amp; REPUTASI RIIL PELANGGAN</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Rating &amp; Ulasan Kepuasan Pelanggan di {{ $displayLocation }}
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm mt-2 leading-relaxed">
                Transparansi pengerjaan nyata teknisi spesialis saluran pipa Drainusantara di sektor residensial, ruko niaga, kafe kuliner, dan perkantoran wilayah {{ $displayLocation }}. 100% tanpa bongkar lantai keramik dan dilindungi nota garansi resmi 30 hari.
            </p>
        </div>

        <!-- Rating Summary Box (CRO Trust Pillar) -->
        <div class="rounded-lg border border-slate-200 bg-white p-5 sm:p-7 mb-10 shadow-2xs">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <!-- Score & Stars -->
                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col items-start sm:items-center lg:items-start gap-4 border-b lg:border-b-0 lg:border-r border-slate-200 pb-6 lg:pb-0 lg:pr-6">
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">4.9</span>
                            <span class="text-lg font-bold text-slate-400">/ 5.0</span>
                        </div>
                        <div class="flex items-center gap-1 mt-1.5" aria-label="Rating 5 dari 5 bintang">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-amber-400 fill-amber-400" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1.5">
                            Berdasarkan kepuasan puluhan pelanggan di {{ $displayLocation }}
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-bold">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Garansi Tuntas Baru Bayar (No Cure No Pay)</span>
                    </div>
                </div>

                <!-- Rating Distribution Bars -->
                <div class="lg:col-span-5 space-y-2 border-b lg:border-b-0 lg:border-r border-slate-200 pb-6 lg:pb-0 lg:pr-6">
                    <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Distribusi Kepuasan Pelanggan</div>
                    
                    <!-- 5 Stars -->
                    <div class="flex items-center gap-2.5 text-xs text-slate-600">
                        <span class="w-12 font-medium shrink-0">5 Bintang</span>
                        <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 92%"></div>
                        </div>
                        <span class="w-9 text-right font-bold text-slate-900 shrink-0">92%</span>
                    </div>

                    <!-- 4 Stars -->
                    <div class="flex items-center gap-2.5 text-xs text-slate-600">
                        <span class="w-12 font-medium shrink-0">4 Bintang</span>
                        <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 rounded-full" style="width: 8%"></div>
                        </div>
                        <span class="w-9 text-right font-bold text-slate-700 shrink-0">8%</span>
                    </div>

                    <!-- 3 Stars -->
                    <div class="flex items-center gap-2.5 text-xs text-slate-400">
                        <span class="w-12 font-medium shrink-0">3 Bintang</span>
                        <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-200 rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="w-9 text-right font-medium text-slate-400 shrink-0">0%</span>
                    </div>

                    <!-- 2 Stars -->
                    <div class="flex items-center gap-2.5 text-xs text-slate-400">
                        <span class="w-12 font-medium shrink-0">2 Bintang</span>
                        <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-200 rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="w-9 text-right font-medium text-slate-400 shrink-0">0%</span>
                    </div>

                    <!-- 1 Star -->
                    <div class="flex items-center gap-2.5 text-xs text-slate-400">
                        <span class="w-12 font-medium shrink-0">1 Bintang</span>
                        <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-200 rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="w-9 text-right font-medium text-slate-400 shrink-0">0%</span>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="lg:col-span-3 flex flex-col gap-2.5">
                    <a href="{{ $googleMapsSearchUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-xs font-bold text-slate-800 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span>Lihat Profil di Google Maps</span>
                    </a>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-2xs">
                        <svg class="w-4 h-4 shrink-0 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Masalah Pipa</span>
                    </a>

                    <div class="text-[11px] text-slate-500 text-center">
                        Respon cepat teknisi siaga 24 jam di {{ $displayLocation }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Local Review Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($listReviews as $review)
                <div class="rounded-lg border border-slate-200 bg-white p-5 flex flex-col justify-between shadow-2xs hover:border-sky-300 transition-colors">
                    <div>
                        <!-- Reviewer Header -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-2.5">
                                @if(!empty($review['avatar_url']))
                                    <img src="{{ $review['avatar_url'] }}" alt="{{ $review['customer_name'] }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-slate-200" loading="lazy">
                                @else
                                    <div class="w-10 h-10 rounded-full {{ $review['avatar_bg'] ?? 'bg-sky-700' }} text-white text-xs font-black flex items-center justify-center shrink-0 shadow-2xs">
                                        {{ $review['initials'] ?? 'DN' }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-bold text-slate-900 tracking-tight leading-tight">
                                        {{ $review['customer_name'] }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-medium">
                                        {{ $review['property_type'] }}
                                    </div>
                                </div>
                            </div>

                            <span class="text-[10px] text-slate-400 font-medium shrink-0">
                                {{ $review['time_ago'] }}
                            </span>
                        </div>

                        <!-- Verification Badge & Stars -->
                        <div class="flex items-center justify-between gap-2 mb-3 pb-2.5 border-b border-slate-100">
                            <div class="flex items-center gap-1" aria-label="{{ $review['rating'] }} dari 5 bintang">
                                @for($s = 0; $s < ($review['rating'] ?? 5); $s++)
                                    <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Terverifikasi</span>
                            </span>
                        </div>

                        <!-- Service Name Tag -->
                        <div class="mb-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                {{ $review['service_name'] }}
                            </span>
                        </div>

                        <!-- Review Text -->
                        <p class="text-xs text-slate-600 leading-relaxed italic mb-3">
                            &ldquo;{{ $review['comment'] }}&rdquo;
                        </p>
                    </div>

                    <!-- Card Footer: Turnaround & Safe Guarantee -->
                    <div class="pt-3 border-t border-slate-100 space-y-1.5">
                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-slate-700">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>{{ $review['turnaround'] }}</span>
                        </div>
                        <div class="text-[10px] text-slate-400">
                            Metode: Spiral Rotary Ridgid &bull; Garansi 30 Hari
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

