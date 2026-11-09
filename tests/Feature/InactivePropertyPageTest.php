<?php

declare(strict_types=1);

use App\Enums\PropertyStatus;
use App\Livewire\Pages\PropertyShow;
use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyRedirect;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * An Infopark-like building in district XI, with fees, a quote form and services.
 */
function infoparkBuilding(array $attributes = []): Property
{
    return Property::factory()->create([
        'title' => 'Infopark D',
        'slug' => 'infopark-d',
        'district' => 'XI',
        'postal_code' => '1117',
        'street' => 'Gábor Dénes',
        'street_type' => 'utca',
        'house_number' => '2.',
        'maps_lat' => '47.4703755',
        'maps_lng' => '19.0612607',
        'construction_year' => '2001',
        'total_area' => '17000',
        'total_area_unit' => 'm2',
        'available_area' => '850',
        'min_rent' => '14',
        'max_rent' => '16',
        'operating_fee' => '3900',
        'operating_fee_unit' => 'HUF/m2/hó',
        'content' => '<p>Az Infopark D épület bemutatója.</p>',
        ...$attributes,
    ]);
}

it('keeps the page of a building that is no longer offered, with its basic data but no fees or quote form', function (string $state): void {
    /** @var TestCase $this */
    $property = infoparkBuilding(['status' => PropertyStatus::Inactive]);

    if ($state === 'deleted') {
        $property->update(['status' => PropertyStatus::Active]);
        $property->delete();
    }

    $html = $this->get('/kiado-iroda/infopark-d')
        ->assertOk()
        ->assertSee('Infopark D')
        ->assertSee('1117 Budapest, Gábor Dénes utca 2.')
        ->assertSee('2001')
        ->assertSee('17000')
        ->assertSee('Az Infopark D épület bemutatója.')
        ->assertSee('Ezt az épületet jelenleg nem közvetítjük.')
        ->assertDontSee('3900')
        ->assertDontSee('14 - 16')
        ->assertDontSeeLivewire('contact-form')
        ->assertDontSeeHtml('noindex')
        ->getContent();

    $place = jsonLdNode($html, 'Place');

    expect($place['name'])->toBe('Infopark D')
        ->and(array_column($place['additionalProperty'], 'name'))->toBe(['Építés éve', 'Összterület'])
        ->and(jsonLdNode($html, 'Offer'))->toBeNull();
})->with(['inactive', 'deleted']);

it('still shows the fees, the quote form and the offer of a building that is offered', function (): void {
    /** @var TestCase $this */
    infoparkBuilding();

    $html = $this->get('/kiado-iroda/infopark-d')
        ->assertOk()
        ->assertSee('3900')
        ->assertSeeLivewire('contact-form')
        ->assertDontSee('Ezt az épületet jelenleg nem közvetítjük.')
        ->getContent();

    expect(jsonLdNode($html, 'Offer'))->not->toBeNull();
});

it('suggests the nearest offered buildings of the same district', function (): void {
    $property = infoparkBuilding(['status' => PropertyStatus::Inactive]);
    $neighbour = Property::factory()->create(['title' => 'Infopark E', 'district' => 'XI', 'maps_lat' => '47.4694713', 'maps_lng' => '19.0598979']);
    $sameDistrictFar = Property::factory()->create(['district' => 'XI', 'maps_lat' => '47.4502', 'maps_lng' => '19.0201']);
    $otherDistrictNear = Property::factory()->create(['district' => 'IX', 'maps_lat' => '47.4710', 'maps_lng' => '19.0640']);
    Property::factory()->inactive()->create(['district' => 'XI', 'maps_lat' => '47.4705017', 'maps_lng' => '19.0599275']);

    $similar = Livewire::test(PropertyShow::class, ['property' => $property])->instance()->similarProperties;

    expect($similar->pluck('id')->all())->toBe([$neighbour->id, $sameDistrictFar->id, $otherDistrictNear->id]);
});

it('redirects the page of a permanently deleted property to its district', function (string $uri, string $target): void {
    /** @var TestCase $this */
    Category::query()->forceCreate(['name' => 'Kiadó irodák XI. kerület', 'slug' => 'kiado-irodak-xi-kerulet']);
    infoparkBuilding()->forceDelete();
    infoparkBuilding(['slug' => 'lurdy-haz', 'district' => null, 'postal_code' => '1097'])->forceDelete();
    Property::factory()->forSale()->create(['slug' => 'elado-haz', 'district' => 'XI'])->forceDelete();

    $this->get($uri)->assertMovedPermanently()->assertRedirect($target);
})->with([
    'rental with a district category page' => ['/kiado-iroda/infopark-d', '/budapest/kiado-irodak-xi-kerulet'],
    'English rental' => ['/office-to-let/infopark-d', '/budapest-en/kiado-irodak-xi-kerulet'],
    'rental without a category page, by postal code' => ['/kiado-iroda/lurdy-haz', '/kiado-irodak?district=IX'],
    'sale' => ['/elado-irodahaz/elado-haz', '/elado-irodahazak'],
]);

it('returns 404 for a property that never existed', function (): void {
    /** @var TestCase $this */
    $this->get('/kiado-iroda/nincs-ilyen')->assertNotFound();
});

it('does not keep a redirect for a soft delete', function (): void {
    infoparkBuilding()->delete();

    expect(PropertyRedirect::query()->count())->toBe(0);
});
