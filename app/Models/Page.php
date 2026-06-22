<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
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
])]
final class Page extends Model
{
    protected $guarded = [];

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'page_content');
    }
}
