@props([
    'slug' => '',
    'title' => '',
    'location' => '',
    'propertyTypes' => [],
    'beforeImage' => null,
    'duration' => null,
    'problemTypes' => [],
])

@php
    $normalizedPropertyTypes = is_array($propertyTypes) 
        ? $propertyTypes 
        : (is_string($propertyTypes) ? (json_decode($propertyTypes, true) ?? array_filter(array_map('trim', explode(',', $propertyTypes)))) : []);
    $normalizedPropertyTypes = is_array($normalizedPropertyTypes) ? array_values(array_filter($normalizedPropertyTypes)) : [];

    $normalizedProblemTypes = is_array($problemTypes) 
        ? $problemTypes 
        : (is_string($problemTypes) ? (json_decode($problemTypes, true) ?? array_filter(array_map('trim', explode(',', $problemTypes)))) : []);
    $normalizedProblemTypes = is_array($normalizedProblemTypes) ? array_values(array_filter($normalizedProblemTypes)) : [];

    $imageUrl = $beforeImage ? (filter_var($beforeImage, FILTER_VALIDATE_URL) ? $beforeImage : asset($beforeImage)) : null;
@endphp

<a href="/studi-kasus/{{ $slug }}" 
   class="block bg-white rounded-lg border border-slate-200 overflow-hidden hover:border-sky-300 transition-colors group shadow-2xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
    
    <!-- Bagian Atas: Gambar Thumbnail -->
    <div class="w-full aspect-[16/10] bg-slate-100 overflow-hidden relative">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" 
                 alt="Studi kasus: {{ $title }}" 
                 width="640" 
                 height="400" 
                 loading="lazy" 
                 decoding="async" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-400 text-xs p-4 text-center">
                <svg class="w-8 h-8 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-[11px] font-medium text-slate-500">Foto belum tersedia</span>
            </div>
        @endif
    </div>

    <!-- Bagian Bawah: Konten & Detail -->
    <div class="p-4 flex flex-col justify-between">
        <div>
            <!-- Judul Studi Kasus -->
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors mb-2 line-clamp-2 leading-snug">
                {{ $title }}
            </h3>

            <!-- Metadata Row (Lokasi & Durasi) -->
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                @if(!empty($location))
                    <span class="font-medium text-slate-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $location }}</span>
                    </span>
                @endif

                @if(!empty($location) && !empty($duration))
                    <span class="text-slate-300" aria-hidden="true">&bull;</span>
                @endif

                @if(!empty($duration))
                    <span>{{ $duration }}</span>
                @endif
            </div>

            <!-- Ringkasan Properti & Kendala -->
            @php
                $allTags = array_merge($normalizedPropertyTypes, $normalizedProblemTypes);
            @endphp
            @if(!empty($allTags))
                <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100 truncate">
                    {{ implode(' &bull; ', $allTags) }}
                </p>
            @endif
        </div>
    </div>
</a>

