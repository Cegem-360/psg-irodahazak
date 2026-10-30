<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Structured data profiles
    |--------------------------------------------------------------------------
    |
    | The "sameAs" links of the Organization and of its founder in the JSON-LD of
    | every page. The LinkedIn company page and profile go here once known.
    |
    */

    'organization_same_as' => [
        'https://www.facebook.com/psgirodahazak',
        'https://www.irodakereso.hu/cegek/ugynoksegek/property-solution-group',
        'https://www.officerentinfo.hu/companies/agencies/property-solution-group',
        'https://iroda.ingatlan.com/psg',
    ],

    'founder_same_as' => [
        'https://acora.blog.hu/2020/07/01/a_berlokepviselet_fele_nyit_a_psg',
    ],

    /*
    |--------------------------------------------------------------------------
    | IndexNow
    |--------------------------------------------------------------------------
    |
    | With a key set, the key file is served at /{key}.txt and every saved
    | property is submitted to the IndexNow API (Bing, Yandex, ...).
    |
    */

    'indexnow' => [
        'key' => env('INDEXNOW_KEY'),
        'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),
    ],

];
