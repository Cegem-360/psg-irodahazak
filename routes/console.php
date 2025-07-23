<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Artisan::call('bloghu:fetch-feed');
})->dailyAt('12:02');

Schedule::call(function () {
    Artisan::call('bloghu:fetch-feed');
})->dailyAt('11:04');
