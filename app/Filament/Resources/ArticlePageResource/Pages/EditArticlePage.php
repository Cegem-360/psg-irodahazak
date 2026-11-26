<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticlePageResource\Pages;

use App\Filament\Resources\ArticlePageResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class EditArticlePage extends EditRecord
{
    protected static string $resource = ArticlePageResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('open')
                ->label('Megnyitás')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->url(fn (): string => $this->getRecord()->key->url())
                ->openUrlInNewTab(),
        ];
    }
}
