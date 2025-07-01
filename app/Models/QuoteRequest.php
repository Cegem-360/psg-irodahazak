<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;

final class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'message',
        'subject',
        'status',
        'contacted_at',
        'notes',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new' => 'text-red-600 bg-red-100',
            'contacted' => 'text-yellow-600 bg-yellow-100',
            'closed' => 'text-green-600 bg-green-100',
            default => 'text-gray-600 bg-gray-100',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new' => 'Új',
            'contacted' => 'Kapcsolatfelvéve',
            'closed' => 'Lezárva',
            default => 'Ismeretlen',
        };
    }

    #[Scope]
    protected function new($query): void
    {
        $query->where('status', 'new');
    }

    #[Scope]
    protected function contacted($query): void
    {
        $query->where('status', 'contacted');
    }

    #[Scope]
    protected function closed($query): void
    {
        $query->where('status', 'closed');
    }
}
