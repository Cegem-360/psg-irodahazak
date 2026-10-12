<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'iranyitoszam',
    'helyiseg',
    'megye',
])]
#[WithoutTimestamps]
final class PostCode extends Model {}
