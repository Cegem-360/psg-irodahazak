<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\AboutUs;
use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use App\Models\Reference;
use App\Models\Testimonial;
use Filament\Forms\Components\RichEditor;
use GoogleTagManager;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Override;
use Whitecube\LaravelCookieConsent\Facades\Cookies;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->shareHomeSectionData();

        GoogleTagManager::set('config', config('services.google_tag_manager.id', ''));
        if (Cookies::hasConsentFor('ad_storage')) {
            GoogleTagManager::set('ad_storage', 'granted');
        }

        if (Cookies::hasConsentFor('ad_user_data')) {
            GoogleTagManager::set('ad_user_data', 'granted');
        }

        if (Cookies::hasConsentFor('ad_personalization')) {
            GoogleTagManager::set('ad_personalization', 'granted');
        }

        RichEditor::configureUsing(function (RichEditor $editor): void {
            /** Add the "justify" alignment button next to the other alignment buttons. */
            $editor->toolbarButtons(fn (): array => array_map(
                fn (array $buttonGroup): array => in_array('alignEnd', $buttonGroup, true)
                    ? [...$buttonGroup, 'alignJustify']
                    : $buttonGroup,
                $editor->getDefaultToolbarButtons(),
            ));
        });
    }

    /**
     * The home page sections load their data here rather than querying from Blade.
     */
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

        View::composer('components.pages.about-us', fn (ViewContract $view) => $view->with(
            'aboutUs', AboutUs::query()->active()->byLanguage(app()->getLocale())->get(),
        ));
    }
}
