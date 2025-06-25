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
        'lang',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    #[Scope]
<<<<<<< HEAD
    protected function featured($query)
=======
    protected function active($query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function featured($query): void
>>>>>>> 9de41a1 (refactor: Add return type declarations to scope methods in Testimonial model for improved clarity)
    {
        return $query->where('is_featured', true);
    }

    #[Scope]
    protected function ordered($query): void
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    #[Scope]
<<<<<<< HEAD
    protected function forLang($query, string $lang = 'hu')
=======
    protected function forLang($query, $lang): void
>>>>>>> 9de41a1 (refactor: Add return type declarations to scope methods in Testimonial model for improved clarity)
    {
        return $query->where('lang', $lang);
    }

    #[Scope]
    protected function active($query)
    {
        $query->where('is_active', true);
    }
}
