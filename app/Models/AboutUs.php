<?php

declare(strict_types=1);

namespace App\Models;

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

    /**
     * Aktív rólunk oldal lekérése nyelvek szerint
     */
    public static function getActive(?string $language = 'hu'): ?self
    {
        return self::where('is_active', true)
            ->where('language', $language)
            ->first();
    }

    /**
     * Rólunk oldal tartalom lekérése nyelvek szerint
     */
    public static function getContent(?string $language = 'hu'): ?string
    {
        $aboutUs = self::getActive($language);

        return $aboutUs?->content;
    }

    /**
     * Rólunk oldal cím lekérése nyelvek szerint
     */
    public static function getTitle(?string $language = 'hu'): ?string
    {
        $aboutUs = self::getActive($language);

        return $aboutUs?->title;
    }
}
