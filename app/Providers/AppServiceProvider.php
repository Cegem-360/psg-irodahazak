<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Gallery;
use App\Observers\GalleryObserver;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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

        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->translateLabel();
        });
        RichEditor::configureUsing(function (RichEditor $editor): void {
            $editor->translateLabel();
        });
    }
}
