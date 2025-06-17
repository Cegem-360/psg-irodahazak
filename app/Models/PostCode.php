<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class PostCode extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'iranyitoszam',
        'helyiseg',
        'megye',
    ];
}
