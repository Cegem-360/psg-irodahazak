<?php

declare(strict_types=1);

namespace App\Actions;

use App\Services\FavoriteProperties;
use App\Services\FavoritesExcelExportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Downloads the visitor's favorite properties as an Excel sheet.
 */
final readonly class ExportFavorites
{
    public function __construct(
        private FavoriteProperties $favorites,
        private FavoritesExcelExportService $export,
    ) {}

    public function __invoke(): StreamedResponse
    {
        return $this->export->generate($this->favorites->properties());
    }
}
