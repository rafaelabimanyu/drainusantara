@extends('layouts.admin')

@section('title', 'Daftar Testimoni & Ulasan')
@section('page-title', 'Kelola Ulasan Pelanggan')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Testimoni &amp; Ulasan Pelanggan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola bukti kepuasan pelanggan yang ditampilkan pada landing page dan halaman wilayah.</p>
        </div>
        <a href="{{ route('admin.reviews.create') }}" class="inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-lg shadow-2xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Testimoni</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-2xs">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label for="rating-filter" class="text-xs font-bold text-slate-700">Rating:</label>
                <select id="rating-filter" name="rating" onchange="this.form.submit()" class="text-xs rounded-lg border border-slate-300 py-1.5 px-3 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white shadow-2xs">
                    <option value="">Semua Rating</option>
                    @for($r = 5; $r >= 1; $r--)
                        <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>★ {{ $r }} Bintang</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label for="status-filter" class="text-xs font-bold text-slate-700">Status:</label>
                <select id="status-filter" name="status" onchange="this.form.submit()" class="text-xs rounded-lg border border-slate-300 py-1.5 px-3 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white shadow-2xs">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            @if(request()->filled('rating') || request()->filled('status'))
                <a href="{{ route('admin.reviews.index') }}" class="text-xs text-sky-700 hover:text-sky-800 font-semibold underline ml-auto">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-slate-700 font-bold text-xs uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-5 py-3.5">Pelanggan</th>
                        <th scope="col" class="px-5 py-3.5">Rating &amp; Komentar</th>
                        <th scope="col" class="px-5 py-3.5">Layanan Terkait</th>
                        <th scope="col" class="px-5 py-3.5">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-800 font-bold text-xs flex items-center justify-center shrink-0 border border-sky-200">
                                        {{ strtoupper(substr($review->customer_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $review->customer_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $review->customer_role_or_location ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-1 text-amber-500 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-amber-400 text-amber-400' : 'fill-slate-200 text-slate-200' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="text-[11px] font-bold text-slate-700 ml-1">({{ $review->rating }}/5)</span>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-md">"{{ $review->comment }}"</p>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($review->service)
                                    <span class="inline-block bg-slate-100 text-slate-800 text-[11px] px-2 py-0.5 rounded-md font-medium border border-slate-200">
                                        {{ $review->service->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Umum / Semua</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($review->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-right text-xs font-medium space-x-1.5">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni dari {{ $review->customer_name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-xs">
                                Belum ada testimoni pelanggan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
