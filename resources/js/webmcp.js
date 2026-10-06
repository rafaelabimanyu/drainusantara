/**
 * WebMCP (Web Model Context Protocol) Integration for Drainusantara
 * Exposes lightweight read-only tools to browser AI agents via navigator.modelContext.
 */

const DIAGNOSTIC_MESSAGES = {
    wastafel: 'Halo Drainusantara, saya butuh penanganan darurat untuk Wastafel / Bak Cuci Piring mampet. Mohon info teknisi terdekat.',
    toilet: 'Halo Drainusantara, saya butuh bantuan darurat untuk Kloset / Toilet tersumbat tanpa bongkar keramik. Mohon segera kirim teknisi.',
    floordrain: 'Halo Drainusantara, saya butuh penanganan Floor Drain Kamar Mandi yang menggenang dan meluap. Mohon info teknisi terdekat.',
    greasetrap: 'Halo Drainusantara, kami ingin memesan pembersihan Grease Trap untuk restoran kami. Mohon info penawaran.',
    talang: 'Halo Drainusantara, pipa talang air rooftop kami tersumbat dan meluap. Mohon info jadwal teknisi.',
    cctv: 'Halo Drainusantara, saya ingin menjadwalkan Inspeksi Kamera CCTV Pipa 30M untuk diagnosa saluran. Mohon info ketersediaan unit.',
    lainnya: 'Halo Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet tanpa bongkar keramik. Mohon info teknisi terdekat.'
};

function getWebMcpData() {
    try {
        const el = document.getElementById('drainusantara-webmcp-data');
        if (el && el.textContent) {
            return JSON.parse(el.textContent);
        }
    } catch {
        // Fallback gracefully
    }
    return {
        services: [],
        whatsappNumber: window.__DRAINUSANTARA_WA__ || '6281234567890',
        baseUrl: window.location.origin
    };
}

function getSearchableAreas() {
    try {
        const el = document.getElementById('drainusantara-areas-data');
        if (el && el.textContent) {
            return JSON.parse(el.textContent);
        }
    } catch {
        // Fallback gracefully
    }
    return window.__DRAINUSANTARA_AREAS__ || [];
}

export function registerWebMcpTools() {
    if (typeof window === 'undefined') return;

    const mc = window.navigator?.modelContext;
    if (!mc || typeof mc.registerTool !== 'function') {
        return;
    }

    const data = getWebMcpData();
    const baseUrl = data.baseUrl || window.location.origin;
    const waNumber = (data.whatsappNumber || '6281234567890').replace(/[^0-9]/g, '');

    // Tool 1: Cari Layanan & Estimasi Biaya
    try {
        mc.registerTool({
            name: 'cari_layanan',
            description: 'Mencari katalog layanan pelancaran saluran pipa mampet, wastafel, kloset, dan inspeksi CCTV pipa Drainusantara beserta harga estimasi mulai dari Rp 400.000.',
            inputSchema: {
                type: 'object',
                properties: {
                    kata_kunci: {
                        type: 'string',
                        description: 'Kata kunci pencarian jenis saluran mampet (contoh: wastafel, kloset, bak kontrol, talang, cctv)'
                    }
                },
                required: []
            }
        }, async (params = {}) => {
            const currentData = getWebMcpData();
            const q = (params.kata_kunci || '').trim().toLowerCase();
            let items = currentData.services || [];

            if (q) {
                items = items.filter(s =>
                    (s.name && s.name.toLowerCase().includes(q)) ||
                    (s.short_description && s.short_description.toLowerCase().includes(q))
                );
            }

            return {
                total: items.length,
                layanan: items.map(s => ({
                    nama: s.name,
                    deskripsi: s.short_description,
                    harga: `Mulai dari Rp ${(s.price_starting_from || 400000).toLocaleString('id-ID')}`,
                    metode: 'Mekanik Spiral Baja Rotary Tanpa Bongkar Keramik',
                    garansi: '30 Hari Kalender'
                }))
            };
        });
    } catch (e) {
        // Fail-safe registration
    }

    // Tool 2: Cek Jangkauan Armada Wilayah
    try {
        mc.registerTool({
            name: 'cek_jangkauan_area',
            description: 'Memeriksa ketersediaan jangkauan armada posko siaga teknisi Drainusantara di kota atau kecamatan tertentu di Jabodetabek, Semarang, dan Bandar Lampung.',
            inputSchema: {
                type: 'object',
                properties: {
                    lokasi: {
                        type: 'string',
                        description: 'Nama kota atau kecamatan yang ingin diperiksa (contoh: Jakarta Selatan, Kebayoran Baru, Semarang, Bandar Lampung)'
                    }
                },
                required: ['lokasi']
            }
        }, async (params = {}) => {
            const loc = (params.lokasi || '').trim().toLowerCase();
            if (!loc) {
                return { status: 'gagal', pesan: 'Parameter lokasi diperlukan.' };
            }

            const areas = getSearchableAreas();
            const matched = areas.filter(a =>
                (a.name && a.name.toLowerCase().includes(loc)) ||
                (a.search && a.search.toLowerCase().includes(loc)) ||
                (a.city && a.city.toLowerCase().includes(loc))
            );

            if (matched.length > 0) {
                return {
                    status: 'tersedia',
                    pesan: `Armada teknisi Drainusantara siaga melayani wilayah ${params.lokasi}.`,
                    wilayah_terdekat: matched.slice(0, 5).map(m => ({
                        nama: m.name,
                        tingkat: m.type,
                        url: m.url ? (m.url.startsWith('http') ? m.url : `${baseUrl}${m.url}`) : `${baseUrl}/area`
                    })),
                    waktu_respon: 'Respon Cepat Armada Siaga 24 Jam'
                };
            }

            return {
                status: 'konfirmasi_manual',
                pesan: `Wilayah ${params.lokasi} belum terdaftar otomatis. Hubungi CS WhatsApp untuk koordinasi jangkauan armada teknisi terdekat.`,
                url_area: `${baseUrl}/area`
            };
        });
    } catch (e) {
        // Fail-safe registration
    }

    // Tool 3: Buat Tautan Konsultasi WhatsApp
    try {
        mc.registerTool({
            name: 'buat_tautan_whatsapp',
            description: 'Membuat tautan konsultasi resmi WhatsApp Drainusantara dengan parameter masalah saluran pipa dan lokasi yang terisi otomatis.',
            inputSchema: {
                type: 'object',
                properties: {
                    masalah: {
                        type: 'string',
                        enum: ['wastafel', 'toilet', 'floordrain', 'greasetrap', 'talang', 'cctv', 'lainnya'],
                        description: 'Kategori titik saluran mampet'
                    },
                    lokasi: {
                        type: 'string',
                        description: 'Nama kecamatan atau kota pemohon (opsional)'
                    }
                },
                required: ['masalah']
            }
        }, async (params = {}) => {
            const key = params.masalah || 'lainnya';
            let message = DIAGNOSTIC_MESSAGES[key] || DIAGNOSTIC_MESSAGES.lainnya;

            if (params.lokasi && params.lokasi.trim()) {
                message += ` Lokasi pengerjaan di: ${params.lokasi.trim()}.`;
            }

            const encoded = encodeURIComponent(message);
            const url = `https://wa.me/${waNumber}?text=${encoded}`;

            return {
                url_whatsapp: url,
                nomor_cs: `+${waNumber}`,
                teks_pesan: message,
                instruksi: 'Tautan siap dibuka oleh pengguna untuk terhubung langsung dengan teknisi siaga Drainusantara.'
            };
        });
    } catch (e) {
        // Fail-safe registration
    }
}
