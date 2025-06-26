<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Translate extends Model
{
    protected $fillable = [
        'name',
        'translated',
        'date',
        'lang',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $attributes = [
        'lang' => 'EN',
    ];
}
