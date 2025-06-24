<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'property_id',
        'property_name',
        'status',
        'contacted_at',
        'notes',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

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
}
