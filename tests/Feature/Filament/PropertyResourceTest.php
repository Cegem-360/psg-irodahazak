<?php

declare(strict_types=1);

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Filament\Pages\ListRentProperties;
use App\Filament\Pages\ListSaleProperties;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use App\Models\User;
use Filament\Facades\Filament;
use Tests\TestCase;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    /** @var TestCase $this */
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());
});

function adminProperty(array $attributes = []): Property
{
    return Property::query()->forceCreate([
        'title' => 'Bank Center',
        'slug' => 'bank-center',
        'status' => 'active',
        'elado_v_kiado' => 'kiado-iroda',
        ...$attributes,
    ]);
}

it('casts status and type to enums', function (): void {
    $property = adminProperty()->refresh();

    expect($property->status)->toBe(PropertyStatus::Active)
        ->and($property->elado_v_kiado)->toBe(PropertyType::Rent)
        ->and($property->isRent())->toBeTrue()
        ->and($property->url())->toBe(route('properties.show', ['property' => 'bank-center']));
});

it('lists properties with their status badge', function (string $page): void {
    $rent = adminProperty();
    $sale = adminProperty(['title' => 'Eladó ház', 'slug' => 'elado-haz', 'elado_v_kiado' => 'elado-iroda', 'status' => 'inactive']);

    livewire($page)
        ->assertSuccessful()
        ->assertSee($page === ListSaleProperties::class ? 'Eladó ház' : 'Bank Center');
})->with([
    [ListProperties::class],
    [ListRentProperties::class],
    [ListSaleProperties::class],
]);

it('edits a property and keeps its status and type as enums', function (): void {
    $property = adminProperty();

    livewire(EditProperty::class, ['record' => $property->getRouteKey()])
        ->assertSchemaStateSet(['status' => PropertyStatus::Active, 'elado_v_kiado' => PropertyType::Rent])
        ->fillForm(['status' => PropertyStatus::Inactive, 'elado_v_kiado' => PropertyType::Sale])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($property->refresh())
        ->status->toBe(PropertyStatus::Inactive)
        ->elado_v_kiado->toBe(PropertyType::Sale);
});
