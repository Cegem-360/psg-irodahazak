<?php

namespace App\Filament\Resources;

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
                Forms\Components\TextInput::make('iranyitoszam')
                    ->required()
                    ->maxLength(4),
                Forms\Components\TextInput::make('helyiseg')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('megye')
                    ->required()
                    ->maxLength(64),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iranyitoszam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('helyiseg')
                    ->searchable(),
                Tables\Columns\TextColumn::make('megye')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPostCodes::route('/'),
            'create' => Pages\CreatePostCode::route('/create'),
            'edit' => Pages\EditPostCode::route('/{record}/edit'),
        ];
    }
}
