@extends('layouts.admin')

@section('title', 'Kategori & Sub-Kategori Artikel')
@section('page-title', 'Digital Taxonomy - Kategori Artikel')

@section('content')
<div class="space-y-6" x-data="categoryManager()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kategori &amp; Sub-Kategori Artikel</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Struktur taksonomi konten untuk URL Silo SEO (<code>/edukasi/{kategori}/{sub-kategori}/{slug}</code>) dan navigasi edukasi.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.articles.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Daftar Artikel</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold transition-colors shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tulis Artikel</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Kategori Utama (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Form Tambah Kategori -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-2xs">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900">Tambah Kategori Utama</h2>
                    </div>
                </div>

                <form action="{{ route('admin.article-categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="cat-name" class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" id="cat-name" name="name" required placeholder="Contoh: Edukasi, Penguatan Brand"
                               class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 bg-white">
                    </div>

                    <div>
                        <label for="cat-slug" class="block text-xs font-bold text-slate-700 mb-1">Slug URL <span class="text-slate-400 font-normal">(opsional, auto dari nama)</span></label>
                        <input type="text" id="cat-slug" name="slug" placeholder="contoh: edukasi"
                               class="w-full px-3 py-2 text-xs sm:text-sm font-mono rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 bg-white">
                    </div>

                    <div>
                        <label for="cat-desc" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea id="cat-desc" name="description" rows="2" placeholder="Penjelasan singkat fokus topik kategori ini..."
                                  class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 bg-white"></textarea>
                    </div>

                    <div>
                        <label for="cat-sort" class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Sort Order)</label>
                        <input type="number" id="cat-sort" name="sort_order" value="0" min="0"
                               class="w-24 px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 bg-white">
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs rounded-lg transition-colors shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Kategori</span>
                    </button>
                </form>
            </div>

            <!-- Daftar Kategori Utama -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
                <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Daftar Kategori Utama ({{ $categories->count() }})</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                    <div class="p-4 hover:bg-slate-50/60 transition-colors flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-slate-900">{{ $category->name }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-slate-100 text-slate-600 border border-slate-200">{{ $category->slug }}</span>
                            </div>
                            @if($category->description)
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $category->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-500">
                                <span><strong class="text-slate-700">{{ $category->subcategories->count() }}</strong> Sub-Kategori</span>
                                <span>&bull;</span>
                                <span><strong class="text-slate-700">{{ $category->articles_count }}</strong> Artikel</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" @click="openEditCategory(@js($category))" 
                                    class="p-1.5 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors cursor-pointer" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.article-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Seluruh sub-kategori di dalamnya juga akan terhapus.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-slate-500">
                        Belum ada kategori artikel. Silakan tambahkan form di atas.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Sub-Kategori Dinamis (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Form Tambah Sub-Kategori -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-2xs">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900">Tambah Sub-Kategori Baru</h2>
                    </div>
                </div>

                <form action="{{ route('admin.article-subcategories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="sub-cat-parent" class="block text-xs font-bold text-slate-700 mb-1">Induk Kategori Utama <span class="text-rose-500">*</span></label>
                            <select id="sub-cat-parent" name="category_id" required
                                    class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-white">
                                <option value="">-- Pilih Kategori Utama --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sub-name" class="block text-xs font-bold text-slate-700 mb-1">Nama Sub-Kategori <span class="text-rose-500">*</span></label>
                            <input type="text" id="sub-name" name="name" required placeholder="Contoh: Tips Wastafel & Kloset"
                                   class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="sub-slug" class="block text-xs font-bold text-slate-700 mb-1">Slug URL <span class="text-slate-400 font-normal">(opsional, auto dari nama)</span></label>
                            <input type="text" id="sub-slug" name="slug" placeholder="contoh: tips-wastafel-kloset"
                                   class="w-full px-3 py-2 text-xs sm:text-sm font-mono rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-white">
                        </div>
                        <div>
                            <label for="sub-sort" class="block text-xs font-bold text-slate-700 mb-1">Urutan (Sort)</label>
                            <input type="number" id="sub-sort" name="sort_order" value="0" min="0"
                                   class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>

                    <div>
                        <label for="sub-desc" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea id="sub-desc" name="description" rows="2" placeholder="Penjelasan ruang lingkup sub-kategori ini..."
                                  class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-white"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition-colors shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Sub-Kategori</span>
                    </button>
                </form>
            </div>

            <!-- Daftar Sub-Kategori per Kategori Induk -->
            <div class="space-y-4">
                @foreach($categories as $category)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
                    <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-600"></span>
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">{{ $category->name }}</h3>
                            <span class="text-[11px] font-mono text-slate-400">(/edukasi/{{ $category->slug }}/...)</span>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">{{ $category->subcategories->count() }} Sub</span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($category->subcategories as $sub)
                        <div class="p-3.5 sm:px-5 hover:bg-slate-50/60 transition-colors flex items-center justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs sm:text-sm font-semibold text-slate-900">{{ $sub->name }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 text-slate-600">{{ $sub->slug }}</span>
                                </div>
                                @if($sub->description)
                                <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $sub->description }}</p>
                                @endif
                                <div class="text-[11px] text-slate-400 mt-1">
                                    {{ $sub->articles_count }} artikel terhubung
                                </div>
                            </div>

                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" @click="openEditSubcategory(@js($sub))" 
                                        class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors cursor-pointer" title="Edit Sub-Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.article-subcategories.destroy', $sub) }}" method="POST" onsubmit="return confirm('Hapus sub-kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Hapus Sub-Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-xs text-slate-400">
                            Belum ada sub-kategori untuk kategori ini.
                        </div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-cloak x-show="editingCategoryModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60" role="dialog" aria-modal="true">
        <div @click.away="editingCategoryModal = false" class="bg-white rounded-xl border border-slate-200 max-w-md w-full p-5 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Edit Kategori Utama</h3>
                <button type="button" @click="editingCategoryModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="editCategoryAction" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" x-model="editCategoryForm.name" required
                           class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slug URL</label>
                    <input type="text" name="slug" x-model="editCategoryForm.slug" required
                           class="w-full px-3 py-2 text-xs sm:text-sm font-mono rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="editCategoryForm.description" rows="2"
                              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" x-model="editCategoryForm.sort_order" min="0"
                           class="w-24 px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                </div>
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="editingCategoryModal = false" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs rounded-lg transition-colors shadow-2xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Sub-Kategori -->
    <div x-cloak x-show="editingSubcategoryModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60" role="dialog" aria-modal="true">
        <div @click.away="editingSubcategoryModal = false" class="bg-white rounded-xl border border-slate-200 max-w-md w-full p-5 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Edit Sub-Kategori</h3>
                <button type="button" @click="editingSubcategoryModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="editSubcategoryAction" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sub-Kategori</label>
                    <input type="text" name="name" x-model="editSubcategoryForm.name" required
                           class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slug URL</label>
                    <input type="text" name="slug" x-model="editSubcategoryForm.slug" required
                           class="w-full px-3 py-2 text-xs sm:text-sm font-mono rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="editSubcategoryForm.description" rows="2"
                              class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" x-model="editSubcategoryForm.sort_order" min="0"
                           class="w-24 px-3 py-2 text-xs rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                </div>
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="editingSubcategoryModal = false" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition-colors shadow-2xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function categoryManager() {
    return {
        editingCategoryModal: false,
        editingSubcategoryModal: false,
        editCategoryAction: '',
        editCategoryForm: { name: '', slug: '', description: '', sort_order: 0 },
        editSubcategoryAction: '',
        editSubcategoryForm: { name: '', slug: '', description: '', sort_order: 0 },

        openEditCategory(cat) {
            this.editCategoryForm = {
                name: cat.name,
                slug: cat.slug,
                description: cat.description || '',
                sort_order: cat.sort_order || 0
            };
            this.editCategoryAction = '{{ url('/admin/article-categories') }}/' + cat.id;
            this.editingCategoryModal = true;
        },

        openEditSubcategory(sub) {
            this.editSubcategoryForm = {
                name: sub.name,
                slug: sub.slug,
                description: sub.description || '',
                sort_order: sub.sort_order || 0
            };
            this.editSubcategoryAction = '{{ url('/admin/article-subcategories') }}/' + sub.id;
            this.editingSubcategoryModal = true;
        }
    };
}
</script>
@endpush
