<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BudapestDistrict;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * The URL of a permanently deleted property, kept so the old page answers with a
 * 301 to the page of its district instead of a 404.
 */
#[Fillable([
    'slug',
    'offer_type',
    'district',
])]
final class PropertyRedirect extends Model
{
    /**
     * Remembers the slug of a property that is being removed for good.
     */
    public static function rememberDeleted(Property $property): void
    {
        if (blank($property->slug)) {
            return;
        }

        $district = BudapestDistrict::tryFromName((string) $property->district)
            ?? BudapestDistrict::tryFromPostalCode((string) $property->postal_code);

        self::query()->updateOrCreate(['slug' => $property->slug], [
            'offer_type' => $property->type(),
            'district' => $district?->roman(),
        ]);
    }

    /**
     * Where the old page points: the district's rental category page
     * (/budapest/kiado-irodak-xi-kerulet) when there is one, the office list
     * otherwise, narrowed to the district for rentals.
     */
    public function targetUrl(): string
    {
        $type = $this->offer_type ?? PropertyType::Rent;
        $district = BudapestDistrict::tryFromName((string) $this->district);

        if ($type === PropertyType::Sale || ! $district instanceof BudapestDistrict) {
            return localized_route($type->listRoute());
        }

        $categorySlug = sprintf('kiado-irodak-%s-kerulet', mb_strtolower($district->roman()));

        if (Category::query()->where('slug', $categorySlug)->exists()) {
            return localized_route('budapest.category', ['category' => $categorySlug]);
        }

        return localized_route($type->listRoute(), ['district' => $district->roman()]);
    }

    protected function casts(): array
    {
        return [
            'offer_type' => PropertyType::class,
        ];
    }
}
