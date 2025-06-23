<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\News;
use App\Observers\BlogPostObserver;
use App\Observers\GalleryObserver;
use App\Observers\NewsObserver;
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
        BlogPost::observe(BlogPostObserver::class);
        News::observe(NewsObserver::class);

        // Set locale from session
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->translateLabel();
        });
        RichEditor::configureUsing(function (RichEditor $editor): void {
            $editor->translateLabel();
        });
    }
}
