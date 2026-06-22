<?php

declare(strict_types=1);

use App\Filament\Resources\BlogPostResource\Pages\CreateBlogPost;
use App\Filament\Resources\BlogPostResource\Pages\ListBlogPosts;
use App\Filament\Resources\NewsResource\Pages\ListNews;
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Models\User;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

/*
 * Smoke coverage that the Filament v5 panel (forms, tables, schemas, Livewire 4)
 * boots and renders. Resources backed by externally-imported tables that are not
 * created by migrations (PropertyResource -> "properties", TagResource -> "tags")
 * are intentionally excluded: they cannot render against the :memory: test DB.
 */

beforeEach(function (): void {
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());
});

it('loads the admin dashboard', function (): void {
    $this->get('/admin')->assertSuccessful();
});

it('renders resource list pages', function (string $page): void {
    livewire($page)->assertSuccessful();
})->with([
    [ListBlogPosts::class],
    [ListNews::class],
    [ListTestimonials::class],
]);

it('renders resource create form schemas', function (string $page): void {
    livewire($page)->assertSuccessful();
})->with([
    [CreateBlogPost::class],
    [CreateTestimonial::class],
]);
