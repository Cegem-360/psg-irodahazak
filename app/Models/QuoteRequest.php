<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'phone',
    'email',
    'company',
    'message',
    'subject',
    'status',
    'contacted_at',
    'notes',
])]
final class QuoteRequest extends Model
{
    use HasFactory;

    protected function statusColor(): Attribute
    {
        return Attribute::make(get: fn (): string => match ($this->status) {
            'new' => 'text-red-600 bg-red-100',
            'contacted' => 'text-yellow-600 bg-yellow-100',
            'closed' => 'text-green-600 bg-green-100',
            default => 'text-gray-600 bg-gray-100',
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(get: fn (): string => match ($this->status) {
            'new' => 'Új',
            'contacted' => 'Kapcsolatfelvéve',
            'closed' => 'Lezárva',
            default => 'Ismeretlen',
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function new($query): void
    {
        $query->where('status', 'new');
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function contacted($query): void
    {
        $query->where('status', 'contacted');
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function closed($query): void
    {
        $query->where('status', 'closed');
    }

    protected function casts(): array
    {
        return [
            'contacted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
