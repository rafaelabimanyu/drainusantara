@extends('layouts.admin')

@section('title', 'Kelola Galeri & Portofolio')
@section('page-title', 'Galeri & Portofolio Proyek')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-slate-500">Kelola dokumentasi pengerjaan sebelum dan sesudah untuk meyakinkan calon pelanggan.</p>
    </div>
    <a href="{{ route('admin.galleries.create') }}" 
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm shadow-sky-600/20">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Foto Galeri
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Foto Dokumentasi</th>
                    <th class="px-6 py-4">Judul & Kategori Layanan</th>
                    <th class="px-6 py-4">Deskripsi Hasil</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($galleries as $gallery)
                <tr class="hover:bg-slate-50/75 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if($gallery->before_image && $gallery->after_image)
                                <div class="relative group">
                                    <img src="{{ $gallery->before_image }}" alt="Sebelum" class="w-12 h-12 object-cover rounded-lg border border-slate-200 shadow-xs">
                                    <span class="absolute bottom-0 right-0 bg-slate-800 text-[9px] text-white px-1 rounded-tl font-bold">SEBELUM</span>
                                </div>
                                <div class="relative group">
                                    <img src="{{ $gallery->after_image }}" alt="Sesudah" class="w-12 h-12 object-cover rounded-lg border border-sky-300 shadow-xs">
                                    <span class="absolute bottom-0 right-0 bg-sky-600 text-[9px] text-white px-1 rounded-tl font-bold">SESUDAH</span>
                                </div>
                            @elseif($gallery->image)
                                <img src="{{ $gallery->image }}" alt="{{ $gallery->title }}" class="w-16 h-12 object-cover rounded-lg border border-slate-200 shadow-xs">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $gallery->title }}</div>
                        <div class="text-xs text-sky-600 font-medium mt-0.5">
                            {{ $gallery->service ? $gallery->service->name : 'Layanan Umum' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-sm truncate text-slate-600 text-xs">
                        {{ $gallery->description ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($gallery->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Tampil
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                Disembunyikan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri \'{{ $gallery->title }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
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
                        Belum ada dokumentasi galeri proyek tersimpan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($galleries->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $galleries->links() }}
    </div>
    @endif
</div>
@endsection
