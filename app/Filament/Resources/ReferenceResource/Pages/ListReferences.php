<?php

<<<<<<< HEAD
declare(strict_types=1);

=======
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
namespace App\Filament\Resources\ReferenceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ReferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

<<<<<<< HEAD
final class ListReferences extends ListRecords
{
    protected static string $resource = ReferenceResource::class;

    public function getTitle(): string
    {
        return 'Referenciák';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Új referencia'),
=======
class ListReferences extends ListRecords
{
    protected static string $resource = ReferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
        ];
    }
}
