<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelServiceProvider::class,
    Spatie\GoogleTagManager\GoogleTagManagerServiceProvider::class,
    App\Providers\CookiesServiceProvider::class,
];
