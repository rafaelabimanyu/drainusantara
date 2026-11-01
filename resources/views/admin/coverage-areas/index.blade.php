@extends('layouts.admin')

@section('title', 'Kelola Area Jangkauan')
@section('page-title', 'Area Jangkauan (SEO)')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Area Jangkauan & Landing SEO Lokal</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola direktori landing page provinsi, kota/kabupaten, dan area kawasan dengan pengaturan CMS lengkap.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <form action="{{ route('admin.coverage-areas.sync') }}" method="POST" class="inline" onsubmit="return confirm('Sinkronkan seluruh master wilayah (provinsi, kota, dan area) ke database? Data yang sudah diedit tidak akan tertimpa.');">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs sm:text-sm px-3.5 py-2.5 rounded-lg shadow-2xs transition-colors cursor-pointer" title="Periksa dan daftarkan wilayah master yang belum ada di database">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Sinkronkan Master Wilayah</span>
                </button>
            </form>
            <a href="{{ route('admin.coverage-areas.create') }}" class="inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-lg shadow-2xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Area Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter Tabs (Semua, Provinsi, Kota, Kecamatan) -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-2">
        <a href="{{ route('admin.coverage-areas.index', array_merge(request()->except(['type', 'page']))) }}" 
           class="px-3.5 py-2 rounded-lg text-xs font-bold transition-colors inline-flex items-center gap-2 {{ !request('type') ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>Semua Level</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] {{ !request('type') ? 'bg-slate-800 text-slate-200' : 'bg-slate-100 text-slate-600' }}">{{ $totalCount ?? 0 }}</span>
        </a>
        <a href="{{ route('admin.coverage-areas.index', array_merge(request()->except(['page']), ['type' => 'province'])) }}" 
           class="px-3.5 py-2 rounded-lg text-xs font-bold transition-colors inline-flex items-center gap-2 {{ request('type') === 'province' ? 'bg-indigo-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>Provinsi</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] {{ request('type') === 'province' ? 'bg-indigo-800 text-indigo-100' : 'bg-indigo-50 text-indigo-700' }}">{{ $provinceCount ?? 0 }}</span>
        </a>
        <a href="{{ route('admin.coverage-areas.index', array_merge(request()->except(['page']), ['type' => 'city'])) }}" 
           class="px-3.5 py-2 rounded-lg text-xs font-bold transition-colors inline-flex items-center gap-2 {{ request('type') === 'city' ? 'bg-sky-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>Kota / Kabupaten</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] {{ request('type') === 'city' ? 'bg-sky-800 text-sky-100' : 'bg-sky-50 text-sky-700' }}">{{ $cityCount ?? 0 }}</span>
        </a>
        <a href="{{ route('admin.coverage-areas.index', array_merge(request()->except(['page']), ['type' => 'district'])) }}" 
           class="px-3.5 py-2 rounded-lg text-xs font-bold transition-colors inline-flex items-center gap-2 {{ request('type') === 'district' ? 'bg-slate-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>Area / Kawasan</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] {{ request('type') === 'district' ? 'bg-slate-800 text-slate-200' : 'bg-slate-100 text-slate-600' }}">{{ $districtCount ?? 0 }}</span>
        </a>
    </div>

    <!-- Search & Filter Form -->
    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs">
        <form method="GET" action="{{ route('admin.coverage-areas.index') }}" class="flex flex-col sm:flex-row gap-2.5">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama area, kota, provinsi, atau slug..." class="w-full rounded-lg border border-slate-300 pl-9 pr-3.5 py-2 text-xs sm:text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            @if(isset($cities) && count($cities) > 0)
                <div class="sm:w-60">
                    <select name="city" onchange="this.form.submit()" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs sm:text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs bg-white text-slate-700">
                        <option value="">Semua Kota / Wilayah</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}" {{ request('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs sm:text-sm font-semibold hover:bg-slate-800 transition-colors cursor-pointer shadow-2xs">
                    Cari
                </button>
                @if(request('search') || request('city') || request('type'))
                    <a href="{{ route('admin.coverage-areas.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-200 transition-colors flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5">Level &amp; Nama Area</th>
                        <th scope="col" class="px-5 py-3.5">Induk / Wilayah</th>
                        <th scope="col" class="px-5 py-3.5">SEO Meta Title</th>
                        <th scope="col" class="px-5 py-3.5">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($coverageAreas as $area)
                        @php
                            $displayName = match($area->type) {
                                'province' => $area->province_name ?: $area->city,
                                'city' => $area->city,
                                default => $area->district,
                            };
                            $badgeType = match($area->type) {
                                'province' => ['label' => 'PROVINSI', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                                'city' => ['label' => 'KOTA / KAB', 'class' => 'bg-sky-50 text-sky-700 border-sky-200'],
                                default => ['label' => 'AREA', 'class' => 'bg-slate-100 text-slate-700 border-slate-200'],
                            };
                            $publicUrl = $area->publicUrl();
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $badgeType['class'] }}">
                                        {{ $badgeType['label'] }}
                                    </span>
                                    <span class="font-bold text-slate-900 text-sm">{{ $displayName }}</span>
                                </div>
                                @if($publicUrl)
                                    <div class="text-[11px] text-sky-700 font-mono mt-1 truncate max-w-md">
                                        {{ parse_url($publicUrl, PHP_URL_PATH) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-xs font-medium text-slate-700">
                                @if($area->type === 'province')
                                    <span class="text-slate-400 italic">Regional Provinsi</span>
                                @elseif($area->type === 'city')
                                    <span>{{ $area->province_name ?: 'Provinsi' }}</span>
                                @else
                                    <span>{{ $area->city }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 max-w-xs truncate text-xs text-slate-600">
                                {{ $area->meta_title ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($area->is_active)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-right text-xs font-medium space-x-1.5">
                                @if($publicUrl)
                                    <a href="{{ $publicUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-slate-700 hover:bg-slate-100 border border-slate-200 px-2 py-1 rounded-md transition-colors" title="Buka halaman publik">
                                        <span>Lihat</span>
                                    </a>
                                @endif

                                <a href="{{ route('admin.coverage-areas.edit', $area) }}" class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors">
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.coverage-areas.destroy', $area) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus area {{ $displayName }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2 py-1 rounded-md transition-colors cursor-pointer">
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-xs">
                                Belum ada data area jangkauan untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($coverageAreas->hasPages())
            <div class="p-3 border-t border-slate-200 bg-slate-50">
                {{ $coverageAreas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
