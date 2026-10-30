<?php

declare(strict_types=1);

use App\Models\BlogPost;
use App\Models\Property;
use Tests\TestCase;

it('shows a page in the language of its URL, whatever the session says', function (string $uri, string $sessionLocale, string $expectedLocale): void {
    /** @var TestCase $this */
    $this->withSession(['locale' => $sessionLocale])
        ->get($uri)
        ->assertOk()
        ->assertSee('<html lang="'.$expectedLocale.'">', false)
        ->assertSessionHas('locale', $expectedLocale);
})->with([
    'english page, hungarian session' => ['/offices-for-rent', 'hu', 'en'],
    'english page, no session' => ['/about-us', '', 'en'],
    'hungarian page, english session' => ['/kiado-irodak', 'en', 'hu'],
]);

it('links a page to its other language version with hreflang and in the switcher', function (): void {
    /** @var TestCase $this */
    $response = $this->get('/rolunk')->assertOk();

    $response->assertSee('<link rel="alternate" hreflang="hu" href="'.url('/rolunk').'">', false)
        ->assertSee('<link rel="alternate" hreflang="en" href="'.url('/about-us').'">', false)
        ->assertSee('<link rel="alternate" hreflang="x-default" href="'.url('/rolunk').'">', false)
        ->assertSee('<meta property="og:locale" content="hu_HU">', false)
        ->assertSee('href="'.url('/about-us').'" title="ENG"', false)
        ->assertDontSee('status=200');
});

it('keeps the route parameters in the alternates of a property page', function (): void {
    /** @var TestCase $this */
    $property = Property::query()->forceCreate(['title' => 'Teszt', 'status' => 'active', 'slug' => 'teszt-hreflang', 'elado_v_kiado' => 'kiado-iroda']);

    $this->get('/office-to-let/'.$property->slug)
        ->assertOk()
        ->assertSee('<html lang="en">', false)
        ->assertSee('hreflang="hu" href="'.url('/kiado-iroda/teszt-hreflang').'"', false);
});

it('lets pages without an english twin follow the session', function (): void {
    /** @var TestCase $this */
    $post = BlogPost::factory()->published()->create();

    $this->withSession(['locale' => 'en'])
        ->get(route('en.blog.show', ['post' => $post->slug]))
        ->assertOk()
        ->assertSee('<html lang="en">', false)
        ->assertDontSee('hreflang', false);
});
