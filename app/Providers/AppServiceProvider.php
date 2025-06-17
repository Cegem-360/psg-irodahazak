<?php

declare(strict_types=1);

namespace App\Providers;

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
        TextColumn::configureUsing(function (TextColumn $column) {
            $column->translateLabel();
        });
        RichEditor::configureUsing(function (RichEditor $editor) {
            $editor->translateLabel();
        });
    }
}
