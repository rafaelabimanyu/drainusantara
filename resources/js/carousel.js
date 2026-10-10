export function registerCarousels(Alpine) {
Alpine.data('mobileCarousel', (totalSlides = 3, intervalMs = 4500, groupSize = 1) => ({
    active: 0,
    total: totalSlides,
    timer: null,
    isInteracting: false,
    reducedMotion: false,
    _scrollRaf: null,
    _observer: null,
    _isProgrammatic: false,
    _programmaticTimer: null,
    stopped: false,
    hasFocus: false,
    hovered: false,
    visible: true,
    overflowing: false,
    _destroyed: false,
    get autoplayEnabled() { return !this.stopped && !this.reducedMotion; },
    getContainer() {
        return this.$refs.slider || this.$refs.container;
    },
    isCarouselMode() {
        const container = this.getContainer();
        if (!container) return false;
        return container.scrollWidth > (container.clientWidth + 5);
    },
    init() {
        if (typeof window === 'undefined') return;
        this._motion = window.matchMedia('(prefers-reduced-motion: reduce)');
        this.reducedMotion = this._motion.matches;
        this._onMotion = () => {
            this.reducedMotion = this._motion.matches;
            this.startAutoScroll();
        };
        this._motion.addEventListener('change', this._onMotion);
        this._onVisibility = () => this.startAutoScroll();
        this._onResize = () => this.startAutoScroll();
        this._onFocusIn = () => { this.hasFocus = true; this.startAutoScroll(); };
        this._onFocusOut = (event) => {
            this.hasFocus = this.$root.contains(event.relatedTarget);
            this.startAutoScroll();
        };
        this._onMouseEnter = () => { this.hovered = true; this.startAutoScroll(); };
        this._onMouseLeave = () => { this.hovered = false; this.startAutoScroll(); };
        this.$root.addEventListener('focusin', this._onFocusIn);
        this.$root.addEventListener('focusout', this._onFocusOut);
        this.$root.addEventListener('mouseenter', this._onMouseEnter);
        this.$root.addEventListener('mouseleave', this._onMouseLeave);
        document.addEventListener('visibilitychange', this._onVisibility);
        window.addEventListener('resize', this._onResize);

        this.$nextTick(() => {
            const container = this.getContainer();
            if (container) {
                const slides = Array.from(container.children).filter(el => el.nodeType === 1 && !el.classList.contains('hidden'));
                if (slides.length > 0) {
                    this.total = Math.ceil(slides.length / groupSize);
                }
            }
        });

        const container = this.getContainer();
        if ('IntersectionObserver' in window && container) {
            this.visible = false;
            this._observer = new window.IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.visible = entry.isIntersecting;
                    this.startAutoScroll();
                });
            }, { threshold: 0.25 });
            this._observer.observe(container);
        } else {
            this.startAutoScroll();
        }
    },
    startAutoScroll() {
        this.stopAutoScroll();
        this.overflowing = this.isCarouselMode();
        if (this._destroyed || !this.autoplayEnabled || this.hasFocus || this.hovered ||
            this.isInteracting || !this.visible || document.hidden || !this.overflowing || this.total <= 1) return;
        this.timer = setInterval(() => {
            if (!this.isInteracting && this.isCarouselMode()) {
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
        if (this.total < 1) return;
        this.active = (this.active + 1) % this.total;
        this.scrollToActive();
    },
    prev() {
        if (this.total < 1) return;
        this.active = (this.active - 1 + this.total) % this.total;
        this.scrollToActive();
    },
    goTo(index) {
        this.active = Math.max(0, Math.min(this.total - 1, index));
        this.pause();
        this.scrollToActive();
        this.resume();
    },
    scrollToActive() {
        const container = this.getContainer();
        if (!container) return;
        const slides = Array.from(container.children).filter(el => el.nodeType === 1 && !el.classList.contains('hidden'));
        if (!slides.length || !slides[this.active * groupSize]) return;

        this._isProgrammatic = true;
        clearTimeout(this._programmaticTimer);
        this._programmaticTimer = setTimeout(() => {
            this._isProgrammatic = false;
        }, 600);

        let targetLeft;
        if (groupSize > 1) {
            targetLeft = slides[this.active * groupSize].offsetLeft - container.offsetLeft;
        } else if (this.active === 0) {
            targetLeft = 0;
        } else if (this.active === slides.length - 1) {
            targetLeft = container.scrollWidth - container.clientWidth;
        } else {
            const slide = slides[this.active];
            targetLeft = slide.offsetLeft - container.offsetLeft - (container.clientWidth - slide.clientWidth) / 2;
        }

        container.scrollTo({
            left: Math.max(0, targetLeft),
            behavior: this.reducedMotion ? 'instant' : 'smooth'
        });
    },
    onScroll() {
        if (this._isProgrammatic) return;
        if (this._scrollRaf) return;
        this._scrollRaf = requestAnimationFrame(() => {
            this._scrollRaf = null;
            const container = this.getContainer();
            if (!container) return;
            const slides = Array.from(container.children).filter(el => el.nodeType === 1 && !el.classList.contains('hidden'));
            if (!slides.length) return;

            const scrollLeft = container.scrollLeft;
            const maxScroll = container.scrollWidth - container.clientWidth;

            if (scrollLeft <= 15) {
                if (this.active !== 0) this.active = 0;
                return;
            }
            if (scrollLeft >= maxScroll - 15) {
                this.active = this.total - 1;
                return;
            }

            if (groupSize > 1) {
                const step = slides.length > 1 ? slides[1].offsetLeft - slides[0].offsetLeft : slides[0].clientWidth;
                this.active = Math.min(this.total - 1, Math.max(0, Math.floor((scrollLeft + step * 0.15) / (step * groupSize))));
                return;
            }

            const containerCenter = scrollLeft + (container.clientWidth / 2);
            let closestIndex = 0;
            let minDiff = Infinity;

            slides.forEach((slide, index) => {
                const slideCenter = (slide.offsetLeft - container.offsetLeft) + (slide.clientWidth / 2);
                const diff = Math.abs(containerCenter - slideCenter);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestIndex = index;
                }
            });

            if (closestIndex !== this.active && closestIndex < this.total) {
                this.active = closestIndex;
            }
        });
    },
    toggleAutoplay() {
        this.stopped = !this.stopped;
        this.startAutoScroll();
    },
    pause() {
        this.isInteracting = true;
        this.startAutoScroll();
    },
    resume() {
        this.isInteracting = false;
        this.startAutoScroll();
    },
    destroy() {
        this._destroyed = true;
        this.stopAutoScroll();
        clearTimeout(this._programmaticTimer);
        cancelAnimationFrame(this._scrollRaf);
        this._observer?.disconnect();
        this._motion.removeEventListener('change', this._onMotion);
        this.$root.removeEventListener('focusin', this._onFocusIn);
        this.$root.removeEventListener('focusout', this._onFocusOut);
        this.$root.removeEventListener('mouseenter', this._onMouseEnter);
        this.$root.removeEventListener('mouseleave', this._onMouseLeave);
        document.removeEventListener('visibilitychange', this._onVisibility);
        window.removeEventListener('resize', this._onResize);
    }
}));

}
