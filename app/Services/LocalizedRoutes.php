<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as Router;

/**
 * Pairs the Hungarian routes with their English twins, whose names carry an
 * "en." prefix. A page that has both versions takes its language from its URL;
 * a page without a twin (the blog, the login) follows the visitor's session.
 */
final class LocalizedRoutes
{
    public const string DEFAULT_LOCALE = 'hu';

    /** @var list<string> */
    public const array LOCALES = ['hu', 'en'];

    /**
     * The name of the given route's version in the given locale, if it exists.
     */
    public function nameIn(string $routeName, string $locale): ?string
    {
        $baseName = str_starts_with($routeName, 'en.') ? mb_substr($routeName, 3) : $routeName;
        $localizedName = $locale === 'en' ? 'en.'.$baseName : $baseName;

        return Router::has($localizedName) ? $localizedName : null;
    }

    /**
     * The language the route's URL stands for, or null when the route has no twin.
     */
    public function localeOf(?Route $route): ?string
    {
        $routeName = $route?->getName();

        if ($routeName === null || ! $this->hasEveryLocale($routeName)) {
            return null;
        }

        return str_starts_with($routeName, 'en.') ? 'en' : self::DEFAULT_LOCALE;
    }

    /**
     * The URL of the same page in every language, keyed by locale; empty when the page has no twin.
     *
     * @return array<string, string>
     */
    public function alternates(?Route $route): array
    {
        if ($this->localeOf($route) === null) {
            return [];
        }

        // Only the URL's own placeholders: Route::view() also carries its view name and status as defaults.
        $parameters = array_intersect_key($route->originalParameters(), array_flip($route->parameterNames()));

        return $this->alternatesFor((string) $route->getName(), $parameters);
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, string>
     */
    public function alternatesFor(string $routeName, array $parameters = []): array
    {
        if (! $this->hasEveryLocale($routeName)) {
            return [];
        }

        return collect(self::LOCALES)
            ->mapWithKeys(fn (string $locale): array => [$locale => route((string) $this->nameIn($routeName, $locale), $parameters)])
            ->all();
    }

    private function hasEveryLocale(string $routeName): bool
    {
        return collect(self::LOCALES)->every(fn (string $locale): bool => $this->nameIn($routeName, $locale) !== null);
    }
}
