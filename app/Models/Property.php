<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Property extends Model
{
    protected $guarded = [];

    protected $table = 'property';

    protected function casts(): array
    {
        return [
            'cimke_json' => 'json',
            'service_json' => 'json',
        ];
    }
}
