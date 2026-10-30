<?php

declare(strict_types=1);

use App\Livewire\NewsList;
use App\Models\News;
use App\Models\NewsCategory;
use Livewire\Livewire;
use Tests\TestCase;

function publishedNews(array $attributes = []): News
{
    return News::factory()->create([
        'is_published' => true,
        'published_at' => now()->subDay(),
        ...$attributes,
    ]);
}

it('is rendered on the news page', function (): void {
    $article = publishedNews(['title' => 'Új irodaház a Váci úton']);

    /** @var TestCase $this */
    $this->get(route('news.index'))
        ->assertOk()
        ->assertSeeLivewire(NewsList::class)
        ->assertSee('Új irodaház a Váci úton')
        ->assertSeeHtml(route('news.show', ['slug' => $article->slug]));
});

it('lists only published news, newest first', function (): void {
    publishedNews(['title' => 'Régebbi hír', 'published_at' => now()->subWeek()]);
    publishedNews(['title' => 'Friss hír', 'published_at' => now()->subHour()]);
    News::factory()->create(['title' => 'Vázlat hír', 'is_published' => false, 'published_at' => null]);

    Livewire::test(NewsList::class)
        ->assertSeeInOrder(['Friss hír', 'Régebbi hír'])
        ->assertDontSee('Vázlat hír');
});

it('filters by search term and category, and keeps them in the URL', function (): void {
    $market = NewsCategory::factory()->create(['name' => 'Irodapiac', 'slug' => 'irodapiac']);
    $other = NewsCategory::factory()->create(['name' => 'Egyéb', 'slug' => 'egyeb']);
    publishedNews(['title' => 'Bérleti díjak 2026-ban', 'news_category_id' => $market->id]);
    publishedNews(['title' => 'Céges évzáró', 'news_category_id' => $other->id]);

    Livewire::withQueryParams(['page' => 1])
        ->test(NewsList::class)
        ->set('search', 'Bérleti')
        ->assertSee('Bérleti díjak 2026-ban')
        ->assertDontSee('Céges évzáró')
        ->set('search', '')
        ->set('category', 'egyeb')
        ->assertSee('Céges évzáró')
        ->assertDontSee('Bérleti díjak 2026-ban')
        ->call('resetFilters')
        ->assertSet('category', '')
        ->assertSee('Bérleti díjak 2026-ban');
});

it('pages through the news', function (): void {
    // NewsCategoryFactory only has ten unique names, so the articles share one category.
    $category = NewsCategory::factory()->create();

    foreach (range(1, NewsList::PER_PAGE + 1) as $day) {
        publishedNews(['title' => sprintf('Hír %02d', $day), 'published_at' => now()->subDays($day), 'news_category_id' => $category->id]);
    }

    Livewire::test(NewsList::class)
        ->assertSee('Hír 01')
        ->assertDontSee(sprintf('Hír %02d', NewsList::PER_PAGE + 1))
        ->call('nextPage')
        ->assertSee(sprintf('Hír %02d', NewsList::PER_PAGE + 1))
        ->assertDontSee('Hír 01');
});

it('shows an empty state when nothing matches', function (): void {
    publishedNews();

    Livewire::test(NewsList::class)
        ->set('search', 'nincs-ilyen-szöveg')
        ->assertSee('Nincs a keresésnek megfelelő hír.');
});
