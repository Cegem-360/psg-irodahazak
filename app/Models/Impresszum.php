<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'language',
    'title',
    'content',
    'is_active',
])]
#[Table(name: 'impressum')]
final class Impresszum extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    #[Scope]
    protected function byLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    #[Scope]
    protected function active($query)
    {
        return $query->where('is_active', true);
    }
}
