<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;

final class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'language',
        'title',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    #[Scope]
    public function byLanguage($query, $language)
    {
        $query->where('language', $language);
    }

    #[Scope]
    protected function active($query)
    {
        $query->where('is_active', true);
    }
}
