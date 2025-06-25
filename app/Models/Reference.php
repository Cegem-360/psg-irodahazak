<?php

declare(strict_types=1);

namespace App\Models;

<<<<<<< HEAD
=======
use App\Observers\ReferenceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
=======
#[ObservedBy(ReferenceObserver::class)]
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
final class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

<<<<<<< HEAD
    /**
     * Scope a query to only include active references.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by order field.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
=======
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('order');
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
    }
}
