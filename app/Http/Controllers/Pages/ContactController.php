<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasPageSeo;
use App\Models\ContactMessage;
use App\Services\RegionService;
use App\Support\PageMetadata;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use HasPageSeo;

    /**
     * Display the official Contact Us page.
     */
    public function index(): View
    {
        $pageTitle = 'Hubungi Posko Teknisi & Layanan Pelanggan 24 Jam';
        $metaDesc = 'Hubungi pusat layanan Drainusantara: hotline darurat 0856-0900-9009, form permohonan kunjungan teknisi pipa mampet, dan posko siaga Jabodetabek, Bandung, Semarang, Demak, Lampung, hingga Bali.';

        PageMetadata::title($pageTitle);
        SEOMeta::setDescription($metaDesc);
        SEOMeta::setCanonical(route('contact'));

        OpenGraph::setTitle($pageTitle . ' - Drainusantara');
        OpenGraph::setDescription($metaDesc);
        OpenGraph::setUrl(route('contact'));
        OpenGraph::addImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        TwitterCard::setTitle($pageTitle);
        TwitterCard::setDescription($metaDesc);
        TwitterCard::setImage(asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));

        JsonLdMulti::setTitle($pageTitle);
        JsonLdMulti::setType('ContactPage');
        JsonLdMulti::addValues([
            'mainEntity' => [
                '@type' => 'Plumber',
                'name' => 'Drainusantara',
                'telephone' => '+6285609009009',
                'url' => route('contact'),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+6285609009009',
                    'contactType' => 'customer service',
                    'availableLanguage' => ['Indonesian', 'English'],
                    'areaServed' => ['Jabodetabek', 'Bandung', 'Semarang', 'Demak', 'Lampung', 'Bali'],
                ],
            ],
        ]);

        $this->addBreadcrumb(
            ['Beranda', route('home')],
            ['Kontak & Pemesanan', route('contact')]
        );

        $provinces = RegionService::all();

        return view('pages.contact', compact('provinces'));
    }

    /**
     * Store a newly created contact message.
     */
    public function submit(Request $request): RedirectResponse
    {
        // Honeypot anti-spam check
        if (! empty($request->input('website_url'))) {
            return redirect()->route('contact')->with('success', 'Permohonan Anda berhasil dikirim.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'min:8', 'max:20'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'service_type' => ['nullable', 'string', 'max:100'],
            'property_type' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $contact = ContactMessage::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'city' => $validated['city'] ?? null,
            'district' => $validated['district'] ?? null,
            'service_type' => $validated['service_type'] ?? 'Saluran Pipa Mampet',
            'property_type' => $validated['property_type'] ?? 'Rumah Tinggal',
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $waNumber = config('app.whatsapp_number', '6285609009009');
        $directWaText = urlencode("Halo Admin Drainusantara, saya {$contact->name}. Saya telah mengisi formulir pemesanan untuk penanganan '{$contact->service_type}' di area {$contact->city}" . ($contact->district ? ", {$contact->district}" : '') . ". Mohon info teknisi terdekat.");
        $directWaUrl = "https://wa.me/{$waNumber}?text={$directWaText}";

        return redirect()->route('contact')
            ->with('success', 'Permohonan layanan Anda telah diterima tim dispatcher posko Drainusantara! Kami akan segera menghubungi Anda.')
            ->with('direct_wa_url', $directWaUrl);
    }
}

