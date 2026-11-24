<?php

declare(strict_types=1);

namespace App\Livewire\Pages\News;

use App\Livewire\Concerns\RendersAsPage;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * /hirek/uzemeltetesi-dij-irodaberles: the article on the operating fee of
 * office leases, from the property data sheets. Hungarian only.
 *
 * It is not a news item (the owner's request): it has no News record, so it
 * is not in the news list or the home page news block. Its route comes before
 * the news route, so a News record with the same slug would never be shown.
 *
 * The copy is translatable like the rental fee overview: the English keys are
 * in the view and here, the approved Hungarian text in lang/hu.json.
 */
final class OperatingFee extends Component
{
    use RendersAsPage;

    public const string SLUG = 'uzemeltetesi-dij-irodaberles';

    public const string PUBLISHED = '2026-11-24';

    public const string LAST_UPDATED = '2026-11-24';

    public static function headline(): string
    {
        return __('Operating fee in office leasing: what it includes, how much it is in Budapest in 2026, and what to watch for in the settlement');
    }

    public static function description(): string
    {
        return __('What an office building\'s operating fee includes, how much it is in Budapest in 2026 (the median is 2,500 HUF/m²/month), how it is settled and what can be negotiated.');
    }

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    /**
     * The operating fee per submarket, as in the approved text.
     *
     * @return list<array{submarket: string, huf: string, eur: string, rent: string}>
     */
    public function submarkets(): array
    {
        return [
            ['submarket' => __('City centre (V., VI., VII.)'), 'huf' => '2 845', 'eur' => '6,25', 'rent' => '18,0'],
            ['submarket' => __('Váci út corridor (XIII.)'), 'huf' => '2 375', 'eur' => '5,25', 'rent' => '15,0'],
            ['submarket' => __('South Buda (XI., XXII.)'), 'huf' => '2 340', 'eur' => '6,5', 'rent' => '14,5'],
            ['submarket' => __('Rest of Buda (I., II., III., XII.)'), 'huf' => '2 600', 'eur' => '5,9', 'rent' => '16,7'],
            ['submarket' => __('Rest of Pest'), 'huf' => '2 800', 'eur' => '6,3', 'rent' => '15,0'],
            ['submarket' => __('Budapest total'), 'huf' => '2 500', 'eur' => '6,0', 'rent' => '15,5'],
        ];
    }

    /**
     * The questions and answers, shown on the page and in the FAQPage schema word for word.
     *
     * @return list<array{question: string, answer: string}>
     */
    public function faqs(): array
    {
        return [
            [
                'question' => __('How much is the operating fee in a Budapest office building?'),
                'answer' => __('In autumn 2026 typically 2,200–2,850 HUF/m²/month, with a median of 2,500 HUF/m²/month; 5–6.5 EUR/m²/month in buildings priced in euros. It is highest in the city centre and lowest on Váci út.'),
            ],
            [
                'question' => __('Are heating and cooling included in the operating fee?'),
                'answer' => __('In most Budapest office buildings, yes, together with water consumption and waste collection. The premises\' own electricity consumption, however, is almost always paid separately, based on a sub-meter.'),
            ],
            [
                'question' => __('What is open-book settlement?'),
                'answer' => __('At the end of the year the landlord settles the actual operating costs item by item, and the tenant may inspect the invoices. The monthly fee is an advance; the difference is settled afterwards.'),
            ],
            [
                'question' => __('Can the operating fee increase during the lease term?'),
                'answer' => __('Yes, if the actual costs rise, for example because of utility prices. An inflation cap or a fixed fee for the first years can be stipulated in the lease.'),
            ],
            [
                'question' => __('Is there an operating fee in serviced offices too?'),
                'answer' => __('Not separately: the package price per workstation (150–550 EUR/person/month in Budapest) includes it, together with furniture, internet and cleaning.'),
            ],
            [
                'question' => __('Is the operating fee of new office buildings higher?'),
                'answer' => __('No: the median of Budapest buildings handed over after 2018 is 2,425 HUF/m²/month, that of buildings from before 2005 is 2,590, because modern building services use less energy. A BREEAM or LEED certificate, however, does not mean a lower fee: the medians of certified and non-certified buildings are almost the same.'),
            ],
        ];
    }

    public function render(): View
    {
        return $this->asPage(view('pages.news.operating-fee', [
            'published' => CarbonImmutable::parse(self::PUBLISHED),
            'lastUpdated' => CarbonImmutable::parse(self::LAST_UPDATED),
        ]), [
            ['name' => __('News'), 'url' => route('news.index')],
            ['name' => __('Operating fee in office leasing'), 'url' => route('operating-fee')],
        ]);
    }
}
