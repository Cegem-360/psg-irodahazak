<?php

declare(strict_types=1);

use App\Enums\ArticlePageKey;
use App\Filament\Resources\ArticlePageResource;
use App\Filament\Resources\ArticlePageResource\Pages\EditArticlePage;
use App\Filament\Resources\ArticlePageResource\Pages\ListArticlePages;
use App\Models\ArticlePage;
use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Filament\Facades\Filament;
use Tests\TestCase;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    /** @var TestCase $this */
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());
});

it('lists the two article pages and offers no way to create or delete one', function (): void {
    livewire(ListArticlePages::class)
        ->assertCanSeeTableRecords(ArticlePage::query()->get())
        ->assertCountTableRecords(2);

    expect(ArticlePageResource::canCreate())->toBeFalse();
});

it('shows the owner\'s edits of the rental fee overview on the page, in its schema and in the links to it', function (): void {
    /** @var TestCase $this */
    $page = ArticlePage::for(ArticlePageKey::RentalFees);

    livewire(EditArticlePage::class, ['record' => $page->id])
        ->fillForm([
            'headline' => 'Irodabérleti díjak Budapesten 2027-ben',
            'link_label' => 'Budapesti díjsávok 2027',
            'last_updated_on' => '2027-01-15',
            'body' => '<p>Budapesten 2027 elején 8 és 29 EUR/m²/hó között.</p><table><tbody><tr><th><p>Alpiac</p></th><th><p>Középérték</p></th></tr><tr><th><p>Belváros</p></th><td><p>19,0</p></td></tr></tbody></table>',
            'faqs' => [['question' => 'Mennyibe kerül egy iroda 2027-ben?', 'answer' => 'Jellemzően 16 EUR/m²/hó.']],
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

    $html = $this->get(route('rental-fees'))
        ->assertOk()
        ->assertSeeText('Irodabérleti díjak Budapesten 2027-ben')
        ->assertSeeText('Utolsó frissítés: 2027. január')
        ->assertSeeText('Budapesten 2027 elején 8 és 29 EUR/m²/hó között.')
        ->assertSeeHtml('<td><p>19,0</p></td>')
        ->assertDontSeeText('Budapesten egy irodaház bérleti díja 2026 őszén')
        ->getContent();

    expect(jsonLdNode($html, 'Article'))->toMatchArray(['headline' => 'Irodabérleti díjak Budapesten 2027-ben', 'dateModified' => '2027-01-15'])
        ->and(jsonLdNode($html, 'FAQPage')['mainEntity'])->toHaveCount(1)
        ->and(jsonLdNode($html, 'FAQPage')['mainEntity'][0]['name'])->toBe('Mennyibe kerül egy iroda 2027-ben?');

    Category::query()->forceCreate(['name' => 'Kiadó budai irodák', 'slug' => 'kiado-budai-irodak']);
    $this->get('/budapest/kiado-budai-irodak')->assertOk()->assertSeeText('Budapesti díjsávok 2027');
    $this->get(Property::factory()->create()->url())->assertOk()->assertSeeText('Budapesti díjsávok 2027');
});

it('does not save an update date earlier than the publication date', function (): void {
    livewire(EditArticlePage::class, ['record' => ArticlePage::for(ArticlePageKey::OperatingFee)->id])
        ->fillForm(['last_updated_on' => '2026-11-01'])
        ->call('save')
        ->assertHasFormErrors(['last_updated_on' => 'after_or_equal']);
});

it('shows the update date of the operating fee article next to its publication date once it is refreshed', function (): void {
    /** @var TestCase $this */
    ArticlePage::for(ArticlePageKey::OperatingFee)->update(['last_updated_on' => '2027-02-03']);

    $html = $this->get(route('operating-fee'))
        ->assertOk()
        ->assertSeeText('Megjelent: 2026. november 24. · Utolsó frissítés: 2027. február 3.')
        ->getContent();

    expect(jsonLdNode($html, 'Article')['dateModified'])->toBe('2027-02-03');
});
