<?php

declare(strict_types=1);

use App\Livewire\IngatlanCard;
use App\Livewire\PropertyMapModal;
use App\Livewire\PropertyPhoneModal;
use App\Models\Property;
use Livewire\Livewire;

function modalProperty(): Property
{
    return Property::query()->forceCreate([
        'title' => 'Bank Center',
        'slug' => 'bank-center',
        'status' => 'active',
        'elado_v_kiado' => 'kiado-iroda',
        'cim_irsz' => '1054',
        'cim_varos' => 'Budapest',
        'cim_utca' => 'Szabadság',
        'cim_hazszam' => '7.',
    ]);
}

it('sends the title and property id as named event parameters from the card', function (): void {
    $property = modalProperty();

    Livewire::test(IngatlanCard::class, ['property' => $property, 'title' => 'Bank Center', 'images' => ['a.webp']])
        ->call('showMapModal')
        ->assertDispatched('show-map-modal', title: 'Bank Center', propertyId: $property->id)
        ->call('showPhoneModal')
        ->assertDispatched('show-phone-modal', title: 'Bank Center', propertyId: $property->id);
});

it('opens the map modal with the property loaded', function (): void {
    $property = modalProperty();

    Livewire::test(PropertyMapModal::class)
        ->dispatch('show-map-modal', title: 'Bank Center', propertyId: $property->id)
        ->assertSet('showModal', true)
        ->assertSet('title', 'Bank Center')
        ->assertSee('maps.google.com', escape: false);
});

it('opens the phone modal without a property too', function (): void {
    Livewire::test(PropertyPhoneModal::class)
        ->dispatch('show-phone-modal', title: 'Bank Center')
        ->assertSet('showModal', true)
        ->assertSet('title', 'Bank Center')
        ->assertSee('+36');
});
