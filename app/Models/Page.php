<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
#[Unguarded]
final class Page extends Model
{
    /**
     * @return BelongsToMany<Content, $this, Pivot>
     */
    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'page_content');
    }
}
