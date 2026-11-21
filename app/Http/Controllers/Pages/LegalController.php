<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;

class LegalController extends Controller
{
    /**
     * Display the Privacy Policy page.
     */
    public function privacy(): View
    {
        $description = 'Kebijakan privasi resmi Drainusantara PT JAWA JAYA ROOTER. Komitmen perlindungan data pelanggan, kerahasiaan informasi kontak, dan keamanan privasi layanan.';

        PageMetadata::title('Kebijakan Privasi (Privacy Policy)');
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        JsonLdMulti::setTitle('Kebijakan Privasi (Privacy Policy) - Drainusantara');
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('WebPage');

        return view('legal.privacy');
    }

    /**
     * Display the Terms of Service page.
     */
    public function terms(): View
    {
        $description = 'Syarat dan ketentuan resmi pengerjaan saluran pipa mampet Drainusantara PT JAWA JAYA ROOTER. Standar mekanis tanpa bongkar, ketentuan garansi 30 hari, dan transparansi biaya.';

        PageMetadata::title('Syarat & Ketentuan Layanan (Terms of Service)');
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(url()->current());
        JsonLdMulti::setTitle('Syarat & Ketentuan Layanan (Terms of Service) - Drainusantara');
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setType('WebPage');

        return view('legal.terms');
    }
}

