<?php

declare(strict_types=1);

use App\Models\BlogPost;
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
        'elado_v_kiado' => 'kiado-iroda',
    ]);

    $hidden = Property::query()->forceCreate([
        'title' => 'Nem aktív ingatlan',
        'status' => 'inactive',
        'slug' => 'nem-aktiv-ingatlan',
        'elado_v_kiado' => 'kiado-iroda',
    ]);

    // BlogCategoryFactory picks from eight fixed names, so two posts share one category to avoid a slug clash.
    $indexedPost = BlogPost::factory()->published()->create();
    $noindexPost = BlogPost::factory()->published()->create(['noindex' => true, 'blog_category_id' => $indexedPost->blog_category_id]);

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
        ->and($properties)->toContain(route('properties.show', ['property' => $property->slug]))
        ->and($properties)->toContain('<loc>'.route('en.properties.show', ['property' => $property->slug]).'</loc>')
        ->and($properties)->not->toContain($hidden->slug)
        ->and($articles)->toContain(route('en.blog.show', ['post' => $indexedPost->slug]))
        ->and($articles)->not->toContain($noindexPost->slug);
});
