<?php

declare(strict_types=1);

use App\Models\Reference;
use App\Models\Translate;
use Illuminate\Database\Eloquent\Collection;

if (! function_exists('translate_value')) {
    /**
     * Translate a free-text value via the Translate table when the current
     * locale is English, falling back to the original value when there is no
     * matching translation. Non-English locales return the value unchanged.
     */
    function translate_value(?string $value): ?string
    {
        if (blank($value)) {
            return $value;
        }

        if (app()->getLocale() !== 'en') {
            return $value;
        }

        return Translate::whereName($value)->first()?->translated ?: $value;
    }
}

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

if (! function_exists('get_references')) {
    /**
     * Get active references ordered by order field
     */
    function get_references(): Collection
    {
        return Reference::active()
            ->ordered()
            ->get();
    }
}
