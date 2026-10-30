<?php

declare(strict_types=1);

use App\Jobs\SubmitUrlsToIndexNow;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Property;
use App\Models\Reference;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Pulls every JSON-LD block out of a page and merges their @graph nodes.
 *
 * @return list<array<string, mixed>>
 */
function jsonLdNodes(string $html): array
{
    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

    return collect($matches[1])
        ->map(fn (string $json): array => json_decode($json, true, flags: JSON_THROW_ON_ERROR))
        ->flatMap(fn (array $data): array => $data['@graph'] ?? [$data])
        ->values()
        ->all();
}

/**
 * @return array<string, mixed>|null
 */
function jsonLdNode(string $html, string $type): ?array
{
    return collect(jsonLdNodes($html))
        ->first(fn (array $node): bool => in_array($type, (array) $node['@type'], true));
}

function bankCenter(array $attributes = []): Property
{
    return Property::query()->forceCreate([
        'title' => 'Bank Center',
        'slug' => 'bank-center',
        'status' => 'active',
        'offer_type' => 'kiado-iroda',
        'postal_code' => '1054',
        'city' => 'Budapest',
        'street' => 'Szabadság',
        'street_type' => 'tér',
        'house_number' => '7.',
        'maps_lat' => '47.5028034',
        'maps_lng' => '19.0521024',
        'construction_year' => '1995',
        'total_area' => '32,000',
        'total_area_unit' => 'm2',
        'available_area' => '1820',
        'min_available_area' => '79',
        'min_available_area_unit' => 'm2',
        'min_rent' => '22',
        'max_rent' => '25',
        'min_rent_unit' => 'EUR/m2/hó',
        'operating_fee' => '2840',
        'operating_fee_unit' => 'HUF/m2/hó',
        'min_parking_fee' => '220',
        'min_parking_fee_unit' => 'EUR/hely/hó',
        'common_area_ratio' => '10',
        'common_area_ratio_unit' => '%',
        'min_lease_term' => '3',
        'min_lease_term_unit' => 'év',
        ...$attributes,
    ]);
}

describe('canonical host redirects', function (): void {
    beforeEach(function (): void {
        /** @var TestCase $this */
        $this->app['env'] = 'production';
        config(['app.url' => 'https://psg-irodahazak.hu']);
    });

    it('redirects the /public/ copy of a page to the root URL', function (): void {
        /** @var TestCase $this */
        $this->call('GET', 'https://psg-irodahazak.hu/public/kapcsolat', server: [
            'SCRIPT_NAME' => '/public/index.php',
            'SCRIPT_FILENAME' => '/home/psgiroda/public_html/public/index.php',
        ])->assertRedirect('https://psg-irodahazak.hu/kapcsolat')->assertStatus(301);
    });

    it('redirects http and www to https without www', function (string $url): void {
        /** @var TestCase $this */
        $this->get($url)->assertRedirect('https://psg-irodahazak.hu/kapcsolat?a=1')->assertStatus(301);
    })->with([
        'http' => 'http://psg-irodahazak.hu/kapcsolat?a=1',
        'www' => 'https://www.psg-irodahazak.hu/kapcsolat?a=1',
        'http www' => 'http://www.psg-irodahazak.hu/kapcsolat?a=1',
    ]);

    it('serves the canonical address itself', function (): void {
        /** @var TestCase $this */
        $this->call('GET', 'https://psg-irodahazak.hu/kapcsolat', server: [
            'SCRIPT_NAME' => '/public/index.php',
            'SCRIPT_FILENAME' => '/home/psgiroda/public_html/public/index.php',
        ])->assertOk();
    });
});

it('leaves addresses alone outside production', function (): void {
    /** @var TestCase $this */
    $this->get('http://www.psg-irodahazak.test/kapcsolat')->assertOk();
});

it('ships the agreed robots.txt', function (): void {
    expect(file_get_contents(public_path('robots.txt')))
        ->toStartWith("User-agent: *\nDisallow: /admin/\nDisallow: /adatlap-oldal\n")
        ->toContain("User-agent: GPTBot\nAllow: /")
        ->toEndWith("Sitemap: https://psg-irodahazak.hu/sitemap.xml\n");
});

it('renders the home page head with robots, author and organization data', function (): void {
    /** @var TestCase $this */
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('<meta name="robots"
                content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">')
        ->not->toContain('name="googlebot"')
        ->toContain('<meta name="author" content="Property Solution Group Kft.">')
        ->not->toMatch('#<title>[^<]*\|\s*</title>#')
        ->and(mb_substr_count($html, '<h1'))->toBe(1)
        ->and($html)->toContain('Kiadó irodák Budapesten – A kategóriás irodaházak egy helyen');

    $organization = jsonLdNode($html, 'Organization');
    $person = jsonLdNode($html, 'Person');

    expect($organization)
        ->toMatchArray(['legalName' => 'Property Solution Group Kft.', 'vatID' => '24963200-2-41'])
        ->and($organization['founder']['@id'])->toBe($person['@id'])
        ->and($person['worksFor']['@id'])->toBe($organization['@id'])
        ->and(jsonLdNode($html, 'BreadcrumbList'))->toBeNull();
});

it('puts the counter values and the image alt texts in the home page HTML', function (): void {
    Reference::factory()->create(['name' => 'Lavylites', 'is_active' => true]);
    Property::query()->forceCreate([
        'title' => 'Váci Greens',
        'slug' => 'vaci-greens',
        'status' => 'active',
        'featured' => true,
        'offer_type' => 'kiado-iroda',
        'property_photos' => ['property/1/vaci-greens.webp'],
    ]);

    /** @var TestCase $this */
    $this->get(route('home'))
        ->assertOk()
        ->assertSeeHtml('data-to="25" data-suffix="+">25+</span>')
        ->assertSeeHtml('data-to="90" data-suffix="%">90%</span>')
        ->assertSeeHtml('alt="Lavylites"')
        ->assertSeeHtml('alt="Váci Greens irodaház"');
});

it('keeps the slogan out of the headings below the home page', function (): void {
    /** @var TestCase $this */
    $html = $this->get(route('kiado-irodak'))->assertOk()->getContent();

    expect($html)->not->toMatch('#<h2>\s*A teljes budapesti#')
        ->and(mb_substr_count($html, '<h1'))->toBe(1);
});

it('gives a category page its own H1, title, description and breadcrumb', function (): void {
    $category = Category::query()->create([
        'name' => 'Kiadó belvárosi irodák',
        'slug' => 'kiado-belvarosi-irodak',
        'heading' => 'Kiadó belvárosi irodák Budapesten',
        'seo_title' => 'Belvárosi irodák bérlése',
        'meta_description' => 'Egyedi kategória-leírás.',
    ]);
    bankCenter()->categories()->attach($category);

    /** @var TestCase $this */
    $html = $this->get(route('budapest.category', ['category' => 'kiado-belvarosi-irodak']))->assertOk()->getContent();

    expect($html)
        ->toContain('<title>Belvárosi irodák bérlése</title>')
        ->toContain('<meta name="description" content="Egyedi kategória-leírás.">')
        ->and(mb_substr_count($html, '<h1'))->toBe(1);

    preg_match('#<h1[^>]*>(.*?)</h1>#s', $html, $heading);

    expect(Str::squish(strip_tags($heading[1])))->toBe('Kiadó belvárosi irodák Budapesten (1 irodaház)');

    $crumbs = jsonLdNode($html, 'BreadcrumbList')['itemListElement'];

    expect(array_column($crumbs, 'name'))->toBe(['Főoldal', 'Kiadó irodák', 'Kiadó belvárosi irodák'])
        ->and($crumbs[2]['item'])->toBe(route('budapest.category', ['category' => 'kiado-belvarosi-irodak']));
});

it('returns 404 for an unknown category', function (): void {
    /** @var TestCase $this */
    $this->get('/budapest/nincs-ilyen')->assertNotFound();
});

it('describes a property page as a Place with an offer, matching the listed values', function (): void {
    $property = bankCenter();

    /** @var TestCase $this */
    $html = $this->get(route('properties.show', ['property' => $property->slug]))->assertOk()->getContent();

    $place = jsonLdNode($html, 'Place');
    $offer = jsonLdNode($html, 'Offer');
    $values = collect($place['additionalProperty'])->keyBy('name');

    expect($place['@id'])->toBe(route('properties.show', ['property' => 'bank-center']).'#place')
        ->and($place['address'])->toMatchArray(['streetAddress' => 'Szabadság tér 7.', 'postalCode' => '1054'])
        ->and($place['geo'])->toMatchArray(['latitude' => 47.5028034, 'longitude' => 19.0521024])
        ->and($values['Összterület'])->toMatchArray(['value' => 32000, 'unitCode' => 'MTK'])
        ->and($values['Jelenleg kiadó'])->toMatchArray(['value' => 1820, 'unitCode' => 'MTK'])
        ->and($values['Üzemeltetési díj']['value'])->toBe('2840 HUF/m2/hó')
        ->and($values['Parkolás díja']['value'])->toBe('220 EUR/hely/hó')
        ->and($values['Közös területi arány']['value'])->toBe('10%')
        ->and($values['Minimum bérleti időszak']['value'])->toBe('3 év')
        ->and($offer['availableAtOrFrom']['@id'])->toBe($place['@id'])
        ->and($offer['priceSpecification'])->toMatchArray([
            'minPrice' => 22,
            'maxPrice' => 25,
            'priceCurrency' => 'EUR',
            'unitText' => 'm2/hó',
        ])
        ->and($offer['seller']['@id'])->toBe(url('/').'/#organization')
        ->and(mb_substr_count($html, '<h1'))->toBe(1)
        ->and(array_column(jsonLdNode($html, 'BreadcrumbList')['itemListElement'], 'name'))
        ->toBe(['Főoldal', 'Kiadó irodák', 'Bank Center']);
});

it('marks the empty data sheet page noindex', function (): void {
    /** @var TestCase $this */
    $html = $this->get(route('adatlap-oldal'))->assertOk()->getContent();

    expect($html)->toContain('<meta name="robots" content="noindex, follow">')
        ->and(mb_substr_count($html, 'name="robots"'))->toBe(1);
});

it('marks hidden blog posts noindex and credits the organization in the article schema', function (): void {
    $post = BlogPost::factory()->published()->create([
        'noindex' => true,
        'featured_image' => 'https://m.blog.hu/ps/psgirodahazak/image/kep.jpg',
    ]);

    /** @var TestCase $this */
    $html = $this->get(route('en.blog.show', $post->slug))->assertOk()->getContent();

    $article = jsonLdNode($html, 'Article');

    expect($html)->toContain('<meta name="robots" content="noindex, follow">')
        ->and(mb_substr_count($html, 'name="robots"'))->toBe(1)
        ->and($article['author'])->toMatchArray(['@type' => 'Organization', '@id' => url('/').'/#organization'])
        ->and($article['publisher']['logo']['url'])->toContain('psg-irodahazak-logo')
        ->and($article['image'])->toBe('https://m.blog.hu/ps/psgirodahazak/image/kep.jpg');
});

it('serves the IndexNow key file only for the configured key', function (): void {
    config(['seo.indexnow.key' => 'abcdef0123456789']);

    /** @var TestCase $this */
    $this->get('/abcdef0123456789.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertContent('abcdef0123456789');

    $this->get('/0000000000000000.txt')->assertNotFound();
});

it('pings IndexNow when an active property is saved', function (): void {
    config(['seo.indexnow.key' => 'abcdef0123456789']);
    Bus::fake();

    bankCenter();

    Bus::assertDispatchedAfterResponse(
        SubmitUrlsToIndexNow::class,
        fn (SubmitUrlsToIndexNow $job): bool => $job->urls === [route('properties.show', ['property' => 'bank-center'])],
    );
});

it('posts the changed URLs to the IndexNow API', function (): void {
    config(['seo.indexnow.key' => 'abcdef0123456789']);
    Http::fake(['api.indexnow.org/*' => Http::response(status: 200)]);

    (new SubmitUrlsToIndexNow(['https://psg-irodahazak.test/kiado-iroda/bank-center']))->handle();

    Http::assertSent(fn ($request): bool => $request['key'] === 'abcdef0123456789'
        && $request['urlList'] === ['https://psg-irodahazak.test/kiado-iroda/bank-center']);
});

it('does not ping IndexNow without a key', function (): void {
    config(['seo.indexnow.key' => null]);
    Bus::fake();

    bankCenter();

    Bus::assertNothingDispatched();
});

it('prints one canonical link per page, under APP_URL and without the query string', function (string $uri, string $canonicalPath): void {
    /** @var TestCase $this */
    config(['app.url' => 'https://psg-irodahazak.hu']);

    $html = $this->get($uri)->assertOk()->getContent();

    expect(mb_substr_count((string) $html, 'rel="canonical"'))->toBe(1)
        ->and($html)->toContain('<link rel="canonical" href="https://psg-irodahazak.hu'.$canonicalPath.'">');
})->with([
    'home' => ['/', ''],
    'filtered list' => ['/kiado-irodak?districts=V,XIII&page=2', '/kiado-irodak'],
    'page with its own meta slot' => ['/impresszum', '/impresszum'],
]);

it('links a for-sale property page to the sale list in its breadcrumbs', function (): void {
    /** @var TestCase $this */
    $property = Property::query()->forceCreate(['title' => 'Eladó székház', 'slug' => 'elado-szekhaz', 'status' => 'active', 'offer_type' => 'elado-iroda']);

    $nodes = jsonLdNodes((string) $this->get(route('properties.show-for-sale', ['property' => $property->slug]))->assertOk()->getContent());
    $breadcrumbs = collect($nodes)->firstWhere('@type', 'BreadcrumbList');

    expect(collect($breadcrumbs['itemListElement'])->pluck('item')->all())->toBe([
        route('home'),
        route('elado-irodahazak'),
        route('properties.show-for-sale', ['property' => $property->slug]),
    ]);
});
