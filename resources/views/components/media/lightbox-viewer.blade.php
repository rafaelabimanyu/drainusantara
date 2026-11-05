@props([
    'targetSelector' => null,
])

<div x-data="blogImageViewer()"
    @keydown.escape.window="if(isOpen) close()"
    x-cloak>
    
    <!-- Fullscreen Modal Overlay -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] bg-slate-950/95 backdrop-blur-md flex flex-col justify-between select-none"
         role="dialog" 
         aria-modal="true" 
         aria-label="Penampil Gambar Penuh">
        
        <!-- Top Navigation Bar / Controls -->
        <div class="flex items-center justify-between px-3 sm:px-6 py-2.5 sm:py-3 bg-slate-900/90 border-b border-slate-800 text-white shrink-0">
            <div class="flex items-center gap-2 max-w-[45%] sm:max-w-md truncate">
                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs sm:text-sm font-semibold truncate" x-text="activeAlt"></span>
            </div>

            <!-- Toolbar Controls -->
            <div class="flex items-center gap-1 sm:gap-2">
                <!-- Zoom Out -->
                <button type="button" 
                        @click="zoomOut()" 
                        :disabled="zoomLevel <= 1"
                        :class="zoomLevel <= 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-800 active:scale-95 cursor-pointer'"
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-slate-800/80 text-white transition-all border border-slate-700/60"
                        title="Perkecil (-)" aria-label="Perkecil Gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>

                <!-- Zoom Level Display -->
                <span class="text-xs font-mono font-bold px-2 sm:px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-sky-300 min-w-[50px] sm:min-w-[56px] text-center select-none text-[11px] sm:text-xs"
                      x-text="Math.round(zoomLevel * 100) + '%'">
                </span>

                <!-- Zoom In -->
                <button type="button" 
                        @click="zoomIn()" 
                        :disabled="zoomLevel >= 3"
                        :class="zoomLevel >= 3 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-800 active:scale-95 cursor-pointer'"
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-slate-800/80 text-white transition-all border border-slate-700/60"
                        title="Perbesar (+)" aria-label="Perbesar Gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>

                <!-- Reset Zoom -->
                <button type="button" 
                        @click="resetZoom()" 
                        class="hidden sm:inline-flex min-h-[44px] items-center justify-center px-3 rounded-lg bg-slate-800/80 hover:bg-slate-800 active:scale-95 text-white text-xs font-semibold transition-all border border-slate-700/60 cursor-pointer"
                        title="Kembalikan ke Ukuran Semula" aria-label="Reset Ukuran">
                    Reset
                </button>

                <!-- Open original in new tab -->
                <a :href="activeSrc" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="hidden sm:inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg bg-slate-800/80 hover:bg-slate-800 active:scale-95 text-slate-300 hover:text-white transition-all border border-slate-700/60"
                   title="Buka Gambar Asli di Tab Baru" aria-label="Buka di Tab Baru">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <!-- Close Button -->
                <button type="button" 
                        @click="close()" 
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-rose-600/90 hover:bg-rose-600 active:scale-95 text-white transition-all border border-rose-500/60 ml-0.5 sm:ml-1 cursor-pointer"
                        title="Tutup (ESC)" aria-label="Tutup Penampil Gambar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Image Main Stage -->
        <div class="flex-1 overflow-auto p-2 sm:p-6 md:p-8 flex items-center justify-center cursor-zoom-out" 
             @click.self="close()">
            <div class="relative transition-transform duration-200 ease-out" 
                 :style="'transform: scale(' + zoomLevel + '); transform-origin: center center;'">
                <img :src="activeSrc" 
                     :alt="activeAlt" 
                     class="max-h-[78vh] sm:max-h-[82vh] max-w-[95vw] sm:max-w-[85vw] object-contain rounded-lg shadow-2xl border border-slate-700/40 select-none cursor-pointer"
                     @click.stop="toggleZoom()"
                     title="Klik untuk zoom 1.75x / kembali">
            </div>
        </div>

        <!-- Footer Hint -->
        <div class="py-2 px-4 bg-slate-900/80 text-center text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-800/80 shrink-0">
            <span>Tekan tombol zoom atau klik gambar &bull; Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700 font-mono text-[10px]">ESC</kbd> untuk menutup</span>
        </div>
    </div>
</div>

<script>
window.blogImageViewer = function() {
    return {
        isOpen: false,
        activeSrc: '',
        activeAlt: '',
        zoomLevel: 1,

        init() {
            window.addEventListener('open-lightbox', (e) => {
                if (e.detail && e.detail.src) {
                    this.open(e.detail.src, e.detail.alt || 'Gambar Dokumentasi');
                }
            });

            window.__openLightbox = (src, alt) => {
                this.open(src, alt || 'Gambar Dokumentasi');
            };

            @if($targetSelector)
            this.$nextTick(() => {
                const elements = document.querySelectorAll('{{ $targetSelector }}');
                elements.forEach(img => {
                    img.classList.add('cursor-zoom-in', 'hover:opacity-95', 'transition-opacity');
                    if (!img.getAttribute('title')) {
                        img.setAttribute('title', 'Klik untuk melihat foto lebih besar');
                    }
                    img.addEventListener('click', () => {
                        this.open(img.src, img.alt || img.getAttribute('title') || 'Gambar Dokumentasi');
                    });
                });
            });
            @endif
        },

        open(src, alt) {
            this.activeSrc = src;
            this.activeAlt = alt || 'Pratinjau Foto';
            this.zoomLevel = 1;
            this.isOpen = true;
            document.body.classList.add('overflow-hidden');
        },

        close() {
            this.isOpen = false;
            this.zoomLevel = 1;
            document.body.classList.remove('overflow-hidden');
        },

        zoomIn() {
            if (this.zoomLevel < 3) {
                this.zoomLevel = Math.min(3, +(this.zoomLevel + 0.35).toFixed(2));
            }
        },

        zoomOut() {
            if (this.zoomLevel > 1) {
                this.zoomLevel = Math.max(1, +(this.zoomLevel - 0.35).toFixed(2));
            }
        },

        resetZoom() {
            this.zoomLevel = 1;
        },

        toggleZoom() {
            this.zoomLevel = this.zoomLevel > 1 ? 1 : 1.75;
        }
    };
};
window.lightboxViewer = window.blogImageViewer;
</script>

