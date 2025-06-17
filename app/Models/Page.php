<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Page extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'title',
        'url',
        'ord',
        'template',
        'parent_id',
        'show_menu',
        'type',
        'content_id',
        'title_url',
        'content_category_id',
    ];

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'page_content');
    }
}
