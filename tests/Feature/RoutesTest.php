<?php

declare(strict_types=1);

use App\Livewire\Pages;
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
    ['/', Pages\Home::class],
    ['/home', Pages\Home::class],
    ['/kiado-irodak', Pages\OfficesForRent::class],
    ['/office-buildings-for-sale', Pages\OfficesForSale::class],
    ['/rolunk', Pages\AboutUs::class],
    ['/data-sheet', Pages\DataSheet::class],
    ['/kapcsolat', Pages\Contact::class],
    ['/impressum', Pages\Impressum::class],
    ['/hirek', Pages\NewsIndex::class],
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
    /** @var TestCase $this */
    $property = Property::factory()->create(['district' => 'V']);
    $sameDistrict = Property::factory()->create(['district' => 'V']);
    $otherDistrict = Property::factory()->create(['district' => 'XIII']);
    Property::factory()->forSale()->create(['district' => 'V']);

    $similar = Livewire::test(Pages\PropertyShow::class, ['property' => $property])->instance()->similarProperties;

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
