<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\Equipment;
use App\Models\Portfolio;
use App\Models\Staff;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    use HasPageSeo;

    /**
     * Display the About Us main entry page (delegates to Profil Perusahaan).
     */
    public function about(): View
    {
        return $this->aboutProfile();
    }

    /**
     * Sub-Page 1: Profil Perusahaan
     */
    public function aboutProfile(): View
    {
        PageMetadata::title('Profil Perusahaan: Spesialis Pipa Tanpa Bongkar');
        SEOMeta::setDescription('Profil resmi Drainusantara: spesialis pelancaran pipa mampet tanpa bongkar keramik berstandar mutu tinggi, integritas teknis, dan jaminan garansi 30 hari.');
        SEOMeta::setCanonical(route('about.profile'));

        OpenGraph::setDescription('Mengenal integritas, visi, misi, dan pilar keunggulan teknik Drainusantara dalam melayani perumahan dan komersial.');
        OpenGraph::setUrl(route('about.profile'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Spesialis pelancaran pipa mampet tanpa bongkar keramik bergaransi 30 hari.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Profil Perusahaan Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Profil Perusahaan', 'about.profile');

        $staffMembers = Cache::remember('staff.all_active', 86400, function () {
            return Staff::where('is_active', true)
                ->orderBy('order')
                ->latest('id')
                ->get();
        });

        return view('about.profile', compact('staffMembers'));
    }

    /**
     * Sub-Page 2: Struktur Holding J&J Group
     */
    public function aboutHolding(): View
    {
        PageMetadata::title('Struktur Ekosistem Holding J&J Group');
        SEOMeta::setDescription('Drainusantara bernaung di bawah ekosistem holding J&J Group. Sinergi rantai pasok mesin mekanik impor, kendali mutu, dan standarisasi operasional terpadu.');
        SEOMeta::setCanonical(route('about.holding'));

        OpenGraph::setDescription('Fondasi korporasi kokoh di bawah naungan J&J Group dengan jaringan logistik armada dan pengawasan mutu sanitasi.');
        OpenGraph::setUrl(route('about.holding'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Ekosistem holding sanitasi dan drainase modern di Indonesia.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Struktur Holding J&J Group - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Struktur Holding', 'about.holding');

        return view('about.holding');
    }

    /**
     * Sub-Page 3: Standar Operasional Prosedur (SOP) K3
     */
    public function aboutK3(): View
    {
        PageMetadata::title('Standar SOP K3 & Higienitas Teknisi');
        SEOMeta::setDescription('Protokol K3 resmi teknisi Drainusantara: pemakaian APD steril, cover sepatu saat masuk hunian, keamanan kelistrikan GFCI, dan uji alir sanitasi.');
        SEOMeta::setCanonical(route('about.k3'));

        OpenGraph::setDescription('Disiplin keselamatan kerja dan perlindungan sanitasi ruangan konsumen pada setiap penanganan pipa.');
        OpenGraph::setUrl(route('about.k3'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Protokol higienis, cover sepatu, sarung tangan nitril, dan keamanan kelistrikan.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Standar SOP K3 Teknisi - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('SOP K3', 'about.k3');

        return view('about.sop-k3');
    }

    /**
     * Sub-Page 4: Peralatan & Teknologi
     */
    public function aboutEquipment(): View
    {
        PageMetadata::title('Peralatan & Teknologi Mesin Pipa Modern');
        SEOMeta::setDescription('Spesifikasi mesin drain rooter Ridgid spiral baja rotary, kamera inspeksi visual CCTV IP68 jangkauan 30 meter, dan water jetting pembersih grease trap.');
        SEOMeta::setCanonical(route('about.equipment'));

        OpenGraph::setDescription('Teknologi mekanis spiral baja elastis dan visualisasi kondisi internal pipa dengan kamera endoskopi digital.');
        OpenGraph::setUrl(route('about.equipment'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Mesin spiral Ridgid K-50/K-60 dan kamera pipa CCTV IP68.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addAboutBreadcrumb('Peralatan & Teknologi', 'about.equipment');

        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });

        return view('about.equipment', compact('equipments'));
    }

    /**
     * Sub-Page: Detail Spesifikasi Mesin & Peralatan
     */
    public function equipmentDetail(string $slug): View
    {
        $equipment = Cache::remember('equipment_'.$slug, 86400, function () use ($slug) {
            return Equipment::where('slug', $slug)
                ->where('is_active', true)
                ->with(['galleries' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->firstOrFail();
        });

        $relatedEquipments = Equipment::where('is_active', true)
            ->where('id', '!=', $equipment->id)
            ->orderBy('order')
            ->take(3)
            ->get();

        $pageTitle = $equipment->name.' | Spesifikasi & Teknologi Drainusantara';
        $metaDescription = $equipment->short_description 
            ?: Str::limit(strip_tags((string) ($equipment->description ?? '')), 160)
            ?: "Spesifikasi teknis unit {$equipment->name} armada Drainusantara untuk pelancaran saluran pipa mampet tanpa bongkar.";

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription($metaDescription);
        SEOMeta::setCanonical(route('equipment.show', $slug));

        $imageUrl = $equipment->image ? asset($equipment->image) : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');

        OpenGraph::setTitle($pageTitle);
        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl(route('equipment.show', $slug));
        OpenGraph::addProperty('type', 'product');
        OpenGraph::addImage($imageUrl);

        TwitterCard::setTitle($pageTitle);
        TwitterCard::setDescription($metaDescription);
        TwitterCard::setImage($imageUrl);

        $this->addBreadcrumb(
            ['Tentang Kami', route('about')],
            ['Peralatan & Teknologi', route('about.equipment')],
            [$equipment->name, route('equipment.show', $slug)]
        );

        $productSchema = JsonLdMulti::newJsonLd();
        $productSchema->setType('Product');
        $productSchema->addValues([
            'name' => $equipment->name,
            'description' => $metaDescription,
            'image' => $imageUrl,
            'category' => $equipment->category ?? 'Drain Cleaning Equipment',
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Drainusantara',
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'IDR',
                'lowPrice' => '400000',
                'price' => '400000',
                'availability' => 'https://schema.org/InStock',
            ],
        ]);

        return view('about.equipment-detail', compact('equipment', 'relatedEquipments'));
    }

    /**
     * Sub-Page 5: Klien & Portofolio Rekam Jejak
     */
    public function aboutPortfolio(): View
    {
        PageMetadata::title('Klien & Portofolio Proyek B2B');
        SEOMeta::setDescription('Daftar portofolio klien komersial B2B dan hunian residensial Drainusantara: restoran F&B, hotel bintang, food court, ruko, dan gedung perkantoran.');
        SEOMeta::setCanonical(route('about.portfolio'));

        OpenGraph::setDescription('Kepercayaan puluhan entitas komersial F&B dan perhotelan terhadap solusi drainase tanpa bongkar keramik.');
        OpenGraph::setUrl(route('about.portfolio'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Portofolio pembersihan pipa dan grease trap resto, hotel, dan gedung komersial.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Klien & Portofolio Proyek - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Klien & Portofolio', 'about.portfolio');

        $portfolios = Cache::remember('landing.portfolios', 86400, function () {
            return Portfolio::where('is_active', true)
                ->orderBy('order')
                ->get();
        });

        return view('about.portfolio', compact('portfolios'));
    }

    /**
     * Sub-Page 6: Ketentuan Garansi 30 Hari Kalender
     */
    public function aboutWarranty(): View
    {
        PageMetadata::title('Ketentuan Resmi Garansi 30 Hari Kalender');
        SEOMeta::setDescription('Syarat dan ketentuan resmi jaminan garansi 30 hari kalender Drainusantara, komitmen No Cure No Pay, serta alur klaim kunjungan ulang bebas biaya.');
        SEOMeta::setCanonical(route('about.warranty'));

        OpenGraph::setDescription('Perlindungan purna jual nyata: nota digital resmi, komitmen No Cure No Pay, dan respon klaim prioritas.');
        OpenGraph::setUrl(route('about.warranty'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Jaminan garansi 30 hari kalender dan komitmen No Cure No Pay.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Ketentuan Resmi Garansi 30 Hari - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Ketentuan Garansi', 'about.warranty');

        return view('about.warranty');
    }

    /**
     * Sub-Page 7: FAQ (Tanya Jawab Seputar Layanan)
     */
    public function aboutFaq(): View
    {
        PageMetadata::title('Tanya Jawab (FAQ) Pelancaran Pipa');
        SEOMeta::setDescription('Kumpulan tanya jawab teknis: mengapa soda api merusak pipa PVC, durasi pengerjaan rooter spiral, transparansi biaya, dan cara klaim garansi.');
        SEOMeta::setCanonical(route('about.faq'));

        OpenGraph::setDescription('Informasi transparan seputar metode pengerjaan tanpa bongkar keramik, peralatan, dan jaminan keamanan sanitasi.');
        OpenGraph::setUrl(route('about.faq'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription('Tanya jawab teknis seputar pelancaran pipa tanpa bongkar keramik.');
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle('Tanya Jawab (FAQ) - Drainusantara');
        JsonLdMulti::setType('FAQPage');
        JsonLdMulti::addValues([
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Mengapa Drainusantara melarang keras penggunaan soda api?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Soda api memicu reaksi eksotermik panas ekstrem hingga di atas 100°C yang melunakkan, merusak lem, dan memecahkan pipa PVC cor di dalam lantai, serta memadatkan endapan lemak menjadi sekeras semen.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Berapa lama estimasi waktu pengerjaan pelancaran pipa?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => config('service_facts.duration_answer'),
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Apakah penanganan saluran memerlukan pembongkaran lantai atau keramik?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Tidak perlu. Metode mekanis spiral baja elastis masuk mengikuti jalur belokan pipa langsung dari lubang saringan atau leher angsa porselen tanpa membongkar keramik.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Bagaimana ketentuan jaminan garansi 30 hari kalender?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Setiap pengerjaan tuntas dilindungi nota digital garansi 30 hari. Jika saluran mampet kembali dalam masa garansi akibat residu titik yang sama, teknisi datang melancarkan ulang tanpa biaya tambahan.',
                    ],
                ],
            ],
        ]);

        $this->addAboutBreadcrumb('FAQ', 'about.faq');

        return view('about.faq');
    }
}

