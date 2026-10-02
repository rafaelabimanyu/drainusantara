@extends('layouts.admin')

@section('title', 'Kelola Galeri Proyek')
@section('page-title', 'Galeri & Portofolio Proyek')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Galeri Dokumentasi Pengerjaan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Dokumentasi foto sebelum dan sesudah (before-after) saluran pipa mampet.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Foto Galeri</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-xs uppercase font-bold text-slate-700 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Dokumentasi</th>
                        <th class="px-5 py-3.5">Judul &amp; Sektor</th>
                        <th class="px-5 py-3.5">Deskripsi Hasil</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($galleries as $gallery)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($gallery->image)
                                    <img src="{{ $gallery->image }}" alt="{{ $gallery->title }}" width="56" height="44" loading="lazy" decoding="async" class="w-14 h-11 object-cover rounded-md border border-slate-200 shadow-2xs">
                                @elseif($gallery->after_image)
                                    <img src="{{ $gallery->after_image }}" alt="{{ $gallery->title }}" width="56" height="44" loading="lazy" decoding="async" class="w-14 h-11 object-cover rounded-md border border-slate-200 shadow-2xs">
                                @elseif($gallery->before_image)
                                    <img src="{{ $gallery->before_image }}" alt="{{ $gallery->title }}" width="56" height="44" loading="lazy" decoding="async" class="w-14 h-11 object-cover rounded-md border border-slate-200 shadow-2xs">
                                @else
                                    <div class="w-11 h-11 rounded-md bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-900 text-sm">{{ $gallery->title }}</div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $gallery->category === 'b2b' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-sky-50 text-sky-800 border border-sky-200' }}">
                                    {{ $gallery->category === 'b2b' ? 'B2B Komersial' : 'Residensial' }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    {{ $gallery->service ? $gallery->service->name : 'Umum' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 max-w-sm truncate text-slate-600 text-xs">
                            {{ $gallery->description ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            @if($gallery->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    Disembunyikan
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1.5">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                               class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri \'{{ $gallery->title }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold cursor-pointer" title="Hapus">
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
                            Belum ada dokumentasi galeri proyek tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($galleries->hasPages())
        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
            {{ $galleries->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
