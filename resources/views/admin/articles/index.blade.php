@extends('layouts.admin')

@section('title', 'Kelola Artikel & Edukasi')
@section('page-title', 'Daftar Artikel & Edukasi Plumbing')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-slate-500">Kelola artikel edukatif untuk meningkatkan organic search SEO dan trust pelanggan.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" 
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm shadow-sky-600/20">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tulis Artikel Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Thumbnail</th>
                    <th class="px-6 py-4">Judul Artikel & Kategori</th>
                    <th class="px-6 py-4">Ringkasan / Excerpt</th>
                    <th class="px-6 py-4">Status & Tanggal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($articles as $article)
                <tr class="hover:bg-slate-50/75 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ $article->thumbnail ?: 'https://placehold.co/100x70/0284c7/ffffff?text=Artikel' }}" 
                             alt="{{ $article->title }}" 
                             class="w-16 h-12 object-cover rounded-lg border border-slate-200">
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $article->title }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                {{ $article->category ?? 'Umum' }}
                            </span>
                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="text-xs text-slate-400 hover:text-sky-600 font-mono">
                                /artikel/{{ $article->slug }} ↗
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-xs truncate text-slate-600 text-xs">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 80) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($article->is_published)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Terbit
                            </span>
                            <div class="text-[11px] text-slate-400 mt-1">
                                {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                            </div>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                Draf
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Lihat di Web">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel \'{{ $article->title }}\'?');">
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
                        Belum ada artikel yang ditulis.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
