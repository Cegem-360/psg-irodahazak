<?php

declare(strict_types=1);

use App\Livewire\Pages\News\OperatingFee;
use App\Models\News;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

it('publishes the operating fee article with its table, source line, links and schema', function (): void {
    /** @var TestCase $this */
    $html = $this->get('/hirek/uzemeltetesi-dij-irodaberles')
        ->assertOk()
        ->assertSee('<title>Üzemeltetési díj irodabérlésnél: mennyi Budapesten 2026-ban? | PSG Irodaházak</title>', false)
        ->assertSeeHtml('<meta name="description" content="Mit tartalmaz az irodaház üzemeltetési díja, mennyi Budapesten 2026-ban (2 500 HUF/m²/hó a középérték), hogyan számolják el, és mit lehet belőle tárgyalni.">')
        ->assertSeeText('Üzemeltetési díj irodabérlésnél: mit tartalmaz, mennyi Budapesten 2026-ban, és mire figyelj az elszámolásnál')
        ->assertSeeHtml('<th>Pest egyéb</th>')
        ->assertSeeText('Forrás: a PSG Irodaházak irodaház-adatlapjai, 131 forintban és 66 euróban árazó irodaház, 2026. november 6. Minden díj nettó.')
        ->assertSeeText('Fekete Richárd tapasztalata')
        ->assertSeeHtml('<a href="/budapest/irodaberleti-dijak">irodabérleti díjak Budapesten</a>')
        ->assertSeeHtml('href="'.route('fekete-richard').'" rel="author"')
        ->assertSeeHtml("Livewire.dispatch('open-request-quote-modal')")
        ->getContent();

    $article = jsonLdNode($html, 'Article');
    $faqs = jsonLdNode($html, 'FAQPage')['mainEntity'];

    expect(mb_substr_count($html, '<h1'))->toBe(1)
        ->and($html)->toContain('<table')
        ->and($article['headline'])->toBe('Üzemeltetési díj irodabérlésnél: mit tartalmaz, mennyi Budapesten 2026-ban, és mire figyelj az elszámolásnál')
        ->and($article['datePublished'])->toBe('2026-11-24')
        ->and($article['author']['@id'])->toBe(jsonLdNode($html, 'Person')['@id'])
        ->and($article['publisher']['@id'])->toBe(jsonLdNode($html, 'Organization')['@id'])
        ->and($faqs)->toHaveCount(6);

    foreach ($faqs as $faq) {
        expect($html)->toContain('<h3>'.e($faq['name']).'</h3>')
            ->toContain('<p>'.e($faq['acceptedAnswer']['text']).'</p>');
    }
});

it('is linked from the operating cost paragraph of the rental fee overview', function (): void {
    /** @var TestCase $this */
    $this->get(route('rental-fees'))
        ->assertOk()
        ->assertSeeHtml('<a href="/hirek/uzemeltetesi-dij-irodaberles">részletesen az üzemeltetési díjról</a>');
});

it('opens the article itself from its news record, also from the English news URL', function (): void {
    /** @var TestCase $this */
    News::factory()->create(['slug' => OperatingFee::SLUG, 'is_published' => true, 'published_at' => now()]);

    $this->get(route('news.show', ['news' => OperatingFee::SLUG]))->assertOk()->assertSeeText('Fekete Richárd tapasztalata');
    $this->get('/news/'.OperatingFee::SLUG)->assertRedirect(route('operating-fee'))->assertStatus(301);
});

it('lists the article in the sitemap once', function (): void {
    /** @var TestCase $this */
    News::factory()->create(['slug' => OperatingFee::SLUG, 'is_published' => true, 'published_at' => now()]);
    $directory = sys_get_temp_dir().'/sitemap-test-'.bin2hex(random_bytes(6));
    File::ensureDirectoryExists($directory);

    $this->artisan('sitemap:generate', ['--path' => $directory.'/sitemap.xml'])->assertSuccessful();

    $sitemaps = file_get_contents($directory.'/sitemap-oldalak.xml').file_get_contents($directory.'/sitemap-hirek.xml');
    File::deleteDirectory($directory);

    expect(mb_substr_count($sitemaps, route('operating-fee')))->toBe(1);
});

it('names the article in llms.txt', function (): void {
    expect(file_get_contents(public_path('llms.txt')))
        ->toContain('- [Üzemeltetési díj irodabérlésnél](https://psg-irodahazak.hu/hirek/uzemeltetesi-dij-irodaberles): mit tartalmaz, mennyi Budapesten 2026-ban, elszámolás és tárgyalás');
});
