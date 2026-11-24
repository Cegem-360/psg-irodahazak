<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The English translations of the category titles and meta descriptions of
     * content package 2, in the translates table (Hungarian text => English),
     * where the admin keeps the other translations of database content. The
     * English category pages use them; ":count" stays a placeholder.
     */
    public function up(): void
    {
        foreach ($this->translations() as $hungarian => $english) {
            if (DB::table('translates')->where('name', $hungarian)->exists()) {
                continue;
            }

            DB::table('translates')->insert([
                'name' => $hungarian,
                'translated' => $english,
                'lang' => 'EN',
                'date' => now(),
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
        DB::table('translates')->whereIn('name', array_keys($this->translations()))->delete();
    }

    /**
     * @return array<string, string>
     */
    private function translations(): array
    {
        return [
            'Kiadó belvárosi irodák: V., VI., VII. kerület | PSG Irodaházak' => 'Offices for rent in the city centre: Districts V, VI, VII | PSG Irodaházak',
            'Kiadó belvárosi irodák :count irodaházban az V., VI. és VII. kerületben, 11,5–28 EUR/m²/hó bérleti díjjal: prémium paloták és felújított körúti irodaházak.' => 'Offices for rent in the city centre in :count office buildings in Districts V, VI and VII, at 11.5–28 EUR/m²/month: premium palaces and refurbished Grand Boulevard office buildings.',
            'Kiadó irodák az V. kerületben, Lipótváros | PSG Irodaházak' => 'Offices for rent in District V, Lipótváros | PSG Irodaházak',
            'Kiadó irodák az V. kerület :count irodaházában, 14–28 EUR/m²/hó bérleti díjjal: Bank Center, Academia, Roosevelt és a belváros prémium épületei.' => 'Offices for rent in :count office buildings of District V, at 14–28 EUR/m²/month: Bank Center, Academia, Roosevelt and the premium buildings of the city centre.',
            'Kiadó Váci úti irodák, XIII. kerület | PSG Irodaházak' => 'Offices for rent on Váci út, District XIII | PSG Irodaházak',
            'Kiadó Váci úti irodák :count irodaházban, 7,5–23 EUR/m²/hó bérleti díjjal. Budapest legnagyobb irodapiaca metróval, zöld épületekkel, a legkedvezőbb üzemeltetési díjjal.' => 'Offices for rent on Váci út in :count office buildings, at 7.5–23 EUR/m²/month. The largest office market of Budapest, with the metro, green buildings and the most favourable operating fee.',
            'Kiadó pesti irodák: a pesti oldal kínálata | PSG Irodaházak' => 'Offices for rent in Pest: the offer of the Pest side | PSG Irodaházak',
            'Kiadó pesti irodák :count irodaházban a belvárostól a Váci úton át a Corvin-negyedig, 7–28 EUR/m²/hó bérleti díjjal, aktuális szabad területekkel.' => 'Offices for rent in Pest in :count office buildings, from the city centre through Váci út to Corvin Quarter, at 7–28 EUR/m²/month, with currently available spaces.',
            'Kiadó budai irodák: I., II., III., XI., XII. kerület | PSG Irodaházak' => 'Offices for rent in Buda: Districts I, II, III, XI, XII | PSG Irodaházak',
            'Kiadó budai irodák :count irodaházban a Margit körúttól a MOM Parkon át Dél-Budáig, 7–27 EUR/m²/hó bérleti díjjal, üzemeltetési díjjal és parkolással.' => 'Offices for rent in Buda in :count office buildings, from Margit körút through MOM Park to South Buda, at 7–27 EUR/m²/month, with operating fee and parking.',
            'Kiadó bel-budai irodák: I., II., XII. kerület | PSG Irodaházak' => 'Offices for rent in inner Buda: Districts I, II, XII | PSG Irodaházak',
            'Kiadó bel-budai irodák :count irodaházban az I., II. és XII. kerületben, 11–27 EUR/m²/hó bérleti díjjal; 100–300 m²-es irodák a Margit körút és a MOM Park környékén.' => 'Offices for rent in inner Buda in :count office buildings in Districts I, II and XII, at 11–27 EUR/m²/month; offices of 100–300 m² around Margit körút and MOM Park.',
            'Kiadó irodák a XI. kerületben: Infopark, BudaPart | PSG Irodaházak' => 'Offices for rent in District XI: Infopark, BudaPart | PSG Irodaházak',
            'Kiadó irodák a XI. kerület :count irodaházában, 9,25–21 EUR/m²/hó bérleti díjjal: Infopark, BudaPart, Budapest ONE. Nagy egybefüggő területek, olcsó parkolás.' => 'Offices for rent in :count office buildings of District XI, at 9.25–21 EUR/m²/month: Infopark, BudaPart, Budapest ONE. Large contiguous areas, cheap parking.',
            'Szolgáltatott irodák és coworking Budapesten | PSG Irodaházak' => 'Serviced offices and coworking in Budapest | PSG Irodaházak',
            'Azonnal beköltözhető, bútorozott szolgáltatott irodák és coworking terek :count budapesti helyszínen, 150–550 EUR/fő/hó áron, üzemeltetéssel és internettel együtt.' => 'Furnished serviced offices and coworking spaces, ready to move into, at :count Budapest locations, for 150–550 EUR/person/month, including operation and internet.',
            'Kiadó zöld irodák: BREEAM és LEED irodaházak | PSG Irodaházak' => 'Green offices for rent: BREEAM and LEED office buildings | PSG Irodaházak',
            'Kiadó zöld irodák :count BREEAM vagy LEED minősítésű budapesti irodaházban, 14–23 EUR/m²/hó bérleti díjjal. Alacsonyabb energiafogyasztás, ESG-jelentéshez tanúsítvány.' => 'Green offices for rent in :count BREEAM or LEED certified Budapest office buildings, at 14–23 EUR/m²/month. Lower energy consumption, a certificate for ESG reporting.',
            'Kiadó klasszikus irodaházak, felújított paloták | PSG Irodaházak' => 'Classic office buildings for rent, refurbished palaces | PSG Irodaházak',
            'Kiadó irodák :count felújított történelmi épületben Budapest belvárosában, 13–28 EUR/m²/hó bérleti díjjal: magas belmagasság, reprezentatív előcsarnok, Andrássy út.' => 'Offices for rent in :count refurbished historic buildings in central Budapest, at 13–28 EUR/m²/month: high ceilings, representative lobbies, Andrássy út.',
            'Kiadó új irodaházak: 2022 után átadott irodák | PSG Irodaházak' => 'New office buildings for rent: offices handed over after 2022 | PSG Irodaházak',
            'Kiadó irodák :count új, 2022 után átadott vagy épülő budapesti irodaházban, 14–27 EUR/m²/hó bérleti díjjal: CenterPoint 3, Major Udvar, BEM Center. Előbérlet is lehetséges.' => 'Offices for rent in :count new Budapest office buildings, handed over after 2022 or under construction, at 14–27 EUR/m²/month: CenterPoint 3, Major Udvar, BEM Center. Pre-leasing is possible.',
        ];
    }
};
