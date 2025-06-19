<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Content extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'title',
        'status',
        'lead',
        'content',
        'ord',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'lang',
        'tags',
        'lead_pic',
        'sdf',
        'file',
        'ok',
        'mysep',
        'link',
    ];

    protected $casts = [
        'content_json' => 'array',
    ];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_content');
    }
}
