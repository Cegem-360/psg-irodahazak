<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'client_name',
    'client_position',
    'client_company',
    'testimonial',
    'client_image',
    'company_logo',
    'rating',
    'project_type',
    'is_featured',
    'is_active',
    'order',
    'lang',
])]
final class Testimonial extends Model
{
    use HasFactory;

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function active($query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function featured($query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function ordered($query): void
    {
        $query->orderBy('order')->latest();
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function forLang($query, $lang): void
    {
        $query->where('lang', $lang);
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'integer',
        ];
    }
}
