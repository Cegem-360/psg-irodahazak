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
 * When the figures are refreshed, update the text and LAST_UPDATED together:
 * the visible "Utolsó frissítés" date and the Article's dateModified follow it.
 */
final class RentalFees extends Component
{
    use RendersAsPage;

    public const string PUBLISHED = '2026-11-09';

    public const string LAST_UPDATED = '2026-11-09';

    public const string HEADLINE = 'Irodabérleti díjak Budapesten 2026-ban: mennyibe kerül egy iroda alpiaconként?';

    public const string DESCRIPTION = 'Mennyibe kerül egy iroda Budapesten 2026-ban? 230 irodaház kínálati díja alpiaconként: belváros, Váci út, Dél-Buda, Buda, Pest. Üzemeltetési díj, parkolás, közös területi szorzó.';

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    /**
     * The fee bands per submarket, as in the approved text.
     *
     * @return list<array{submarket: string, buildings: string, range: string, median: string, operating_fee: string, parking: string}>
     */
    public function submarkets(): array
    {
        return [
            ['submarket' => 'Belváros (V., VI., VII.)', 'buildings' => '42', 'range' => '11,5 – 28', 'median' => '18,0', 'operating_fee' => '2 845 HUF vagy 6,25 EUR', 'parking' => '148 EUR/hely'],
            ['submarket' => 'Váci úti folyosó (XIII.)', 'buildings' => '51', 'range' => '7,5 – 23', 'median' => '15,0', 'operating_fee' => '2 375 HUF vagy 5,25 EUR', 'parking' => '120 EUR/hely'],
            ['submarket' => 'Dél-Buda (XI., XXII.)', 'buildings' => '30', 'range' => '9,25 – 21', 'median' => '14,5', 'operating_fee' => '2 340 HUF vagy 6,5 EUR', 'parking' => '100 EUR/hely'],
            ['submarket' => 'Buda egyéb (I., II., III., XII.)', 'buildings' => '41', 'range' => '7 – 27', 'median' => '16,7', 'operating_fee' => '2 600 HUF vagy 5,9 EUR', 'parking' => '120 EUR/hely'],
            ['submarket' => 'Pest egyéb (VIII., IX., X., XIV. és a többi)', 'buildings' => '31', 'range' => '7 – 22', 'median' => '15,0', 'operating_fee' => '2 800 HUF vagy 6,3 EUR', 'parking' => '110 EUR/hely'],
            ['submarket' => 'Agglomeráció (Budaörs, Törökbálint)', 'buildings' => '3', 'range' => '8 – 14', 'median' => '12,9', 'operating_fee' => '2 340 HUF vagy 4,75 EUR', 'parking' => '40 EUR/hely'],
            ['submarket' => 'Budapest összesen', 'buildings' => '198', 'range' => '7 – 28', 'median' => '15,5', 'operating_fee' => '2 500 HUF vagy 6 EUR', 'parking' => '120 EUR/hely'],
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
                'question' => 'Mennyibe kerül egy iroda bérlése Budapesten 2026-ban?',
                'answer' => 'A kínálati bérleti díj 7 és 28 EUR/m²/hó között mozog, a tipikus érték 15,5 EUR/m²/hó. Ehhez jön az üzemeltetési díj (2 300–3 200 HUF/m²/hó) és a parkolás (100–180 EUR/hely/hó), minden tétel nettó összeg.',
            ],
            [
                'question' => 'Melyik a legdrágább irodapiaci alpiac Budapesten?',
                'answer' => 'Az V. kerület, 22,5 EUR/m²/hó középértékkel; a prémium épületek 25–28 EUR-t kérnek. A legolcsóbb a III. kerület és az agglomeráció, 13–14 EUR körüli középértékkel.',
            ],
            [
                'question' => 'Mennyi az üzemeltetési díj egy budapesti irodaházban?',
                'answer' => 'Jellemzően 2 300–3 200 HUF/m²/hó, euróban megadva 5–7 EUR/m²/hó. A belvárosban a legmagasabb, a Váci úton a legalacsonyabb. A bérbeadó évente, utólag, open-book rendszerben számol el vele a bérlők felé.',
            ],
            [
                'question' => 'Mi az a közös területi szorzó?',
                'answer' => 'A közös területek (lobby, folyosók, lépcsőház, liftelőtér) használata után is fizetni kell egy bizonyos százalékot, amely hozzáadódik a kizárólagosan bérelt nettó területhez. Ez a bruttó bérelt terület lesz a bérleti díj és az üzemeltetési költség alapja. Budapesten 5–10% között mozog, az adatlapjaink középértéke 7,2%.',
            ],
            [
                'question' => 'Mennyi ideig kell bérelni egy irodát minimum?',
                'answer' => 'A legtöbb irodaház 3 vagy 5 éves szerződést vár el. 1 éves futamidő a szolgáltatott irodáknál és a B kategóriás épületeknél érhető el.',
            ],
            [
                'question' => 'Mennyibe kerül egy szolgáltatott iroda Budapesten?',
                'answer' => '150–550 EUR/fő/hó, a középérték 370 EUR, ami az üzemeltetési díjat, a bútorhasználatot, az internetet, a recepciós szolgáltatást, a tárgyalóhasználat egy részét és az irodák takarítását is tartalmazza.',
            ],
            [
                'question' => 'Honnan származnak az adatok?',
                'answer' => 'A PSG Irodaházak 230 budapesti irodaház-adatlapjából, amelyeket a bérbeadók és a kizárólagos megbízással rendelkező ingatlan-tanácsadó cégek riportjai alapján havonta frissítünk. A díjsávok a 198 négyzetméter-alapon árazott irodaházból számolnak, a szolgáltatott irodák külön szerepelnek. Az összesítés 2026. november 6-i állapotot tükröz.',
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
            ['name' => 'Irodabérleti díjak Budapesten 2026', 'url' => route('rental-fees')],
        ]);
    }
}
