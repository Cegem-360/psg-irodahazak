<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ReferenceObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ReferenceObserver::class)]
#[Fillable([
    'name',
    'image',
    'order',
    'is_active',
])]
final class Reference extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('order');
    }
}
