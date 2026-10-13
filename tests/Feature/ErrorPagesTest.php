<?php

namespace Tests\Feature;

use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    /**
     * Test HTTP 404 page returns 404 status and renders recovery paths.
     */
    public function test_404_error_page_renders_with_proper_status_and_recovery_paths(): void
    {
        $response = $this->get('/halaman-url-pasti-tidak-ada-' . uniqid());

        $response->assertStatus(404);
        $response->assertSee('Status HTTP 404: Halaman Tidak Ditemukan');
        $response->assertSee('Jalur Tautan Terputus atau Halaman Telah Dipindahkan');
        $response->assertSee('Kembali ke Beranda');
        $response->assertSee('Hubungi Teknisi via WA');
        $response->assertSee('Pencarian Cepat Solusi Masalah Saluran Air');
        $response->assertSee('Wastafel &amp; Cuci Piring', false);
        $response->assertSee('Kloset &amp; Toilet Meluap', false);
        $response->assertSee('Inspeksi Kamera CCTV 30M');
    }

    /**
     * Test HTTP 410 page returns 410 status and transparent copy.
     */
    public function test_410_error_page_renders_with_proper_status_and_transparent_copy(): void
    {
        \Illuminate\Support\Facades\Route::get('/_internal_test/410', fn () => abort(410));

        $response = $this->get('/_internal_test/410');

        $response->assertStatus(410);
        $response->assertSee('Status HTTP 410: Konten Dinonaktifkan Permanen');
        $response->assertSee('Halaman atau Informasi Ini Telah Ditutup Permanen');
        $response->assertSee('Ke Halaman Utama');
        $response->assertSee('Konfirmasi via WhatsApp');
        $response->assertSee('Destinasi Resmi Terkini Drainusantara');
        $response->assertSee('Layanan &amp; Solusi Pipa Terkini', false);
        $response->assertSee('Pusat Pengetahuan Sanitasi');
    }

    /**
     * Test HTTP 500 page returns 500 status and emergency hotline.
     */
    public function test_500_error_page_renders_with_proper_status_and_emergency_hotline(): void
    {
        \Illuminate\Support\Facades\Route::get('/_internal_test/500', fn () => abort(500));

        $response = $this->get('/_internal_test/500');

        $response->assertStatus(500);
        $response->assertSee('Status HTTP 500: Gangguan Sistem Sementara');
        $response->assertSee('Terjadi Kendala Sistem Sementara pada Server Kami');
        $response->assertSee('Hubungi Teknisi via WA');
        $response->assertSee('Muat Ulang Halaman');
        $response->assertSee('Posko Siaga Darurat 24 Jam Nonstop');
        $response->assertSee('Pelayanan Lapangan Pipa Mampet Tetap Berjalan Penuh');
    }

    /**
     * Anti-Slop R-02 Hard Gate: Ensure zero em-dashes across all error views.
     */
    public function test_error_views_strictly_contain_no_em_dash_characters(): void
    {
        $views = [
            resource_path('views/errors/404.blade.php'),
            resource_path('views/errors/410.blade.php'),
            resource_path('views/errors/500.blade.php'),
        ];

        foreach ($views as $viewPath) {
            $this->assertFileExists($viewPath);
            $content = file_get_contents($viewPath);
            
            // Hard Gate: No em dash (—)
            $this->assertStringNotContainsString('—', $content, "Em dash found in {$viewPath}, which violates Anti-Slop R-02 rule.");
            
            // Craftsmanship: No dead href="#" links
            $this->assertStringNotContainsString('href="#"', $content, "Dead href='#' found in {$viewPath}, violating R-26 rule.");
        }
    }
}
