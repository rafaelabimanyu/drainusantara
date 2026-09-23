import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('layoutData', () => ({
    activeMenu: null,
    areaSearch: '',
    sidebarOpen: false,
    mobileSearchOpen: false,
    diagProblem: 'wastafel',
    whatsappNumber: window.__DRAINUSANTARA_WA__ || '6281234567890',
    _cachedAreas: null,
    diagnostics: {
        wastafel: {
            title: 'Wastafel & Sink Dapur',
            problem: 'Kerak minyak & lemak sisa masakan membatu di leher angsa sifon.',
            tool: 'Mesin Spiral Rotary K-50 Ridgid',
            cable: 'Spiral Fleksibel 16mm Khusus Sifon',
            est: 'Mulai Rp 400.000 / titik',
            msg: 'Halo Drainusantara, saya butuh penanganan darurat untuk Wastafel / Bak Cuci Piring mampet. Mohon info teknisi terdekat.'
        },
        toilet: {
            title: 'Kloset & WC Meluap',
            problem: 'Sumbatan tisu basah, pembalut, atau benda keras di lekukan leher angsa keramik.',
            tool: 'Rooter Heavy Duty K-60 Rigid',
            cable: 'Spiral Torsi Tinggi Anti-Kinking',
            est: 'Mulai Rp 400.000 / titik',
            msg: 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon segera kirim teknisi.'
        },
        floordrain: {
            title: 'Floor Drain Kamar Mandi',
            problem: 'Jeratan rambut rontok dan kerak buih sabun padat yang menyumbat jalur pembuangan.',
            tool: 'Rooter Fleksibel 16mm Anti-Knee',
            cable: 'Spiral Baja Karbon Lentur',
            est: 'Mulai Rp 400.000 / titik',
            msg: 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang dan meluap. Mohon info teknisi terdekat.'
        },
        greasetrap: {
            title: 'Sedot & Kuras Grease Trap',
            problem: 'Limbah minyak & kerak lemak padat restoran F&B berbau menyengat.',
            tool: 'Ekstraksi Vakum & Rotary Degreaser',
            cable: 'Pembersih Dinding Pipa Komersial',
            est: 'Mulai Rp 400.000 / unit',
            msg: 'Halo Drainusantara, kami ingin memesan pembersihan Grease Trap untuk restoran kami. Mohon info penawaran.'
        },
        talang: {
            title: 'Talang Hujan & Pipa Rooftop',
            problem: 'Endapan lumut tebal, pasir atap, dan dedaunan kering di pipa vertikal.',
            tool: 'Spiral Baja Jangkauan Panjang 22mm',
            cable: 'Kabel Heavy Duty s/d 30 Meter',
            est: 'Mulai Rp 400.000 / titik',
            msg: 'Halo Drainusantara, pipa talang air rooftop kami tersumbat dan meluap. Mohon info jadwal teknisi.'
        },
        cctv: {
            title: 'Inspeksi Digital CCTV 30M',
            problem: 'Investigasi visual resolusi tinggi mendeteksi retak, sambungan lepas, atau akar.',
            tool: 'Endoscopic Push-Rod Camera IP68 HD',
            cable: 'Kabel Dorong Fiber Optic 30 Meter',
            est: 'Mulai Rp 400.000 / inspeksi',
            msg: 'Halo Drainusantara, saya ingin menjadwalkan Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran. Mohon info ketersediaan unit.'
        }
    },
    get areas() {
        if (!this._cachedAreas) {
            const el = document.getElementById('drainusantara-areas-data');
            if (el && el.textContent) {
                try {
                    this._cachedAreas = JSON.parse(el.textContent);
                } catch (e) {
                    this._cachedAreas = [];
                }
            } else {
                this._cachedAreas = window.__DRAINUSANTARA_AREAS__ || [];
            }
        }
        return this._cachedAreas;
    },
    filterArea(area) {
        const q = this.areaSearch.trim().toLowerCase();
        if (!q) {
            return area.type === 'Provinsi' || area.type === 'Kota';
        }
        if (area.search && area.search.includes(q)) {
            return true;
        }
        if (area.type === 'Kecamatan' && q.length >= 3 && q.includes(area.search)) {
            return true;
        }
        return false;
    }
}));

Alpine.data('mobileCarousel', (totalSlides = 3, intervalMs = 4500) => ({
    active: 0,
    total: totalSlides,
    timer: null,
    isInteracting: false,
    _scrollRaf: null,
    _observer: null,
    init() {
        if (typeof window === 'undefined') return;

        // Auto scroll only when visible on mobile screen (zero idle CPU work when offscreen)
        if ('IntersectionObserver' in window && this.$refs.slider) {
            this._observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && window.innerWidth < 768) {
                        this.startAutoScroll();
                    } else {
                        this.stopAutoScroll();
                    }
                });
            }, { threshold: 0.25 });
            this._observer.observe(this.$refs.slider);
        } else if (window.innerWidth < 768) {
            setTimeout(() => this.startAutoScroll(), 2500);
        }
    },
    startAutoScroll() {
        this.stopAutoScroll();
        this.timer = setInterval(() => {
            if (!this.isInteracting && window.innerWidth < 768) {
                this.next();
            }
        }, intervalMs);
    },
    stopAutoScroll() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    next() {
        this.active = (this.active + 1) % this.total;
        this.scrollToActive();
    },
    prev() {
        this.active = (this.active - 1 + this.total) % this.total;
        this.scrollToActive();
    },
    goTo(index) {
        this.active = index;
        this.scrollToActive();
    },
    scrollToActive() {
        const container = this.$refs.slider;
        if (!container) return;
        const slides = container.children;
        if (slides[this.active]) {
            const slide = slides[this.active];
            const targetLeft = slide.offsetLeft - container.offsetLeft - 16;
            container.scrollTo({
                left: targetLeft,
                behavior: 'smooth'
            });
        }
    },
    onScroll() {
        if (this._scrollRaf) return;
        this._scrollRaf = requestAnimationFrame(() => {
            this._scrollRaf = null;
            const container = this.$refs.slider;
            if (!container) return;
            const scrollLeft = container.scrollLeft;
            const slideWidth = container.clientWidth * 0.82;
            if (slideWidth > 0) {
                const newIndex = Math.min(this.total - 1, Math.max(0, Math.round(scrollLeft / slideWidth)));
                if (this.active !== newIndex) {
                    this.active = newIndex;
                }
            }
        });
    },
    pause() {
        this.isInteracting = true;
    },
    resume() {
        setTimeout(() => {
            this.isInteracting = false;
        }, 2500);
    }
}));

Alpine.start();

