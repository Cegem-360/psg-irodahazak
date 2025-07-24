<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Tag extends Model
{
    protected $fillable = ['name'];

    /**
     * Many-to-many relationship with Properties
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class);
    }
}
