<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Office;

use App\Livewire\Concerns\RendersAsPage;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * /budapest/irodaberleti-dijak: the office rental fee bands of Budapest per
 * submarket, from the property data sheets. Hungarian only.
 *
 * The copy is translatable: the English keys are in the view and here, the
 * approved Hungarian text in lang/hu.json. When the figures are refreshed,
 * update the text and LAST_UPDATED together: the visible "Utolsó frissítés"
 * date and the Article's dateModified follow it.
 */
final class RentalFees extends Component
{
    use RendersAsPage;

    public const string PUBLISHED = '2026-11-09';

    public const string LAST_UPDATED = '2026-11-09';

    public static function headline(): string
    {
        return __('Office rents in Budapest in 2026: how much does an office cost per submarket?');
    }

    public static function description(): string
    {
        return __('How much does an office cost in Budapest in 2026? Asking rents of 230 office buildings per submarket: city centre, Váci út, South Buda, Buda, Pest. Operating fee, parking, common area factor.');
    }

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    /**
     * A link to an office category page, for the "related listings" lines of the text.
     */
    public function categoryLink(string $slug, string $anchor): string
    {
        return '<a wire:navigate.hover href="'.e(route('budapest.category', ['category' => $slug])).'">'.e($anchor).'</a>';
    }

    /**
     * The fee bands per submarket, as in the approved text.
     *
     * @return list<array{submarket: string, buildings: string, range: string, median: string, operating_fee: string, parking: string}>
     */
    public function submarkets(): array
    {
        return [
            ['submarket' => __('City centre (V., VI., VII.)'), 'buildings' => '42', 'range' => '11,5 – 28', 'median' => '18,0', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 845', 'eur' => '6,25']), 'parking' => __(':eur EUR/space', ['eur' => '148'])],
            ['submarket' => __('Váci út corridor (XIII.)'), 'buildings' => '51', 'range' => '7,5 – 23', 'median' => '15,0', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 375', 'eur' => '5,25']), 'parking' => __(':eur EUR/space', ['eur' => '120'])],
            ['submarket' => __('South Buda (XI., XXII.)'), 'buildings' => '30', 'range' => '9,25 – 21', 'median' => '14,5', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 340', 'eur' => '6,5']), 'parking' => __(':eur EUR/space', ['eur' => '100'])],
            ['submarket' => __('Rest of Buda (I., II., III., XII.)'), 'buildings' => '41', 'range' => '7 – 27', 'median' => '16,7', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 600', 'eur' => '5,9']), 'parking' => __(':eur EUR/space', ['eur' => '120'])],
            ['submarket' => __('Rest of Pest (VIII., IX., X., XIV. and the others)'), 'buildings' => '31', 'range' => '7 – 22', 'median' => '15,0', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 800', 'eur' => '6,3']), 'parking' => __(':eur EUR/space', ['eur' => '110'])],
            ['submarket' => __('Agglomeration (Budaörs, Törökbálint)'), 'buildings' => '3', 'range' => '8 – 14', 'median' => '12,9', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 340', 'eur' => '4,75']), 'parking' => __(':eur EUR/space', ['eur' => '40'])],
            ['submarket' => __('Budapest total'), 'buildings' => '198', 'range' => '7 – 28', 'median' => '15,5', 'operating_fee' => __(':huf HUF or :eur EUR', ['huf' => '2 500', 'eur' => '6']), 'parking' => __(':eur EUR/space', ['eur' => '120'])],
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
                'question' => __('How much does it cost to rent an office in Budapest in 2026?'),
                'answer' => __('Asking rents range from 7 to 28 EUR/m²/month, with a typical value of 15.5 EUR/m²/month. On top of this come the operating fee (2,300–3,200 HUF/m²/month) and parking (100–180 EUR/space/month); all amounts are net.'),
            ],
            [
                'question' => __('Which is the most expensive office submarket in Budapest?'),
                'answer' => __('District V, with a median of 22.5 EUR/m²/month; premium buildings ask 25–28 EUR. The cheapest are District III and the agglomeration, with medians around 13–14 EUR.'),
            ],
            [
                'question' => __('What is the operating fee in a Budapest office building?'),
                'answer' => __('Typically 2,300–3,200 HUF/m²/month, or 5–7 EUR/m²/month when given in euros. It is highest in the city centre and lowest on Váci út. The landlord settles it with the tenants annually, in arrears, on an open-book basis.'),
            ],
            [
                'question' => __('What is the common area factor?'),
                'answer' => __('A percentage is also charged for the use of the common areas (lobby, corridors, staircase, lift lobby), added to the net area leased exclusively. This gross leased area becomes the basis for the rent and the operating costs. In Budapest it is between 5 and 10%; the median on our data sheets is 7.2%.'),
            ],
            [
                'question' => __('What is the minimum lease term for an office?'),
                'answer' => __('Most office buildings expect a 3 or 5 year lease. A 1 year term is available in serviced offices and Class B buildings.'),
            ],
            [
                'question' => __('How much does a serviced office cost in Budapest?'),
                'answer' => __('150–550 EUR/person/month, with a median of 370 EUR, which also includes the operating fee, use of furniture, internet, reception services, part of the meeting room use and office cleaning.'),
            ],
            [
                'question' => __('Where does the data come from?'),
                'answer' => __('From the 230 Budapest office building data sheets of PSG Irodaházak, updated monthly from the reports of landlords and real estate consultancies with exclusive mandates. The fee bands are calculated from the 198 office buildings priced per square metre; serviced offices are listed separately. The summary reflects the situation on 6 November 2026.'),
            ],
        ];
    }

    public function render(): View
    {
        return $this->asPage(view('pages.office.rental-fees', [
            'published' => CarbonImmutable::parse(self::PUBLISHED),
            'lastUpdated' => CarbonImmutable::parse(self::LAST_UPDATED),
        ]), [
            ['name' => __('Rental Offices'), 'url' => route('kiado-irodak')],
            ['name' => __('Office rents in Budapest 2026'), 'url' => route('rental-fees')],
        ]);
    }
}
