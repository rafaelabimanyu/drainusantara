@extends('layouts.admin')

@section('title', 'Kelola Portofolio Klien B2B')
@section('page-title', 'Portofolio Klien B2B & Komersial')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-slate-500">Kelola daftar portofolio perusahaan, perhotelan, restoran, dan gedung bertingkat untuk memperkuat kredibilitas.</p>
    </div>
    <a href="{{ route('admin.portfolios.create') }}" 
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm shadow-sky-600/20">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Klien B2B
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Foto Lokasi / Proyek</th>
                    <th class="px-6 py-4">Nama Perusahaan &amp; Sektor</th>
                    <th class="px-6 py-4">Lokasi &amp; Pengerjaan</th>
                    <th class="px-6 py-4">Status &amp; Urutan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($portfolios as $portfolio)
                <tr class="hover:bg-slate-50/75 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-12 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 relative group">
                            <img src="{{ $portfolio->image ?: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $portfolio->client_name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $portfolio->client_name }}</div>
                        <div class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                            {{ $portfolio->client_type ?? 'Komersial & B2B' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        <div class="text-xs font-semibold text-slate-800 line-clamp-1">
                            {{ $portfolio->project_title ?? '-' }}
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate">{{ $portfolio->location ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if($portfolio->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    Disembunyikan
                                </span>
                            @endif
                            <span class="text-xs text-slate-400 font-mono">#{{ $portfolio->order }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit Portofolio">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio klien \'{{ $portfolio->client_name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Portofolio">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <p class="font-medium text-slate-600">Belum ada portofolio klien B2B.</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol &ldquo;Tambah Klien B2B&rdquo; di atas untuk menambahkan klien pertama.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($portfolios->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $portfolios->links() }}
    </div>
    @endif
</div>
@endsection
