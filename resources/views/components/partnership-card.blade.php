@props([
    'slug' => '',
    'businessName' => '',
    'logoUrl' => null,
    'businessType' => null,
    'partnershipType' => null,
    'location' => null,
    'services' => [],
])

@php
    $typeMap = [
        'kontrak-maintenance' => 'Kontrak Maintenance',
        'kerjasama-proyek' => 'Kerjasama Proyek',
        'sewa-alat' => 'Sewa Alat',
        'emergency' => 'Layanan Darurat',
    ];
    $partnerLabel = $typeMap[$partnershipType] ?? ucwords(str_replace(['-', '_'], ' ', (string) ($partnershipType ?: 'Kemitraan B2B')));

    $servicesList = is_array($services) 
        ? $services 
        : (is_string($services) ? (json_decode($services, true) ?? array_filter(array_map('trim', explode(',', $services)))) : []);
    $servicesList = is_array($servicesList) ? array_values(array_filter($servicesList)) : [];

    // Inisial untuk fallback logo jika file gambar belum ada
    $initials = '';
    $words = explode(' ', trim((string) $businessName));
    if (count($words) >= 2) {
        $initials = \Illuminate\Support\Str::upper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
    } else {
        $initials = \Illuminate\Support\Str::upper(mb_substr($businessName, 0, 2));
    }

    $resolvedLogo = $logoUrl ? (filter_var($logoUrl, FILTER_VALIDATE_URL) ? $logoUrl : asset($logoUrl)) : null;
@endphp

<a href="/kemitraan/{{ $slug }}" 
   class="block bg-white rounded-lg border border-slate-200 overflow-hidden hover:border-sky-300 transition-colors group p-5 text-center shadow-2xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
    
    <!-- Logo Area -->
    @if($resolvedLogo)
        <img src="{{ $resolvedLogo }}" 
             alt="Logo {{ $businessName }}" 
             width="64"
             height="64"
             loading="lazy"
             decoding="async"
             class="w-16 h-16 object-contain rounded-md bg-slate-50 p-2 mx-auto mb-3 border border-slate-100 group-hover:scale-105 transition-transform duration-300">
    @else
        <div class="w-16 h-16 mx-auto mb-3 rounded-lg bg-sky-50 border border-sky-200 flex items-center justify-center text-sky-700 font-bold text-xl shadow-2xs group-hover:scale-105 transition-transform duration-300" aria-hidden="true">
            {{ $initials }}
        </div>
    @endif

    <!-- Nama Bisnis -->
    <h3 class="text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug line-clamp-2">
        {{ $businessName }}
    </h3>

    @if(!empty($businessType))
        <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
            {{ $businessType }}
        </p>
    @endif

    <!-- Kemitraan -->
    <p class="text-[11px] font-bold text-amber-800 mt-1 uppercase tracking-wide">
        {{ $partnerLabel }}
    </p>

    <!-- Lokasi -->
    @if(!empty($location))
        <p class="text-[11px] text-slate-500 mt-1 flex items-center justify-center gap-1 font-medium">
            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="truncate max-w-[200px]">{{ $location }}</span>
        </p>
    @endif

    <!-- Layanan -->
    @if(count($servicesList) > 0)
        <p class="text-[11px] text-slate-500 mt-2.5 pt-2 border-t border-slate-100 truncate">
            {!! implode(' &bull; ', array_map('e', $servicesList)) !!}
        </p>
    @endif

</a>

