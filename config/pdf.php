<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | PDF Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration values for PDF generation
    |
    */

    'browsershot' => [
        'format' => 'A4',
        'margins' => [
            'top' => 15,
            'right' => 15,
            'bottom' => 20,
            'left' => 15,
        ],
        'timeout' => 60,
        'show_background' => true,
        'wait_until_network_idle' => true,
    ],

    'property' => [
        'max_images' => 6,
        'default_image_height' => 200,
    ],
];
