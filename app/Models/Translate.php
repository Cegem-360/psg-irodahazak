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
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'lang' => 'EN',
    ];
}
