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
    'operating_fee',
    'storage_rent',
    'parking',
    'common_area_ratio',
    'postal_code',
    'city',
    'district',
    'street',
    'house_number',
    'maps_lat',
    'maps_lng',
    'identifier',
    'total_area_unit',
    'max_rent',
    'max_rent_unit',
    'min_rent',
    'min_rent_unit',
    'storage_area',
    'storage_area_unit',
    'storage_rent_unit',
    'operating_fee_unit',
    'min_parking_fee',
    'min_parking_fee_unit',
    'max_parking_fee',
    'max_parking_fee_unit',
    'common_area_ratio_unit',
    'min_available_area',
    'min_available_area_unit',
    'available_area',
    'available_area_unit',
    'code',
    'en_content',
    'min_lease_term',
    'min_lease_term_unit',
    'street_type',
    'label',
    'service',
    'maps',
    'offer_type',
    'updated',
    'other_info',
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
            $properties = self::query()->rent()->active()->budapestOnly()->get(['district', 'postal_code']);

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
            || BudapestDistrict::tryFromPostalCode((string) $this->postal_code) === $district;
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

    /**
     * The street address on one line: "1051 Budapest, Szabadság tér 7."
     */
    public function address(): string
    {
        return Str::squish(sprintf('%s %s, %s %s %s', $this->postal_code, $this->city, $this->street, __($this->street_type ?? ''), $this->house_number));
    }

    /**
     * The English version of a text field on the English site when it is filled
     * in, the Hungarian one otherwise.
     */
    public function localized(string $field, string $englishField): ?string
    {
        if (app()->getLocale() === 'en' && filled($this->{$englishField})) {
            return $this->{$englishField};
        }

        return $this->{$field};
    }

    /**
     * A Google Maps embed of the building: its coordinates when known, its address otherwise.
     */
    public function mapEmbedUrl(): string
    {
        $query = $this->maps_lat && $this->maps_lng ? $this->maps_lat.','.$this->maps_lng : $this->address();

        return 'https://maps.google.com/maps?'.http_build_query(['q' => $query, 'hl' => app()->getLocale(), 'z' => 16, 'output' => 'embed']);
    }

    /**
     * The public URL of the first gallery photo, or null when the property has none.
     */
    public function getFirstImageUrl(): ?string
    {
        $firstPhoto = collect($this->property_photos)->first();

        return $firstPhoto === null ? null : Storage::url($firstPhoto);
    }

    /**
     * Rent or sale; a property without a type is treated as a rental, as the site always has.
     */
    public function type(): PropertyType
    {
        return $this->offer_type ?? PropertyType::Rent;
    }

    public function isRent(): bool
    {
        return $this->offer_type === PropertyType::Rent;
    }

    public function isSale(): bool
    {
        return $this->offer_type === PropertyType::Sale;
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
        return localized_route($this->type()->showRoute(), ['property' => $this->slug]);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function inCategory(Builder $query, Category $category): void
    {
        $query->whereRelation('categories', 'categories.id', $category->id);
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
        $query->where('offer_type', PropertyType::Sale);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function rent(Builder $query): void
    {
        $query->where('offer_type', PropertyType::Rent);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function agglomeration(Builder $query): void
    {
        $query->whereNot(fn (Builder $q): Builder => $q->budapestOnly());
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function budapestOnly(Builder $query): void
    {
        $query->where(fn (QueryBuilder $q): QueryBuilder => $q
            ->where('city', 'like', '%Budapest%')
            ->orWhere('postal_code', 'like', '1%'));
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
                ->orWhere('code', 'like', '%'.$search.'%')
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
            $query->whereBetween('max_rent', [$minPrice, $maxPrice]);
        } elseif ($minPrice) {
            $query->where('max_rent', '>=', $minPrice);
        } elseif ($maxPrice) {
            $query->where('max_rent', '<=', $maxPrice);
        }
    }

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'vat' => 'boolean',
            'property_photos' => 'array',
            'status' => PropertyStatus::class,
            'offer_type' => PropertyType::class,
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
     * A `postal_code` postal code such as 1051 maps to a Budapest district via
     * floor(1051 / 10) - 100 = 5. MySQL and SQLite spell the required string and
     * math functions differently, so we branch on the active driver while keeping
     * identical semantics.
     */
    private function applyPostalCodeDistrictFilter(QueryBuilder $query, int $districtNum): void
    {
        if ($query->getConnection()->getDriverName() === 'sqlite') {
            $query->whereRaw('LENGTH(postal_code) = 4')
                ->whereRaw('CAST(postal_code AS INTEGER) > 999')
                ->whereRaw('CAST(postal_code AS INTEGER) < 10000')
                ->whereRaw('(CAST(postal_code AS INTEGER) / 10) - 100 = ?', [$districtNum]);

            return;
        }

        $query->whereRaw('CHAR_LENGTH(postal_code) = 4')
            ->whereRaw('CAST(postal_code AS UNSIGNED) > 999')
            ->whereRaw('CAST(postal_code AS UNSIGNED) < 10000')
            ->whereRaw('FLOOR(CAST(postal_code AS UNSIGNED) / 10) - 100 = ?', [$districtNum]);
    }
}
