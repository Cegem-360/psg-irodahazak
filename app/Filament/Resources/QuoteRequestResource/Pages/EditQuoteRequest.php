<?php

declare(strict_types=1);

namespace App\Filament\Resources\QuoteRequestResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\QuoteRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditQuoteRequest extends EditRecord
{
    protected static string $resource = QuoteRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
