<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

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
        'clearCache',
    ];

    protected $signature = 'sitemap:generate {--path= : Where to write the file (defaults to public/sitemap.xml)}';

    protected $description = 'Write sitemap.xml from the published content';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        foreach ($this->staticUrls() as $url) {
            $sitemap->add(Url::create($url)->setPriority(0.8));
        }

        $properties = Property::query()
            ->where('status', 'active')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->cursor();

        foreach ($properties as $property) {
            $route = str_starts_with((string) $property->elado_v_kiado, 'elado')
                ? 'properties.show-for-sale'
                : 'properties.show';

            $sitemap->add(
                Url::create(route($route, ['property' => $property->slug]))
                    ->setLastModificationDate($property->updated_at ?? now())
                    ->setPriority(0.9)
            );
        }

        foreach (News::query()->where('is_published', true)->whereNotNull('slug')->cursor() as $news) {
            $sitemap->add(
                Url::create(route('news.show', ['slug' => $news->slug]))
                    ->setLastModificationDate($news->updated_at ?? now())
                    ->setPriority(0.6)
            );
        }

        if (Route::has('en.blog.show')) {
            foreach (BlogPost::query()->where('is_published', true)->whereNotNull('slug')->cursor() as $post) {
                $sitemap->add(
                    Url::create(route('en.blog.show', ['post' => $post->slug]))
                        ->setLastModificationDate($post->updated_at ?? now())
                        ->setPriority(0.6)
                );
            }
        }

        $path = $this->option('path') ?: public_path('sitemap.xml');
        $sitemap->writeToFile($path);

        $this->info(sprintf('Wrote %d URLs to %s', count($sitemap->getTags()), $path));

        return self::SUCCESS;
    }

    /**
     * Every public GET page that takes no route parameters. Discovered from the
     * router rather than hard-coded, so both sites can share this command
     * despite their different Hungarian URLs.
     *
     * @return Collection<int, string>
     */
    private function staticUrls(): Collection
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
            ->map(fn (RoutingRoute $route): string => url($route->uri() === '/' ? '/' : '/'.$route->uri()))
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
