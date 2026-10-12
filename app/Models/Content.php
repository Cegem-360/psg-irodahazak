<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
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
])]
#[Unguarded]
final class Content extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany<Page, $this, Pivot>
     */
    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_content');
    }

    protected function casts(): array
    {
        return [
            'content_json' => 'array',
        ];
    }
}
