<?php

declare(strict_types=1);

namespace App\Filament\Resources\QuoteRequestResource\Pages;

use App\Filament\Resources\QuoteRequestResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateQuoteRequest extends CreateRecord
{
    protected static string $resource = QuoteRequestResource::class;
}
