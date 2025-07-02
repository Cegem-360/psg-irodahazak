<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostCodeResource\Pages\CreatePostCode;
use App\Filament\Resources\PostCodeResource\Pages\EditPostCode;
use App\Filament\Resources\PostCodeResource\Pages\ListPostCodes;
use App\Models\PostCode;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PostCodeResource extends Resource
{
    protected static ?string $model = PostCode::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Irányítószámok';

    protected static ?string $modelLabel = 'Irányítószám';

    protected static ?string $pluralModelLabel = 'Irányítószámok';

    protected static ?string $navigationGroup = 'Rendszer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('iranyitoszam')
                    ->label('Irányítószám')
                    ->required()
                    ->maxLength(4),
                TextInput::make('helyiseg')
                    ->label('Helység')
                    ->required()
                    ->maxLength(64),
                TextInput::make('megye')
                    ->label('Megye')
                    ->required()
                    ->maxLength(64),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('iranyitoszam')
                    ->label('Irányítószám')
                    ->searchable(),
                TextColumn::make('helyiseg')
                    ->label('Helység')
                    ->searchable(),
                TextColumn::make('megye')
                    ->label('Megye')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Frissítve')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostCodes::route('/'),
            'create' => CreatePostCode::route('/create'),
            'edit' => EditPostCode::route('/{record}/edit'),
        ];
    }
}
