<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PostCodeResource\Pages\ListPostCodes;
use App\Filament\Resources\PostCodeResource\Pages\CreatePostCode;
use App\Filament\Resources\PostCodeResource\Pages\EditPostCode;
use App\Filament\Resources\PostCodeResource\Pages;
use App\Filament\Resources\PostCodeResource\RelationManagers;
use App\Models\PostCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostCodeResource extends Resource
{
    protected static ?string $model = PostCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('iranyitoszam')
                    ->required()
                    ->maxLength(4),
                TextInput::make('helyiseg')
                    ->required()
                    ->maxLength(64),
                TextInput::make('megye')
                    ->required()
                    ->maxLength(64),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('iranyitoszam')
                    ->searchable(),
                TextColumn::make('helyiseg')
                    ->searchable(),
                TextColumn::make('megye')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
