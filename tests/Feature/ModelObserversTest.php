<?php

declare(strict_types=1);

use App\Models\BlogCategory;
use App\Models\News;
use App\Models\NewsCategory;

it('fills in the slug and excerpt of news and defaults to normal priority', function (): void {
    $news = News::factory()->create([
        'title' => 'Új irodaház nyílt',
        'slug' => null,
        'excerpt' => null,
        'content' => '<p>'.str_repeat('Tartalom ', 40).'</p>',
    ]);

    expect($news->slug)->toBe('uj-irodahaz-nyilt')
        ->and($news->excerpt)->toStartWith('Tartalom Tartalom')->not->toContain('<p>')
        ->and(mb_strlen($news->excerpt))->toBeLessThanOrEqual(163)
        ->and((new News)->priority)->toBe(2);
});

it('keeps a slug that was given', function (): void {
    $news = News::factory()->create(['slug' => 'sajat-slug']);

    $news->update(['title' => 'Más cím']);

    expect($news->fresh()->slug)->toBe('sajat-slug');
});

it('fills in the slug of categories and puts a new news category last', function (): void {
    $first = NewsCategory::factory()->create(['sort_order' => 5]);
    $next = NewsCategory::factory()->create(['name' => 'Piaci elemzés', 'slug' => null, 'sort_order' => null]);
    $blogCategory = BlogCategory::factory()->create(['name' => 'Bérlői tippek', 'slug' => null]);

    expect($next->slug)->toBe('piaci-elemzes')
        ->and($next->sort_order)->toBe($first->sort_order + 1)
        ->and($blogCategory->slug)->toBe('berloi-tippek');
});
