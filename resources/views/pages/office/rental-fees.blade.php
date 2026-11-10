@inject('structuredData', 'App\Services\StructuredDataService')
@use('App\Livewire\Pages\Office\RentalFees')
<x-slot name="title">Irodabérleti díjak Budapesten 2026: díjsávok alpiaconként | PSG Irodaházak</x-slot>
<x-slot name="metaDescription">{{ RentalFees::DESCRIPTION }}</x-slot>
<x-slot name="meta">
    {{ $structuredData->toScript($structuredData->authoredArticle(RentalFees::HEADLINE, RentalFees::DESCRIPTION, route('rental-fees'), $published, $lastUpdated)) }}
    {{ $structuredData->toScript($structuredData->faqPage($this->faqs())) }}
</x-slot>

@php
    $category = fn (string $slug, string $anchor): string => '<a wire:navigate.hover href="'.e(route('budapest.category', ['category' => $slug])).'">'.e($anchor).'</a>';
@endphp

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ RentalFees::HEADLINE }}</x-slot:heading>

        <x-glass-panel>
            <article class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                <p class="text-sm text-gray-500">
                    Utolsó frissítés: <time datetime="{{ $lastUpdated->toDateString() }}">{{ $lastUpdated->year }}. {{ $lastUpdated->locale('hu')->translatedFormat('F') }}</time>
                </p>

                <p>Budapesten egy irodaház bérleti díja 2026 őszén 7 és 28 EUR/m²/hó között mozog, a tipikus érték 15,5 EUR/m²/hó. A kínálatunk szinte teljes egészében A kategóriás irodaházakból áll, a sáv alját a néhány régebbi, B kategóriás épület adja. A legdrágább alpiac a belváros (V., VI. és VII. kerület), ahol a középérték 18 EUR/m², a prémium épületek pedig 25–28 EUR/m²/hó körül kínálják az irodaterületeket. A legnagyobb kínálat a Váci úti irodafolyosón (XIII. kerület) van, 15 EUR-s középértékkel. A bérleti díjon felül üzemeltetési díjat (jellemzően 2 300–3 200 HUF vagy 5–7 EUR/m²/hó) és parkolási díjat (100–180 EUR/hely/hó) kell számolni. Az alábbi számok a PSG Irodaházak 230 budapesti irodaház-adatlapjából származnak, ebből 198 irodaház négyzetméter-alapon, 29 szolgáltatott iroda munkaállomásonként árazott; 2026. november 6-i állapot szerint.</p>

                <h2>Bérleti díjak alpiaconként</h2>

                <div class="not-prose overflow-x-auto">
                    <table class="data-table w-full min-w-[720px] text-left text-sm md:text-base border-collapse">
                        <thead class="bg-logogray/10 text-gray-900">
                            <tr>
                                <th scope="col" class="p-3 font-semibold">Alpiac</th>
                                <th scope="col" class="p-3 font-semibold">Irodaházak a díjszámításban</th>
                                <th scope="col" class="p-3 font-semibold">Kínálati bérleti díj (EUR/m²/hó)</th>
                                <th scope="col" class="p-3 font-semibold">Középérték</th>
                                <th scope="col" class="p-3 font-semibold">Üzemeltetési díj (medián)</th>
                                <th scope="col" class="p-3 font-semibold">Parkolás (medián)</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($this->submarkets() as $row)
                                <tr @class(['border-t border-gray-200', 'font-semibold bg-logogray/5' => $loop->last])>
                                    <th scope="row" class="p-3 font-medium text-gray-900">{{ $row['submarket'] }}</th>
                                    <td class="p-3">{{ $row['buildings'] }}</td>
                                    <td class="p-3 whitespace-nowrap">{{ $row['range'] }}</td>
                                    <td class="p-3">{{ $row['median'] }}</td>
                                    <td class="p-3">{{ $row['operating_fee'] }}</td>
                                    <td class="p-3 whitespace-nowrap">{{ $row['parking'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-gray-500">Forrás: a PSG Irodaházak 230 irodaház-adatlapja, 2026. november 6. A díjsávok a 198 négyzetméter-alapon (EUR/m²/hó) árazott irodaházból számolnak, a szolgáltatott irodák munkaállomásonkénti ára külön szerepel. A középérték a díjsávok közepének mediánja. Az üzemeltetési díjat a bérbeadók egy része forintban, más része euróban adja meg, a két értéket nem váltottuk át. Minden díj nettó, ÁFA nélkül.</p>

                <p>A sávok szélesek, mert ugyanazon az alpiacon egy 2023-ban átadott, BREEAM-minősítésű irodaház és egy húszéves, felújításra váró épület is szerepel. A valódi összehasonlítási alap ezért nem a lokáció, hanem az épület kora, minősége és a bérbe vehető terület mérete. A BREEAM vagy LEED minősítésű irodaházak középértéke 16,3 EUR, a minősítés nélkülieké 15,25 EUR/m²/hó.</p>

                <h2>Belváros: V., VI. és VII. kerület</h2>

                <p>A belvárosban 42 irodaház kínálata szerepel az adatbázisunkban, 11,5 és 28 EUR/m²/hó közötti díjakkal. A felső sávot az V. kerületi prémium épületek adják: a Roosevelt irodaház 26–28, az Academia irodaház 25–27, a Bank Center 22–25 EUR/m²/hó áron kínál területet, a VI. kerületben az Eiffel Square 21,5–26 EUR/m² között mozog. Az V. kerület önmagában a legdrágább kerület Budapesten, 22,5 EUR-s középértékkel. A VI. és VII. kerületben, főleg a nagykörúton kívül, 13–17 EUR-ért is találni jó állapotú, felújított irodaházat. A belvárosban a parkolás is a legdrágább, 170–220 EUR/hely/hó a prémium épületekben, és a parkolóhelyek száma is korlátozott.</p>

                <p>Kapcsolódó kínálat: {!! $category('kiado-belvarosi-irodak', 'kiadó belvárosi irodák') !!}, {!! $category('kiado-irodak-v-kerulet', 'kiadó irodák az V. kerületben') !!}.</p>

                <h2>Váci úti irodafolyosó: XIII. kerület</h2>

                <p>A XIII. kerület a legnagyobb budapesti irodapiac: 53 irodaház, együttesen több mint 137 ezer m² jelenleg is kiadó terület szerepel az adatbázisunkban. A kínálati díjak 7,5 és 23 EUR/m²/hó között szóródnak, a középérték 15 EUR/m², a közvetlenül a Váci úton álló épületeké 16 EUR/m². A legmagasabb díjak az új vagy teljesen felújított házak esetében figyelhetők meg: az Agora Tower 17–23, a 2025-ben átadott CenterPoint 3 irodaház 20–22, a Duna Tower 18,5–21,9, a WestEnd Business Center 19–21 EUR/m²/hó. A kerület belső részein, a metrótól távolabb 10–12 EUR-ért is kiadó jó minőségű terület. Az üzemeltetési díj itt a legkedvezőbb, 2 375 HUF/m²/hó a középérték, és itt a legtöbb a zöld minősítésű épület is: a kerület irodaházainak csaknem fele rendelkezik BREEAM vagy LEED tanúsítvánnyal.</p>

                <p>Kapcsolódó kínálat: {!! $category('kiado-vaci-uti-irodak', 'kiadó Váci úti irodák') !!}.</p>

                <h2>Dél-Buda: XI. és XXII. kerület</h2>

                <p>Dél-Budán 30 irodaház adatlapja szerepel nálunk, 9,25 és 21 EUR/m²/hó közötti díjakkal, 14,5 EUR-s középértékkel. A felső sávot a Budapest ONE (20,5–21 EUR), az Allee Corner (19,5–20 EUR) és a BudaPart épületei (18–19,5 EUR) adják, az Infopark és a Lágymányosi út környékén 13–16 EUR a jellemző, a kerület déli részén 10–11 EUR-ért is van kínálat. A parkolás a budapesti átlagnál olcsóbb, 100 EUR/hely/hó a középérték, és a legtöbb házban felszíni és mélygarázs is rendelkezésre áll. Ez az alpiac a technológiai cégek és a nagy létszámú ügyfélszolgálati központok piaca, ahol a 2 000 m² fölötti, egybefüggő területek is elérhetők.</p>

                <p>Kapcsolódó kínálat: {!! $category('kiado-irodak-xi-kerulet', 'kiadó irodák a XI. kerületben') !!}.</p>

                <h2>Buda: I., II., III. és XII. kerület</h2>

                <p>A budai oldal többi kerületében 41 irodaház kínálata szerepel az adatbázisunkban, a legszélesebb sávval: 7-től 27 EUR/m²/hó-ig. A XII. kerület a budai oldal legdrágább része, 19,9 EUR-s középértékkel, a 2022-ben átadott Major Udvar 24,5–27 EUR-ért kínálja a területeket. A II. kerületben a Margit körút és a Millenáris környéke a keresett: a BEM Center 23–24,5, a Canada Square 22, a Millenáris Avantgarde 20–22 EUR/m²/hó. A III. kerület a legkedvezőbb bérleti díjon elérhető budai alpiac, 14,2 EUR-s középértékkel, ahol az óbudai iparterületek irodaházaiban 7–9 EUR-ért is kiadó terület. Budán jellemzően kisebb, 500–3 000 m²-es épületek állnak, ezért a bel-budai kerületekben a 200–300 m²-es irodák kínálata a legnagyobb.</p>

                <p>Kapcsolódó kínálat: {!! $category('kiado-budai-irodak', 'kiadó budai irodák') !!}, {!! $category('kiado-bel-budai-irodak', 'kiadó bel-budai irodák') !!}.</p>

                <h2>Pest egyéb kerületei: VIII., IX., X., XIV.</h2>

                <p>A pesti oldal belvároson és Váci úton kívüli részein 34 irodaház kínálata szerepel nálunk, 7 és 22 EUR/m²/hó között, 15 EUR-s középértékkel. A Corvin-negyed a VIII. kerület középértékét 17,5 EUR-ra húzza: a Corvin Palace 18–22, a Corvin Innovation Campus 19–20, a Corvin Skypark 18–19 EUR/m²/hó. A IX. kerületben kettős a kép: a Soroksári úti és a Mill Park környéki új épületek 17–21 EUR-t kérnek, a Millennium Towers egyes épületei 9,5 EUR-ért kínálnak területet, ezeknél viszont nincs kiépítési hozzájárulás, és a kerületben van a legnagyobb kiadó területmennyiség is, 69 ezer m². A XIV. kerületben 11,5–15,5 EUR a sáv, a X. kerületben két megbízásunk van.</p>

                <p>Kapcsolódó kínálat: {!! $category('kiado-pesti-irodak', 'kiadó pesti irodák') !!}.</p>

                <h2>Mi jön a bérleti díjon felül?</h2>

                <p>Az irodaház-adatlapokon szereplő bérleti díj a nettó területre vonatkozó bérleti díj. A tényleges havi költség ennél több, mert négy tétel jön rá.</p>

                <ul>
                    <li><strong>Üzemeltetési költség.</strong> Budapesten jellemzően 2 300–3 200 HUF/m²/hó vagy 5–7 EUR/m²/hó, ebből fedezik a közös területek takarítását, a recepciós szolgáltatást és őrzést, a lift és a gépészet karbantartását, a biztosítást, az épületkezelést, továbbá a bérlemények rezsiköltségének nagy részét (a hűtés-fűtés és a víz-csatorna díját is) és a kommunális hulladék szállítását. A bérbeadó évente elszámol vele open-book rendszerben, azonban ha a közműdíjak év közben emelkednek, az az üzemeltetési díjat is növelheti. Az üzemeltetési díj a belvárosban a legmagasabb (2 845 HUF/m² a középérték), a Váci úton a legalacsonyabb (2 375 HUF/m²).</li>
                    <li><strong>Közös területi szorzó.</strong> A bérleti díjat nem csak a saját irodára, hanem a közös területek (folyosók, lépcsőház, lobby, liftelőtér) után is fizetni kell, a teljes területre vetítve, arányosítva. Ez az adatlapjaink szerint 2 és 17% között mozog, a középérték 7,2%, a tipikus sáv 5–10%. Egy 500 m²-es iroda 8%-os szorzó esetén 540 m²-es területté „növekszik”, azaz ez lesz az a bruttó terület, amely után a bérleti díjat és az üzemeltetési költséget fizetni kell.</li>
                    <li><strong>Parkolás.</strong> Budapesten 100–180 EUR/hely/hó a jellemző, a belvárosi prémium házakban 220 EUR. A parkolóhelyek száma az épülettől függ: a belvárosban 90–100 m² irodaterületre jut egy hely, a külső kerületekben és az új épületekben 50–75 m²-re.</li>
                    <li><strong>ÁFA és biztosíték.</strong> Minden megadott díj nettó összeg, erre még 27% ÁFA jön. Az aláíráskor a bérbeadók jellemzően 3–6 havi bérleti díjnak és üzemeltetési díjnak megfelelő kauciót vagy bankgaranciát kérnek, amelynek mértékét a bérlő cég bonitásvizsgálata után határozzák meg. Ez az összeg a bérlői költségvetésben egyszeri, de jelentős tétel. Az óvadékot a szerződés lejártával a bérbeadó visszautalja, ha a bérlő nem bankgaranciával biztosította.</li>
                </ul>

                <p>Egy példa: egy 500 m²-es, 16 EUR/m²/hó díjú, 8%-os közös területi szorzójú iroda a Váci úton, 2 400 HUF üzemeltetési díjjal és 6 parkolóhellyel havi nettó 8 640 EUR bérleti díjat, körülbelül 1,3 millió HUF üzemeltetési díjat és 720 EUR parkolási díjat jelent. A bérleti díj tehát a teljes havi költségnek nagyjából a kétharmada.</p>

                <h2>Kínálati díj és tényleges díj: miért nem azt fizeted, ami az adatlapon áll?</h2>

                <p>Az adatlapokon szereplő érték a bérbeadó kínálati bérleti díja. A ténylegesen megfizetett, úgynevezett effektív díj a tárgyalástól függően ennél alacsonyabb lehet, mert a bérbeadók egy 5 éves szerződésnél jellemzően három eszközzel igyekeznek megnyerni a bérlőket: bérletmentes hónapokkal a futamidő elején vagy az évfordulókon; a kialakítási költségekhez adott kiépítési hozzájárulással; és ritkább esetben a headline bérleti díj közvetlen csökkentésével, ami az épületek éves felértékelése miatt nem jelentős mértékű. Egy már korábban kiépített iroda új, kulcsrakész kialakítása 2026-ban 600–800 EUR/m² közötti összegbe kerül, ezért a kialakítási hozzájárulás mértéke sokszor többet számít, mint egy-két euró a négyzetméterdíjból. A tárgyalás eredménye nagyban függ az épület üresedésétől, a bérelt terület méretétől és a futamidőtől: egy 5 éves, 1 000 m² fölötti szerződésnél lényegesen több a mozgástér, mint egy 3 éves, 200 m²-es egységnél.</p>

                <h2>Szolgáltatott irodák és coworking: EUR/fő/hó</h2>

                <p>A bútorozott, azonnal beköltözhető szolgáltatott irodákat nem négyzetméterre, hanem munkaállomásra árazzák, csomagárral. Az adatbázisunkban szereplő 29 budapesti szolgáltatott irodai ajánlat 150 és 550 EUR/fő/hó között mozog, a középérték 370 EUR. Ebben benne van az üzemeltetési díj, a bútorhasználat, az internet, a recepciós szolgáltatás, a tárgyalóhasználat egy része és az irodák takarítása is, ezért a két típus (hagyományos és szolgáltatott iroda) közvetlenül nem hasonlítható össze. Tapasztalatunk szerint 12–15 fő fölött a hagyományos irodabérlet kedvezőbb, ha a cég legalább 3 évre el tud köteleződni, és a létszáma évente nem nő dinamikusan. A kínálatot a {!! $category('kiado-azonnali-szolgaltatott-irodak', 'kiadó azonnali szolgáltatott irodák') !!} oldalon találod.</p>

                <h2>Futamidő és minimum terület</h2>

                <p>A budapesti irodaházak többsége 3 vagy 5 éves minimum futamidőt vár el: az adatlapjaink szerint 105 épület 5 évet, 81 épület 3 évet, 30 épület 1 évet, 9 épület 2 évet kér. Rövidebb, 1 éves szerződés jellemzően a szolgáltatott irodáknál vagy olyan irodaházakban érhető el, ahol a tulajdonos nem biztosít átépítést az új bérlőknek. A minimum kiadó terület középértéke 268 m², de a kínálat 50 m²-től indul, a nagy házakban pedig egész emeletek, 1 500–3 000 m² is egyben bérelhetők.</p>

                <h2>Fekete Richárd értékelése a 2026 őszi piacról</h2>

                <blockquote>
                    <p>„A belvárosi prémium irodaházakban 23–25 euró/m² a kínálati bérleti díj, és az elmúlt egy évben 3–4%-os emelkedést látunk a jó minőségű épületekben. A piac kettészakadt: az új vagy gépészetileg is felújított, zöld minősítésű házakban a bérbeadók tartják a díjszintet, a régebbi épületek esetében azonban könnyebb kedvezőbb alkupozícióba kerülni. Itt jön képbe az az ingatlantanácsadó, akinek rálátása van a piaci szegmensre, és korábbi tapasztalatai alapján úgy tudja támogatni az irodát kereső ügyfelet, hogy az a hosszú távú döntését 1–1,5 év elteltével se bánja meg, hanem visszaigazolva lássa a befektetett munka és együttműködés gyümölcsét. Aki 2026–27-ben irodát keres, annak több összetevő mellett az üzemeltetési költséget is érdemes mérlegelnie, nem csak a négyzetméterdíjat.”</p>
                </blockquote>

                <p><a wire:navigate.hover href="{{ route('fekete-richard') }}">Fekete Richárd</a>, ügyvezető, PSG Irodaházak</p>

                <h2>Gyakori kérdések</h2>

                @foreach ($this->faqs() as $faq)
                    <h3>{{ $faq['question'] }}</h3>
                    <p>{{ $faq['answer'] }}</p>
                @endforeach

                <div class="not-prose mt-12 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    <p class="text-lg md:text-xl">Ha konkrét épületre vagy alpiacra keresel aktuális díjat, 24 órán belül küldünk ajánlatot a megadott terület- és létszámigényre, a kínálati bérleti díjjal együtt az üzemeltetési költséggel és a parkolással is számolva.</p>
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        Kérek ajánlatot
                    </button>
                </div>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
