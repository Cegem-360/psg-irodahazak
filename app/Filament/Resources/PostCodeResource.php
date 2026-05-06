<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostCodeResource\Pages\CreatePostCode;
use App\Filament\Resources\PostCodeResource\Pages\EditPostCode;
use App\Filament\Resources\PostCodeResource\Pages\ListPostCodes;
use App\Models\PostCode;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class PostCodeResource extends Resource
{
    protected static ?string $model = PostCode::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Irányítószámok';

    protected static ?string $modelLabel = 'Irányítószám';

    protected static ?string $pluralModelLabel = 'Irányítószámok';

    protected static string|UnitEnum|null $navigationGroup = 'Rendszer';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
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
