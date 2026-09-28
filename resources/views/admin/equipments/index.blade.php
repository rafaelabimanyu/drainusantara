@extends('layouts.admin')

@section('title', 'Kelola Peralatan & Mesin')
@section('page-title', 'Peralatan & Mesin Armada')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-slate-500">Kelola daftar unit mesin pelancar saluran, kamera CCTV pipa, hydro jetting, dan mata cutter teknisi di lapangan.</p>
    </div>
    <a href="{{ route('admin.equipments.create') }}" 
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm shadow-sky-600/20">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Peralatan
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Foto Alat</th>
                    <th class="px-6 py-4">Nama Peralatan &amp; Kategori</th>
                    <th class="px-6 py-4">Badge / Keunggulan</th>
                    <th class="px-6 py-4">Status &amp; Urutan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($equipments as $equipment)
                <tr class="hover:bg-slate-50/75 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-20 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-900 relative">
                            <img src="{{ $equipment->image ?: asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}" 
                                 alt="{{ $equipment->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}';">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $equipment->name }}</div>
                        <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                            {{ $equipment->short_description ?? '-' }}
                        </div>
                        @if($equipment->category)
                        <div class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $equipment->category }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($equipment->badge)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                {{ $equipment->badge }}
                            </span>
                        @else
                            <span class="text-slate-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if($equipment->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    Disembunyikan
                                </span>
                            @endif
                            <span class="text-xs text-slate-400 font-mono">#{{ $equipment->order }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.equipments.edit', $equipment) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit Peralatan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.equipments.destroy', $equipment) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus peralatan \'{{ $equipment->name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Peralatan">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="font-medium text-slate-600">Belum ada peralatan yang ditambahkan</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Peralatan" untuk menambahkan unit mesin pertama Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($equipments->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $equipments->links() }}
    </div>
    @endif
</div>
@endsection
