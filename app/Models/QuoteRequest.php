<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InquirySubject;
use App\Enums\QuoteRequestStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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
    /**
     * Mirrors the column default.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => QuoteRequestStatus::New,
    ];

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function new(Builder $query): void
    {
        $query->where('status', QuoteRequestStatus::New);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function contacted(Builder $query): void
    {
        $query->where('status', QuoteRequestStatus::Contacted);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function closed(Builder $query): void
    {
        $query->where('status', QuoteRequestStatus::Closed);
    }

    protected function casts(): array
    {
        return [
            'status' => QuoteRequestStatus::class,
            'subject' => InquirySubject::class,
            'contacted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
