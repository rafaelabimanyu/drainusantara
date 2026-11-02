@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang Kami')
@section('page-title', 'Halaman Tentang Kami')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Halaman Tentang Kami</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola konten, metadata SEO, dan detail section untuk 7 sub-halaman profil dan operasional Drainusantara.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                <span>{{ $pages->count() }} Sub-Halaman Terkonfigurasi</span>
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5">Key / ID</th>
                        <th scope="col" class="px-5 py-3.5">Judul Halaman</th>
                        <th scope="col" class="px-5 py-3.5">URL Publik</th>
                        <th scope="col" class="px-5 py-3.5">Pembaruan Terakhir</th>
                        <th scope="col" class="px-5 py-3.5">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($pages as $page)
                        @php
                            $publicUrl = match($page->page_key) {
                                'profil' => route('about.profile'),
                                'cara-kerja' => route('how-it-works'),
                                'holding' => route('about.holding'),
                                'sop-k3' => route('about.k3'),
                                'peralatan' => route('about.equipment'),
                                'kemitraan' => route('about.portfolio'),
                                'garansi' => route('about.warranty'),
                                default => route('about'),
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 font-mono font-bold text-slate-500">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-xs">
                                    {{ $page->page_key }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900 text-sm">{{ $page->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $page->subtitle }}</div>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <a href="{{ $publicUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs text-sky-700 hover:text-sky-800 font-medium">
                                    <span>Lihat Halaman</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-500 whitespace-nowrap">
                                {{ $page->updated_at?->diffForHumans() ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if($page->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Non-Aktif</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.company-pages.edit', $page) }}" 
                                   class="inline-flex items-center gap-1 text-xs font-bold text-sky-700 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-lg border border-sky-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit Konten & SEO</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

