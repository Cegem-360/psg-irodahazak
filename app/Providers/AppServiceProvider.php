<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Forms\Components\RichEditor;
use GoogleTagManager;
use Illuminate\Support\ServiceProvider;
use Livewire\Blaze\Blaze;
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
        // Compile the anonymous Blade components into plain PHP functions. The
        // layouts are left out: Livewire renders the page layout with @component,
        // not with a component tag, which Blaze does not support.
        Blaze::optimize()
            ->in(resource_path('views/components'))
            ->in(resource_path('views/components/layouts'), compile: false);

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
}
