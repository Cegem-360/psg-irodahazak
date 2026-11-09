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
        'https://www.linkedin.com/in/richard-fekete-17371943/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Console
    |--------------------------------------------------------------------------
    |
    | The HTML-tag verification token of Google Search Console; with it set,
    | every page carries the google-site-verification meta tag.
    |
    */

    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),

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
