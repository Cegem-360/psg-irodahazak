<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\CookiesServiceProvider::class,
    App\Providers\Filament\AdminPanelServiceProvider::class,
    App\Providers\ViewServiceProvider::class,
    Spatie\GoogleTagManager\GoogleTagManagerServiceProvider::class,
];
