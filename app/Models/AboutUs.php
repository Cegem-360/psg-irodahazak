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
#[Table(name: 'about_us')]
final class AboutUs extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    #[Scope]
    protected function byLanguage($query, $language): void
    {
        $query->where('language', $language);
    }

    #[Scope]
    protected function active($query): void
    {
        $query->where('is_active', true);
    }
}
