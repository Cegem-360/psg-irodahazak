<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function byLanguage($query, $language): void
    {
        $query->where('language', $language);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function active($query): void
    {
        $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
