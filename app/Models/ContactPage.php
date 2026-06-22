<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'language',
    'content',
])]
final class ContactPage extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'string',
    ];

    /**
     * Get the active contact page by language.
     */
    public static function getActiveByLanguage(string $language = 'hu'): ?self
    {
        return self::where('language', $language)->first();
    }
}
