@props([
    'category' => '',
    'class' => 'w-5 h-5',
])

@php
    $key = strtolower(trim((string) $category));
@endphp

@if(str_contains($key, 'resto') || str_contains($key, 'fnb') || str_contains($key, 'kafe'))
    <!-- Restoran & FnB: Fork & Knife / Dining Utensils -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2M15 11v11M5 2v10a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V2M7 14v8"/>
    </svg>
@elseif(str_contains($key, 'ruko') || str_contains($key, 'komersial') || str_contains($key, 'toko'))
    <!-- Ruko & Komersial: Multi-Level Shophouse / Commercial Storefront -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 21V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v17M4 21h16M9 8h2m-2 4h2m-2 4h2m4-8h2m-2 4h2m-2 4h2M9 21v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
    </svg>
@elseif(str_contains($key, 'gedung') || str_contains($key, 'kantor') || str_contains($key, 'office'))
    <!-- Gedung & Perkantoran: High-rise Office Tower -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
    </svg>
@elseif(str_contains($key, 'pabrik') || str_contains($key, 'industri') || str_contains($key, 'gudang'))
    <!-- Pabrik & Pergudangan: Industrial Plant Factory -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 18h1M12 18h1M7 18h1"/>
    </svg>
@else
    <!-- Rumahan / Residensial Default: Residential Home -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
@endif

