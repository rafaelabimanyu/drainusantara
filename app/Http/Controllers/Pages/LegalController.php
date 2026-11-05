<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;

class LegalController extends Controller
{
    /**
     * Display the Privacy Policy page.
     */
    public function privacy(): View
    {
        PageMetadata::title('Kebijakan Privasi (Privacy Policy)');
        SEOMeta::setDescription('Kebijakan privasi resmi Drainusantara PT JAWA JAYA ROOTER. Komitmen perlindungan data pelanggan, kerahasiaan informasi kontak, dan keamanan privasi layanan.');
        SEOMeta::setCanonical(url()->current());

        return view('legal.privacy');
    }

    /**
     * Display the Terms of Service page.
     */
    public function terms(): View
    {
        PageMetadata::title('Syarat & Ketentuan Layanan (Terms of Service)');
        SEOMeta::setDescription('Syarat dan ketentuan resmi pengerjaan saluran pipa mampet Drainusantara PT JAWA JAYA ROOTER. Standar mekanis tanpa bongkar, ketentuan garansi 30 hari, dan transparansi biaya.');
        SEOMeta::setCanonical(url()->current());

        return view('legal.terms');
    }
}

