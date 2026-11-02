@extends('layouts.admin')

@section('title', 'Pesan Masuk Permohonan Layanan')
@section('page-title', 'Pesan Masuk (Form Kontak)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Pesan Masuk &amp; Permohonan Layanan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar pelanggan yang mengisi form pemesanan dan permohonan kunjungan teknisi pipa mampet.</p>
        </div>
        <div class="flex items-center gap-2">
            @if($counts['new'] > 0)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>{{ $counts['new'] }} Pesan Baru Menunggu Follow Up</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-1.5">
            <a href="{{ route('admin.contacts.index') }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ !request()->has('status') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ $counts['total'] }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'new']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ request('status') === 'new' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Baru ({{ $counts['new'] }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'in_progress']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ request('status') === 'in_progress' ? 'bg-sky-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Diproses ({{ $counts['in_progress'] }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'completed']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ request('status') === 'completed' ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai ({{ $counts['completed'] }})
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, no WA, kota..."
                   class="text-xs rounded-lg border border-slate-300 px-3 py-1.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-300 transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.contacts.index', request()->only('status')) }}" class="text-xs text-rose-600 hover:underline">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5">Tanggal</th>
                        <th scope="col" class="px-5 py-3.5">Pelanggan</th>
                        <th scope="col" class="px-5 py-3.5">Wilayah</th>
                        <th scope="col" class="px-5 py-3.5">Layanan &amp; Properti</th>
                        <th scope="col" class="px-5 py-3.5">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $msg->status === 'new' ? 'bg-amber-50/40' : '' }}">
                            <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500">
                                <div class="font-bold text-slate-700">{{ $msg->created_at->format('d M Y') }}</div>
                                <div>{{ $msg->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900">{{ $msg->name }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $msg->phone }}</div>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $msg->city ?: '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $msg->district }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-sky-800 block text-xs">{{ $msg->service_type ?: 'Pipa Mampet' }}</span>
                                <span class="text-xs text-slate-500 block">{{ $msg->property_type }}</span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($msg->status === 'new')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Baru</span>
                                    </span>
                                @elseif($msg->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        <span>Diproses</span>
                                    </span>
                                @elseif($msg->status === 'completed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Selesai</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        Batal
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ $msg->whats_app_reply_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg border border-emerald-300 transition-colors"
                                       title="Balas cepat via WhatsApp">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        <span>WA</span>
                                    </a>
                                    <a href="{{ route('admin.contacts.show', $msg) }}" 
                                       class="inline-flex items-center gap-1 text-xs font-bold text-sky-700 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg border border-sky-200 transition-colors">
                                        <span>Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                Tidak ada pesan masuk yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="px-5 py-3 border-t border-slate-200">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

