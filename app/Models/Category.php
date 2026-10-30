<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'name',
    'slug',
    'heading',
    'seo_title',
    'meta_description',
])]
final class Category extends Model
{
    /**
     * Many-to-many relationship with Properties
     *
     * @return BelongsToMany<Property, $this, Pivot>
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class);
    }
}
