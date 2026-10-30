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
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
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
        'offer_type' => 'kiado-iroda',
        ...$attributes,
    ]);
}

it('casts status and type to enums', function (): void {
    $property = adminProperty()->refresh();

    expect($property->status)->toBe(PropertyStatus::Active)
        ->and($property->offer_type)->toBe(PropertyType::Rent)
        ->and($property->isRent())->toBeTrue()
        ->and($property->url())->toBe(route('properties.show', ['property' => 'bank-center']));
});

it('lists properties with their status badge', function (string $page): void {
    $rent = adminProperty();
    $sale = adminProperty(['title' => 'Eladó ház', 'slug' => 'elado-haz', 'offer_type' => 'elado-iroda', 'status' => 'inactive']);

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
        ->assertSchemaStateSet(['status' => PropertyStatus::Active, 'offer_type' => PropertyType::Rent])
        ->fillForm(['status' => PropertyStatus::Inactive, 'offer_type' => PropertyType::Sale])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($property->refresh())
        ->status->toBe(PropertyStatus::Inactive)
        ->offer_type->toBe(PropertyType::Sale);
});

it('has no first image URL without photos', function (): void {
    expect(adminProperty()->getFirstImageUrl())->toBeNull()
        ->and(adminProperty(['slug' => 'with-photo', 'property_photos' => ['property/1/a.webp']])->getFirstImageUrl())->toEndWith('/storage/property/1/a.webp');
});

it('picks the English text on the English site only when it is filled in', function (): void {
    $property = adminProperty(['content' => 'Magyar leírás', 'en_content' => 'English description', 'meta_title_en' => null, 'meta_title' => 'Magyar cím']);

    expect($property->localized('content', 'en_content'))->toBe('Magyar leírás');

    app()->setLocale('en');

    expect($property->localized('content', 'en_content'))->toBe('English description')
        ->and($property->localized('meta_title', 'meta_title_en'))->toBe('Magyar cím');
});

it('embeds the map by coordinates when known, by address otherwise', function (): void {
    $byAddress = adminProperty(['postal_code' => '1051', 'city' => 'Budapest', 'street' => 'Szabadság tér', 'house_number' => '7']);
    $byCoordinates = adminProperty(['slug' => 'coords', 'maps_lat' => '47.5', 'maps_lng' => '19.05']);

    expect($byAddress->mapEmbedUrl())->toContain('q=1051+Budapest%2C+Szabads%C3%A1g+t%C3%A9r+7')
        ->and($byCoordinates->mapEmbedUrl())->toContain('q=47.5%2C19.05')->toContain('output=embed');
});

it('fills in a missing slug from the title when saving', function (): void {
    $property = Property::factory()->create(['title' => 'Árpád Center', 'slug' => null]);

    expect($property->slug)->toBe('arpad-center');
});

it('tells Budapest and agglomeration properties apart', function (): void {
    $budapest = Property::factory()->create();
    $budaors = Property::factory()->create(['postal_code' => '2040', 'city' => 'Budaörs']);

    expect(Property::query()->agglomeration()->pluck('id')->all())->toBe([$budaors->id])
        ->and(Property::query()->budapestOnly()->pluck('id')->all())->toBe([$budapest->id]);
});

it('summarises rent and sale properties differently on their cards', function (): void {
    $rent = Property::factory()->create(['min_rent' => 12, 'max_rent' => 15, 'operating_fee' => '5']);
    $sale = Property::factory()->forSale()->create(['total_area' => 1200, 'min_rent' => 990000000]);

    $render = fn (Property $property): string => Str::squish(strip_tags(Blade::render('<x-property.summary :property="$property" />', ['property' => $property])));

    expect($render($rent))->toContain($rent->address())->toContain('12 - 15')->toContain('5')
        ->and($render($sale))->toContain('1200 m2')->toContain('990000000');
});
