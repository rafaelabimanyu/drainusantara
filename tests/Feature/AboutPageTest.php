<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_seven_tentang_kami_sub_pages_render_successfully(): void
    {
        // 1. Profil Perusahaan
        $resProfile = $this->get('/tentang-kami/profil');
        $resProfile->assertStatus(200);
        $resProfile->assertSee('Profil Resmi Drainusantara');
        $resProfile->assertSee('PT JAWA JAYA ROOTER');
        $resProfile->assertSee('100% Non-Destruktif');
        $resProfile->assertSee('Bebas Bahan Kimia');
        $resProfile->assertSee('STAFF &amp; TEKNISI DRAINUSANTARA PT JAWA JAYA ROOTER', false);
        $resProfile->assertSee('Staff &amp; Teknisi Lapangan Siaga', false);
        $resProfile->assertSee('Daftar Staff &amp; Teknisi Lapangan Sedang Diperbarui', false);

        // Main alias /tentang-kami
        $resMain = $this->get('/tentang-kami');
        $resMain->assertStatus(200);
        $resMain->assertSee('Profil Resmi Drainusantara');
        $resMain->assertSee('STANDAR PERALATAN TEKNISI');
        $resMain->assertSee('Peralatan Mekanis &amp; Diagnosis Visual Armada', false);

        // 2. Struktur Holding J&J Group
        $resHolding = $this->get('/tentang-kami/holding');
        $resHolding->assertStatus(200);
        $resHolding->assertSee('Sinergi Ekosistem J&amp;J Group', false);
        $resHolding->assertSee('PT JAWA JAYA ROOTER');
        $resHolding->assertSee('Transparansi Harga Total');
        $resHolding->assertSee('Formalitas Kelengkapan Administrasi &amp; Kemitraan Korporat', false);
        $resHolding->assertSee('NIB (Nomor Induk Berusaha)');
        $resHolding->assertSee('NPWP &amp; SPPKP Perusahaan', false);
        $resHolding->assertSee('Faktur Pajak PPN 11%');

        // Test alias redirect holding-jj-group
        $resHoldingAlias = $this->get('/tentang-kami/holding-jj-group');
        $resHoldingAlias->assertRedirect(route('about.holding'));

        // 3. SOP K3
        $resK3 = $this->get('/tentang-kami/sop-k3');
        $resK3->assertStatus(200);
        $resK3->assertSee('Perlengkapan APD K3 Teknisi Lapangan Drainusantara');
        $resK3->assertSee('Protokol Desinfeksi Mesin Ridgid &amp; Hydro-Jetting', false);
        $resK3->assertSee('Point Checklist Verifikasi Pasca Kerja');

        // 4. Peralatan & Teknologi
        $resEquip = $this->get('/tentang-kami/peralatan');
        $resEquip->assertStatus(200);
        $resEquip->assertSee('Peralatan Mekanis Spiral Baja &amp; Kamera Inspeksi CCTV', false);
        $resEquip->assertSee('Ridgid K-50 &amp; K-60', false);
        $resEquip->assertSee('IP68 30 Meter');
        $resEquip->assertSee('Detail Spesifikasi &amp; SOP', false);
        $resEquip->assertSee(route('equipment.show', 'mesin-rooter-ridgid-k-50-cable-spiral'));

        // 5. Klien & Portofolio: project details come from active CMS entries.
        \App\Models\Portfolio::create([
            'client_name' => 'Klien Pengujian',
            'project_title' => 'Perawatan Grease Trap',
            'is_active' => true,
        ]);
        $resPortfolio = $this->get('/tentang-kami/portofolio');
        $resPortfolio->assertStatus(200);
        $resPortfolio->assertSee('Dipercaya Restoran F&amp;B, Perhotelan &amp; Gedung Komersial', false);
        $resPortfolio->assertSee('Grease Trap');

        // 6. Ketentuan Garansi 30 Hari
        $resWarranty = $this->get('/tentang-kami/garansi');
        $resWarranty->assertStatus(200);
        $resWarranty->assertSee('4 Pilar Jaminan Garansi Drainusantara');
        $resWarranty->assertSee('Alur Klaim 3 Langkah Cepat');
        $resWarranty->assertSee('Syarat &amp; Ketentuan Klaim Garansi', false);
        $resWarranty->assertSee('Cakupan Garansi');

        // 7. FAQ
        $resFaq = $this->get('/tentang-kami/faq');
        $resFaq->assertStatus(200);
        $resFaq->assertSee('Tanya Jawab Seputar Layanan &amp; Prosedur Pengerjaan', false);
        $resFaq->assertSee('Mengapa pemakaian soda api sangat dilarang');

        // 8. Cara Kerja & Standar Proses
        $resHow = $this->get('/cara-kerja');
        $resHow->assertStatus(200);
        $resHow->assertSee('5 Tahapan Pelancaran Saluran Pipa Mekanis');
        $resHow->assertSee('PT JAWA JAYA ROOTER');
        $resHow->assertSee('Ridgid Rotary Rooter');
        $resHow->assertSee('No Cure No Pay');
        $resHow->assertSee('Diagnosa &amp; Inspeksi Visual Endoskopi CCTV', false);
        $resHow->assertSee('Sanitasi Area Kerja &amp; Penerbitan Surat Garansi 30 Hari', false);
    }

    public function test_navbar_contains_tentang_kami_dropdown_linking_to_dedicated_pages_without_pills(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Desktop popover dropdown and triggers
        $response->assertSee('activeMenu === \'tentang\'', false);
        $response->assertSee('Struktur Holding J&amp;J Group', false);
        $response->assertSee('SOP K3');
        $response->assertSee('Profil Perusahaan');
        $response->assertSee('Peralatan &amp; Teknologi', false);
        $response->assertSee('Perusahaan &amp; Portofolio Klien', false);
        $response->assertSee('Ketentuan Garansi 30 Hari');
        $response->assertSee('FAQ');

        // Sub-page route links in dropdown
        $response->assertSee(route('about.holding'));
        $response->assertSee(route('about.k3'));
        $response->assertSee(route('about.profile'));
        $response->assertSee(route('how-it-works'));
        $response->assertSee(route('about.equipment'));
        $response->assertSee(route('about.portfolio'));
        $response->assertSee(route('about.warranty'));
        $response->assertSee(route('about.faq'));

        // Footer hotline & official legal name
        $response->assertSee('PT JAWA JAYA ROOTER');
        $response->assertSee('0856-0900-9009');

        // Mobile drawer accordion trigger
        $response->assertSee('tentangDrawerOpen', false);

        // Ensure NO pill badges exist on the edge/corner of dropdown items
        $response->assertDontSee('rounded bg-slate-100 text-slate-600 font-bold">Holding</span>', false);
        $response->assertDontSee('rounded bg-amber-100 text-amber-800 font-bold">K3</span>', false);
        $response->assertDontSee('rounded bg-sky-100 text-sky-800 font-bold">Profil</span>', false);
        $response->assertDontSee('rounded bg-indigo-100 text-indigo-800 font-bold">Alat</span>', false);
        $response->assertDontSee('rounded bg-emerald-100 text-emerald-800 font-bold">B2B</span>', false);
        $response->assertDontSee('rounded bg-teal-100 text-teal-800 font-bold">Garansi</span>', false);
    }
}
