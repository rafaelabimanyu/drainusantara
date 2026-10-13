@extends('layouts.admin')

@section('title', 'Kelola Portofolio')
@section('page-title', 'Portofolio Restoran & Klien')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Portofolio Restoran &amp; Klien</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar portofolio restoran, tempat usaha, dan klien komersial yang telah ditangani.</p>
        </div>
        <a href="{{ route('admin.portfolios.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Portofolio</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-xs uppercase font-bold text-slate-700 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Foto</th>
                        <th class="px-5 py-3.5">Nama Restoran / Klien</th>
                        <th class="px-5 py-3.5">Lokasi &amp; Kategori</th>
                        <th class="px-5 py-3.5">Status &amp; Urutan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($portfolios as $portfolio)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="w-14 h-11 rounded-md overflow-hidden border border-slate-200 bg-slate-100 relative shadow-2xs">
                                <img src="{{ $portfolio->image ?: asset('images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp') }}" 
                                     alt="{{ $portfolio->client_name }}" 
                                     width="56"
                                     height="44"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-900 text-sm">{{ $portfolio->client_name }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                ID: #{{ $portfolio->id }}
                            </div>
                        </td>
                        <td class="px-5 py-3.5 max-w-xs">
                            <div class="text-xs text-slate-700 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $portfolio->location ?? 'Jabodetabek' }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $portfolio->client_type ?? 'Restoran & F&B' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($portfolio->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Tampil
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Disembunyikan
                                    </span>
                                @endif
                                <span class="text-xs text-slate-400 font-mono">#{{ $portfolio->order }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1.5">
                            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
                               class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold" title="Edit Portofolio">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio \'{{ $portfolio->client_name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold cursor-pointer" title="Hapus Portofolio">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-xs">
                            Belum ada portofolio tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($portfolios->hasPages())
        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
            {{ $portfolios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
