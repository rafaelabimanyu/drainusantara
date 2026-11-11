<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Artesaos\SEOTools\Facades\JsonLdMulti;

trait HasPageSeo
{
    /**
     * Add standard About Us breadcrumbs to JSON-LD BreadcrumbList.
     */
    protected function addAboutBreadcrumb(string $name, string $route): void
    {
        $this->addBreadcrumb(['Tentang Kami', route('about')], [$name, route($route)]);
    }

    /**
     * Build and attach a clean JSON-LD BreadcrumbList schema.
     */
    protected function addBreadcrumb(array ...$entries): void
    {
        $items = [['Beranda', url('/')], ...$entries];
        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => array_map(
                static fn (array $entry, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $entry[0],
                    'item' => $entry[1],
                ],
                $items,
                array_keys($items)
            ),
        ]);
    }

    /**
     * Format official hotline phone into E.164 international format for Schema JSON-LD.
     */
    protected function formatInternationalPhone(): string
    {
        $raw = (string) config('app.whatsapp_number', '6285609009009');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        return '+'.($digits !== '' ? $digits : '6285609009009');
    }

    /**
     * Official Headquarters Postal Address (Lubang Buaya, Cipayung, Jakarta Timur 13810).
     */
    protected function getHeadquartersAddress(): array
    {
        return [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung',
            'addressLocality' => 'Kota Jakarta Timur',
            'addressRegion' => 'DKI Jakarta',
            'postalCode' => '13810',
            'addressCountry' => 'ID',
        ];
    }

    /**
     * Official Headquarters GeoCoordinates.
     */
    protected function getHeadquartersGeo(): array
    {
        return [
            '@type' => 'GeoCoordinates',
            'latitude' => -6.2906,
            'longitude' => 106.8974,
        ];
    }

    /**
     * Get verified SameAs array linking to official Google Business Profile / Maps and Social profiles.
     */
    protected function getSameAsUrls(): array
    {
        $urls = [
            config('services.company.google_maps_url'),
            config('services.social.instagram'),
            config('services.social.tiktok'),
            config('services.social.facebook'),
            config('services.social.youtube'),
            config('services.social.linkedin'),
        ];

        return array_values(array_filter($urls, fn ($url) => ! empty($url) && is_string($url) && filter_var($url, FILTER_VALIDATE_URL)));
    }

    /**
     * Clean parent organization entity linked via @id.
     */
    protected function getParentOrganizationSchema(): array
    {
        return [
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => 'PT Jawa Jaya Rooter',
            'legalName' => 'PT Jawa Jaya Rooter',
            'url' => url('/'),
            'logo' => asset('images/logo/WebIcon.webp'),
            'telephone' => $this->formatInternationalPhone(),
            'email' => (string) config('services.company.email', 'drainusantara@gmail.com'),
            'address' => $this->getHeadquartersAddress(),
        ];
    }
}
