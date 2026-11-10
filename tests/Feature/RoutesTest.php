<?php

declare(strict_types=1);

use App\Livewire\Pages\Company\About;
use App\Livewire\Pages\Company\Contact;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Legal\Impressum;
use App\Livewire\Pages\News\Index;
use App\Livewire\Pages\Office\ForRent;
use App\Livewire\Pages\Office\ForSale;
use App\Livewire\Pages\Property\DataSheet;
use App\Livewire\Pages\Property\Show;
use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use Livewire\Livewire;
use Tests\TestCase;

it('redirects the old and helper addresses', function (string $uri, string $target, int $status): void {
    /** @var TestCase $this */
    $this->get($uri)->assertRedirect($target)->assertStatus($status);
})->with([
    'old for-sale category' => ['/budapest/elado-irodak', '/elado-irodahazak', 301],
    'old for-sale category, English' => ['/budapest-en/elado-irodak', '/office-buildings-for-sale', 301],
    'login' => ['/login', '/admin/login', 302],
    'blog without a list page' => ['/news-blog', '/', 302],
]);

it('serves each page as its own Livewire page component', function (string $uri, string $component): void {
    /** @var TestCase $this */
    $this->get($uri)->assertOk()->assertSeeLivewire($component);
})->with([
    ['/', Home::class],
    ['/home', Home::class],
    ['/kiado-irodak', ForRent::class],
    ['/office-buildings-for-sale', ForSale::class],
    ['/rolunk', About::class],
    ['/data-sheet', DataSheet::class],
    ['/kapcsolat', Contact::class],
    ['/impressum', Impressum::class],
    ['/hirek', Index::class],
]);

it('shows a published news article by its slug and hides the rest', function (): void {
    /** @var TestCase $this */
    $published = News::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);
    $draft = News::factory()->create(['is_published' => false]);

    $this->get(route('news.show', ['news' => $published->slug]))->assertOk()->assertSee($published->title);
    $this->get(route('news.show', ['news' => $draft->slug]))->assertNotFound();
    $this->get('/hirek/nincs-ilyen-hir')->assertNotFound();
});

it('shows similar properties of the same type on a property page', function (): void {
    $property = Property::factory()->create(['district' => 'V']);
    $sameDistrict = Property::factory()->create(['district' => 'V']);
    $otherDistrict = Property::factory()->create(['district' => 'XIII']);
    Property::factory()->forSale()->create(['district' => 'V']);

    $similar = Livewire::test(Show::class, ['property' => $property])->instance()->similarProperties;

    expect($similar->pluck('id')->all())->toBe([$sameDistrict->id, $otherDistrict->id]);
});

it('lists the published posts of a blog category', function (): void {
    /** @var TestCase $this */
    $post = BlogPost::factory()->published()->create();
    $post->category->update(['is_active' => true]);

    $this->get(route('en.blog.category', ['category' => $post->category->slug]))
        ->assertOk()
        ->assertSee($post->title);
});
