@props([
    'catalog',
    'locationName' => '',
    'whatsappNumber' => '',
    'whatsappText' => null,
    'areaPrice' => 0,
    'buttonText' => 'Pesan via WhatsApp',
])

@php
    $isModel = $catalog instanceof \App\Models\Service;
    $title = $isModel ? $catalog->name : ($catalog['name'] ?? ($catalog['title'] ?? 'Layanan Saluran Pipa'));
    $slug = $isModel ? $catalog->slug : ($catalog['slug'] ?? \Illuminate\Support\Str::slug($title));
    $category = $isModel ? ($catalog->category ?? 'LAYANAN UTAMA') : ($catalog['category'] ?? 'LAYANAN UTAMA');
    $desc = $isModel 
        ? ($catalog->short_description ?: ($catalog->description ?: 'Pelancaran saluran pipa mampet tanpa bongkar keramik.')) 
        : ($catalog['short_description'] ?? ($catalog['desc'] ?? 'Pelancaran saluran pipa mampet tanpa bongkar keramik.'));
    
    $rawPrice = $isModel ? $catalog->price_starting_from : ($catalog['price_starting_from'] ?? ($catalog['price'] ?? 0));
    $price = ($rawPrice > 0) ? $rawPrice : $areaPrice;

    $rawImage = $isModel ? $catalog->image : ($catalog['image'] ?? null);
    $fallbackImage = asset('assets/placeholders/service.svg');
    if (empty($rawImage) || str_contains($rawImage, 'placehold.co') || str_contains($rawImage, 'unsplash.com')) {
        $imageSrc = $fallbackImage;
    } else {
        $imageSrc = str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')
            ? $rawImage : asset(ltrim($rawImage, '/'));
    }

    $cleanWaNumber = preg_replace('/[^0-9]/', '', $whatsappNumber ?: config('drainusantara.contact.whatsapp_number', '6281234567890'));
    $msg = $whatsappText ?: ("Halo teknisi Drainusantara, saya butuh perbaikan " . $title . ($locationName ? " di area {$locationName}" : "") . ". Mohon info estimasi biaya.");
    $itemWaUrl = "https://wa.me/{$cleanWaNumber}?text=" . urlencode($msg);
@endphp

<div class="service-card bg-white rounded-xl border border-slate-200 p-3.5 sm:p-4 flex flex-col justify-between shadow-2xs hover:border-sky-400 hover:shadow-xs transition-all duration-200 group h-full">
    <div>
        <div class="relative w-full aspect-16/10 rounded-lg overflow-hidden bg-slate-100 mb-3 border border-slate-100">
            <img src="{{ $imageSrc }}" 
                 alt="{{ $title }}" 
                 width="600"
                 height="375"
                 loading="lazy" 
                 decoding="async"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out"
                 onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">
        </div>
        <span class="text-[10px] sm:text-[11px] font-bold text-sky-800 uppercase tracking-wider block mb-1 truncate">
            {{ $category }}
        </span>
        <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5 tracking-tight leading-snug group-hover:text-sky-700 transition-colors line-clamp-2">
            {{ $title }}
        </h3>
        <p class="text-xs text-slate-600 leading-relaxed line-clamp-2 mb-2">
            {{ $desc }}
        </p>
    </div>
    <div class="mt-2.5 sm:mt-3 pt-2.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
        <div class="min-w-0 pr-1">
            <span class="text-[10px] sm:text-[11px] text-slate-500 font-medium block leading-tight">Estimasi Biaya:</span>
            <span class="text-xs sm:text-base font-extrabold text-slate-900 tracking-tight truncate block">
                {{ ($isModel && $catalog->price_starting_from === 0) ? 'Hubungi untuk harga' : ($price > 0 ? 'Mulai Rp ' . number_format($price, 0, ',', '.') : 'Hubungi untuk harga') }}
            </span>
            <span class="text-[9px] sm:text-[10px] font-semibold text-emerald-700 block leading-tight mt-0.5">No Cure No Pay • Garansi 30 Hari</span>
        </div>
        <a href="{{ $itemWaUrl }}" target="_blank" rel="noopener noreferrer" 
           class="min-h-10 shrink-0 inline-flex items-center justify-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-[11px] sm:text-xs py-2 px-3 rounded-lg shadow-2xs transition-all focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            <span>{{ $buttonText }}</span>
        </a>
    </div>
</div>

