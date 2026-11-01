<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Service;
use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AiCatalogController extends Controller
{
    /**
     * Serve machine-readable AI Catalog adhering to the Agentic Resource Discovery (ARD v1.0) standard.
     */
    public function catalog(): JsonResponse
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        if (str_starts_with($baseUrl, 'https://')) {
            URL::forceScheme('https');
        }
        if (! empty($baseUrl)) {
            URL::forceRootUrl($baseUrl);
        }

        $payload = Cache::remember('ai-catalog.json', 3600, function (): array {
            $whatsappNumber = (string) config('app.whatsapp_number', '6285609009009');

            // 1. Dynamic active services
            $services = Service::where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(fn (Service $s) => [
                    'name' => $s->name,
                    'slug' => $s->slug,
                    'startingPrice' => (int) $s->price_starting_from,
                    'shortDescription' => $s->short_description ?? '',
                    'url' => url('/#layanan-' . $s->slug),
                ])
                ->values()
                ->all();

            if (empty($services)) {
                $services = [
                    [
                        'name' => 'Wastafel & Cuci Piring Mampet',
                        'slug' => 'wastafel-cuci-piring',
                        'startingPrice' => 400000,
                        'shortDescription' => 'Pelancaran leher angsa sifon dan pipa lemak dapur tanpa bongkar',
                        'url' => url('/#layanan-wastafel'),
                    ],
                    [
                        'name' => 'Kloset & WC Meluap',
                        'slug' => 'kloset-wc-mampet',
                        'startingPrice' => 400000,
                        'shortDescription' => 'Pembersihan sumbatan kloset dengan spiral baja mekanikal fleksibel',
                        'url' => url('/#layanan-kloset'),
                    ],
                    [
                        'name' => 'Floor Drain Kamar Mandi',
                        'slug' => 'floor-drain-kamar-mandi',
                        'startingPrice' => 400000,
                        'shortDescription' => 'Pembersihan gumpalan rambut dan endapan sabun di pembuangan kamar mandi',
                        'url' => url('/#layanan-floor-drain'),
                    ],
                ];
            }

            // 2. Dynamic coverage areas summary
            $provincesData = RegionService::all();
            $provinceNames = array_values(array_map(fn ($p) => $p['name'], $provincesData));
            $totalActiveAreas = CoverageArea::where('is_active', true)->count();
            $coverageCities = [];
            foreach ($provincesData as $prov) {
                foreach ($prov['cities'] as $city) {
                    $coverageCities[] = [
                        'city' => $city['name'],
                        'slug' => $city['slug'],
                        'province' => $city['province_name'],
                        'posko' => $city['posko_address'] ?? "Posko Armada {$city['name']}",
                        'url' => route('area.city', ['city' => $city['slug']]),
                        'districtsCount' => count($city['districts'] ?? []),
                    ];
                }
            }

            // 3. Dynamic active equipment
            $equipments = Equipment::where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(fn (Equipment $eq) => [
                    'name' => $eq->name,
                    'category' => $eq->category ?? 'Peralatan Mekanis',
                    'badge' => $eq->badge,
                    'shortDescription' => $eq->short_description ?? '',
                    'url' => $eq->slug ? route('equipment.show', ['slug' => $eq->slug]) : route('about.equipment'),
                ])
                ->values()
                ->all();

            if (empty($equipments)) {
                $equipments = [
                    [
                        'name' => 'Ridgid K-50 Rooter',
                        'category' => 'Mesin Spiral Baja',
                        'badge' => 'Standar Armada',
                        'shortDescription' => 'Mesin spiral kawat baja 16mm untuk pipa 1.5 hingga 3 inch',
                        'url' => route('about.equipment'),
                    ],
                    [
                        'name' => 'Kamera CCTV Pipa Sonde IP68',
                        'category' => 'Inspeksi Pipa',
                        'badge' => 'Sensor HD Safir',
                        'shortDescription' => 'Kamera endoskopi pipa dengan pemancar sonde locator hingga 30 meter',
                        'url' => route('about.equipment'),
                    ],
                ];
            }

            return [
                'specVersion' => '1.0',
                'host' => [
                    'displayName' => 'Drainusantara',
                    'identifier' => 'did:web:drainusantara.com',
                    'documentationUrl' => route('llms'),
                ],
                'entries' => [
                    [
                        'identifier' => 'urn:air:drainusantara.com:action:emergency-dispatch',
                        'displayName' => 'Emergency WhatsApp Dispatcher',
                        'type' => 'application/json',
                        'description' => 'Menghubungkan pelanggan atau agen AI ke operator teknisi siaga 24 jam Drainusantara untuk pelancaran pipa mampet darurat tanpa bongkar.',
                        'data' => [
                            'channel' => 'whatsapp',
                            'phone' => $whatsappNumber,
                            'urlTemplate' => "https://wa.me/{$whatsappNumber}?text={encoded_message}",
                            'parameters' => [
                                'problem_type' => ['kloset', 'wastafel', 'floor_drain', 'talang', 'grease_trap', 'cctv_inspeksi'],
                                'location' => 'Nama jalan, kelurahan/kecamatan, dan kota',
                                'urgency' => ['darurat_sekarang', 'hari_ini', 'jadwal_terencana'],
                            ],
                        ],
                        'representativeQueries' => [
                            'Pesan jasa pelancar WC mampet darurat di Jakarta Selatan',
                            'Panggil teknisi pipa wastafel mampet ke Depok sekarang',
                            'Kontak darurat tukang pipa mampet 24 jam Jabodetabek',
                        ],
                        'tags' => ['emergency', 'whatsapp', 'booking', 'plumbing', 'drainage'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:tool:quick-quote',
                        'displayName' => 'Drainage Cost & Quick Quote Estimator',
                        'type' => 'application/json',
                        'description' => 'Estimasi biaya penanganan saluran mampet berdasarkan jenis properti, tingkat keparahan, dan garansi tertulis 30 hari.',
                        'data' => [
                            'currency' => 'IDR',
                            'startingRates' => [
                                'residential' => 400000,
                                'commercial' => 650000,
                                'cctv_inspection' => 400000,
                            ],
                            'guaranteeDays' => 30,
                            'method' => 'Mekanikal spiral baja tanpa bongkar keramik',
                            'calculatorUrl' => url('/#estimasi'),
                        ],
                        'representativeQueries' => [
                            'Berapa biaya perbaikan wastafel tersumbat di rumah',
                            'Estimasi harga kuras grease trap restoran di Jakarta Barat',
                            'Biaya inspeksi pipa memakai kamera CCTV saluran air',
                        ],
                        'tags' => ['pricing', 'cost-calculator', 'quote', 'estimation'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:catalog:services',
                        'displayName' => 'Katalog Layanan Pelancaran Pipa Tanpa Bongkar',
                        'type' => 'application/json',
                        'description' => 'Daftar lengkap layanan spesialis pelancaran pipa air kotor, talang, kloset, dan bak kontrol tanpa pembongkaran ubin keramik.',
                        'data' => [
                            'services' => $services,
                        ],
                        'representativeQueries' => [
                            'Layanan pembersihan saluran kloset meluap tanpa membongkar keramik',
                            'Jasa pelancaran talang rooftop pipa atap mampet kena pasir dan daun',
                            'Pembersihan pipa lemak grease trap dapur restoran',
                        ],
                        'tags' => ['services', 'rooter', 'spiral-baja', 'cctv-pipa', 'grease-trap'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:geo:coverage-areas',
                        'displayName' => 'Cakupan Wilayah Operasional & SLA Teknisi',
                        'type' => 'application/json',
                        'description' => 'Area jangkauan mobilisasi teknisi siaga di seluruh Jabodetabek, Semarang, dan Bandar Lampung.',
                        'data' => [
                            'provinces' => $provinceNames,
                            'cities' => $coverageCities,
                            'totalActiveAreas' => $totalActiveAreas,
                            'emergencyResponseMinutes' => 60,
                            'directoryUrl' => route('area.index'),
                        ],
                        'representativeQueries' => [
                            'Apakah melayani pelancaran pipa di Duren Sawit Jakarta Timur',
                            'Cakupan teknisi pipa di Semarang Barat dan sekitarnya',
                            'Wilayah jangkauan pelancar saluran air di Tangerang Selatan',
                        ],
                        'tags' => ['coverage-area', 'geolocation', 'jabodetabek', 'semarang', 'lampung'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:fleet:equipment',
                        'displayName' => 'Armada Mesin Mekanis & Toolkit Drainase',
                        'type' => 'application/json',
                        'description' => 'Daftar spesifikasi peralatan mekanis drainase berstandar industri tanpa penggunaan bahan kimia korosif.',
                        'data' => [
                            'equipmentList' => $equipments,
                        ],
                        'representativeQueries' => [
                            'Alat apa yang dipakai untuk melancarkan pipa mampet tanpa dibongkar',
                            'Spesifikasi mesin spiral baja Ridgid untuk pipa 4 inch',
                            'Teknologi inspeksi kamera endoskopi saluran pembuangan air',
                        ],
                        'tags' => ['equipment', 'ridgid-k50', 'hydro-jetting', 'cctv-pipe-inspection'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:content:case-studies',
                        'displayName' => 'Studi Kasus Before-After & Portofolio B2B',
                        'type' => 'application/json',
                        'url' => route('gallery'),
                        'description' => 'Bukti pengerjaan dokumentasi pipa sebelum dan sesudah pelancaran serta kerja sama pemeliharaan rutin ruko, restoran, dan gedung.',
                        'representativeQueries' => [
                            'Bukti before after pembersihan pipa saluran pembuangan restoran',
                            'Klien komersial dan restoran yang menggunakan jasa Drainusantara',
                        ],
                        'tags' => ['case-studies', 'before-after', 'b2b-portfolio'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:content:knowledge-base',
                        'displayName' => 'Basis Pengetahuan Edukasi Drainase & Sanitasi',
                        'type' => 'application/json',
                        'url' => route('articles.index'),
                        'description' => 'Artikel edukasi teknis pencegahan saluran tersumbat, bahaya soda api pada pipa PVC, dan pemeliharaan leher angsa.',
                        'representativeQueries' => [
                            'Kenapa soda api berbahaya untuk pipa PVC rumah',
                            'Cara merawat saluran leher angsa wastafel agar tidak mampet',
                        ],
                        'tags' => ['articles', 'diy-safety', 'drainage-tips', 'soda-api-danger'],
                    ],
                    [
                        'identifier' => 'urn:air:drainusantara.com:feed:llms-txt',
                        'displayName' => 'Drainusantara LLMs.txt Context Manifest',
                        'type' => 'text/plain',
                        'url' => route('llms'),
                        'description' => 'Rangkuman lengkap profil bisnis, spesifikasi teknis, harga dasar, dan kontak darurat dalam format Markdown untuk injeksi context window LLM.',
                        'representativeQueries' => [
                            'Ringkasan dokumentasi Drainusantara untuk LLM',
                            'Dapatkan konteks teks lengkap Drainusantara',
                        ],
                        'tags' => ['llms-txt', 'markdown', 'system-prompt-context'],
                    ],
                ],
            ];
        });

        return response()->json($payload, 200, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
            'Cache-Control' => 'public, max-age=3600',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

