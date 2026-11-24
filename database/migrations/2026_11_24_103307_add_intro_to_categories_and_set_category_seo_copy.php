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
     * Content package 2 (approved 17 November 2026): every category page gets its
     * own title and meta description, and four of them an intro below the H1.
     * In the meta description ":count" is replaced by the current number of
     * office buildings in the category. The links are relative, so they work on
     * every host.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->text('intro')->nullable()->after('meta_description');
        });

        foreach ($this->copy() as $slug => $copy) {
            DB::table('categories')->where('slug', $slug)->update($copy);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('intro');
        });

        DB::table('categories')->whereIn('slug', array_keys($this->copy()))->update(['seo_title' => null, 'meta_description' => null]);
    }

    /**
     * @return array<string, array{seo_title: string, meta_description: string, intro?: string}>
     */
    private function copy(): array
    {
        $feeBands = '<a href="/budapest/irodaberleti-dijak">Budapesti díjsávok 2026</a>';
        $office = fn (string $slug, string $name): string => '<a href="/kiado-iroda/'.$slug.'">'.$name.'</a>';

        return [
            'kiado-belvarosi-irodak' => [
                'seo_title' => 'Kiadó belvárosi irodák: V., VI., VII. kerület | PSG Irodaházak',
                'meta_description' => 'Kiadó belvárosi irodák :count irodaházban az V., VI. és VII. kerületben, 11,5–28 EUR/m²/hó bérleti díjjal: prémium paloták és felújított körúti irodaházak.',
                'intro' => '<p>A belváros Budapest legdrágább és legreprezentatívabb irodapiaca: az V., VI. és VII. kerület 54 irodaházában a kínálati bérleti díj 11,5 és 28 EUR/m²/hó között mozog, a középérték 18 EUR. A felső sávot a lipótvárosi prémium épületek adják ('.$office('bank-center', 'Bank Center').', '.$office('academia-irodahaz', 'Academia').', '.$office('roosevelt-irodahaz', 'Roosevelt irodaház').'), a nagykörúton kívül, a VI. és VII. kerületben 13–17 EUR-ért is találni felújított, jó állapotú irodaházat. Az alpiac jellegzetessége a felújított palota: magas belmagasság, reprezentatív előcsarnok, kisebb, 200–800 m²-es egységek. A parkolás itt a legdrágább és a legszűkösebb, 170–220 EUR/hely/hó a prémium házakban, cserébe minden épület metróval és villamossal elérhető. Jellemző bérlők: ügyvédi irodák, tanácsadók, pénzügyi cégek, nemzetközi vállalatok képviseletei. Az alpiaci díjsávokat és az üzemeltetési díjakat a '.$feeBands.' oldalon hasonlíthatod össze.</p>',
            ],
            'kiado-irodak-v-kerulet' => [
                'seo_title' => 'Kiadó irodák az V. kerületben, Lipótváros | PSG Irodaházak',
                'meta_description' => 'Kiadó irodák az V. kerület :count irodaházában, 14–28 EUR/m²/hó bérleti díjjal: Bank Center, Academia, Roosevelt és a belváros prémium épületei.',
            ],
            'kiado-vaci-uti-irodak' => [
                'seo_title' => 'Kiadó Váci úti irodák, XIII. kerület | PSG Irodaházak',
                'meta_description' => 'Kiadó Váci úti irodák :count irodaházban, 7,5–23 EUR/m²/hó bérleti díjjal. Budapest legnagyobb irodapiaca metróval, zöld épületekkel, a legkedvezőbb üzemeltetési díjjal.',
                'intro' => '<p>A Váci úti irodafolyosó Budapest legnagyobb irodapiaca: a XIII. kerület 52 irodaházában együtt több mint 137 ezer m² kiadó terület szerepel a kínálatunkban. A bérleti díj 7,5 és 23 EUR/m²/hó között szóródik, a középérték 15 EUR, a közvetlenül a Váci úton álló épületeké 16 EUR; a legmagasabb díjat az új vagy teljesen felújított házak kérik ('.$office('agora-tower', 'Agora Tower').', '.$office('center-point-3', 'CenterPoint 3').', '.$office('duna-tower', 'Duna Tower').', '.$office('westend-business-center', 'WestEnd Business Center').'). Itt a legkedvezőbb az üzemeltetési díj (2 375 HUF/m²/hó a középérték), itt a legtöbb a BREEAM vagy LEED minősítésű épület, és itt érhetők el a legnagyobb, 2 000–5 000 m²-es egybefüggő területek. A kerületet a 3-as metró fűzi fel, a parkolás 120–150 EUR/hely/hó. Jellemző bérlők: szolgáltató központok, IT- és technológiai cégek, nagyvállalati központok. Az alpiaci díjsávokat a '.$feeBands.' oldalon találod.</p>',
            ],
            'kiado-pesti-irodak' => [
                'seo_title' => 'Kiadó pesti irodák: a pesti oldal kínálata | PSG Irodaházak',
                'meta_description' => 'Kiadó pesti irodák :count irodaházban a belvárostól a Váci úton át a Corvin-negyedig, 7–28 EUR/m²/hó bérleti díjjal, aktuális szabad területekkel.',
            ],
            'kiado-budai-irodak' => [
                'seo_title' => 'Kiadó budai irodák: I., II., III., XI., XII. kerület | PSG Irodaházak',
                'meta_description' => 'Kiadó budai irodák :count irodaházban a Margit körúttól a MOM Parkon át Dél-Budáig, 7–27 EUR/m²/hó bérleti díjjal, üzemeltetési díjjal és parkolással.',
            ],
            'kiado-bel-budai-irodak' => [
                'seo_title' => 'Kiadó bel-budai irodák: I., II., XII. kerület | PSG Irodaházak',
                'meta_description' => 'Kiadó bel-budai irodák :count irodaházban az I., II. és XII. kerületben, 11–27 EUR/m²/hó bérleti díjjal; 100–300 m²-es irodák a Margit körút és a MOM Park környékén.',
            ],
            'kiado-irodak-xi-kerulet' => [
                'seo_title' => 'Kiadó irodák a XI. kerületben: Infopark, BudaPart | PSG Irodaházak',
                'meta_description' => 'Kiadó irodák a XI. kerület :count irodaházában, 9,25–21 EUR/m²/hó bérleti díjjal: Infopark, BudaPart, Budapest ONE. Nagy egybefüggő területek, olcsó parkolás.',
                'intro' => '<p>A XI. kerület Dél-Buda irodapiaca: 35 irodaház, 9,25 és 21 EUR/m²/hó közötti bérleti díjjal, 14,5 EUR-s középértékkel. Három nagy csomópontja az Infopark és a Lágymányosi út környéke, ahol a technológiai és kutatás-fejlesztési cégek koncentrálódnak, a BudaPart új, Duna-parti városnegyede ('.$office('budapart-gate', 'BudaPart GATE').', '.$office('budapart-city', 'City').', '.$office('budapart-downtown', 'Downtown').') és a '.$office('budapest-one-irodahaz', 'Budapest ONE').' az M1–M7 bevezetőnél, amely a budai körzetből és az agglomerációból autóval a legkönnyebben elérhető. A kerületben a parkolás a legolcsóbb Budapesten, 100 EUR/hely/hó a középérték, és a legtöbb házban felszíni és mélygarázs is van; a 4-es metró és a villamosok a belvárossal kötik össze. Jellemző bérlők: IT-cégek, ügyfélszolgálati és szolgáltató központok, gyógyszeripari és mérnöki vállalatok, amelyeknek 1 000 m² fölötti, egybefüggő területre van szükségük. Az alpiaci díjsávokat a '.$feeBands.' oldalon hasonlíthatod össze.</p>',
            ],
            'kiado-azonnali-szolgaltatott-irodak' => [
                'seo_title' => 'Szolgáltatott irodák és coworking Budapesten | PSG Irodaházak',
                'meta_description' => 'Azonnal beköltözhető, bútorozott szolgáltatott irodák és coworking terek :count budapesti helyszínen, 150–550 EUR/fő/hó áron, üzemeltetéssel és internettel együtt.',
                'intro' => '<p>A szolgáltatott iroda bútorozott, azonnal beköltözhető, és nem négyzetméterre, hanem munkaállomásra árazzák: a kínálatunkban szereplő 29 budapesti helyszínen 150 és 550 EUR/fő/hó között, 370 EUR-s középértékkel. A csomagár tartalmazza az üzemeltetési díjat, a bútort, az internetet, a recepciót, a takarítást és a tárgyalóhasználat egy részét, ezért nem hasonlítható össze közvetlenül a hagyományos bérlet négyzetméterdíjával. Előnye a rugalmasság: havi vagy éves szerződés, néhány napon belüli beköltözés, létszámváltozásnál bővíthető vagy szűkíthető terület. Tapasztalatunk szerint 12–15 fő fölött, legalább 3 éves időtávon a hagyományos bérlet kedvezőbb, alatta vagy gyorsan növekvő létszámnál a szolgáltatott iroda. A helyszínek a Váci úton, a belvárosban és Dél-Budán vannak, a nagy irodaházak földszintjén vagy külön emeletein. A hagyományos irodák alpiaci díjsávjait a '.$feeBands.' oldalon találod.</p>',
            ],
            'kiado-zold-irodak' => [
                'seo_title' => 'Kiadó zöld irodák: BREEAM és LEED irodaházak | PSG Irodaházak',
                'meta_description' => 'Kiadó zöld irodák :count BREEAM vagy LEED minősítésű budapesti irodaházban, 14–23 EUR/m²/hó bérleti díjjal. Alacsonyabb energiafogyasztás, ESG-jelentéshez tanúsítvány.',
            ],
            'kiado-klasszikus-irodahazak' => [
                'seo_title' => 'Kiadó klasszikus irodaházak, felújított paloták | PSG Irodaházak',
                'meta_description' => 'Kiadó irodák :count felújított történelmi épületben Budapest belvárosában, 13–28 EUR/m²/hó bérleti díjjal: magas belmagasság, reprezentatív előcsarnok, Andrássy út.',
            ],
            'kiado-uj-irodahazak' => [
                'seo_title' => 'Kiadó új irodaházak: 2022 után átadott irodák | PSG Irodaházak',
                'meta_description' => 'Kiadó irodák :count új, 2022 után átadott vagy épülő budapesti irodaházban, 14–27 EUR/m²/hó bérleti díjjal: CenterPoint 3, Major Udvar, BEM Center. Előbérlet is lehetséges.',
            ],
        ];
    }
};
