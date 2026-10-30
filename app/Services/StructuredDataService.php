<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Builds the schema.org JSON-LD blocks of the public pages.
 */
final class StructuredDataService
{
    public function organizationId(): string
    {
        return url('/').'/#organization';
    }

    public function founderId(): string
    {
        return url('/').'/#fekete-richard';
    }

    /**
     * The site-wide graph: the company, its founder and, on every page below the
     * home page, the breadcrumb trail leading to it.
     *
     * @param  list<array{name: string, url: string}>  $breadcrumbs
     * @return array<string, mixed>
     */
    public function siteGraph(array $breadcrumbs = []): array
    {
        $graph = [
            [
                '@type' => ['Organization', 'RealEstateAgent'],
                '@id' => $this->organizationId(),
                'name' => 'PSG Irodaházak',
                'legalName' => 'Property Solution Group Kft.',
                'alternateName' => 'PSG-IRODAHÁZAK',
                'url' => url('/').'/',
                'logo' => $this->logoUrl(),
                'image' => $this->logoUrl(),
                'foundingDate' => '2014',
                'telephone' => '+36 20 381 3917',
                'email' => 'info@psg-irodahazak.hu',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Derék u. 2.',
                    'postalCode' => '1016',
                    'addressLocality' => 'Budapest',
                    'addressCountry' => 'HU',
                ],
                'areaServed' => 'Budapest',
                'vatID' => '24963200-2-41',
                'sameAs' => config('seo.organization_same_as'),
                'founder' => ['@id' => $this->founderId()],
            ],
            [
                '@type' => 'Person',
                '@id' => $this->founderId(),
                'name' => 'Fekete Richárd',
                'jobTitle' => 'ügyvezető, társtulajdonos',
                'worksFor' => ['@id' => $this->organizationId()],
                'sameAs' => config('seo.founder_same_as'),
            ],
        ];

        if (count($breadcrumbs) > 1) {
            $graph[] = [
                '@type' => 'BreadcrumbList',
                'itemListElement' => array_map(fn (array $crumb, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $crumb['name'],
                    'item' => $crumb['url'],
                ], $breadcrumbs, array_keys($breadcrumbs)),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * The office building as a Place, with its listed parameters, its services,
     * and the rental (or sale) offer made for it.
     *
     * @return array<string, mixed>
     */
    public function property(Property $property, string $url): array
    {
        $place = array_filter([
            '@type' => 'Place',
            '@id' => $url.'#place',
            'name' => $property->title,
            'url' => $url,
            'image' => collect($property->property_photos)->take(5)
                ->map(fn (string $photo): string => url(Storage::url($photo)))
                ->values()
                ->all(),
            'address' => array_filter([
                '@type' => 'PostalAddress',
                'streetAddress' => Str::squish(implode(' ', array_filter([$property->street, $property->street_type, $property->house_number]))),
                'postalCode' => $property->postal_code,
                'addressLocality' => $property->city,
                'addressCountry' => 'HU',
            ]),
            'geo' => is_numeric($property->maps_lat) && is_numeric($property->maps_lng) ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $property->maps_lat,
                'longitude' => (float) $property->maps_lng,
            ] : null,
            'additionalProperty' => $this->propertyValues($property),
            'amenityFeature' => $property->services->merge($property->tags)
                ->map(fn ($feature): array => [
                    '@type' => 'LocationFeatureSpecification',
                    'name' => $feature->name,
                    'value' => true,
                ])
                ->values()
                ->all(),
        ]);

        // Place has no "makesOffer", so the offer is a node of its own that points at
        // the building through availableAtOrFrom; this keeps the validators error-free.
        $offer = [
            '@type' => 'Offer',
            'name' => $property->isSale() ? 'Irodaház eladás' : 'Irodabérlet',
            'itemOffered' => [
                '@type' => 'Service',
                'name' => ($property->isSale() ? 'Irodaház eladás: ' : 'Irodabérlet: ').$property->title,
            ],
            'availableAtOrFrom' => ['@id' => $place['@id']],
            'priceSpecification' => $this->priceSpecification($property),
            'availability' => $property->isSale() || filled($property->available_area)
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
            'seller' => ['@id' => $this->organizationId()],
        ];

        return [
            '@context' => 'https://schema.org',
            '@graph' => [$place, array_filter($offer)],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function article(BlogPost $post, string $url): array
    {
        $publisher = [
            '@type' => 'Organization',
            '@id' => $this->organizationId(),
            'name' => 'PSG Irodaházak',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $this->logoUrl(),
            ],
        ];

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'mainEntityOfPage' => $url,
            'headline' => Str::limit($post->title, 110),
            'description' => $post->excerpt ?: Str::limit(strip_tags((string) $post->content), 160),
            'image' => $this->imageUrl($post->featured_image),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => ($post->updated_at ?? $post->published_at)?->toIso8601String(),
            'author' => $publisher,
            'publisher' => $publisher,
        ]);
    }

    /**
     * Stored image paths are relative to the public disk, but the posts imported
     * from blog.hu keep the absolute URL of their original image.
     */
    public function imageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return url(Storage::url($path));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function toScript(array $data): HtmlString
    {
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT);

        return new HtmlString('<script type="application/ld+json">'.$json.'</script>');
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function propertyValues(Property $property): array
    {
        $values = $property->isSale()
            ? [
                ['Összterület', $property->total_area, $property->total_area_unit],
                ['Ár', $property->min_rent, $property->min_rent_unit],
                ['Parkolás', $property->parking, null],
                ['Kódszám', $property->code, null],
            ]
            : [
                ['Építés éve', $property->construction_year, null],
                ['Összterület', $property->total_area, $property->total_area_unit],
                ['Jelenleg kiadó', $property->available_area, $property->available_area_unit ?: 'm2'],
                ['Minimum kiadó', $property->min_available_area, $property->min_available_area_unit],
                ['Bérleti díj', $this->range($property->min_rent, $property->max_rent), $property->min_rent_unit],
                ['Üzemeltetési díj', $property->operating_fee, $property->operating_fee_unit],
                ['Raktár terület', $property->storage_area, $property->storage_area_unit],
                ['Raktár bérleti díj', $property->storage_rent, $property->storage_rent_unit],
                ['Parkolás', $property->parking, null],
                ['Parkolás díja', $this->range($property->min_parking_fee, $property->max_parking_fee), $property->min_parking_fee_unit],
                ['Közös területi arány', $property->common_area_ratio, $property->common_area_ratio_unit],
                ['Minimum bérleti időszak', $property->min_lease_term, $property->min_lease_term_unit],
                ['Kódszám', $property->code, null],
            ];

        return collect($values)
            ->filter(fn (array $value): bool => filled($value[1]))
            ->map(function (array $value): array {
                [$name, $rawValue, $unit] = $value;
                $number = $this->number((string) $rawValue);

                // A plain square-metre figure carries the UN/CEFACT unit code; every
                // other value keeps its unit in the text, as on the page.
                if ($unit === 'm2' && $number !== null) {
                    return ['@type' => 'PropertyValue', 'name' => $name, 'value' => $number, 'unitCode' => 'MTK'];
                }

                $text = (string) ($number ?? $rawValue);
                $text = match (true) {
                    blank($unit) => $text,
                    $unit === '%' => $text.'%',
                    default => $text.' '.$unit,
                };

                return ['@type' => 'PropertyValue', 'name' => $name, 'value' => $text];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    private function priceSpecification(Property $property): ?array
    {
        $unit = (string) $property->min_rent_unit;

        if (! preg_match('/^(m?)(EUR|HUF)(?:\/(.+))?$/', $unit, $matches)) {
            return null;
        }

        $multiplier = $matches[1] === 'm' ? 1_000_000 : 1;
        $minPrice = $this->number((string) $property->min_rent);
        $maxPrice = $this->number((string) $property->max_rent);

        if ($minPrice === null) {
            return null;
        }

        return array_filter([
            '@type' => 'UnitPriceSpecification',
            'minPrice' => $minPrice * $multiplier,
            'maxPrice' => $maxPrice !== null && $maxPrice > $minPrice ? $maxPrice * $multiplier : null,
            'priceCurrency' => $matches[2],
            'unitText' => $matches[3] ?? null,
        ], fn (mixed $value): bool => $value !== null);
    }

    private function range(?string $min, ?string $max): ?string
    {
        if (blank($min)) {
            return null;
        }

        return filled($max) && $max !== $min ? $min.' - '.$max : $min;
    }

    /**
     * Reads the figures as the admin types them: "32,000" and "4 000 000" use a
     * thousands separator, "2,5" a decimal comma.
     */
    private function number(string $value): int|float|null
    {
        $value = mb_trim($value);

        if (preg_match('/^\d{1,3}([,\s.]\d{3})+$/u', $value)) {
            return (int) preg_replace('/\D/', '', $value);
        }

        $value = str_replace(',', '.', $value);

        if (! is_numeric($value)) {
            return null;
        }

        return str_contains($value, '.') ? (float) $value : (int) $value;
    }

    private function logoUrl(): string
    {
        return Vite::asset('resources/images/psg-irodahazak-logo.png');
    }
}
