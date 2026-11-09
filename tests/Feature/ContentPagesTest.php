<?php

declare(strict_types=1);

use App\Livewire\Pages\RentalFees;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\News;
use App\Models\Property;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

it('publishes the rental fee overview with its table, source line, category links and schema', function (): void {
    /** @var TestCase $this */
    $html = $this->get('/budapest/irodaberleti-dijak')
        ->assertOk()
        ->assertSeeText('Utolsó frissítés: 2026. november')
        ->assertSeeHtml('<th scope="row" class="p-3 font-medium text-gray-900">Váci úti folyosó (XIII.)</th>')
        ->assertSeeText('Forrás: a PSG Irodaházak 230 irodaház-adatlapja, 2026. november 6.')
        ->getContent();

    $links = [
        'kiado-belvarosi-irodak' => 'kiadó belvárosi irodák',
        'kiado-irodak-v-kerulet' => 'kiadó irodák az V. kerületben',
        'kiado-vaci-uti-irodak' => 'kiadó Váci úti irodák',
        'kiado-irodak-xi-kerulet' => 'kiadó irodák a XI. kerületben',
        'kiado-budai-irodak' => 'kiadó budai irodák',
        'kiado-bel-budai-irodak' => 'kiadó bel-budai irodák',
        'kiado-pesti-irodak' => 'kiadó pesti irodák',
        'kiado-azonnali-szolgaltatott-irodak' => 'kiadó azonnali szolgáltatott irodák',
    ];

    foreach ($links as $slug => $anchor) {
        expect($html)->toContain('href="'.route('budapest.category', ['category' => $slug]).'">'.$anchor.'</a>');
    }

    $article = jsonLdNode($html, 'Article');
    $faqs = jsonLdNode($html, 'FAQPage')['mainEntity'];

    expect(mb_substr_count($html, '<h1'))->toBe(1)
        ->and($html)->toContain('<table')
        ->and($article['headline'])->toBe(RentalFees::HEADLINE)
        ->and($article['dateModified'])->toBe(RentalFees::LAST_UPDATED)
        ->and($article['author']['@id'])->toBe(jsonLdNode($html, 'Person')['@id'])
        ->and($article['publisher']['@id'])->toBe(jsonLdNode($html, 'Organization')['@id'])
        ->and($faqs)->toHaveCount(7);

    foreach ($faqs as $faq) {
        expect($html)->toContain('<h3>'.e($faq['name']).'</h3>')
            ->toContain('<p>'.e($faq['acceptedAnswer']['text']).'</p>');
    }
});

it('presents the founder as a Person that the organization and the pages point to', function (): void {
    /** @var TestCase $this */
    $html = $this->get('/fekete-richard')
        ->assertOk()
        ->assertSeeText('Fekete Richárd, ügyvezető')
        ->assertDontSee('társtulajdonos')
        ->getContent();

    $person = jsonLdNode($html, 'Person');
    $organization = jsonLdNode($html, 'Organization');

    expect(jsonLdNode($html, 'ProfilePage')['mainEntity']['@id'])->toBe($person['@id'])
        ->and($organization['founder']['@id'])->toBe($person['@id'])
        ->and($organization)->toMatchArray(['foundingDate' => '2014', 'areaServed' => 'Budapest'])
        ->and($organization)->not->toHaveKey('alternateName')
        ->and($person)->toMatchArray([
            'name' => 'Fekete Richárd',
            'jobTitle' => 'ügyvezető',
            'url' => route('fekete-richard'),
            'sameAs' => ['https://www.linkedin.com/in/richard-fekete-17371943/'],
            'knowsAbout' => ['irodabérlés Budapest', 'irodabérleti szerződés tárgyalása', 'irodaház értékesítés'],
        ])
        ->and(array_column($person['alumniOf'], 'name'))->toBe(['Budapesti Gazdasági Egyetem', 'Budapesti Műszaki és Gazdaságtudományi Egyetem'])
        ->and($person)->not->toHaveKey('image');
});

it('shows the new About Us text as an AboutPage of the organization, linking the founder and the fee overview', function (): void {
    /** @var TestCase $this */
    $html = $this->get('/rolunk')
        ->assertOk()
        ->assertSeeText('Rólunk: a PSG Irodaházak')
        ->assertSeeHtml('href="'.route('fekete-richard').'"')
        ->assertSeeHtml('href="'.route('rental-fees').'">az adatlapjainkon szereplő bérleti díjak</a>')
        ->getContent();

    expect(jsonLdNode($html, 'AboutPage')['mainEntity']['@id'])->toBe(jsonLdNode($html, 'Organization')['@id']);
});

it('credits the founder as the author of the news', function (): void {
    /** @var TestCase $this */
    $news = News::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);

    $html = $this->get(route('news.show', ['news' => $news->slug]))
        ->assertOk()
        ->assertSeeText('Szerző: Fekete Richárd')
        ->getContent();

    expect(jsonLdNode($html, 'NewsArticle')['author']['@id'])->toBe(jsonLdNode($html, 'Person')['@id']);
});

it('links the fee overview from the category pages, the rent of a data sheet and the menus', function (): void {
    /** @var TestCase $this */
    Category::query()->forceCreate(['name' => 'Kiadó budai irodák', 'slug' => 'kiado-budai-irodak']);
    $property = Property::factory()->create();
    $feeLink = 'href="'.route('rental-fees').'"';

    $this->get('/budapest/kiado-budai-irodak')->assertOk()->assertSeeHtml($feeLink)->assertSeeText('Budapesti díjsávok 2026');
    $this->get($property->url())->assertOk()->assertSeeHtml($feeLink)->assertSeeText('Budapesti díjsávok 2026');
    $this->get('/')->assertOk()->assertSeeText('Bérleti díjak')->assertSeeHtml('href="'.route('fekete-richard').'"');
});

it('lists both new pages in the sitemap', function (): void {
    /** @var TestCase $this */
    $directory = sys_get_temp_dir().'/sitemap-test-'.bin2hex(random_bytes(6));
    File::ensureDirectoryExists($directory);

    $this->artisan('sitemap:generate', ['--path' => $directory.'/sitemap.xml'])->assertSuccessful();

    $pages = (string) file_get_contents($directory.'/sitemap-oldalak.xml');
    File::deleteDirectory($directory);

    expect($pages)->toContain('<loc>'.route('rental-fees').'</loc>')
        ->toContain('<loc>'.route('fekete-richard').'</loc>');
});

it('shows a 404 page without the popup that could not be closed, with the way on', function (string $uri): void {
    /** @var TestCase $this */
    $this->get($uri)
        ->assertNotFound()
        ->assertDontSeeHtml('wire:snapshot')
        ->assertSeeHtml('href="'.route('home').'"')
        ->assertSeeHtml('href="'.route('kiado-irodak').'"')
        ->assertSeeText('A keresett oldal nem létezik vagy átköltözött.');
})->with([
    'unknown property' => ['/kiado-iroda/nincs-ilyen-epulet'],
    'unknown address' => ['/nincs-ilyen-oldal'],
]);

it('keeps noindex blog posts out of the home page and the category lists but readable', function (): void {
    /** @var TestCase $this */
    $listed = BlogPost::factory()->published()->create(['title' => 'Irodapiaci poszt']);
    $hidden = BlogPost::factory()->published()->create(['title' => 'Karácsonyi filmek', 'noindex' => true, 'blog_category_id' => $listed->blog_category_id]);

    $this->get('/')->assertSeeText('Irodapiaci poszt')->assertDontSeeText('Karácsonyi filmek');
    $this->get(route('en.blog.category', ['category' => $listed->category->slug]))->assertSeeText('Irodapiaci poszt')->assertDontSeeText('Karácsonyi filmek');
    $this->get(route('en.blog.show', ['post' => $hidden->slug]))->assertOk()->assertSeeHtml('<meta name="robots" content="noindex, follow">');
});
