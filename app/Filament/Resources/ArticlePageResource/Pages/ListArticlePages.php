<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticlePageResource\Pages;

use App\Filament\Resources\ArticlePageResource;
use Filament\Resources\Pages\ListRecords;

final class ListArticlePages extends ListRecords
{
    protected static string $resource = ArticlePageResource::class;
}
