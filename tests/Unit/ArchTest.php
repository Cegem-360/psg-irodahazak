<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;

arch()->preset()->php();
// arch()->preset()->strict();
// Scope the Laravel preset to this project's conventions:
// - Controllers expose intentional extra actions beyond the resource methods.
// - Console commands are not suffixed with "Command".
// - Mailables are sent synchronously (no ShouldQueue) on the sync queue.
arch()->preset()->laravel()->ignoring([
    'App\Http\Controllers\BlogController',
    'App\Http\Controllers\LanguageController',
    'App\Http\Controllers\PropertyController',
    'App\Console\Commands',
    'App\Mail',
]);
arch()->preset()->security();
arch()->expect('App\Models')->toBeClasses()->toExtend(Model::class);
arch('App\Controllers\Controller is abstract')->expect('App\Controllers\Controller')->toBeAbstract();
