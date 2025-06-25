<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;

final class Testimonial extends Model
{
    protected $fillable = [
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
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    #[Scope]
    protected function active($query)
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function featured($query)
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    protected function ordered($query)
    {
        $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    #[Scope]
    protected function forLang($query, $lang)
    {
        $query->where('lang', $lang);
    }
}
