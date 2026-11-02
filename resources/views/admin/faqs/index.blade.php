@extends('layouts.admin')

@section('title', 'Kelola FAQ (Tanya Jawab)')
@section('page-title', 'Kelola FAQ')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Pusat Tanya Jawab (FAQ)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola pertanyaan umum seputar teknis pipa, transparansi biaya, garansi, dan SOP untuk halaman publik dan homepage.</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-lg shadow-2xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah FAQ Baru</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.faqs.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan / jawaban..." 
                       class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <div class="w-full sm:w-48">
                <select name="category" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-white">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $catKey => $catLabel)
                        <option value="{{ $catKey }}" {{ $category === $catKey ? 'selected' : '' }}>{{ $catLabel }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-semibold transition-colors">
                Filter
            </button>
            @if($search || ($category && $category !== 'all'))
                <a href="{{ route('admin.faqs.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
            @endif
        </form>

        <div class="text-xs text-slate-500 font-medium whitespace-nowrap self-end md:self-center">
            Total: <strong class="text-slate-900">{{ $faqs->total() }}</strong> pertanyaan
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 w-16">Urutan</th>
                        <th scope="col" class="px-5 py-3.5 w-44">Kategori</th>
                        <th scope="col" class="px-5 py-3.5">Pertanyaan &amp; Jawaban</th>
                        <th scope="col" class="px-5 py-3.5 w-28 text-center">Homepage</th>
                        <th scope="col" class="px-5 py-3.5 w-28 text-center">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-400">
                                #{{ $faq->order }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-sky-50 text-sky-800 border border-sky-200">
                                    {{ $faq->category_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900 text-sm line-clamp-1 mb-1">{{ $faq->question }}</div>
                                <div class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $faq->answer }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                @if($faq->is_featured)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        ★ Featured
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.faqs.toggle', $faq) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold transition-colors cursor-pointer {{ $faq->is_active ? 'bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-300 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $faq->is_active ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                                        <span>{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" 
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-sky-700 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 transition-colors"
                                       title="Edit FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 rounded-lg text-slate-600 hover:text-rose-700 hover:bg-rose-50 border border-slate-200 hover:border-rose-300 transition-colors cursor-pointer"
                                                title="Hapus FAQ">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-semibold text-slate-600">Belum ada data FAQ</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah FAQ Baru" untuk membuat tanya jawab pertama.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

