<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

<<<<<<< HEAD
use Filament\Actions\ViewAction;
=======
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
use Filament\Actions\DeleteAction;
use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonial extends EditRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
<<<<<<< HEAD
            ViewAction::make(),
=======
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
            DeleteAction::make(),
        ];
    }
}
