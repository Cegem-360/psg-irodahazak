<?php

declare(strict_types=1);

use App\Livewire\FavoritesSendModal;
use App\Livewire\QuoteRequestModal;
use App\Mail\FavoritesSendMail;
use App\Models\BlogPost;
use App\Models\Property;
use App\Models\QuoteRequest;
use App\Models\User;
use App\Services\FavoriteProperties;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

it('does not expose the debug routes', function (string $uri): void {
    /** @var TestCase $this */
    $this->get($uri)->assertNotFound();
})->with([
    'cache clearing' => '/clearCache',
    'pdf test' => '/test-pdf/1',
    'pdf preview' => '/property-preview/1',
]);

it('lists only published posts in the home page blog section', function (): void {
    /** @var TestCase $this */
    $published = BlogPost::factory()->published()->create();
    $draft = BlogPost::factory()->draft()->create(['blog_category_id' => $published->blog_category_id]);

    $this->get('/')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

it('emails the active favorites from the cookie, never a list sent by the client', function (): void {
    Mail::fake();
    $active = Property::query()->forceCreate(['title' => 'Aktív', 'status' => 'active', 'slug' => 'aktiv', 'offer_type' => 'kiado-iroda']);
    $inactive = Property::query()->forceCreate(['title' => 'Inaktív', 'status' => 'inactive', 'slug' => 'inaktiv', 'offer_type' => 'kiado-iroda']);

    Livewire::withCookies([FavoriteProperties::COOKIE => json_encode([$active->id, $inactive->id])])
        ->test(FavoritesSendModal::class)
        ->set('recipientName', 'Címzett')
        ->set('recipientEmail', 'cimzett@example.com')
        ->call('sendFavorites')
        ->assertHasNoErrors()
        ->assertDispatched('refresh-favorites');

    Mail::assertSent(FavoritesSendMail::class, fn (FavoritesSendMail $mail): bool => $mail->hasTo('cimzett@example.com')
        && $mail->properties->pluck('title')->all() === ['Aktív']
        && str_contains($mail->render(), route('properties.show', ['property' => 'aktiv'])));
});

it('does not send an empty favorites list', function (): void {
    Mail::fake();

    Livewire::test(FavoritesSendModal::class)
        ->set('recipientName', 'Címzett')
        ->set('recipientEmail', 'cimzett@example.com')
        ->call('sendFavorites')
        ->assertHasErrors('recipientEmail');

    Mail::assertNothingSent();
});

it('asks guests to sign in before showing the favorites', function (string $uri): void {
    /** @var TestCase $this */
    $this->get($uri)->assertRedirect(route('login'));
})->with(['/kedvencek', '/kedvencek/export-excel', '/favorites', '/favorites/export-excel']);

it('hides inactive properties from visitors but not from signed-in admins', function (): void {
    /** @var TestCase $this */
    $property = Property::query()->forceCreate(['title' => 'Inaktív', 'status' => 'inactive', 'slug' => 'inaktiv-adatlap', 'offer_type' => 'kiado-iroda']);

    $this->get(route('properties.show', ['property' => $property->slug]))->assertNotFound();

    $this->actingAs(User::factory()->create())
        ->get(route('properties.show', ['property' => $property->slug]))
        ->assertOk();
});

it('drops a quote request whose honeypot is filled', function (): void {
    Mail::fake();

    Livewire::test(QuoteRequestModal::class)
        ->set('name', 'Bot')
        ->set('phone', '+36301234567')
        ->set('email', 'bot@example.com')
        ->set('privacy', true)
        ->set('website', 'https://spam.example')
        ->call('submitForm')
        ->assertNotDispatched('notify');

    expect(QuoteRequest::query()->count())->toBe(0);
});

it('rate limits the quote request form per visitor', function (): void {
    $submit = fn () => Livewire::test(QuoteRequestModal::class)
        ->set('name', 'Teszt Elek')
        ->set('phone', '+36301234567')
        ->set('email', 'teszt.elek@example.com')
        ->set('privacy', true)
        ->call('submitForm');

    foreach (range(1, 3) as $attempt) {
        $submit()->assertDispatched('notify', fn (string $event, array $params): bool => $params['type'] === 'success');
    }

    $submit()->assertDispatched('notify', fn (string $event, array $params): bool => $params['type'] === 'danger');

    expect(QuoteRequest::query()->count())->toBe(3);
});

it('rate limits the favorites email', function (): void {
    Mail::fake();

    $property = Property::query()->forceCreate(['title' => 'Aktív', 'status' => 'active', 'slug' => 'aktiv', 'offer_type' => 'kiado-iroda']);

    $send = fn () => Livewire::withCookies([FavoriteProperties::COOKIE => json_encode([$property->id])])
        ->test(FavoritesSendModal::class)
        ->set('recipientName', 'Címzett')
        ->set('recipientEmail', 'cimzett@example.com')
        ->call('sendFavorites');

    foreach (range(1, 5) as $attempt) {
        $send();
    }

    $send()->assertDispatched('notify', fn (string $event, array $params): bool => $params['type'] === 'danger');

    Mail::assertSentCount(5);
});
