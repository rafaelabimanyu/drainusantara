@extends('layouts.admin')

@section('title', 'Kelola Area Jangkauan')
@section('page-title', 'Area Jangkauan (SEO)')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Area Jangkauan & Landing SEO Lokal</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola direktori kota, kecamatan, dan optimasi tag meta SEO per wilayah.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.create') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Area Baru</span>
        </a>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
        <form method="GET" action="{{ route('admin.coverage-areas.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kota, kecamatan, atau slug..." class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="px-5 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-sm font-semibold hover:bg-slate-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Kecamatan</th>
                        <th scope="col" class="px-6 py-4">Kota / Wilayah</th>
                        <th scope="col" class="px-6 py-4">SEO Meta Title</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($coverageAreas as $area)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-base">{{ $area->district }}</div>
                                <div class="text-[11px] text-sky-600 font-mono mt-0.5">/area/{{ Str::slug($area->city) }}/{{ Str::slug($area->district) }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 text-xs font-bold">
                                    {{ $area->city }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-xs text-slate-600">
                                {{ $area->meta_title ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($area->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-2">
                                <a href="{{ url('/area/' . Str::slug($area->city) . '/' . Str::slug($area->district)) }}" target="_blank" class="inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <span>Lihat</span>
                                </a>

                                <a href="{{ route('admin.coverage-areas.edit', $area) }}" class="inline-flex items-center gap-1 bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-600 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.coverage-areas.destroy', $area) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus area {{ $area->district }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg transition-colors">
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada area jangkauan yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($coverageAreas->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $coverageAreas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
