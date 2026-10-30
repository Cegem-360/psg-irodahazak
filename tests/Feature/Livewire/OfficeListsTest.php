<?php

declare(strict_types=1);

use App\Livewire\ListRentOffices;
use App\Livewire\ListSaleOffices;
use App\Livewire\PropertyMapModal;
use App\Models\Property;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

it('falls back to sorting by name when the client sends an unknown column', function (): void {
    Property::query()->forceCreate(['title' => 'Eladó ház', 'status' => 'active', 'slug' => 'elado-haz', 'elado_v_kiado' => 'elado-iroda']);

    $list = Livewire::test(ListSaleOffices::class)
        ->set('sortField', 'password; drop table properties')
        ->assertOk();

    expect($list->instance()->getOffices()->pluck('title')->all())->toBe(['Eladó ház']);
});

it('does not let the client change the page size or the category', function (string $component, string $property, mixed $value): void {
    Livewire::test($component)->set($property, $value);
})->throws(CannotUpdateLockedPropertyException::class)->with([
    'sale page size' => [ListSaleOffices::class, 'perPage', 100000],
    'rent page size' => [ListRentOffices::class, 'perPage', 100000],
    'rent category' => [ListRentOffices::class, 'category', 'nem-letezik'],
]);

it('links the map markers to the property page in the current language', function (): void {
    $property = Property::query()->forceCreate(['title' => 'Térképes', 'status' => 'active', 'slug' => 'terkepes', 'elado_v_kiado' => 'kiado-iroda', 'maps_lat' => '47.5', 'maps_lng' => '19.05']);
    app()->setLocale('en');

    $markers = Livewire::test(ListRentOffices::class)->instance()->getOfficesForMap();

    expect($markers->pluck('url')->all())->toBe([route('en.properties.show', ['property' => $property->slug])]);
});

it('does not show the location of an inactive property', function (): void {
    $property = Property::query()->forceCreate(['title' => 'Inaktív', 'status' => 'inactive', 'slug' => 'inaktiv-terkep', 'elado_v_kiado' => 'kiado-iroda']);

    Livewire::test(PropertyMapModal::class)
        ->dispatch('show-map-modal', title: 'Inaktív', propertyId: $property->id)
        ->assertSet('property', null);
});
