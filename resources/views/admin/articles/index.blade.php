@extends('layouts.admin')

@section('title', 'Kelola Artikel & Edukasi')
@section('page-title', 'Daftar Artikel & Edukasi Plumbing')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Artikel &amp; Edukasi Plumbing</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola artikel edukatif untuk meningkatkan pencarian organik Google dan kepercayaan pelanggan.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-xs uppercase font-bold text-slate-700 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Thumbnail</th>
                        <th class="px-5 py-3.5">Judul &amp; Kategori</th>
                        <th class="px-5 py-3.5">Ringkasan</th>
                        <th class="px-5 py-3.5">Status &amp; Tanggal</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $article)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <img src="{{ $article->thumbnail ?: 'https://placehold.co/100x70/0284c7/ffffff?text=Artikel' }}" 
                                 alt="{{ $article->title }}" 
                                 width="64"
                                 height="44"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-16 h-11 object-cover rounded-md border border-slate-200 shadow-2xs">
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-900 text-sm">{{ $article->title }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $article->category ?? 'Umum' }}
                                </span>
                                <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="text-xs text-slate-500 hover:text-sky-700 font-mono">
                                    /artikel/{{ $article->slug }} ↗
                                </a>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 max-w-xs truncate text-slate-600 text-xs">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 80) }}
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            @if($article->is_published)
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Terbit
                                </span>
                                <div class="text-[11px] text-slate-500 mt-1">
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                </div>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                    Draf
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1.5">
                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-slate-700 hover:bg-slate-100 border border-slate-200 px-2 py-1 rounded-md transition-colors text-xs font-semibold" title="Lihat di Web">
                                <span>Lihat</span>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article) }}" 
                               class="inline-flex items-center gap-1 text-sky-700 hover:bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold" title="Edit">
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel \'{{ $article->title }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md transition-colors text-xs font-semibold cursor-pointer" title="Hapus">
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-xs">
                            Belum ada artikel yang ditulis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
