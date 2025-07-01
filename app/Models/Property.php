<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

final class Property extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'title',
        'status',
        'lead',
        'content',
        'date',
        'ord',
        'meta_title',
        'meta_title_en',
        'meta_keywords',
        'meta_keywords_en',
        'meta_description',
        'meta_description_en',
        'construction_year',
        'total_area',
        'jelenleg_kiado',
        'max_berleti_dij',
        'uzemeletetesi_dij',
        'raktar_terulet',
        'raktar_berleti_dij',
        'parkolas',
        'kozos_teruleti_arany',
        'cim_irsz',
        'cim_varos',
        'district',
        'cim_utca',
        'cim_hazszam',
        'tags',
        'services',
        'maps_lat',
        'maps_lng',
        'azonosito',
        'osszterulet_addons',
        'max_berleti_dij_addons',
        'min_berleti_dij',
        'min_berleti_dij_addons',
        'raktar_terulet_addons',
        'raktar_berleti_dij_addons',
        'uzemeletetesi_dij_addons',
        'min_parkolas_dija',
        'min_parkolas_dija_addons',
        'max_parkolas_dija',
        'max_parkolas_dija_addons',
        'kozos_teruleti_arany_addons',
        'min_kiado',
        'min_kiado_addons',
        'jelenleg_kiado_addons',
        'kodszam',
        'en_content',
        'min_berleti_idoszak',
        'min_berleti_idoszak_addons',
        'cim_utca_addons',
        'lang',
        'cimke',
        'service',
        'maps',
        'elado_v_kiado',
        'elado_v_kiado_addons',
        'updated',
        'egyeb',
        'vat',
        'slug',
        'featured',
        'property_photos',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'vat' => 'boolean',
        'property_photos' => 'array',
        'tags' => 'array',
        'services' => 'array',
    ];

    public static function countByDistrict(): array
    {
        // Kerületek római számmal
        $romanNumerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
            16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
            21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
        ];

        $result = [];

        foreach (array_keys($romanNumerals) as $num) {
            $count = self::where(function ($q) use ($num): void {
                $q->budapestOnly()->inDistrict((string) $num);
            })->count();

            $result[$num] = $count;
        }

        return $result;
    }

    public function getAddressFormated(): string
    {
        $address = mb_trim(sprintf('%s %s, %s %s', $this->cim_irsz, $this->cim_varos, $this->cim_utca, $this->cim_hazszam));
        $rent = __('Rental fee');
        $address .= '<br><strong>'.$rent.':</strong> '.$this->min_berleti_dij.' - '.$this->max_berleti_dij.' EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>'.$this->uzemeletetesi_dij.' HUF/m2/hó';

        return $address ?: null;
    }

    public function getAddressFormatedForSale(): string
    {
        return "{$this->cim_irsz} {$this->cim_varos},<br><strong>".__('Total Area').":</strong> {$this->total_area} m²<br><strong>".__('Price').":</strong> {$this->min_berleti_dij} {$this->min_berleti_dij_addons}";
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class, 'target_table_id')
            ->where('target_table', 'property')
            ->orderBy('ord');
    }

    /**
     * Get gallery images ordered by ord field
     */
    public function galleryImages()
    {
        return $this->images()->get();
    }

    /**
     * Get all image URLs for this property
     */
    public function getImageUrlsAttribute(): array
    {
        return $this->images->map(function ($image) {
            return $image->image_url;
        })->toArray();
    }

    /**
     * Get the first image URL
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        $firstImage = $this->images->first();

        return $firstImage ? $firstImage->getFirstImageUrl() : null;
    }

    /**
     * Get the first image URL with specified size (default 800x600)
     */
    public function getFirstImageUrl(string $size = '800x600', string $extension = 'jpg'): ?string
    {
        $firstImage = $this->images->first();

        return $firstImage ? $firstImage->getImageUrl($size, $extension) : null;
    }

    /**
     * Get image URLs in a specific size
     */
    public function getImageUrls(?string $size = null): array
    {
        return $this->images->map(function ($image) use ($size) {
            return $image->getImageUrl($size);
        })->toArray();
    }

    public function isRent(): bool
    {
        return $this->elado_v_kiado === 'kiado-iroda';
    }

    public function isSale(): bool
    {
        return $this->elado_v_kiado === 'elado-iroda';
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('featured', true);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', 'active');
    }

    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('status', 'inactive');
    }

    #[Scope]
    protected function sale(Builder $query): void
    {
        $query->where('elado_v_kiado', 'elado-iroda');
    }

    #[Scope]
    protected function rent(Builder $query): void
    {
        $query->where('elado_v_kiado', 'kiado-iroda');
    }

    #[Scope]
    protected function agglomeration(Builder $query): void
    {
        $query->where('cim_varos', '!=', 'Budapest');
    }

    #[Scope]
    protected function budapestOnly(Builder $query): void
    {
        $query->where(function ($q): void {
            $q->where('cim_varos', 'like', '%Budapest%')
                ->orWhere(function ($subQ): void {
                    $subQ->where('cim_irsz', 'like', '1%');
                });
        });
    }

    #[Scope]
    protected function inDistrict(Builder $query, string $district): void
    {
        $districtNum = (int) $district;

        // Roman numerals mapping
        $romanNumerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
            16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
            21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
        ];

        $romanDistrict = $romanNumerals[$districtNum] ?? $district;

        $query->where(function ($q) use ($romanDistrict, $district, $districtNum): void {
            // District oszlopban keresés
            $q->where('district', $romanDistrict)
                ->orWhere('district', $district);

            // Irányítószám alapú keresés - matematikai megoldás
            if ($districtNum >= 1 && $districtNum <= 23) {
                $q->orWhere(function ($subQ) use ($districtNum): void {
                    // Irányítószám → szám → osztás 10-zel → kivonás 100
                    // Például: 1051 → 1051/10=105 → 105-100=5 → 5. kerület
                    $subQ->whereRaw('CHAR_LENGTH(cim_irsz) = 4')
                        ->whereRaw('CAST(cim_irsz AS UNSIGNED) > 999')
                        ->whereRaw('CAST(cim_irsz AS UNSIGNED) < 10000')
                        ->whereRaw('FLOOR(CAST(cim_irsz AS UNSIGNED) / 10) - 100 = ?', [$districtNum]);
                });
            }
        });
    }

    #[Scope]
    protected function inDistricts(Builder $query, array $districts): void
    {
        $query->where(function ($q) use ($districts): void {
            foreach ($districts as $district) {
                $q->orWhere(function ($subQ) use ($district): void {
                    $districtNum = (int) $district;

                    // Roman numerals mapping
                    $romanNumerals = [
                        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
                        6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
                        11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
                        16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
                        21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
                    ];

                    $romanDistrict = $romanNumerals[$districtNum] ?? $district;

                    // District oszlopban keresés
                    $subQ->where('district', $romanDistrict)
                        ->orWhere('district', $district);

                    // Irányítószám alapú keresés - matematikai megoldás
                    if ($districtNum >= 1 && $districtNum <= 23) {
                        $subQ->orWhere(function ($postalQ) use ($districtNum): void {
                            // Irányítószám → szám → osztás 10-zel → kivonás 100
                            // Például: 1051 → 1051/10=105 → 105-100=5 → 5. kerület
                            $postalQ->whereRaw('CHAR_LENGTH(cim_irsz) = 4')
                                ->whereRaw('CAST(cim_irsz AS UNSIGNED) > 999')
                                ->whereRaw('CAST(cim_irsz AS UNSIGNED) < 10000')
                                ->whereRaw('FLOOR(CAST(cim_irsz AS UNSIGNED) / 10) - 100 = ?', [$districtNum]);
                        });
                    }
                });
            }
        });
    }

    #[Scope]
    protected function searchText(Builder $query, string $search): void
    {
        $searchTerms = explode(' ', mb_trim($search));
        $searchTerms = array_filter($searchTerms);

        $query->where(function (Builder $q) use ($searchTerms): void {
            foreach ($searchTerms as $term) {
                $q->where(function (Builder $subQ) use ($term): void {
                    $subQ->where('title', 'like', '%'.$term.'%')
                        ->orWhere('content', 'like', '%'.$term.'%')
                        ->orWhere('lead', 'like', '%'.$term.'%')
                        // Tags tömb mezőben keresés - case-insensitive JSON keresés
                        ->orWhereRaw('JSON_SEARCH(LOWER(tags), "one", LOWER(?)) IS NOT NULL', ['%'.$term.'%'])
                        // Services tömb mezőben keresés - case-insensitive JSON keresés
                        ->orWhereRaw('JSON_SEARCH(LOWER(services), "one", LOWER(?)) IS NOT NULL', ['%'.$term.'%']);
                });
            }
        });
    }

    #[Scope]
    protected function byOfficeName(Builder $query, string $officeName): void
    {
        $query->where('title', 'like', '%'.$officeName.'%');
    }

    #[Scope]
    protected function areaRange(Builder $query, ?int $minArea = null, ?int $maxArea = null): void
    {
        if ($minArea && $maxArea) {
            $query->whereBetween('total_area', [$minArea, $maxArea]);
        } elseif ($minArea) {
            $query->where('total_area', '>=', $minArea);
        } elseif ($maxArea) {
            $query->where('total_area', '<=', $maxArea);
        }
    }

    #[Scope]
    protected function priceRange(Builder $query, ?int $minPrice = null, ?int $maxPrice = null): void
    {
        if ($minPrice && $maxPrice) {
            $query->whereBetween('max_berleti_dij', [$minPrice, $maxPrice]);
        } elseif ($minPrice) {
            $query->where('max_berleti_dij', '>=', $minPrice);
        } elseif ($maxPrice) {
            $query->where('max_berleti_dij', '<=', $maxPrice);
        }
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: Str::slug($this->title),
            set: fn ($value) => $value ?: Str::slug($this->title)
        );
    }
}
