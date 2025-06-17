<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Content extends Model
{
    protected $guarded = [];

   

    protected $casts = [
        'content_json' => 'array',
    ];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_content');
    }
}
