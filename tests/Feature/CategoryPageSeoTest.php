<?php

declare(strict_types=1);

use App\Livewire\Pages\Office\Category as CategoryPage;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Support\Str;
use Tests\TestCase;

function vaciUtCategory(): Category
{
    return Category::query()->forceCreate([
        'name' => 'Kiadó Váci úti irodák',
        'slug' => 'kiado-vaci-uti-irodak',
        'seo_title' => 'Kiadó Váci úti irodák, XIII. kerület | PSG Irodaházak',
        'meta_description' => 'Kiadó Váci úti irodák :count irodaházban, 7,5–23 EUR/m²/hó bérleti díjjal.',
        'intro' => '<p>A Váci úti irodafolyosó Budapest legnagyobb irodapiaca. Az alpiaci díjsávokat a <a href="/budapest/irodaberleti-dijak">Budapesti díjsávok 2026</a> oldalon találod.</p>',
    ]);
}

it('gives a category page its own title, a meta description with the current count and the intro instead of the fee band line', function (): void {
    /** @var TestCase $this */
    $category = vaciUtCategory();
    Property::factory()->count(3)->create()->each(fn (Property $property) => $property->categories()->attach($category));

    $html = $this->get('/budapest/kiado-vaci-uti-irodak')
        ->assertOk()
        ->assertSee('<title>Kiadó Váci úti irodák, XIII. kerület | PSG Irodaházak</title>', false)
        ->assertSeeHtml('<meta name="description" content="Kiadó Váci úti irodák 3 irodaházban, 7,5–23 EUR/m²/hó bérleti díjjal.">')
        ->assertSeeText('A Váci úti irodafolyosó Budapest legnagyobb irodapiaca.')
        ->assertDontSeeText('Mennyibe kerül ma egy iroda Budapesten?')
        ->getContent();

    expect(mb_substr_count($html, 'href="/budapest/irodaberleti-dijak"'))->toBe(1)
        ->and(Str::betweenFirst($html, '<h1', '</h1>'))->not->toContain('irodaház')
        ->and($html)->toContain('(3 irodaház)');
});

it('describes a category page as a CollectionPage listing its office buildings in the order shown', function (): void {
    /** @var TestCase $this */
    $category = vaciUtCategory();
    foreach (['Duna Tower', 'Agora Tower', 'WestEnd Business Center'] as $title) {
        Property::factory()->create(['title' => $title])->categories()->attach($category);
    }
    Property::factory()->create(['title' => 'Más kategória']);

    $html = $this->get('/budapest/kiado-vaci-uti-irodak')->assertOk()->getContent();
    $collection = jsonLdNode($html, 'CollectionPage');

    expect($collection['mainEntity']['@type'])->toBe('ItemList')
        ->and(array_column($collection['mainEntity']['itemListElement'], 'name'))->toBe(['Agora Tower', 'Duna Tower', 'WestEnd Business Center'])
        ->and(array_column($collection['mainEntity']['itemListElement'], 'position'))->toBe([1, 2, 3])
        ->and($collection['mainEntity']['itemListElement'][0]['url'])->toBe(Property::query()->where('title', 'Agora Tower')->sole()->url())
        ->and(jsonLdNode($html, 'BreadcrumbList'))->not->toBeNull();
});

it('names at most the first 50 office buildings in the ItemList', function (): void {
    /** @var TestCase $this */
    Property::factory()->count(CategoryPage::ITEM_LIST_LIMIT + 1)->create();

    $html = $this->get(route('kiado-irodak'))->assertOk()->getContent();

    expect(jsonLdNode($html, 'CollectionPage')['mainEntity']['itemListElement'])->toHaveCount(CategoryPage::ITEM_LIST_LIMIT)
        ->and($html)->toContain('<meta name="description" content="Kiadó irodák Budapesten '.(CategoryPage::ITEM_LIST_LIMIT + 1).' irodaházból:');
});

it('keeps the Hungarian copy off the English category page', function (): void {
    /** @var TestCase $this */
    vaciUtCategory();

    $this->get(route('en.budapest.category', ['category' => 'kiado-vaci-uti-irodak']))
        ->assertOk()
        ->assertDontSee('XIII. kerület | PSG Irodaházak', false)
        ->assertDontSeeText('A Váci úti irodafolyosó Budapest legnagyobb irodapiaca.');
});
