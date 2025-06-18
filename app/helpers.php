<?php

declare(strict_types=1);

if (! function_exists('localized_route')) {
    /**
     * Generate a localized route URL based on current locale
     */
    function localized_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        $locale = app()->getLocale();

        // If current locale is English, prefix the route name
        if ($locale === 'en') {
            $name = 'en.'.$name;
        }

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('switch_locale_route')) {
    /**
     * Get the equivalent route in different locale
     */
    function switch_locale_route(string $targetLocale): string
    {
        $currentRoute = request()->route();
        if (! $currentRoute) {
            return $targetLocale === 'en' ? '/en' : '/';
        }

        $routeName = $currentRoute->getName();
        $parameters = $currentRoute->parameters();

        // Remove language prefix if exists
        $baseRouteName = str_replace('en.', '', $routeName);

        // Add target language prefix if needed
        if ($targetLocale === 'en') {
            $targetRouteName = 'en.'.$baseRouteName;
        } else {
            $targetRouteName = $baseRouteName;
        }

        // Check if target route exists
        if (Illuminate\Support\Facades\Route::has($targetRouteName)) {
            return route($targetRouteName, $parameters);
        }

        // Fallback to homepage in target language
        return $targetLocale === 'en' ? '/en' : '/';
    }
}
