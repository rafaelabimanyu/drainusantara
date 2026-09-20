@extends('layouts.admin')

@section('title', 'Daftar Layanan')
@section('page-title', 'Kelola Layanan')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Katalog Layanan Pipa Mampet</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola daftar layanan saluran, harga mulai, dan rincian penanganan.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-md shadow-sky-600/20 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Urutan</th>
                        <th scope="col" class="px-6 py-4">Nama Layanan</th>
                        <th scope="col" class="px-6 py-4">Harga Mulai Dari</th>
                        <th scope="col" class="px-6 py-4">Fitur Utama</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($services as $service)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-400">
                                #{{ $service->order }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-base">{{ $service->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $service->short_description }}</div>
                                <div class="text-[11px] text-sky-600 font-mono mt-1">slug: /layanan#{{ $service->slug }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900 whitespace-nowrap">
                                @if($service->price_starting_from)
                                    Rp {{ number_format($service->price_starting_from, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-400">Hubungi Kami</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(!empty($service->features) && is_array($service->features))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($service->features, 0, 2) as $feat)
                                            <span class="inline-block bg-slate-100 text-slate-700 text-[11px] px-2 py-0.5 rounded-md font-medium">
                                                {{ $feat }}
                                            </span>
                                        @endforeach
                                        @if(count($service->features) > 2)
                                            <span class="text-[10px] text-slate-400 self-center">+{{ count($service->features) - 2 }} lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->is_active)
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
                                <a href="{{ route('admin.services.edit', $service) }}" class="inline-flex items-center gap-1 bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-600 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan {{ $service->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data layanan. Klik tombol <strong>Tambah Layanan Baru</strong> di atas untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
