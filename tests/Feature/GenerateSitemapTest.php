<?php

declare(strict_types=1);

use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

it('writes a sitemap index pointing at the page, property and article sitemaps', function (): void {
    // forceCreate rather than the factory: PropertyFactory is still an empty stub
    // and the model does not use HasFactory.
    /** @var TestCase $this */
    $property = Property::query()->forceCreate([
        'title' => 'Teszt ingatlan',
        'status' => 'active',
        'slug' => 'teszt-ingatlan-sitemap',
        'offer_type' => 'kiado-iroda',
    ]);

    $inactive = Property::factory()->inactive()->create(['slug' => 'nem-aktiv-ingatlan']);
    $deleted = Property::factory()->create(['slug' => 'torolt-ingatlan']);
    $deleted->delete();
    Property::factory()->create(['slug' => 'veglegesen-torolt'])->forceDelete();

    // BlogCategoryFactory picks from eight fixed names, so two posts share one category to avoid a slug clash.
    $indexedPost = BlogPost::factory()->published()->create();
    $noindexPost = BlogPost::factory()->published()->create(['noindex' => true, 'blog_category_id' => $indexedPost->blog_category_id]);

    $news = News::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);

    $directory = sys_get_temp_dir().'/sitemap-test-'.bin2hex(random_bytes(6));
    File::ensureDirectoryExists($directory);

    $this->artisan('sitemap:generate', ['--path' => $directory.'/sitemap.xml'])->assertSuccessful();

    $index = (string) file_get_contents($directory.'/sitemap.xml');
    $pages = (string) file_get_contents($directory.'/sitemap-oldalak.xml');
    $properties = (string) file_get_contents($directory.'/sitemap-ingatlanok.xml');
    $articles = (string) file_get_contents($directory.'/sitemap-hirek.xml');
    File::deleteDirectory($directory);

    expect($index)->toContain('<sitemapindex')
        ->and($index)->toContain(url('sitemap-oldalak.xml'))
        ->and($index)->toContain(url('sitemap-ingatlanok.xml'))
        ->and($index)->toContain(url('sitemap-hirek.xml'))
        ->and($pages)->toContain('<urlset')
        ->and($pages)->toContain(url('/kapcsolat'))
        ->and($pages)->not->toContain('/adatlap-oldal')
        ->and($pages)->not->toContain('/admin')
        ->and($pages)->toContain('<loc>'.url('/offices-for-rent').'</loc>')
        ->and($pages)->toContain('hreflang="en" href="'.url('/offices-for-rent').'"')
        ->and($pages)->toContain('<loc>'.url('/hirek').'</loc>')
        ->and($pages)->not->toContain(url('/news'))
        ->and($properties)->toContain(route('properties.show', ['property' => $property->slug]))
        ->and($properties)->toContain('<loc>'.route('en.properties.show', ['property' => $property->slug]).'</loc>')
        ->and($properties)->toContain(route('properties.show', ['property' => $inactive->slug]))
        ->and($properties)->toContain(route('properties.show', ['property' => $deleted->slug]))
        ->and($properties)->not->toContain('veglegesen-torolt')
        ->and($articles)->toContain(route('en.blog.show', ['post' => $indexedPost->slug]))
        ->and($articles)->not->toContain($noindexPost->slug)
        ->and($articles)->toContain('<loc>'.route('news.show', ['news' => $news->slug]).'</loc>')
        ->and($articles)->not->toContain(route('en.news.show', ['news' => $news->slug]));
});
