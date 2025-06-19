<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

final class LanguageController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(Request $request, string $locale)
    {
        // Check if the locale is supported
        if (! in_array($locale, ['hu', 'en'])) {
            abort(404);
        }

        // Store the locale in session
        Session::put('locale', $locale);

        // Get the referer URL to redirect back to the page user was on
        $referer = $request->header('referer');

        if ($referer) {
            $targetUrl = $this->convertUrlToTargetLocale($referer, $locale);
        } else {
            // Fallback to homepage in target language
            $targetUrl = $locale === 'en' ? '/en' : '/';
        }

        return redirect($targetUrl);
    }

    /**
     * Convert a URL to the target locale
     */
    private function convertUrlToTargetLocale(string $url, string $targetLocale): string
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '/';

        // Remove leading slash
        $path = mb_ltrim($path, '/');

        // Define URL mappings between locales
        $urlMappings = [
            'en_to_hu' => [
                'en' => '',
                'en/data-sheet' => 'adatlap-oldal',
                'en/offices-for-rent' => 'kiado-irodak',
                'en/office-buildings-for-sale' => 'elado-irodahazak',
                'en/about-us' => 'rolunk',
                'en/contact' => 'kapcsolat',
                'en/privacy-policy' => 'adatvedelmi-nyilatkozat',
                'en/impressum' => 'impresszum',
                'en/properties' => 'ingatlanok',
                'en/blog' => 'blog',
                'en/news' => 'hirek',
            ],
            'hu_to_en' => [
                '' => 'en',
                'adatlap-oldal' => 'en/data-sheet',
                'kiado-irodak' => 'en/offices-for-rent',
                'elado-irodahazak' => 'en/office-buildings-for-sale',
                'rolunk' => 'en/about-us',
                'kapcsolat' => 'en/contact',
                'adatvedelmi-nyilatkozat' => 'en/privacy-policy',
                'impresszum' => 'en/impressum',
                'ingatlanok' => 'en/properties',
                'blog' => 'en/blog',
                'hirek' => 'en/news',
            ],
        ];

        // If switching to Hungarian (default locale)
        if ($targetLocale === 'hu') {
            $mappingKey = 'en_to_hu';
            $mappings = $urlMappings[$mappingKey];

            if (isset($mappings[$path])) {
                return '/'.$mappings[$path];
            }

            // For dynamic routes, try to remove en/ prefix
            if (str_starts_with($path, 'en/')) {
                $pathWithoutEn = mb_substr($path, 3);
                // Check if we have a mapping for the path without en/
                foreach ($mappings as $enPath => $huPath) {
                    if (str_starts_with($enPath, 'en/') && mb_substr($enPath, 3) === $pathWithoutEn) {
                        return '/'.$huPath;
                    }
                }

                return '/'.$pathWithoutEn;
            }

            return '/'.$path;
        }

        // If switching to English
        if ($targetLocale === 'en') {
            $mappingKey = 'hu_to_en';
            $mappings = $urlMappings[$mappingKey];

            if (isset($mappings[$path])) {
                return '/'.$mappings[$path];
            }

            // For dynamic routes, try to add en/ prefix
            if (! str_starts_with($path, 'en/') && $path !== 'en') {
                return '/en/'.$path;
            }

            return '/'.$path;
        }

        // Fallback
        return $targetLocale === 'en' ? '/en' : '/';
    }
}
