<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Gallery;
use App\Observers\GalleryObserver;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Column;
use GoogleTagManager;
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
        // Register model observers
        Gallery::observe(GalleryObserver::class);

        // Set locale from session
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

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

        Column::configureUsing(function (Column $column): void {
            $column->translateLabel();
        });
        Field::configureUsing(function (Field $field): void {
            $field->translateLabel();
        });
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
}
