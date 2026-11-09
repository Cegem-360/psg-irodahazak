<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The off-topic /news-blog posts copied from blog.hu, as listed by marketing
     * on 2026-11-09: they stay readable but get noindex, leave the sitemap and the
     * post lists. The few office-related posts stay indexable.
     *
     * @var list<string>
     */
    private const array SLUGS = [
        '7-bombabiztos-tipp-azoknak-akik-mindenaron-tonkre-tennek-a-nyaralasukat',
        'volt-hogy-a-papavalaszto-biborosok-feje-folul-lebontottak-a-tetot-tortenelmi-konklavek',
        'a-12-pont-szuletesenek-tortenete',
        'az-iskolaban-vertek-apja-terrorizalta-megis-zseni-lett-milyen-volt-elon-musk-gyermekkora-del-afrikaban',
        'megdobbento-mi-mindent-jeleztek-elore-1925-ben-az-idei-evvel-kapcsolatban',
        'minden-idok-egyik-legjobb-karacsonyi-reklamfilmjet-hozta-ossze-ez-a-bank',
        'kicsi-a-feje-nem-lesz-jo-elnok-az-amerikai-valasztasok-legbizarrabb-kampanyai',
        'amikor-csonakokkal-mentettek-az-embereket-a-pesti-utcakon-magyarorszag-legdurvabb-arvizei',
        'elkepesztoen-gyanus-a-sziciliai-partoknal-elsullyedt-luxusjacht-tragediaja',
        'legutobb-egy-megszallott-szerelmes-akarta-megolni-az-amerikai-elnokot-43-evvel-ezelott',
        'kettetort-spagetti-fellibbent-skotszoknya-focilazban-eg-europa',
        'szeduletes-mire-kepes-az-uj-hangvezerelt-mesterseges-intelligencia',
        'legendas-mitoszok-1848-rol-avagy-hogy-nem-szavalt-nemzeti-dalt-petofi-a-nemzeti-muzeum-lepcsojenel',
        'tulzasba-vitt-elvezet-hogyan-vess-veget-a-dopaminfuggesnek',
        'mire-jo-az-atlatszo-teve-a-fogmoso-robot-es-a-napenergias-generator-ujdonsagok-las-vegasbol',
        'a-het-legnagyobb-hiba-amit-elkovethetsz-karacsonykor',
        'nehany-apro-otlet-amivel-karacsonyi-hangulatot-teremthetsz-az-otthonodban',
        'hires-magyar-zsidok-akiknek-sokat-koszonhet-magyarorszag-es-a-vilag',
        'slow-living-a-lelassulas-muveszete-hogyan-katapultaljunk-a-tulporgott-vilagunkbol',
        'teljesen-elbutithatja-az-embert-a-mesterseges-intelligencia-allando-hasznalata',
        'leszoktunk-az-olvasasrol-pedig-mar-napi-6-perc-is-oriasi-valtozast-hozna',
        'legy-halas-tovabb-elsz-ezert-erdemes-rendszeresen-koszonetet-mondani',
        'minden-idok-7-legjobb-karacsonyi-filmje-ha-unod-mar-a-keresgelest',
        'kototuvel-a-doomscrolling-ellen-miert-vagyunk-vissza-az-analog-vilagba',
        '5-helyszin-amit-erdemes-felkeresned-iden-nyaron-magyarorszagon',
        'az-elfelejtett-vb-ezust-az-ev-amikor-majdnem-sikerult-megnyernunk-a-vilagbajnoksagot',
        '1540-az-ev-amikor-elzartak-a-csapokat-az-egen',
        'skynet-en-a-robot-hal-9000-tenyleg-az-emberiseg-ellen-fordulhat-az-ai',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('blog_posts')->whereIn('slug', self::SLUGS)->update(['noindex' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('blog_posts')->whereIn('slug', self::SLUGS)->update(['noindex' => false]);
    }
};
