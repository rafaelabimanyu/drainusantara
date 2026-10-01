@extends('layouts.admin')

@section('title', 'Kelola Staff & Teknisi')
@section('page-title', 'Staff & Teknisi Lapangan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Staff &amp; Teknisi Lapangan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola data profil tenaga kerja, staf, dan teknisi siaga yang tampil di halaman Tentang Kami.</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Staff</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-xs uppercase font-bold text-slate-700 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Foto / Avatar</th>
                        <th class="px-5 py-3.5">Nama Staff</th>
                        <th class="px-5 py-3.5">Peran &amp; Spesialisasi</th>
                        <th class="px-5 py-3.5">Status &amp; Urutan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($staffMembers as $staff)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 relative shadow-2xs flex items-center justify-center">
                                @if(!empty($staff->photo))
                                    <img src="{{ $staff->photo }}" 
                                         alt="{{ $staff->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-b from-sky-50 to-slate-100 text-sky-800">
                                        <svg class="w-6 h-6 text-sky-700/70" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-500 font-mono">{{ $staff->initials }}</span>
                                    </div>
                                @endif
                                <span class="absolute bottom-0.5 right-0.5 w-2 h-2 rounded-full {{ $staff->is_active ? 'bg-emerald-500' : 'bg-slate-300' }} border border-white"></span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-900 text-sm">{{ $staff->name }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Inisial: <span class="font-mono font-semibold text-slate-700">{{ $staff->initials }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 max-w-xs">
                            <div class="text-xs text-slate-800 font-medium">
                                {{ $staff->role ?? 'Teknisi Lapangan Siaga' }}
                            </div>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($staff->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Siaga Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                                <span class="text-xs text-slate-400 font-mono">#{{ $staff->order }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1.5">
                            <a href="{{ route('admin.staff.edit', $staff) }}" 
                               class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold" title="Edit Profil Staff">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus staff \'{{ $staff->name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold cursor-pointer" title="Hapus Staff">
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
                            Belum ada data staff tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($staffMembers->hasPages())
        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
            {{ $staffMembers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
