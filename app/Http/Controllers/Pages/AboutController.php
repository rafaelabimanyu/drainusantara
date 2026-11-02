<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\CompanyPage;
use App\Models\Equipment;
use App\Models\Faq;
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
        $companyPage = CompanyPage::getByKey('profil');

        PageMetadata::title($companyPage->meta_title ?: 'Profil Perusahaan: Spesialis Pipa Tanpa Bongkar');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Profil resmi Drainusantara: spesialis pelancaran pipa mampet tanpa bongkar keramik berstandar mutu tinggi, integritas teknis, dan jaminan garansi 30 hari.');
        SEOMeta::setCanonical(route('about.profile'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Mengenal integritas, visi, misi, dan pilar keunggulan teknik Drainusantara dalam melayani perumahan dan komersial.');
        OpenGraph::setUrl(route('about.profile'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Spesialis pelancaran pipa mampet tanpa bongkar keramik bergaransi 30 hari.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Profil Perusahaan Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Profil Perusahaan', 'about.profile');

        $staffMembers = Cache::remember('staff.all_active', 86400, function () {
            return Staff::where('is_active', true)
                ->orderBy('order')
                ->latest('id')
                ->get();
        });

        return view('about.profile', compact('staffMembers', 'companyPage'));
    }

    /**
     * Sub-Page 2: Struktur Holding J&J Group
     */
    public function aboutHolding(): View
    {
        $companyPage = CompanyPage::getByKey('holding');

        PageMetadata::title($companyPage->meta_title ?: 'Struktur Ekosistem Holding J&J Group');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Drainusantara bernaung di bawah ekosistem holding J&J Group. Sinergi rantai pasok mesin mekanik impor, kendali mutu, dan standarisasi operasional terpadu.');
        SEOMeta::setCanonical(route('about.holding'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Fondasi korporasi kokoh di bawah naungan J&J Group dengan jaringan logistik armada dan pengawasan mutu sanitasi.');
        OpenGraph::setUrl(route('about.holding'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Ekosistem holding sanitasi dan drainase modern di Indonesia.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Struktur Holding J&J Group - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Struktur Holding', 'about.holding');

        return view('about.holding', compact('companyPage'));
    }

    /**
     * Sub-Page 3: Standar Operasional Prosedur (SOP) K3
     */
    public function aboutK3(): View
    {
        $companyPage = CompanyPage::getByKey('sop-k3');

        PageMetadata::title($companyPage->meta_title ?: 'Standar SOP K3 & Higienitas Teknisi');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Protokol K3 resmi teknisi Drainusantara: pemakaian APD steril, cover sepatu saat masuk hunian, keamanan kelistrikan GFCI, dan uji alir sanitasi.');
        SEOMeta::setCanonical(route('about.k3'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Disiplin keselamatan kerja dan perlindungan sanitasi ruangan konsumen pada setiap penanganan pipa.');
        OpenGraph::setUrl(route('about.k3'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Protokol higienis, cover sepatu, sarung tangan nitril, dan keamanan kelistrikan.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Standar SOP K3 Teknisi - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('SOP K3', 'about.k3');

        return view('about.sop-k3', compact('companyPage'));
    }

    /**
     * Sub-Page 4: Peralatan & Teknologi
     */
    public function aboutEquipment(): View
    {
        $companyPage = CompanyPage::getByKey('peralatan');

        PageMetadata::title($companyPage->meta_title ?: 'Peralatan & Teknologi Mesin Pipa Modern');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Spesifikasi mesin drain rooter Ridgid spiral baja rotary, kamera inspeksi visual CCTV IP68 jangkauan 30 meter, dan water jetting pembersih grease trap.');
        SEOMeta::setCanonical(route('about.equipment'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Teknologi mekanis spiral baja elastis dan visualisasi kondisi internal pipa dengan kamera endoskopi digital.');
        OpenGraph::setUrl(route('about.equipment'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Mesin spiral Ridgid K-50/K-60 dan kamera pipa CCTV IP68.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
        $this->addAboutBreadcrumb('Peralatan & Teknologi', 'about.equipment');

        $equipments = Cache::remember('equipments.all_active', 86400, function () {
            return Equipment::where('is_active', true)->orderBy('order')->get();
        });

        return view('about.equipment', compact('equipments', 'companyPage'));
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
        $companyPage = CompanyPage::getByKey('kemitraan');

        PageMetadata::title($companyPage->meta_title ?: 'Klien & Portofolio Proyek B2B');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Daftar portofolio klien komersial B2B dan hunian residensial Drainusantara: restoran F&B, hotel bintang, food court, ruko, dan gedung perkantoran.');
        SEOMeta::setCanonical(route('about.portfolio'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Kepercayaan puluhan entitas komersial F&B dan perhotelan terhadap solusi drainase tanpa bongkar keramik.');
        OpenGraph::setUrl(route('about.portfolio'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Portofolio pembersihan pipa dan grease trap resto, hotel, dan gedung komersial.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Klien & Portofolio Proyek - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Klien & Portofolio', 'about.portfolio');

        $portfolios = Cache::remember('landing.portfolios', 86400, function () {
            return Portfolio::where('is_active', true)
                ->orderBy('order')
                ->get();
        });

        return view('about.portfolio', compact('portfolios', 'companyPage'));
    }

    /**
     * Sub-Page 6: Ketentuan Garansi 30 Hari Kalender
     */
    public function aboutWarranty(): View
    {
        $companyPage = CompanyPage::getByKey('garansi');

        PageMetadata::title($companyPage->meta_title ?: 'Ketentuan Resmi Garansi 30 Hari Kalender');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Syarat dan ketentuan resmi jaminan garansi 30 hari kalender Drainusantara, komitmen No Cure No Pay, serta alur klaim kunjungan ulang bebas biaya.');
        SEOMeta::setCanonical(route('about.warranty'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Perlindungan purna jual nyata: nota digital resmi, komitmen No Cure No Pay, dan respon klaim prioritas.');
        OpenGraph::setUrl(route('about.warranty'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Jaminan garansi 30 hari kalender dan komitmen No Cure No Pay.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Ketentuan Resmi Garansi 30 Hari - Drainusantara');
        JsonLdMulti::setType('AboutPage');
        $this->addAboutBreadcrumb('Ketentuan Garansi', 'about.warranty');

        return view('about.warranty', compact('companyPage'));
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

        $rawFaqs = Faq::active()->ordered()->get();
        if ($rawFaqs->isEmpty()) {
            $faqs = [
                [
                    'id' => 1,
                    'category' => 'teknis',
                    'question' => 'Apakah benar proses pengerjaan 100% tanpa membongkar keramik lantai atau dinding?',
                    'answer' => 'Benar 100%. Teknisi Drainusantara menggunakan unit mesin spiral rotary Ridgid dengan kabel baja lentur berkecepatan putar terukur serta nozel Hydro-Jetting bertekanan air. Akses pengerjaan langsung melalui lubang afur wastafel, floor drain, kloset, atau bak kontrol eksisting sehingga ubin keramik dan struktur dinding Anda tetap utuh.',
                ],
                [
                    'id' => 2,
                    'category' => 'teknis',
                    'question' => 'Mengapa pemakaian soda api sangat dilarang keras untuk pipa pembuangan PVC?',
                    'answer' => 'Soda api memicu reaksi eksotermik panas ekstrem hingga di atas 90°C yang melunakkan pipa PVC dan merusak sambungan lem elbow. Selain itu, residu kimianya akan mengalami saponifikasi dan mengeras menjadi kerak kapur padat seperti batu semen.',
                ],
                [
                    'id' => 3,
                    'category' => 'durasi',
                    'question' => 'Berapa lama rata-rata durasi pengerjaan pelancaran saluran pipa?',
                    'answer' => config('service_facts.duration_answer'),
                ],
                [
                    'id' => 4,
                    'category' => 'biaya',
                    'question' => 'Bagaimana sistem penentuan biaya jasa dan apakah ada risiko biaya tersembunyi?',
                    'answer' => 'Drainusantara menerapkan sistem harga transparan berdasarkan jenis titik saluran dan estimasi panjang jangkauan meteran pipa. Seluruh rincian biaya dikonfirmasi di awal dengan komitmen No Cure No Pay.',
                ],
                [
                    'id' => 5,
                    'category' => 'garansi',
                    'question' => 'Bagaimana prosedur dan ketentuan klaim garansi 30 hari resmi?',
                    'answer' => 'Setiap pengerjaan dilengkapi nota digital resmi berstempel. Cukup hubungi WhatsApp Customer Care jika terjadi kendala pada titik yang sama dalam 30 hari kalender untuk kunjungan ulang 100% gratis.',
                ],
            ];
        } else {
            $faqs = $rawFaqs->map(fn ($item) => [
                'id' => $item->id,
                'category' => $item->category,
                'question' => $item->question,
                'answer' => $item->answer,
            ])->all();
        }

        JsonLdMulti::setTitle('Tanya Jawab (FAQ) - Drainusantara');
        JsonLdMulti::setType('FAQPage');
        JsonLdMulti::addValues([
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ], $faqs),
        ]);

        $this->addAboutBreadcrumb('FAQ', 'about.faq');
        $categories = Faq::categories();

        return view('about.faq', compact('faqs', 'categories'));
    }

    /**
     * Sub-Page / Standalone Page: Cara Kerja & Standar Proses Non-Destruktif
     */
    public function howItWorks(): View
    {
        $companyPage = CompanyPage::getByKey('cara-kerja');

        PageMetadata::title($companyPage->meta_title ?: 'Cara Kerja & Proses Pelancaran Pipa Tanpa Bongkar');
        SEOMeta::setDescription($companyPage->meta_description ?: 'Pelajari 5 tahap proses kerja mekanis Drainusantara: deteksi CCTV endoskopi, penetrasi spiral baja Ridgid, pengikisan kerak pipa, uji alir debit air, dan garansi 30 hari.');
        SEOMeta::setCanonical(route('how-it-works'));

        OpenGraph::setDescription($companyPage->meta_description ?: 'Standar kerja profesional 100% mekanis tanpa bongkar keramik lantai dan bebas soda api korosif.');
        OpenGraph::setUrl(route('how-it-works'));
        OpenGraph::addImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setDescription($companyPage->meta_description ?: 'Metodologi sistematis penanganan saluran pipa mampet tanpa bongkar bergaransi 30 hari.');
        TwitterCard::setImage(asset($companyPage->hero_image ?: 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($companyPage->meta_title ?: 'Cara Kerja & Standar Proses Pelancaran Pipa - Drainusantara');
        JsonLdMulti::setType('HowTo');
        $this->addAboutBreadcrumb('Cara Kerja & Proses', 'how-it-works');

        return view('about.how-it-works', compact('companyPage'));
    }
}

