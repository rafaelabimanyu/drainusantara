@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page-title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header Banner -->
    <div class="rounded-3xl bg-gradient-to-r from-sky-600 via-sky-700 to-slate-900 text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="relative max-w-2xl">
            <span class="px-3 py-1 rounded-full bg-white/20 text-sky-100 text-xs font-semibold backdrop-blur-xs mb-3 inline-block">
                CMS Panel &bull; Drainusantara
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Selamat Datang di Admin Dashboard
            </h1>
            <p class="text-sm sm:text-base text-sky-100 mt-2 leading-relaxed">
                Kelola katalog layanan saluran mampet, kelola halaman SEO area kecamatan dinamis, dan pantau performa visibilitas website Drainusantara.
            </p>
        </div>
    </div>

    <!-- Metric Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Layanan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Layanan</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900">{{ $stats['total_services'] }}</span>
                <span class="text-xs font-medium text-emerald-600">({{ $stats['active_services'] }} Aktif)</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.services.index') }}" class="font-semibold text-sky-600 hover:text-sky-700">Kelola layanan &rarr;</a>
            </div>
        </div>

        <!-- Card 2: Total Area Jangkauan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Area Jangkauan (SEO)</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900">{{ $stats['total_coverage_areas'] }}</span>
                <span class="text-xs text-slate-500">Kecamatan/Kota</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.coverage-areas.index') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Kelola area &rarr;</a>
            </div>
        </div>

        <!-- Card 3: Galeri & Portofolio -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Galeri & Portofolio</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900">{{ $stats['total_galleries'] }}</span>
                <span class="text-xs text-slate-500">Dokumentasi</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.galleries.index') }}" class="font-semibold text-purple-600 hover:text-purple-700">Kelola galeri &rarr;</a>
            </div>
        </div>

        <!-- Card 4: Artikel & Edukasi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Artikel Edukasi</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900">{{ $stats['total_articles'] }}</span>
                <span class="text-xs text-slate-500">Tips & Panduan</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.articles.index') }}" class="font-semibold text-amber-600 hover:text-amber-700">Kelola artikel &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Quick Action Shortcut Buttons -->
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Layanan Baru</span>
        </a>

        <a href="{{ route('admin.coverage-areas.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Area Kecamatan</span>
        </a>

        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Foto Galeri</span>
        </a>

        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tulis Artikel Baru</span>
        </a>

        <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Pratinjau Website</span>
        </a>
    </div>

    <!-- 2 Column Overview Table -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- 1. Katalog Layanan -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Katalog Layanan Aktif</h3>
                    <p class="text-xs text-slate-500">Daftar layanan saluran mampet bergaransi 30 hari</p>
                </div>
                <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-sky-600 hover:text-sky-700">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentServices as $service)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $service->name }}</div>
                                <div class="text-xs text-slate-500">Mulai: Rp {{ number_format($service->price_starting_from, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-xs font-semibold text-slate-600 hover:text-sky-600 p-2 rounded-lg bg-slate-100 hover:bg-slate-200">
                            Edit
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada layanan terdaftar.</div>
                @endforelse
            </div>
        </div>

        <!-- 2. Area Jangkauan Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Area Jangkauan (SEO Lokal)</h3>
                    <p class="text-xs text-slate-500">Wilayah kecamatan & kota operasional teknisi</p>
                </div>
                <a href="{{ route('admin.coverage-areas.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentAreas as $area)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $area->district }}</div>
                            <div class="text-xs text-slate-500">{{ $area->city }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ url('/area/' . Str::slug($area->city) . '/' . Str::slug($area->district)) }}" target="_blank" class="text-xs text-slate-500 hover:text-sky-600 px-2 py-1 bg-slate-100 rounded-md">
                                Live Preview
                            </a>
                            <a href="{{ route('admin.coverage-areas.edit', $area) }}" class="text-xs text-slate-600 hover:text-emerald-600 px-2 py-1 bg-slate-100 rounded-md">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada area terdaftar.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
