<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Property extends Model
{
    protected $guarded = [];

    protected $table = 'properties';

    protected function casts(): array
    {
        return [
            'cimke_json' => 'array',
            'service_json' => 'array',
        ];
    }
}
