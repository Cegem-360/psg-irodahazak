<?php

declare(strict_types=1);

use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use Tests\TestCase;

it('shows a page in the language of its URL, whatever the session says', function (string $uri, string $sessionLocale, string $expectedLocale): void {
    /** @var TestCase $this */
    $this->withSession(['locale' => $sessionLocale])
        ->get($uri)
        ->assertOk()
        ->assertSeeHtml('<html lang="'.$expectedLocale.'">')
        ->assertSessionHas('locale', $expectedLocale);
})->with([
    'english page, hungarian session' => ['/offices-for-rent', 'hu', 'en'],
    'english page, no session' => ['/about-us', '', 'en'],
    'hungarian page, english session' => ['/kiado-irodak', 'en', 'hu'],
]);

it('links a page to its other language version with hreflang and in the switcher', function (): void {
    /** @var TestCase $this */
    $response = $this->get('/rolunk')->assertOk();

    $response->assertSeeHtml('<link rel="alternate" hreflang="hu" href="'.url('/rolunk').'">')
        ->assertSeeHtml('<link rel="alternate" hreflang="en" href="'.url('/about-us').'">')
        ->assertSeeHtml('<link rel="alternate" hreflang="x-default" href="'.url('/rolunk').'">')
        ->assertSeeHtml('<meta property="og:locale" content="hu_HU">')
        ->assertSeeHtml('href="'.url('/about-us').'" title="ENG"')
        ->assertDontSee('status=200');
});

it('keeps the route parameters in the alternates of a property page', function (): void {
    /** @var TestCase $this */
    $property = Property::query()->forceCreate(['title' => 'Teszt', 'status' => 'active', 'slug' => 'teszt-hreflang', 'offer_type' => 'kiado-iroda']);

    $this->get('/office-to-let/'.$property->slug)
        ->assertOk()
        ->assertSeeHtml('<html lang="en">')
        ->assertSeeHtml('hreflang="hu" href="'.url('/kiado-iroda/teszt-hreflang').'"');
});

it('lets pages without an english twin follow the session', function (): void {
    /** @var TestCase $this */
    $post = BlogPost::factory()->published()->create();

    $this->withSession(['locale' => 'en'])
        ->get(route('en.blog.show', ['post' => $post->slug]))
        ->assertOk()
        ->assertSeeHtml('<html lang="en">')
        ->assertDontSeeHtml('hreflang');
});

it('keeps the untranslated english news list and articles out of search engines', function (): void {
    /** @var TestCase $this */
    $news = News::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);

    $this->get(route('en.news.show', ['news' => $news->slug]))
        ->assertOk()
        ->assertSeeHtml('<html lang="en">')
        ->assertSeeHtml('content="noindex, follow"')
        ->assertDontSeeHtml('hreflang');

    $this->get(route('news.show', ['news' => $news->slug]))
        ->assertOk()
        ->assertDontSeeHtml('noindex')
        ->assertDontSeeHtml('hreflang');

    $this->get(route('en.news.index'))
        ->assertOk()
        ->assertSeeHtml('content="noindex, follow"')
        ->assertDontSeeHtml('hreflang');

    $this->get(route('news.index'))
        ->assertOk()
        ->assertDontSeeHtml('noindex')
        ->assertDontSeeHtml('hreflang');
});
