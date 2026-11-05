<dialog id="quick-quote-dialog" 
        x-cloak 
        x-show="quickQuoteOpen"
        x-ref="quickQuoteDialog"
        x-data="{
            quickQuoteOpen: false,
            triggerEl: null,
            init() {
                this.$watch('quickQuoteOpen', open => {
                    const dialog = this.$refs.quickQuoteDialog;
                    if (open) {
                        this.triggerEl = document.activeElement;
                        document.documentElement.style.overflow = 'hidden';
                        document.body.style.overflow = 'hidden';
                        this.$nextTick(() => {
                            if (!this.quickQuoteOpen) return;
                            if (dialog && !dialog.open) dialog.showModal();
                        });
                    } else {
                        if (dialog && dialog.open) dialog.close();
                        document.documentElement.style.overflow = '';
                        document.body.style.overflow = '';
                        if (this.triggerEl && this.triggerEl.isConnected) {
                            this.triggerEl.focus({ preventScroll: true });
                        }
                    }
                });
            }
        }"
        @open-quick-quote.window="quickQuoteOpen = true"
        @cancel.prevent="quickQuoteOpen = false"
        @close="if (!$el.open) quickQuoteOpen = false"
        class="fixed inset-0 z-60 w-full h-full max-w-none max-h-none p-0 border-0 bg-transparent"
        :class="quickQuoteOpen ? 'flex items-center justify-center' : 'hidden'"
        style="margin: 0; display: none;"
        aria-labelledby="quick-quote-modal-title">

    <!-- Backdrop -->
    <div x-show="quickQuoteOpen" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="quickQuoteOpen = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" 
         aria-hidden="true"></div>

    <!-- Modal Panel -->
    <div x-show="quickQuoteOpen"
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative z-10 w-full max-w-xl mx-4 my-6 bg-white rounded-xl shadow-xl border border-slate-200 max-h-[90vh] flex flex-col overflow-hidden">
        
        <!-- Header with Close Button -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-slate-200 bg-slate-900 text-white shrink-0">
            <h2 id="quick-quote-modal-title" class="text-sm font-bold tracking-tight text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400" aria-hidden="true"></span>
                <span>Estimasi Biaya &amp; Konsultasi WhatsApp</span>
            </h2>
            <button @click="quickQuoteOpen = false" 
                    type="button" 
                    class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors btn-press cursor-pointer"
                    aria-label="Tutup formulir estimasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Scrollable Quote Body -->
        <div class="overflow-y-auto flex-1 p-4 sm:p-5">
            <x-conversion.quick-quote :is-modal="true" />
        </div>
    </div>
</dialog>

