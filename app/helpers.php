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
