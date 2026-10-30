<?php

declare(strict_types=1);

use App\Livewire\PropertyCard;
use App\Models\Property;
use App\Models\User;
use App\Services\FavoriteProperties;
use Livewire\Livewire;
use Tests\TestCase;

function favoriteProperty(string $slug = 'kedvenc'): Property
{
    return Property::query()->forceCreate(['title' => 'Kedvenc', 'status' => 'active', 'slug' => $slug, 'offer_type' => 'kiado-iroda']);
}

it('adds a property to the favorites and takes it off again', function (): void {
    $property = favoriteProperty();

    $card = Livewire::test(PropertyCard::class, ['property' => $property, 'title' => 'Kedvenc'])
        ->assertSet('isFavorite', false)
        ->call('toggleFavorite')
        ->assertSet('isFavorite', true)
        ->assertDispatched('set-cookie', name: FavoriteProperties::COOKIE, value: json_encode([$property->id]), days: 365)
        ->assertDispatched('favorites-updated', propertyId: $property->id, isFavorite: true);

    Livewire::withCookies([FavoriteProperties::COOKIE => json_encode([$property->id])])
        ->test(PropertyCard::class, ['property' => $property, 'title' => 'Kedvenc'])
        ->assertSet('isFavorite', true)
        ->call('toggleFavorite')
        ->assertSet('isFavorite', false)
        ->assertDispatched('set-cookie', value: '[]');
});

it('reads the plain JSON favorites cookie the browser writes', function (): void {
    /** @var TestCase $this */
    $property = favoriteProperty();

    $this->actingAs(User::factory()->create())
        ->withUnencryptedCookie(FavoriteProperties::COOKIE, json_encode([$property->id]))
        ->get('/kedvencek')
        ->assertOk()
        ->assertSee(__('You have :count favorite properties', ['count' => 1]));
});
