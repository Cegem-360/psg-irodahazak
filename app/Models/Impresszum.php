<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Impresszum extends Model
{
    protected $table = 'impressum';

    protected $fillable = [
        'title',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Aktív impresszum lekérése
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Impresszum tartalom lekérése
     */
    public static function getContent(): ?string
    {
        $impresszum = self::getActive();

        return $impresszum?->content;
    }
}
