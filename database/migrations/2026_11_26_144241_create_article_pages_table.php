<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The rental fee overview and the operating fee article become editable in
     * the admin (Fekete Richárd, 2026-11-26: he keeps the figures and the year
     * up to date himself). The records start with the approved copy that the
     * pages showed until now, word for word.
     */
    public function up(): void
    {
        Schema::create('article_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('headline');
            $table->string('short_title');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('link_label')->nullable();
            $table->date('published_on');
            $table->date('last_updated_on');
            $table->longText('body');
            $table->text('cta')->nullable();
            $table->json('faqs');
            $table->timestamps();
        });

        foreach ($this->pages() as $page) {
            DB::table('article_pages')->insert([
                ...$page,
                'faqs' => json_encode($page['faqs'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_pages');
    }

    /**
     * @return list<array{key: string, headline: string, short_title: string, meta_title: string, meta_description: string, link_label: string|null, published_on: string, last_updated_on: string, body: string, cta: string, faqs: list<array{question: string, answer: string}>}>
     */
    private function pages(): array
    {
        return [
            [
                'key' => 'rental-fees',
                'headline' => 'Irodabérleti díjak Budapesten 2026-ban: mennyibe kerül egy iroda alpiaconként?',
                'short_title' => 'Irodabérleti díjak Budapesten 2026',
                'meta_title' => 'Irodabérleti díjak Budapesten 2026: díjsávok alpiaconként | PSG Irodaházak',
                'meta_description' => 'Mennyibe kerül egy iroda Budapesten 2026-ban? 230 irodaház kínálati díja alpiaconként: belváros, Váci út, Dél-Buda, Buda, Pest. Üzemeltetési díj, parkolás, közös területi szorzó.',
                'link_label' => 'Budapesti díjsávok 2026',
                'published_on' => '2026-11-09',
                'last_updated_on' => '2026-11-09',
                'body' => <<<'HTML'
<p>Budapesten egy irodaház bérleti díja 2026 őszén 7 és 28 EUR/m²/hó között mozog, a tipikus érték 15,5 EUR/m²/hó. A kínálatunk szinte teljes egészében A kategóriás irodaházakból áll, a sáv alját a néhány régebbi, B kategóriás épület adja. A legdrágább alpiac a belváros (V., VI. és VII. kerület), ahol a középérték 18 EUR/m², a prémium épületek pedig 25–28 EUR/m²/hó körül kínálják az irodaterületeket. A legnagyobb kínálat a Váci úti irodafolyosón (XIII. kerület) van, 15 EUR-s középértékkel. A bérleti díjon felül üzemeltetési díjat (jellemzően 2 300–3 200 HUF vagy 5–7 EUR/m²/hó) és parkolási díjat (100–180 EUR/hely/hó) kell számolni. Az alábbi számok a PSG Irodaházak 230 budapesti irodaház-adatlapjából származnak, ebből 198 irodaház négyzetméter-alapon, 29 szolgáltatott iroda munkaállomásonként árazott; 2026. november 6-i állapot szerint.</p>
<h2>Bérleti díjak alpiaconként</h2>
<table><thead><tr><th>Alpiac</th><th>Irodaházak a díjszámításban</th><th>Kínálati bérleti díj (EUR/m²/hó)</th><th>Középérték</th><th>Üzemeltetési díj (medián)</th><th>Parkolás (medián)</th></tr></thead><tbody><tr><th>Belváros (V., VI., VII.)</th><td>42</td><td>11,5 – 28</td><td>18,0</td><td>2 845 HUF vagy 6,25 EUR</td><td>148 EUR/hely</td></tr><tr><th>Váci úti folyosó (XIII.)</th><td>51</td><td>7,5 – 23</td><td>15,0</td><td>2 375 HUF vagy 5,25 EUR</td><td>120 EUR/hely</td></tr><tr><th>Dél-Buda (XI., XXII.)</th><td>30</td><td>9,25 – 21</td><td>14,5</td><td>2 340 HUF vagy 6,5 EUR</td><td>100 EUR/hely</td></tr><tr><th>Buda egyéb (I., II., III., XII.)</th><td>41</td><td>7 – 27</td><td>16,7</td><td>2 600 HUF vagy 5,9 EUR</td><td>120 EUR/hely</td></tr><tr><th>Pest egyéb (VIII., IX., X., XIV. és a többi)</th><td>31</td><td>7 – 22</td><td>15,0</td><td>2 800 HUF vagy 6,3 EUR</td><td>110 EUR/hely</td></tr><tr><th>Agglomeráció (Budaörs, Törökbálint)</th><td>3</td><td>8 – 14</td><td>12,9</td><td>2 340 HUF vagy 4,75 EUR</td><td>40 EUR/hely</td></tr><tr><th><strong>Budapest összesen</strong></th><td><strong>198</strong></td><td><strong>7 – 28</strong></td><td><strong>15,5</strong></td><td><strong>2 500 HUF vagy 6 EUR</strong></td><td><strong>120 EUR/hely</strong></td></tr></tbody></table>
<p><small>Forrás: a PSG Irodaházak 230 irodaház-adatlapja, 2026. november 6. A díjsávok a 198 négyzetméter-alapon (EUR/m²/hó) árazott irodaházból számolnak, a szolgáltatott irodák munkaállomásonkénti ára külön szerepel. A középérték a díjsávok közepének mediánja. Az üzemeltetési díjat a bérbeadók egy része forintban, más része euróban adja meg, a két értéket nem váltottuk át. Minden díj nettó, ÁFA nélkül.</small></p>
<p>A sávok szélesek, mert ugyanazon az alpiacon egy 2023-ban átadott, BREEAM-minősítésű irodaház és egy húszéves, felújításra váró épület is szerepel. A valódi összehasonlítási alap ezért nem a lokáció, hanem az épület kora, minősége és a bérbe vehető terület mérete. A BREEAM vagy LEED minősítésű irodaházak középértéke 16,3 EUR, a minősítés nélkülieké 15,25 EUR/m²/hó.</p>
<h2>Belváros: V., VI. és VII. kerület</h2>
<p>A belvárosban 42 irodaház kínálata szerepel az adatbázisunkban, 11,5 és 28 EUR/m²/hó közötti díjakkal. A felső sávot az V. kerületi prémium épületek adják: a Roosevelt irodaház 26–28, az Academia irodaház 25–27, a Bank Center 22–25 EUR/m²/hó áron kínál területet, a VI. kerületben az Eiffel Square 21,5–26 EUR/m² között mozog. Az V. kerület önmagában a legdrágább kerület Budapesten, 22,5 EUR-s középértékkel. A VI. és VII. kerületben, főleg a nagykörúton kívül, 13–17 EUR-ért is találni jó állapotú, felújított irodaházat. A belvárosban a parkolás is a legdrágább, 170–220 EUR/hely/hó a prémium épületekben, és a parkolóhelyek száma is korlátozott.</p>
<p>Kapcsolódó kínálat: <a href="/budapest/kiado-belvarosi-irodak">kiadó belvárosi irodák</a>, <a href="/budapest/kiado-irodak-v-kerulet">kiadó irodák az V. kerületben</a>.</p>
<h2>Váci úti irodafolyosó: XIII. kerület</h2>
<p>A XIII. kerület a legnagyobb budapesti irodapiac: 53 irodaház, együttesen több mint 137 ezer m² jelenleg is kiadó terület szerepel az adatbázisunkban. A kínálati díjak 7,5 és 23 EUR/m²/hó között szóródnak, a középérték 15 EUR/m², a közvetlenül a Váci úton álló épületeké 16 EUR/m². A legmagasabb díjak az új vagy teljesen felújított házak esetében figyelhetők meg: az Agora Tower 17–23, a 2025-ben átadott CenterPoint 3 irodaház 20–22, a Duna Tower 18,5–21,9, a WestEnd Business Center 19–21 EUR/m²/hó. A kerület belső részein, a metrótól távolabb 10–12 EUR-ért is kiadó jó minőségű terület. Az üzemeltetési díj itt a legkedvezőbb, 2 375 HUF/m²/hó a középérték, és itt a legtöbb a zöld minősítésű épület is: a kerület irodaházainak csaknem fele rendelkezik BREEAM vagy LEED tanúsítvánnyal.</p>
<p>Kapcsolódó kínálat: <a href="/budapest/kiado-vaci-uti-irodak">kiadó Váci úti irodák</a>.</p>
<h2>Dél-Buda: XI. és XXII. kerület</h2>
<p>Dél-Budán 30 irodaház adatlapja szerepel nálunk, 9,25 és 21 EUR/m²/hó közötti díjakkal, 14,5 EUR-s középértékkel. A felső sávot a Budapest ONE (20,5–21 EUR), az Allee Corner (19,5–20 EUR) és a BudaPart épületei (18–19,5 EUR) adják, az Infopark és a Lágymányosi út környékén 13–16 EUR a jellemző, a kerület déli részén 10–11 EUR-ért is van kínálat. A parkolás a budapesti átlagnál olcsóbb, 100 EUR/hely/hó a középérték, és a legtöbb házban felszíni és mélygarázs is rendelkezésre áll. Ez az alpiac a technológiai cégek és a nagy létszámú ügyfélszolgálati központok piaca, ahol a 2 000 m² fölötti, egybefüggő területek is elérhetők.</p>
<p>Kapcsolódó kínálat: <a href="/budapest/kiado-irodak-xi-kerulet">kiadó irodák a XI. kerületben</a>.</p>
<h2>Buda: I., II., III. és XII. kerület</h2>
<p>A budai oldal többi kerületében 41 irodaház kínálata szerepel az adatbázisunkban, a legszélesebb sávval: 7-től 27 EUR/m²/hó-ig. A XII. kerület a budai oldal legdrágább része, 19,9 EUR-s középértékkel, a 2022-ben átadott Major Udvar 24,5–27 EUR-ért kínálja a területeket. A II. kerületben a Margit körút és a Millenáris környéke a keresett: a BEM Center 23–24,5, a Canada Square 22, a Millenáris Avantgarde 20–22 EUR/m²/hó. A III. kerület a legkedvezőbb bérleti díjon elérhető budai alpiac, 14,2 EUR-s középértékkel, ahol az óbudai iparterületek irodaházaiban 7–9 EUR-ért is kiadó terület. Budán jellemzően kisebb, 500–3 000 m²-es épületek állnak, ezért a bel-budai kerületekben a 200–300 m²-es irodák kínálata a legnagyobb.</p>
<p>Kapcsolódó kínálat: <a href="/budapest/kiado-budai-irodak">kiadó budai irodák</a>, <a href="/budapest/kiado-bel-budai-irodak">kiadó bel-budai irodák</a>.</p>
<h2>Pest egyéb kerületei: VIII., IX., X., XIV.</h2>
<p>A pesti oldal belvároson és Váci úton kívüli részein 34 irodaház kínálata szerepel nálunk, 7 és 22 EUR/m²/hó között, 15 EUR-s középértékkel. A Corvin-negyed a VIII. kerület középértékét 17,5 EUR-ra húzza: a Corvin Palace 18–22, a Corvin Innovation Campus 19–20, a Corvin Skypark 18–19 EUR/m²/hó. A IX. kerületben kettős a kép: a Soroksári úti és a Mill Park környéki új épületek 17–21 EUR-t kérnek, a Millennium Towers egyes épületei 9,5 EUR-ért kínálnak területet, ezeknél viszont nincs kiépítési hozzájárulás, és a kerületben van a legnagyobb kiadó területmennyiség is, 69 ezer m². A XIV. kerületben 11,5–15,5 EUR a sáv, a X. kerületben két megbízásunk van.</p>
<p>Kapcsolódó kínálat: <a href="/budapest/kiado-pesti-irodak">kiadó pesti irodák</a>.</p>
<h2>Mi jön a bérleti díjon felül?</h2>
<p>Az irodaház-adatlapokon szereplő bérleti díj a nettó területre vonatkozó bérleti díj. A tényleges havi költség ennél több, mert négy tétel jön rá.</p>
<ul><li><strong>Üzemeltetési költség.</strong> Budapesten jellemzően 2 300–3 200 HUF/m²/hó vagy 5–7 EUR/m²/hó, ebből fedezik a közös területek takarítását, a recepciós szolgáltatást és őrzést, a lift és a gépészet karbantartását, a biztosítást, az épületkezelést, továbbá a bérlemények rezsiköltségének nagy részét (a hűtés-fűtés és a víz-csatorna díját is) és a kommunális hulladék szállítását. A bérbeadó évente elszámol vele open-book rendszerben, azonban ha a közműdíjak év közben emelkednek, az az üzemeltetési díjat is növelheti. Az üzemeltetési díj a belvárosban a legmagasabb (2 845 HUF/m² a középérték), a Váci úton a legalacsonyabb (2 375 HUF/m²). Lásd még: <a href="/hirek/uzemeltetesi-dij-irodaberles">részletesen az üzemeltetési díjról</a>.</li><li><strong>Közös területi szorzó.</strong> A bérleti díjat nem csak a saját irodára, hanem a közös területek (folyosók, lépcsőház, lobby, liftelőtér) után is fizetni kell, a teljes területre vetítve, arányosítva. Ez az adatlapjaink szerint 2 és 17% között mozog, a középérték 7,2%, a tipikus sáv 5–10%. Egy 500 m²-es iroda 8%-os szorzó esetén 540 m²-es területté „növekszik”, azaz ez lesz az a bruttó terület, amely után a bérleti díjat és az üzemeltetési költséget fizetni kell.</li><li><strong>Parkolás.</strong> Budapesten 100–180 EUR/hely/hó a jellemző, a belvárosi prémium házakban 220 EUR. A parkolóhelyek száma az épülettől függ: a belvárosban 90–100 m² irodaterületre jut egy hely, a külső kerületekben és az új épületekben 50–75 m²-re.</li><li><strong>ÁFA és biztosíték.</strong> Minden megadott díj nettó összeg, erre még 27% ÁFA jön. Az aláíráskor a bérbeadók jellemzően 3–6 havi bérleti díjnak és üzemeltetési díjnak megfelelő kauciót vagy bankgaranciát kérnek, amelynek mértékét a bérlő cég bonitásvizsgálata után határozzák meg. Ez az összeg a bérlői költségvetésben egyszeri, de jelentős tétel. Az óvadékot a szerződés lejártával a bérbeadó visszautalja, ha a bérlő nem bankgaranciával biztosította.</li></ul>
<p>Egy példa: egy 500 m²-es, 16 EUR/m²/hó díjú, 8%-os közös területi szorzójú iroda a Váci úton, 2 400 HUF üzemeltetési díjjal és 6 parkolóhellyel havi nettó 8 640 EUR bérleti díjat, körülbelül 1,3 millió HUF üzemeltetési díjat és 720 EUR parkolási díjat jelent. A bérleti díj tehát a teljes havi költségnek nagyjából a kétharmada.</p>
<h2>Kínálati díj és tényleges díj: miért nem azt fizeted, ami az adatlapon áll?</h2>
<p>Az adatlapokon szereplő érték a bérbeadó kínálati bérleti díja. A ténylegesen megfizetett, úgynevezett effektív díj a tárgyalástól függően ennél alacsonyabb lehet, mert a bérbeadók egy 5 éves szerződésnél jellemzően három eszközzel igyekeznek megnyerni a bérlőket: bérletmentes hónapokkal a futamidő elején vagy az évfordulókon; a kialakítási költségekhez adott kiépítési hozzájárulással; és ritkább esetben a headline bérleti díj közvetlen csökkentésével, ami az épületek éves felértékelése miatt nem jelentős mértékű. Egy már korábban kiépített iroda új, kulcsrakész kialakítása 2026-ban 600–800 EUR/m² közötti összegbe kerül, ezért a kialakítási hozzájárulás mértéke sokszor többet számít, mint egy-két euró a négyzetméterdíjból. A tárgyalás eredménye nagyban függ az épület üresedésétől, a bérelt terület méretétől és a futamidőtől: egy 5 éves, 1 000 m² fölötti szerződésnél lényegesen több a mozgástér, mint egy 3 éves, 200 m²-es egységnél.</p>
<h2>Szolgáltatott irodák és coworking: EUR/fő/hó</h2>
<p>A bútorozott, azonnal beköltözhető szolgáltatott irodákat nem négyzetméterre, hanem munkaállomásra árazzák, csomagárral. Az adatbázisunkban szereplő 29 budapesti szolgáltatott irodai ajánlat 150 és 550 EUR/fő/hó között mozog, a középérték 370 EUR. Ebben benne van az üzemeltetési díj, a bútorhasználat, az internet, a recepciós szolgáltatás, a tárgyalóhasználat egy része és az irodák takarítása is, ezért a két típus (hagyományos és szolgáltatott iroda) közvetlenül nem hasonlítható össze. Tapasztalatunk szerint 12–15 fő fölött a hagyományos irodabérlet kedvezőbb, ha a cég legalább 3 évre el tud köteleződni, és a létszáma évente nem nő dinamikusan. A kínálatot a <a href="/budapest/kiado-azonnali-szolgaltatott-irodak">kiadó azonnali szolgáltatott irodák</a> oldalon találod.</p>
<h2>Futamidő és minimum terület</h2>
<p>A budapesti irodaházak többsége 3 vagy 5 éves minimum futamidőt vár el: az adatlapjaink szerint 105 épület 5 évet, 81 épület 3 évet, 30 épület 1 évet, 9 épület 2 évet kér. Rövidebb, 1 éves szerződés jellemzően a szolgáltatott irodáknál vagy olyan irodaházakban érhető el, ahol a tulajdonos nem biztosít átépítést az új bérlőknek. A minimum kiadó terület középértéke 268 m², de a kínálat 50 m²-től indul, a nagy házakban pedig egész emeletek, 1 500–3 000 m² is egyben bérelhetők.</p>
<h2>Fekete Richárd értékelése a 2026 őszi piacról</h2>
<blockquote><p>„A belvárosi prémium irodaházakban 23–25 euró/m² a kínálati bérleti díj, és az elmúlt egy évben 3–4%-os emelkedést látunk a jó minőségű épületekben. A piac kettészakadt: az új vagy gépészetileg is felújított, zöld minősítésű házakban a bérbeadók tartják a díjszintet, a régebbi épületek esetében azonban könnyebb kedvezőbb alkupozícióba kerülni. Itt jön képbe az az ingatlantanácsadó, akinek rálátása van a piaci szegmensre, és korábbi tapasztalatai alapján úgy tudja támogatni az irodát kereső ügyfelet, hogy az a hosszú távú döntését 1–1,5 év elteltével se bánja meg, hanem visszaigazolva lássa a befektetett munka és együttműködés gyümölcsét. Aki 2026–27-ben irodát keres, annak több összetevő mellett az üzemeltetési költséget is érdemes mérlegelnie, nem csak a négyzetméterdíjat.”</p>
</blockquote>
<p><a href="/fekete-richard">Fekete Richárd</a>, ügyvezető, PSG Irodaházak</p>
HTML,
                'cta' => '<p>Ha konkrét épületre vagy alpiacra keresel aktuális díjat, 24 órán belül küldünk ajánlatot a megadott terület- és létszámigényre, a kínálati bérleti díjjal együtt az üzemeltetési költséggel és a parkolással is számolva.</p>',
                'faqs' => [
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
                ],
            ],
            [
                'key' => 'operating-fee',
                'headline' => 'Üzemeltetési díj irodabérlésnél: mit tartalmaz, mennyi Budapesten 2026-ban, és mire figyelj az elszámolásnál',
                'short_title' => 'Üzemeltetési díj irodabérlésnél',
                'meta_title' => 'Üzemeltetési díj irodabérlésnél: mennyi Budapesten 2026-ban? | PSG Irodaházak',
                'meta_description' => 'Mit tartalmaz az irodaház üzemeltetési díja, mennyi Budapesten 2026-ban (2 500 HUF/m²/hó a középérték), hogyan számolják el, és mit lehet belőle tárgyalni.',
                'link_label' => null,
                'published_on' => '2026-11-24',
                'last_updated_on' => '2026-11-24',
                'body' => <<<'HTML'
<p>Az üzemeltetési díj a bérleti díjon felül fizetett, az irodaház közös költségeit fedező havi összeg. Budapesten 2026 őszén jellemzően 2 200–2 850 HUF/m²/hó, a középérték 2 500 HUF/m²/hó, az euróban árazó házakban 5–6,5 EUR/m²/hó. Ez a bérleti díj nagyjából 40%-a, vagyis egy 15,5 EUR-s négyzetméterdíj mellett az üzemeltetés körülbelül 6 EUR-t tesz hozzá minden négyzetméterhez. A díj fedezi a recepciót, az őrzést, a közös területek takarítását, a gépészet karbantartását, a biztosítást, az épületkezelést, és a legtöbb budapesti irodaházban a bérlemény fűtését, hűtését és vízfogyasztását is. A bérbeadó évente, utólag, open-book rendszerben számol el vele, ezért a tényleges összeg az év végén eltérhet a havonta fizetett előlegtől. A számok a PSG Irodaházak 230 budapesti irodaház-adatlapjából származnak.</p>
<h2>Mit tartalmaz az üzemeltetési díj?</h2>
<p>A budapesti irodaházak üzemeltetési díja a következő tételeket fedezi. A pontos lista házanként eltér, ezért a bérleti szerződés mellékletében mindig szerepel egy tételes felsorolás, és ezt érdemes aláírás előtt elolvasni.</p>
<ul><li><strong>Közös területek:</strong> az előcsarnok, a folyosók, a lépcsőházak, a liftelőterek és a mosdók takarítása, világítása, fűtése és hűtése.</li><li><strong>Recepció és őrzés:</strong> a 24 órás recepciós szolgálat, a biztonsági őrzés, a beléptető- és kamerarendszer üzemeltetése.</li><li><strong>Gépészet:</strong> a liftek, a szellőző- és klímarendszer, a hűtő-fűtő berendezések, a tűzjelző és a sprinkler karbantartása, a kötelező hatósági felülvizsgálatok.</li><li><strong>A bérlemény rezsijének nagy része:</strong> a legtöbb budapesti irodaházban a bérelt terület fűtése, hűtése és vízfogyasztása, valamint a kommunális hulladék elszállítása is az üzemeltetési díjban van.</li><li><strong>Épületkezelés és biztosítás:</strong> az üzemeltető cég díja, az épület vagyonbiztosítása, a kertészet, a hóeltakarítás, a homlokzat és a tető karbantartása.</li></ul>
<p>A szolgáltatott irodáknál és a coworking tereknél nincs külön üzemeltetési díj: a munkaállomásonkénti csomagár tartalmazza, a bútorral, az internettel és a takarítással együtt.</p>
<h2>Mi nincs benne?</h2>
<p>Három tétel szinte mindig a bérlőt terheli az üzemeltetési díjon felül, és ezekkel a költségvetésben külön kell számolni.</p>
<ul><li><strong>A bérlemény saját villamosenergia-fogyasztása:</strong> a világítás, a számítógépek, a konyha és a szerverszoba áramát a bérlő almérő alapján, külön fizeti.</li><li><strong>Internet és telefon:</strong> a bérlő saját szolgáltatói szerződése, az irodaház csak a bekötést biztosítja.</li><li><strong>A bérlemény takarítása:</strong> a saját iroda napi takarítását a bérlő rendeli meg, az üzemeltetési díj a közös területekre vonatkozik. Néhány házban az üzemeltető ezt is vállalja, külön díjért.</li></ul>
<p>Nem része az üzemeltetési díjnak a parkolás sem, ami Budapesten 100–180 EUR/hely/hó külön tétel, és a 27% ÁFA sem, ami minden díjra rájön.</p>
<h2>Mennyi az üzemeltetési díj Budapesten 2026-ban?</h2>
<p>A PSG Irodaházak adatlapjain a bérbeadók egy része forintban, más része euróban adja meg az üzemeltetési díjat; a két értéket nem váltottuk át, mert a forintos díjak nagyobb része fix, az eurósok árfolyamtól függően változnak.</p>
<table><thead><tr><th>Alpiac</th><th>Üzemeltetési díj (HUF/m²/hó, medián)</th><th>Üzemeltetési díj (EUR/m²/hó, medián)</th><th>Bérleti díj középérték (EUR/m²/hó)</th></tr></thead><tbody><tr><th>Belváros (V., VI., VII.)</th><td>2 845</td><td>6,25</td><td>18,0</td></tr><tr><th>Váci úti folyosó (XIII.)</th><td>2 375</td><td>5,25</td><td>15,0</td></tr><tr><th>Dél-Buda (XI., XXII.)</th><td>2 340</td><td>6,5</td><td>14,5</td></tr><tr><th>Buda egyéb (I., II., III., XII.)</th><td>2 600</td><td>5,9</td><td>16,7</td></tr><tr><th>Pest egyéb</th><td>2 800</td><td>6,3</td><td>15,0</td></tr><tr><th><strong>Budapest összesen</strong></th><td><strong>2 500</strong></td><td><strong>6,0</strong></td><td><strong>15,5</strong></td></tr></tbody></table>
<p><small>Forrás: a PSG Irodaházak irodaház-adatlapjai, 131 forintban és 66 euróban árazó irodaház, 2026. november 6. Minden díj nettó.</small></p>
<p>A forintos díjak 1 100 és 4 500 HUF/m²/hó között szóródnak, az irodaházak fele 2 200 és 2 850 HUF között van. A legmagasabb üzemeltetési díjak a belvárosi prémium házakban és a bevásárlóközponthoz kapcsolt irodákban vannak: a Deák Palota 4 514, a MOM Park irodái 4 025 HUF/m²/hó. A legalacsonyabbak a kisebb, egyszerűbb gépészetű házakban: az Emke Irodaház 1 527, az Olympia irodaház 1 650 HUF/m²/hó. Az alsó sávnál érdemes megnézni, hogy a bérlemény fogyasztását külön mérik-e, mert ahol minden fogyasztás almérőn megy, ott az üzemeltetési díj alacsony, de a rezsi külön jön hozzá. Az euróban árazó házak 4 és 8 EUR között vannak, a középérték 6 EUR.</p>
<p>Két dolog meglepő lehet az adatokban. Az egyik, hogy az új épületek üzemeltetési díja nem magasabb a régieknél: a 2018 után átadott házak középértéke 2 425 HUF, a 2005 előttieké 2 590 HUF/m²/hó, mert a korszerű gépészet kevesebb energiát fogyaszt, és a karbantartása is olcsóbb. A másik, hogy a BREEAM vagy LEED minősítés nem jelent alacsonyabb üzemeltetési díjat, pedig ezt várnánk: a minősítés az épület fenntarthatóságát és környezeti teljesítményét vizsgálja, vagyis a minősített háznak energiahatékonyabbnak, olcsóbban fenntarthatónak kellene lennie. A számokban ez nem látszik: a minősített házak középértéke 2 475, a többié 2 520 HUF, a különbség elhanyagolható. A díjat sokkal inkább az épület elhelyezkedése, a recepció és őrzés szintje, valamint a közös területek mérete határozza meg, mint a tanúsítvány.</p>
<h2>Hogyan történik az elszámolás?</h2>
<p>A havonta fizetett üzemeltetési díj előleg. A bérbeadó az év végén, jellemzően a következő év első negyedévében tételesen elszámol a tényleges költségekkel: ha azok magasabbak voltak az előlegnél, a különbözetet a bérlő utólag fizeti, ha alacsonyabbak, a bérbeadó jóváírja. Ezt nevezik open-book elszámolásnak, mert a bérlő betekinthet a számlákba. A budapesti A kategóriás irodaházakban ez a gyakorlat, és a bérleti szerződésben rögzítik.</p>
<p>Három dolgot érdemes a szerződésben megnézni. Az első, hogy mely tételek számolhatók el: a bérbeadó saját beruházásai (például egy új HVAC-rendszer vagy más épületgépészeti beruházás) vagy a bérbeadó tulajdonosi költségei nem tartozhatnak az üzemeltetési díjba. A második, hogy van-e felső korlát vagy indexálás: egyes szerződésekben az üzemeltetési díj évente legfeljebb az inflációval emelhető, másokban nincs korlát, és egy rezsiemelkedés egy az egyben továbbhárítható. A harmadik, hogy a bérlőnek van-e joga az elszámolást ellenőriztetni, és milyen határidővel kifogásolhatja. Egy 1 000 m²-es irodánál 300 HUF/m²-es eltérés az előleg és a tényleges díj között évi 3,6 millió HUF, ezért ez nem formaság.</p>
<h2>Mit lehet tárgyalni az üzemeltetési díjról?</h2>
<p>Az üzemeltetési díj a bérleti díjnál kevésbé alkuképes, mert tényleges költségeket fedez, de nem érinthetetlen. A bérbeadók jellemzően három ponton engednek: az üzemeltetési díj befagyasztása az első egy-két évre vagy inflációs korlát a teljes futamidőre; a bérletmentes időszak kiterjesztése az üzemeltetési díjra is, nem csak a bérleti díjra; és az elszámolható tételek körének szűkítése a szerződés mellékletében. Nagyobb, 1 000 m² fölötti bérlőknél a bérbeadó néha az egész futamidőre fix üzemeltetési díjat vállal. Ezek a feltételek a tárgyalás végén, a bérleti díj után kerülnek elő, ezért érdemes már az ajánlatkérésben rákérdezni.</p>
<h2>Fekete Richárd tapasztalata</h2>
<blockquote><p>„Az ügyfelek a bérleti díjat és az ezt érintő kedvezményeket tekintik alku tárgyának, az üzemeltetési díjat pedig adottnak veszik, miközben a teljes havi költség harmada-negyede ez. Két épület között, ahol a bérleti díj azonos, az üzemeltetési díj különbsége 1 000 m²-en évi több millió forint lehet, ezért a rövidlistás irodáknál mindig a teljes futamidőre vetített összköltséget hasonlítjuk össze, nem csupán a négyzetméter díját.”</p>
</blockquote>
<p><a href="/fekete-richard">Fekete Richárd</a>, ügyvezető, PSG Irodaházak</p>
HTML,
                'cta' => '<p>A 230 budapesti irodaház üzemeltetési díját az adatlapjainkon épületenként közöljük, a bérleti díjjal és a parkolással együtt. Az alpiaci díjsávokat az <a href="/budapest/irodaberleti-dijak">irodabérleti díjak Budapesten</a> oldalon találod. Ha egy konkrét épület teljes havi költségét szeretnéd látni, 24 órán belül küldünk ajánlatot.</p>',
                'faqs' => [
                    [
                        'question' => 'Mennyi az üzemeltetési díj egy budapesti irodaházban?',
                        'answer' => '2026 őszén jellemzően 2 200–2 850 HUF/m²/hó, a középérték 2 500 HUF/m²/hó; az euróban árazó házakban 5–6,5 EUR/m²/hó. A belvárosban a legmagasabb, a Váci úton a legalacsonyabb.',
                    ],
                    [
                        'question' => 'Benne van a fűtés és a hűtés az üzemeltetési díjban?',
                        'answer' => 'A legtöbb budapesti irodaházban igen, a vízfogyasztással és a hulladékszállítással együtt. A bérlemény saját áramfogyasztása viszont szinte mindig külön, almérő alapján fizetendő.',
                    ],
                    [
                        'question' => 'Mi az az open-book elszámolás?',
                        'answer' => 'A bérbeadó az év végén tételesen elszámol a tényleges üzemeltetési költségekkel, és a bérlő betekinthet a számlákba. A havi díj előleg, a különbözetet utólag rendezik.',
                    ],
                    [
                        'question' => 'Emelkedhet az üzemeltetési díj a futamidő alatt?',
                        'answer' => 'Igen, ha a tényleges költségek emelkednek, például a közműdíjak miatt. A szerződésben lehet inflációs korlátot vagy az első évekre fix díjat kikötni.',
                    ],
                    [
                        'question' => 'A szolgáltatott irodáknál is van üzemeltetési díj?',
                        'answer' => 'Nincs külön: a munkaállomásonkénti csomagár (Budapesten 150–550 EUR/fő/hó) tartalmazza, a bútorral, az internettel és a takarítással együtt.',
                    ],
                    [
                        'question' => 'Az új irodaházak üzemeltetési díja magasabb?',
                        'answer' => 'Nem: a 2018 után átadott budapesti házak középértéke 2 425 HUF/m²/hó, a 2005 előttieké 2 590, mert a korszerű gépészet kevesebb energiát fogyaszt. A BREEAM vagy LEED minősítés viszont nem jelent alacsonyabb díjat, a minősített és a minősítés nélküli házak középértéke közel azonos.',
                    ],
                ],
            ],
        ];
    }
};
