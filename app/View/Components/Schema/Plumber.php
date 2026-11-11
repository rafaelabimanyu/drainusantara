<?php

declare(strict_types=1);

namespace App\View\Components\Schema;

use App\Models\CoverageArea;
use App\Models\Service;
use App\Services\RegionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Plumber extends Component
{
    /**
     * The compiled Schema.org structured data array.
     *
     * @var array<string, mixed>
     */
    public array $schema = [];

    /**
     * Methods that should not be exposed to the view.
     *
     * @var array<int, string>
     */
    protected $except = ['schema', 'buildSchema', 'toArray'];

    /**
     * Create a new Plumber LocalBusiness schema component instance.
     */
    public function __construct(
        public ?CoverageArea $area = null,
        public ?array $cityData = null,
        public ?string $citySlug = null,
        public ?string $district = null,
        public string $name = 'PT JAWA JAYA ROOTER',
        public string $telephone = '+6285609009009',
        public ?string $url = null,
        public ?string $image = null,
        public int|float|string|null $price = null,
    ) {
        $this->schema = $this->buildSchema();
    }

    /**
     * Build the structured Plumber (LocalBusiness) schema array.
     *
     * @return array<string, mixed>
     */
    public function buildSchema(): array
    {
        $city = $this->citySlug 
            ?? ($this->cityData['slug'] 
                ?? ($this->area?->city ? Str::slug($this->area->city) : 'jakarta-pusat'));

        $districtName = $this->district 
            ?? ($this->area?->district && ! $this->area->isCity() && ! $this->area->isProvince() 
                ? $this->area->district 
                : null);

        $coords = ($this->area?->latitude && $this->area?->longitude)
            ? ['lat' => (float) $this->area->latitude, 'lng' => (float) $this->area->longitude]
            : RegionService::centroid($city, $districtName);

        $canonicalUrl = $this->url ?? url()->current();
        $imageUrl = $this->image ?? asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');
        $resolvedPrice = $this->price ?? ($this->area?->resolved_price ?? 400000);

        $services = Cache::remember('schema.plumber.services', 86400, function () {
            try {
                return Service::where('is_active', true)
                    ->orderBy('order')
                    ->get(['name', 'short_description', 'price_starting_from']);
            } catch (\Throwable) {
                return collect();
            }
        });

        $offerItems = [];
        if ($services->isNotEmpty()) {
            foreach ($services as $srv) {
                $offerItems[] = [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $srv->name,
                        'description' => $srv->short_description ?: 'Pelancaran saluran pipa mampet tanpa bongkar keramik.',
                    ],
                    'priceSpecification' => [
                        '@type' => 'PriceSpecification',
                        'price' => $srv->price_starting_from ?: $resolvedPrice,
                        'priceCurrency' => 'IDR',
                    ],
                ];
            }
        } else {
            $offerItems[] = [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => 'Pelancaran Saluran Pipa Tanpa Bongkar',
                    'description' => 'Penanganan wastafel, kloset toilet, dan floor drain dengan mesin spiral rotary.',
                ],
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => $resolvedPrice,
                    'priceCurrency' => 'IDR',
                ],
            ];
        }

        $cityName = $this->cityData['name'] ?? ($this->area?->city ?? 'Jabodetabek');
        $provinceName = $this->cityData['province_name'] ?? ($this->area?->province_name ?? 'Indonesia');

        $areaServed = $districtName
            ? [
                '@type' => 'AdministrativeArea',
                'name' => "Kecamatan {$districtName}",
                'containedInPlace' => [
                    '@type' => 'City',
                    'name' => $cityName,
                ],
            ]
            : ($this->cityData 
                ? (array_map(fn ($d) => [
                    '@type' => 'AdministrativeArea',
                    'name' => "Kecamatan {$d}",
                ], $this->cityData['districts'] ?? []) ?: "{$cityName}, {$provinceName}")
                : ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali']);

        $address = [
            '@type' => 'PostalAddress',
            'streetAddress' => $this->area?->posko_address ?: ($this->cityData['posko_address'] ?? "Posko Armada Siaga {$cityName}"),
            'addressLocality' => $districtName ?: $cityName,
            'addressRegion' => $provinceName,
            'addressCountry' => 'ID',
        ];

        if (! empty($this->area?->postal_code)) {
            $address['postalCode'] = $this->area->postal_code;
        }

        $sameAs = array_values(array_filter([
            config('services.company.maps_url'),
            config('services.social.instagram'),
            config('services.social.tiktok'),
            config('services.social.youtube'),
            config('services.social.facebook'),
            config('services.social.linkedin'),
            'https://www.wikidata.org/wiki/Q193633',
            'https://www.wikidata.org/wiki/Q258385',
        ]));

        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'Plumber',
            'name' => $this->name,
            'alternateName' => 'Drainusantara',
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Drainusantara',
            ],
            'legalName' => 'PT JAWA JAYA ROOTER',
            'url' => $canonicalUrl,
            'image' => $imageUrl,
            'telephone' => $this->telephone,
            'priceRange' => 'Mulai Rp ' . number_format((float) $resolvedPrice, 0, ',', '.'),
            'openingHours' => 'Mo-Su 00:00-24:00',
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => 48,
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng'],
            ],
            'areaServed' => $areaServed,
            'address' => $address,
            'serviceType' => [
                'Jasa Saluran Mampet',
                'Jasa Pipa Mampet',
                'Pelancaran Pipa Tanpa Bongkar',
                'Plumber',
                'Drain Cleaning Service',
                'Rooter Service',
            ],
            'sameAs' => $sameAs,
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Layanan Pelancaran Pipa Mampet',
                'itemListElement' => $offerItems,
            ],
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'PT JAWA JAYA ROOTER',
                'url' => url('/'),
            ],
        ];

        if ($mapsUrl = config('services.company.maps_url')) {
            $schemaData['hasMap'] = $mapsUrl;
        }

        return $schemaData;
    }

    /**
     * Return the schema array.
     *
     * @return array<string, mixed>
     */
    public function schema(): array
    {
        return $this->schema;
    }

    /**
     * Return the schema array as array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->schema;
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('components.schema.plumber', [
            'schema' => $this->schema,
        ]);
    }
}

