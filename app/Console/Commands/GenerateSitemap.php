<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use App\Services\LocalizedRoutes;
use Closure;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

#[Description('Write the sitemap index (sitemap.xml) and its page, property and article sitemaps')]
#[Signature('sitemap:generate {--path= : Where to write the index; the sitemaps go next to it (defaults to public/sitemap.xml)}')]
final class GenerateSitemap extends Command
{
    /**
     * Named routes that exist but should stay out of the sitemap: authentication,
     * cache busting, and pages whose content is per-visitor rather than public.
     */
    private const array EXCLUDED_ROUTES = [
        'login',
        'favorites',
        'kedvencek',
        'favorites.export-excel',
        'adatlap-oldal',
    ];

    private LocalizedRoutes $localizedRoutes;

    public function handle(LocalizedRoutes $localizedRoutes): int
    {
        $this->localizedRoutes = $localizedRoutes;
        $indexPath = $this->option('path') ?: public_path('sitemap.xml');
        $directory = dirname((string) $indexPath);

        $sitemaps = [
            'sitemap-oldalak.xml' => $this->pagesSitemap(),
            'sitemap-ingatlanok.xml' => $this->propertiesSitemap(),
            'sitemap-hirek.xml' => $this->articlesSitemap(),
        ];

        $index = SitemapIndex::create();

        foreach ($sitemaps as $fileName => $sitemap) {
            $sitemap->writeToFile($directory.'/'.$fileName);
            $index->add(url($fileName));

            $this->info(sprintf('Wrote %d URLs to %s', count($sitemap->getTags()), $directory.'/'.$fileName));
        }

        $index->writeToFile($indexPath);

        $this->info('Wrote the sitemap index to '.$indexPath);

        return self::SUCCESS;
    }

    private function pagesSitemap(): Sitemap
    {
        $sitemap = Sitemap::create();

        foreach ($this->staticRoutes() as $route) {
            $this->addLocalized($sitemap, $route, [], fn (Url $url): Url => $url->setPriority(0.8));
        }

        return $sitemap;
    }

    private function propertiesSitemap(): Sitemap
    {
        $sitemap = Sitemap::create();

        $properties = Property::query()
            ->active()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->cursor();

        foreach ($properties as $property) {
            $this->addLocalized(
                $sitemap,
                $property->offer_type?->showRoute() ?? 'properties.show',
                ['property' => $property->slug],
                fn (Url $url): Url => $url->setLastModificationDate($property->updated_at ?? now())->setPriority(0.9),
            );
        }

        return $sitemap;
    }

    private function articlesSitemap(): Sitemap
    {
        $sitemap = Sitemap::create();

        foreach (News::query()->where('is_published', true)->whereNotNull('slug')->cursor() as $news) {
            $this->addLocalized(
                $sitemap,
                'news.show',
                ['slug' => $news->slug],
                fn (Url $url): Url => $url->setLastModificationDate($news->updated_at ?? now())->setPriority(0.6),
            );
        }

        if (Route::has('en.blog.show')) {
            $posts = BlogPost::query()
                ->published()
                ->where('noindex', false)
                ->whereNotNull('slug')
                ->cursor();

            foreach ($posts as $post) {
                $sitemap->add(
                    Url::create(route('en.blog.show', ['post' => $post->slug]))
                        ->setLastModificationDate($post->updated_at ?? now())
                        ->setPriority(0.6)
                );
            }
        }

        return $sitemap;
    }

    /**
     * Adds the page in every language it exists in, each entry listing all of
     * them as hreflang alternates; a page without an English twin goes in once.
     *
     * @param  array<string, mixed>  $parameters
     * @param  Closure(Url): Url  $configure
     */
    private function addLocalized(Sitemap $sitemap, string $routeName, array $parameters, Closure $configure): void
    {
        $alternates = $this->localizedRoutes->alternatesFor($routeName, $parameters);

        foreach ($alternates ?: [LocalizedRoutes::DEFAULT_LOCALE => route($routeName, $parameters)] as $pageUrl) {
            $url = $configure(Url::create($pageUrl));

            foreach ($alternates as $locale => $alternateUrl) {
                $url->addAlternate($alternateUrl, $locale);
            }

            $sitemap->add($url);
        }
    }

    /**
     * The names of every public GET page that takes no route parameters, in
     * Hungarian; English twins are added alongside them. Discovered from the
     * router rather than hard-coded, so both sites can share this command
     * despite their different Hungarian URLs.
     *
     * @return Collection<int, string>
     */
    private function staticRoutes(): Collection
    {
        return collect(Route::getRoutes()->getRoutes())
            ->filter(fn (RoutingRoute $route): bool => in_array('GET', $route->methods(), true)
                && $route->getName() !== null
                && ! str_contains($route->uri(), '{')
                && ! str_starts_with($route->uri(), 'admin')
                && ! str_starts_with($route->uri(), '_')
                && ! str_starts_with((string) $route->getName(), 'filament.')
                && ! str_starts_with((string) $route->getName(), 'en.')
                && ! in_array($route->getName(), self::EXCLUDED_ROUTES, true)
                && $this->isAppOwned($route))
            ->map(fn (RoutingRoute $route): string => (string) $route->getName())
            ->unique()
            ->values();
    }

    /**
     * Keep vendor-registered routes out of the sitemap: packages add public
     * endpoints of their own (the cookie-consent script, for one) that are not
     * pages a search engine should index.
     */
    private function isAppOwned(RoutingRoute $route): bool
    {
        $action = $route->getAction('uses');

        if ($action instanceof Closure) {
            return true;
        }

        if (! is_string($action)) {
            return false;
        }

        // Route::view() records the action with a leading backslash. Both spellings
        // are matched rather than trimmed: Pint's mb_str_functions rule rewrites
        // ltrim() to mb_ltrim(), which needs PHP 8.4, and this command runs from
        // the schedule:run cron that is still on 8.3.
        foreach (['App\\', ViewController::class] as $prefix) {
            if (str_starts_with($action, $prefix) || str_starts_with($action, '\\'.$prefix)) {
                return true;
            }
        }

        return false;
    }
}
