<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BudapestDistrict;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Observers\PropertyObserver;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy(PropertyObserver::class)]
#[Fillable([

    'title',
    'status',
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
    'uzemeletetesi_dij',
    'raktar_berleti_dij',
    'parkolas',
    'kozos_teruleti_arany',
    'cim_irsz',
    'cim_varos',
    'district',
    'cim_utca',
    'cim_hazszam',
    'maps_lat',
    'maps_lng',
    'azonosito',
    'osszterulet_addons',
    'max_berleti_dij',
    'max_berleti_dij_addons',
    'min_berleti_dij',
    'min_berleti_dij_addons',
    'raktar_terulet',
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
    'jelenleg_kiado',
    'jelenleg_kiado_addons',
    'kodszam',
    'en_content',
    'min_berleti_idoszak',
    'min_berleti_idoszak_addons',
    'cim_utca_addons',
    'cimke',
    'service',
    'maps',
    'elado_v_kiado',
    'updated',
    'egyeb',
    'vat',
    'slug',
    'featured',
    'property_photos',
])]
final class Property extends Model
{
    use HasFactory;

    public const string DISTRICT_COUNTS_CACHE_KEY = 'properties.rent_count_by_district';

    /**
     * Active rental offices per Budapest district (1–23), for the district map.
     *
     * One query plus PHP matching instead of 23 counts, cached until a property is
     * saved or deleted. A property counts in a district when its district column
     * names it (Roman or Arabic numeral) or its postal code belongs to it, the same
     * rule as the inDistrict() scope.
     *
     * @return array<int, int>
     */
    public static function countByDistrict(): array
    {
        return once(fn (): array => Cache::remember(self::DISTRICT_COUNTS_CACHE_KEY, now()->addDay(), function (): array {
            $properties = self::query()->rent()->active()->budapestOnly()->get(['district', 'cim_irsz']);

            return collect(BudapestDistrict::cases())
                ->mapWithKeys(fn (BudapestDistrict $district): array => [
                    $district->value => $properties->filter(fn (self $property): bool => $property->isInDistrict($district))->count(),
                ])
                ->all();
        }));
    }

    public static function forgetDistrictCounts(): void
    {
        Cache::forget(self::DISTRICT_COUNTS_CACHE_KEY);
    }

    /**
     * The PHP counterpart of the inDistrict() scope: the district column names the
     * district (by number or Roman numeral), or the postal code belongs to it.
     */
    public function isInDistrict(BudapestDistrict $district): bool
    {
        return BudapestDistrict::tryFromName((string) $this->district) === $district
            || BudapestDistrict::tryFromPostalCode((string) $this->cim_irsz) === $district;
    }

    /**
     * @return BelongsToMany<Service, $this, Pivot>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * @return BelongsToMany<Tag, $this, Pivot>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return BelongsToMany<Category, $this, Pivot>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return HasMany<Gallery, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class, 'target_table_id')
            ->where('target_table', 'property')
            ->orderBy('ord');
    }

    public function getAddressFormated(): string
    {
        $address = mb_trim(sprintf('%s %s, %s %s %s', $this->cim_irsz, $this->cim_varos, $this->cim_utca, __($this->cim_utca_addons), $this->cim_hazszam));
        $rent = __('Rental fee');
        $address .=
         '<br><strong>'.$rent.':</strong> '.
          $this->min_berleti_dij
          .($this->max_berleti_dij && $this->max_berleti_dij !== $this->min_berleti_dij ? ' - '.$this->max_berleti_dij.' '.__($this->min_berleti_dij_addons) : ' '.__($this->min_berleti_dij_addons))
          .'<br><strong>'.__('Operating Fee').': </strong>'.translate_value($this->uzemeletetesi_dij).' '.__($this->uzemeletetesi_dij_addons);

        return $address;
    }

    public function getAddressFormatedForSale(): string
    {
        return sprintf('%s %s, %s %s <br><strong>', $this->cim_irsz, $this->cim_varos, $this->cim_utca ?? '', __($this->cim_utca_addons) ?? '').__('Total Area').sprintf(':</strong> %s m2<br><strong>', $this->total_area).__('Price').sprintf(':</strong> %s %s', $this->min_berleti_dij, __($this->min_berleti_dij_addons));
    }

    public function getFirstImageUrl(): ?string
    {
        return Storage::url(collect($this->property_photos)->first());
    }

    public function isRent(): bool
    {
        return $this->elado_v_kiado === PropertyType::Rent;
    }

    public function isSale(): bool
    {
        return $this->elado_v_kiado === PropertyType::Sale;
    }

    public function isActive(): bool
    {
        return $this->status === PropertyStatus::Active;
    }

    /**
     * The public page of the property: /kiado-iroda/… or /elado-irodahaz/…
     */
    public function url(): string
    {
        return localized_route(($this->elado_v_kiado ?? PropertyType::Rent)->showRoute(), ['property' => $this->slug]);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function byCategory(Builder $query, string $category): void
    {
        $query->whereHas('categories', function (Builder $q) use ($category): void {
            $q->where('name', $category);
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('featured', true);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', PropertyStatus::Active);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('status', PropertyStatus::Inactive);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function sale(Builder $query): void
    {
        $query->where('elado_v_kiado', PropertyType::Sale);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function rent(Builder $query): void
    {
        $query->where('elado_v_kiado', PropertyType::Rent);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function agglomeration(Builder $query): void
    {
        $query->where('cim_varos', '!=', 'Budapest');
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function budapestOnly(Builder $query): void
    {
        $query->where(fn (QueryBuilder $q): QueryBuilder => $q
            ->where('cim_varos', 'like', '%Budapest%')
            ->orWhere('cim_irsz', 'like', '1%'));
    }

    /**
     * Properties in one Budapest district, given by number ("5") or Roman numeral ("V").
     *
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function inDistrict(Builder $query, string $district): void
    {
        $query->where(fn (QueryBuilder $q) => $this->whereInDistrict($q, $district));
    }

    /**
     * Properties in any of the given Budapest districts.
     *
     * @param  Builder<self>  $query
     * @param  array<int, string>  $districts
     */
    #[Scope]
    protected function inDistricts(Builder $query, array $districts): void
    {
        $query->where(function (QueryBuilder $q) use ($districts): void {
            foreach ($districts as $district) {
                $q->orWhere(fn (QueryBuilder $subQ) => $this->whereInDistrict($subQ, (string) $district));
            }
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function searchText(Builder $query, string $search): void
    {
        $query->where(function (Builder $subQ) use ($search): void {
            $subQ->where('title', 'like', '%'.$search.'%')
                ->orWhere('content', 'like', '%'.$search.'%')
                ->orWhere('kodszam', 'like', '%'.$search.'%')
                ->orWhereHas('tags', function (Builder $q) use ($search): void {
                    $q->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('services', function (Builder $q) use ($search): void {
                    $q->where('name', 'like', '%'.$search.'%');
                });
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function byOfficeName(Builder $query, string $officeName): void
    {
        $query->where('title', 'like', '%'.$officeName.'%');
    }

    /**
     * @param  Builder<self>  $query
     */
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

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
            'featured' => 'boolean',
            'vat' => 'boolean',
            'property_photos' => 'array',
            'status' => PropertyStatus::class,
            'elado_v_kiado' => PropertyType::class,
        ];
    }

    /**
     * The district column names the district (by number or Roman numeral), or the
     * postal code belongs to it. A free-text value that is not a district only
     * matches the district column literally.
     */
    private function whereInDistrict(QueryBuilder $query, string $district): void
    {
        $budapestDistrict = BudapestDistrict::tryFromName($district);

        $query->where('district', $budapestDistrict?->roman() ?? $district)
            ->orWhere('district', $district);

        if ($budapestDistrict !== null) {
            $query->orWhere(fn (QueryBuilder $postalQuery) => $this->applyPostalCodeDistrictFilter($postalQuery, $budapestDistrict->value));
        }
    }

    /**
     * Apply the postal-code based district filter in a database-portable way.
     *
     * A `cim_irsz` postal code such as 1051 maps to a Budapest district via
     * floor(1051 / 10) - 100 = 5. MySQL and SQLite spell the required string and
     * math functions differently, so we branch on the active driver while keeping
     * identical semantics.
     */
    private function applyPostalCodeDistrictFilter(QueryBuilder $query, int $districtNum): void
    {
        if ($query->getConnection()->getDriverName() === 'sqlite') {
            $query->whereRaw('LENGTH(cim_irsz) = 4')
                ->whereRaw('CAST(cim_irsz AS INTEGER) > 999')
                ->whereRaw('CAST(cim_irsz AS INTEGER) < 10000')
                ->whereRaw('(CAST(cim_irsz AS INTEGER) / 10) - 100 = ?', [$districtNum]);

            return;
        }

        $query->whereRaw('CHAR_LENGTH(cim_irsz) = 4')
            ->whereRaw('CAST(cim_irsz AS UNSIGNED) > 999')
            ->whereRaw('CAST(cim_irsz AS UNSIGNED) < 10000')
            ->whereRaw('FLOOR(CAST(cim_irsz AS UNSIGNED) / 10) - 100 = ?', [$districtNum]);
    }
}
