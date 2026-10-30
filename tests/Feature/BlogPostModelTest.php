<?php

declare(strict_types=1);

use App\Enums\BlogPostStatus;
use App\Filament\Resources\BlogPostResource\Pages\ListBlogPosts;
use App\Models\BlogPost;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

use function Pest\Livewire\livewire;

it('derives the status from the publish flag and date, matching the scopes', function (array $attributes, BlogPostStatus $status): void {
    $post = BlogPost::factory()->create($attributes);

    expect($post->status)->toBe($status)
        ->and(BlogPost::query()->withStatus($status)->pluck('id')->all())->toBe([$post->id]);
})->with([
    'published' => [['is_published' => true, 'published_at' => now()->subDay()], BlogPostStatus::Published],
    'scheduled' => [['is_published' => true, 'published_at' => now()->addDay()], BlogPostStatus::Scheduled],
    'unpublished' => [['is_published' => false, 'published_at' => null], BlogPostStatus::Draft],
    'published without a date' => [['is_published' => true, 'published_at' => null], BlogPostStatus::Draft],
]);

it('estimates the reading time from accented words too', function (): void {
    $post = BlogPost::factory()->make(['content' => '<p>'.str_repeat('árvíztűrő tükörfúrógép ', 150).'</p>']);

    expect($post->reading_time)->toBe(2)
        ->and(BlogPost::factory()->make(['content' => ''])->reading_time)->toBe(1);
});

it('counts a view without changing the last modification date', function (): void {
    /** @var TestCase $this */
    $post = BlogPost::factory()->published()->create(['views_count' => 5]);
    $updatedAt = $post->updated_at;

    Date::setTestNow(now()->addHour());
    $this->get(route('en.blog.show', ['post' => $post->slug]))->assertOk()->assertSee($post->reading_time.' perc olvasás');

    expect($post->refresh()->views_count)->toBe(6)
        ->and($post->updated_at->equalTo($updatedAt))->toBeTrue();
});

it('hides a scheduled post until its date', function (): void {
    /** @var TestCase $this */
    $post = BlogPost::factory()->create(['is_published' => true, 'published_at' => now()->addDay()]);

    $this->get(route('en.blog.show', ['post' => $post->slug]))->assertNotFound();
});

it('filters the admin list by status', function (): void {
    /** @var TestCase $this */
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());

    $published = BlogPost::factory()->published()->create();
    $scheduled = BlogPost::factory()->create(['is_published' => true, 'published_at' => now()->addDay(), 'blog_category_id' => $published->blog_category_id]);

    livewire(ListBlogPosts::class)
        ->assertSee(['Publikált', 'Ütemezett'])
        ->filterTable('status', BlogPostStatus::Scheduled->value)
        ->assertCanSeeTableRecords([$scheduled])
        ->assertCanNotSeeTableRecords([$published]);
});
