import Alpine from 'alpinejs';
import { registerWebMcpTools } from './webmcp';
import { registerCarousels } from './carousel';

window.Alpine = Alpine;

Alpine.data('layoutData', () => ({
    init() {
        this.$watch('mobileSearchOpen', open => {
            const dialog = this.$refs.areaSearchDialog;
            if (open) {
                this.$nextTick(() => {
                    if (!this.mobileSearchOpen) return;
                    dialog.showModal();
                    dialog.querySelector('button').focus();
                });
            } else if (dialog.open) {
                dialog.close();
            }
        });
    },
    trapSearchFocus(event) {
        const dialog = this.$refs.areaSearchDialog;
        const items = [...dialog.querySelectorAll('a[href], button, input')]
            .filter(el => !el.disabled && el.getClientRects().length);
        const first = items[0], last = items.at(-1);
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    },
    activeMenu: null,
    areaSearch: '',
    sidebarOpen: false,
    mobileSearchOpen: false,
    tentangDrawerOpen: false,
    diagProblem: 'wastafel',
    whatsappNumber: window.__DRAINUSANTARA_WA__ || '6285609009009',
    _cachedAreas: null,
    diagnostics: {
        wastafel: {
            title: 'Wastafel & Sink Dapur',
            problem: 'Kerak minyak & lemak sisa masakan membatu di leher angsa sifon.',
            tool: 'Mesin Spiral Rotary K-50 Ridgid',
            cable: 'Spiral Fleksibel 16mm Khusus Sifon',
            est: 'Mulai Rp 400.000',
            msg: 'Halo Drainusantara, saya butuh penanganan darurat untuk Wastafel / Bak Cuci Piring mampet. Mohon info teknisi terdekat.'
        },
        toilet: {
            title: 'Kloset & WC Meluap',
            problem: 'Sumbatan tisu basah, pembalut, atau benda keras di lekukan leher angsa keramik.',
            tool: 'Rooter Heavy Duty K-60 Rigid',
            cable: 'Spiral Torsi Tinggi Anti-Kinking',
            est: 'Mulai Rp 400.000',
            msg: 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon segera kirim teknisi.'
        },
        floordrain: {
            title: 'Floor Drain Kamar Mandi',
            problem: 'Jeratan rambut rontok dan kerak buih sabun padat yang menyumbat jalur pembuangan.',
            tool: 'Rooter Fleksibel 16mm Anti-Knee',
            cable: 'Spiral Baja Karbon Lentur',
            est: 'Mulai Rp 400.000',
            msg: 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang dan meluap. Mohon info teknisi terdekat.'
        },
        greasetrap: {
            title: 'Sedot & Kuras Grease Trap',
            problem: 'Limbah minyak & kerak lemak padat restoran F&B berbau menyengat.',
            tool: 'Ekstraksi Vakum & Rotary Degreaser',
            cable: 'Pembersih Dinding Pipa Komersial',
            est: 'Mulai Rp 400.000',
            msg: 'Halo Drainusantara, kami ingin memesan pembersihan Grease Trap untuk restoran kami. Mohon info penawaran.'
        },
        talang: {
            title: 'Talang Hujan & Pipa Rooftop',
            problem: 'Endapan lumut tebal, pasir atap, dan dedaunan kering di pipa vertikal.',
            tool: 'Spiral Baja Jangkauan Panjang 22mm',
            cable: 'Kabel Heavy Duty s/d 30 Meter',
            est: 'Mulai Rp 400.000',
            msg: 'Halo Drainusantara, pipa talang air rooftop kami tersumbat dan meluap. Mohon info jadwal teknisi.'
        },
        cctv: {
            title: 'Inspeksi Digital CCTV 30M',
            problem: 'Investigasi visual resolusi tinggi mendeteksi retak, sambungan lepas, atau akar.',
            tool: 'Endoscopic Push-Rod Camera IP68 HD',
            cable: 'Kabel Dorong Fiber Optic 30 Meter',
            est: 'Mulai Rp 400.000',
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

registerCarousels(Alpine);

registerWebMcpTools();

Alpine.start();

