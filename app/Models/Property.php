<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Property extends Model
{
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'target_table_id')
            ->where('target_table', 'property');
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', 'active');
    }

    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('status', 'inactive');
    }

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'services' => 'array',
        ];
    }
}
