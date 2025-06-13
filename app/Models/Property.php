<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    protected $guarded = [];
}
