<?php

declare(strict_types=1);

use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Once;

function rentalOffice(array $attributes): Property
{
    return Property::query()->forceCreate([
        'title' => 'Iroda '.fake()->unique()->numberBetween(1, 99999),
        'status' => 'active',
        'elado_v_kiado' => 'kiado-iroda',
        'cim_varos' => 'Budapest',
        ...$attributes,
    ]);
}

it('counts active rental offices per district by district name or postal code', function (): void {
    rentalOffice(['district' => 'V', 'cim_irsz' => '1054']);
    rentalOffice(['district' => '13', 'cim_irsz' => '']);
    rentalOffice(['district' => '', 'cim_irsz' => '1134']);
    rentalOffice(['district' => 'XI', 'cim_irsz' => '1117', 'status' => 'inactive']);
    rentalOffice(['district' => 'XI', 'cim_irsz' => '1117', 'elado_v_kiado' => 'elado-iroda']);

    $counts = Property::countByDistrict();

    expect($counts)->toHaveCount(23)
        ->and($counts[5])->toBe(1)
        ->and($counts[13])->toBe(2)
        ->and($counts[11])->toBe(0);
});

it('answers from one query and refreshes after a property is saved', function (): void {
    rentalOffice(['district' => 'V', 'cim_irsz' => '1054']);

    DB::enableQueryLog();
    expect(Property::countByDistrict()[5])->toBe(1);
    $propertyQueries = collect(DB::getQueryLog())->filter(fn (array $query): bool => str_contains($query['query'], 'from "properties"'));
    expect($propertyQueries)->toHaveCount(1);

    // A new property clears the cache; once() memoises within a request, so flush it like a new request would.
    rentalOffice(['district' => 'V', 'cim_irsz' => '1051']);
    Once::flush();

    expect(Property::countByDistrict()[5])->toBe(2);
});

it('filters by district number or Roman numeral, via the district column or the postal code', function (string $district): void {
    $byColumn = rentalOffice(['district' => 'V', 'cim_irsz' => '']);
    $byPostalCode = rentalOffice(['district' => '', 'cim_irsz' => '1054']);
    $elsewhere = rentalOffice(['district' => 'XIII', 'cim_irsz' => '1134']);

    expect(Property::query()->inDistrict($district)->pluck('id')->all())
        ->toEqualCanonicalizing([$byColumn->id, $byPostalCode->id])
        ->and(Property::query()->inDistricts([$district, '13'])->count())->toBe(3);
})->with(['5', 'V', 'v']);
