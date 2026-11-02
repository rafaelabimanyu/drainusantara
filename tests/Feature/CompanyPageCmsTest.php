<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CompanyPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CompanyPageCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_company_pages_cms(): void
    {
        $response = $this->get(route('admin.company-pages.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_company_pages_list(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.company-pages.index'));
        $response->assertOk();
        $response->assertSee('Manajemen Halaman Tentang Kami');
        $response->assertSee('profil');
        $response->assertSee('cara-kerja');
        $response->assertSee('holding');
        $response->assertSee('sop-k3');
        $response->assertSee('peralatan');
        $response->assertSee('kemitraan');
        $response->assertSee('garansi');
    }

    public function test_admin_can_update_company_page(): void
    {
        $admin = User::factory()->create();
        $page = CompanyPage::getByKey('garansi');

        $response = $this->actingAs($admin)->put(route('admin.company-pages.update', $page), [
            'title' => 'Ketentuan Resmi Garansi 30 Hari Termutakhir',
            'subtitle' => 'Komitmen perlindungan purna jual resmi tanpa biaya tambahan.',
            'meta_title' => 'Garansi 30 Hari Termutakhir Drainusantara',
            'meta_description' => 'Ketentuan resmi garansi purna jual 30 hari kalender dengan jaminan No Cure No Pay.',
            'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
            'content' => 'Konten garansi yang telah diperbarui oleh admin.',
            'sections_data_raw' => json_encode(['rules' => [['title' => 'Aturan Khusus', 'desc' => 'Deskripsi aturan']]]),
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.company-pages.index'));
        $response->assertSessionHas('success');

        $page->refresh();
        $this->assertEquals('Ketentuan Resmi Garansi 30 Hari Termutakhir', $page->title);
        $this->assertEquals('Garansi 30 Hari Termutakhir Drainusantara', $page->meta_title);
        $this->assertTrue($page->is_active);
    }

    public function test_public_about_pages_render_company_page_data(): void
    {
        $profile = CompanyPage::getByKey('profil');
        $profile->update([
            'title' => 'Profil Resmi Drainusantara Indonesia',
            'meta_title' => 'Profil Resmi Drainusantara Indonesia - Ahli Pipa',
        ]);

        $response = $this->get(route('about.profile'));
        $response->assertOk();
        $response->assertSee('Profil Resmi Drainusantara Indonesia - Ahli Pipa');

        $warranty = CompanyPage::getByKey('garansi');
        $warranty->update([
            'meta_title' => 'Garansi 30 Hari Kalender Resmi Drainusantara',
        ]);

        $responseWarranty = $this->get(route('about.warranty'));
        $responseWarranty->assertOk();
        $responseWarranty->assertSee('Garansi 30 Hari Kalender Resmi Drainusantara');
    }

    public function test_admin_can_refresh_cache_and_send_seo_signal(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.system.refresh-cache'));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertTrue(Cache::has('seo.last_ping'));
    }
}

