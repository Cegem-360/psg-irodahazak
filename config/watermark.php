<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Vízjel beállítások
    |--------------------------------------------------------------------------
    |
    | Itt állíthatod be a vízjel tulajdonságait
    |
    */

    // Vízjel engedélyezése
    'enabled' => env('WATERMARK_ENABLED', true),

    // Vízjel szöveg
    'text' => env('WATERMARK_TEXT', 'PSG Irodaházak'),

    // Vízjel pozíció (bottom-right, bottom-left, top-right, top-left, center)
    'position' => env('WATERMARK_POSITION', 'bottom-right'),

    // Vízjel átlátszóság (0-100)
    'opacity' => env('WATERMARK_OPACITY', 50),

    // Vízjel méret (pixel)
    'font_size' => env('WATERMARK_FONT_SIZE', 24),

    // Vízjel szín (hex formátumban)
    'color' => env('WATERMARK_COLOR', '#ffffff'),

    // Vízjel margó (pixel)
    'margin' => env('WATERMARK_MARGIN', 20),

    // Vízjel font fájl útvonal (opcionális)
    'font_path' => env('WATERMARK_FONT_PATH', null),

    // Vízjel háttér szín (opcionális, hex formátumban)
    'background_color' => env('WATERMARK_BACKGROUND_COLOR', '#000000'),

    // Vízjel háttér átlátszóság (0-100)
    'background_opacity' => env('WATERMARK_BACKGROUND_OPACITY', 30),

    // Vízjel shadow (árnyék) beállítás
    'shadow' => [
        'enabled' => env('WATERMARK_SHADOW_ENABLED', true),
        'color' => env('WATERMARK_SHADOW_COLOR', '#000000'),
        'offset_x' => env('WATERMARK_SHADOW_OFFSET_X', 2),
        'offset_y' => env('WATERMARK_SHADOW_OFFSET_Y', 2),
        'blur' => env('WATERMARK_SHADOW_BLUR', 4),
    ],

    // Csak ezeken a típusokon alkalmazva
    'apply_to_types' => [
        'property', // ingatlan képek
        'gallery',  // galéria képek
        'blog',     // blog képek
        'news',     // hírek képek
    ],

    // Minimum kép méret, ami alatt nem rakjuk rá a vízjelet (pixel)
    'min_image_width' => env('WATERMARK_MIN_WIDTH', 100),
    'min_image_height' => env('WATERMARK_MIN_HEIGHT', 100),
];
