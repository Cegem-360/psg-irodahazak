<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use App\Models\Reference;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * The home page sections are anonymous Blade components; the records they show
 * are loaded here, per view, rather than in Blade.
 */
final class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->shareHomeSectionData();
    }

    private function shareHomeSectionData(): void
    {
        View::composer('components.home.featured-offers', fn (ViewContract $view) => $view->with(
            'properties', Property::query()->active()->featured()->get(),
        ));

        View::composer('components.home.testimonials', fn (ViewContract $view) => $view->with(
            'testimonials', Testimonial::query()->active()->forLang(app()->getLocale())->ordered()->get(),
        ));

        View::composer('components.home.references', fn (ViewContract $view) => $view->with(
            'references', Reference::query()->active()->ordered()->get(),
        ));

        View::composer('components.home.blog', fn (ViewContract $view) => $view->with(
            'posts', BlogPost::query()->published()->latest('published_at')->take(3)->get(),
        ));

        View::composer('components.home.news', fn (ViewContract $view) => $view->with(
            'news', News::query()->published()->latest('published_at')->take(3)->get(),
        ));
    }
}
