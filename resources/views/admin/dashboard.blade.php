@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                    Sistem Operasional
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Panel Kendali Drainusantara</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                Ringkasan Layanan &amp; Jangkauan
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl">
                Pantau katalog jasa pelancaran pipa, landing page SEO area, portofolio klien B2B, dan ulasan pelanggan.
            </p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-1.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm px-3.5 py-2 rounded-lg shadow-2xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Layanan</span>
            </a>
            <a href="{{ route('admin.coverage-areas.create') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm px-3.5 py-2 rounded-lg border border-slate-300 shadow-2xs transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Area</span>
            </a>
        </div>
    </div>

    <!-- Metric Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Card 1: Total Layanan -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Total Layanan</span>
                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center border border-sky-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_services'] }}</div>
                <div class="text-[11px] text-emerald-700 font-semibold mt-0.5">{{ $stats['active_services'] }} Aktif</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.services.index') }}" class="text-[11px] font-semibold text-sky-700 hover:text-sky-800 flex items-center justify-between">
                    <span>Kelola</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Card 2: Area Jangkauan -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Area Jangkauan (SEO)</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_coverage_areas'] }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Area / Kota</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.coverage-areas.index') }}" class="text-[11px] font-semibold text-emerald-700 hover:text-emerald-800 flex items-center justify-between">
                    <span>Kelola SEO</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Card 3: Galeri Proyek -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Galeri Foto</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_galleries'] }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Dokumentasi Kerja</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.galleries.index') }}" class="text-[11px] font-semibold text-indigo-700 hover:text-indigo-800 flex items-center justify-between">
                    <span>Kelola</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Card 4: Peralatan & Armada -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Peralatan</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_equipments'] ?? 0 }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Unit Spiral &amp; Mesin</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.equipments.index') }}" class="text-[11px] font-semibold text-slate-700 hover:text-slate-900 flex items-center justify-between">
                    <span>Kelola</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Card 5: Artikel Edukasi -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Artikel</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center border border-amber-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_articles'] }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Tips &amp; Panduan</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.articles.index') }}" class="text-[11px] font-semibold text-amber-700 hover:text-amber-800 flex items-center justify-between">
                    <span>Kelola</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Card 6: Ulasan & Testimoni -->
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Ulasan</span>
                <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center border border-teal-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_reviews'] ?? 0 }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Ulasan Masuk</div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.reviews.index') }}" class="text-[11px] font-semibold text-teal-700 hover:text-teal-800 flex items-center justify-between">
                    <span>Kelola</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Panel -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-3">
            Aksi Cepat Tambah Data
        </p>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Layanan Baru</span>
            </a>
            <a href="{{ route('admin.coverage-areas.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Area SEO Baru</span>
            </a>
            <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Foto Galeri</span>
            </a>
            <a href="{{ route('admin.portfolios.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Portofolio B2B</span>
            </a>
            <a href="{{ route('admin.equipments.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Peralatan Mesin</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tulis Artikel</span>
            </a>
            <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg border border-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Testimoni Baru</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Overview Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 1. Katalog Layanan -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
            <div class="p-4 sm:p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h2 class="font-bold text-slate-900 text-sm sm:text-base">Katalog Layanan Terdaftar</h2>
                    <p class="text-xs text-slate-500">Layanan pelancaran pipa dengan estimasi biaya</p>
                </div>
                <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-sky-700 hover:text-sky-800">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentServices as $service)
                    <div class="p-3.5 sm:p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-7 h-7 rounded-md bg-sky-50 text-sky-700 border border-sky-100 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ $loop->iteration }}
                            </span>
                            <div class="truncate">
                                <div class="font-bold text-slate-900 text-sm truncate">{{ $service->name }}</div>
                                <div class="text-xs text-slate-500">Mulai: Rp {{ number_format($service->price_starting_from, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-xs font-semibold text-slate-700 hover:text-sky-700 px-2.5 py-1.5 rounded-md bg-white hover:bg-slate-50 border border-slate-200 shrink-0">
                            Edit
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-500 text-xs">Belum ada data layanan terdaftar.</div>
                @endforelse
            </div>
        </div>

        <!-- 2. Area Jangkauan Terkini -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
            <div class="p-4 sm:p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h2 class="font-bold text-slate-900 text-sm sm:text-base">Area Jangkauan (SEO Wilayah)</h2>
                    <p class="text-xs text-slate-500">Wilayah operasional teknisi dan target landing page</p>
                </div>
                <a href="{{ route('admin.coverage-areas.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentAreas as $area)
                    <div class="p-3.5 sm:p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="min-w-0">
                            <div class="font-bold text-slate-900 text-sm truncate">{{ $area->district }}</div>
                            <div class="text-xs text-slate-500 truncate">{{ $area->city }}</div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($area->publicUrl())
                                <a href="{{ $area->publicUrl() }}" target="_blank" rel="noopener noreferrer" class="text-xs font-medium text-slate-600 hover:text-sky-700 px-2.5 py-1 bg-white hover:bg-slate-50 border border-slate-200 rounded-md">
                                    Live
                                </a>
                            @endif
                            <a href="{{ route('admin.coverage-areas.edit', $area) }}" class="text-xs font-semibold text-slate-700 hover:text-emerald-700 px-2.5 py-1 bg-white hover:bg-slate-50 border border-slate-200 rounded-md">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-500 text-xs">Belum ada area terdaftar.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
