<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ContentResource\Pages\ListContents;
use App\Filament\Resources\ContentResource\Pages\CreateContent;
use App\Filament\Resources\ContentResource\Pages\EditContent;
use App\Filament\Resources\ContentResource\Pages;
use App\Filament\Resources\ContentResource\RelationManagers;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255),
                TextInput::make('status')
                    ->maxLength(255),
                Textarea::make('lead')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->columnSpanFull(),
                DateTimePicker::make('date'),
                TextInput::make('ord')
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->maxLength(255),
                Textarea::make('meta_keywords')
                    ->columnSpanFull(),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                TextInput::make('lang')
                    ->maxLength(2)
                    ->default('HU'),
                Textarea::make('cimke_json')
                    ->columnSpanFull(),
                TextInput::make('lead_pic')
                    ->maxLength(255),
                TextInput::make('sdf')
                    ->maxLength(255),
                TextInput::make('file')
                    ->maxLength(255),
                TextInput::make('ok')
                    ->numeric()
                    ->default(0),
                TextInput::make('mysep')
                    ->maxLength(255),
                TextInput::make('link')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ord')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('lang')
                    ->searchable(),
                TextColumn::make('lead_pic')
                    ->searchable(),
                TextColumn::make('sdf')
                    ->searchable(),
                TextColumn::make('file')
                    ->searchable(),
                TextColumn::make('ok')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('mysep')
                    ->searchable(),
                TextColumn::make('link')
                    ->searchable(),
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
            'index' => ListContents::route('/'),
            'create' => CreateContent::route('/create'),
            'edit' => EditContent::route('/{record}/edit'),
        ];
    }
}
