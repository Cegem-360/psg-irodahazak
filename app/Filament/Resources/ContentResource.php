<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContentResource\Pages\CreateContent;
use App\Filament\Resources\ContentResource\Pages\EditContent;
use App\Filament\Resources\ContentResource\Pages\ListContents;
use App\Models\Content;
use App\Models\Tag;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Tartalom';

    protected static ?string $modelLabel = 'Tartalom';

    protected static ?string $pluralModelLabel = 'Tartalom';

    protected static ?string $navigationGroup = 'Tartalomkezelés';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Cím')
                    ->maxLength(255),
                TextInput::make('status')
                    ->label('Státusz')
                    ->maxLength(255),
                RichEditor::make('lead')
                    ->label('Bevezető')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Tartalom')
                    ->columnSpanFull(),
                TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->label('Meta cím')
                    ->maxLength(255),
                Textarea::make('meta_keywords')
                    ->label('Meta kulcsszavak')
                    ->columnSpanFull(),
                Textarea::make('meta_description')
                    ->label('Meta leírás')
                    ->columnSpanFull(),
                TextInput::make('lang')
                    ->label('Nyelv')
                    ->maxLength(2)
                    ->default('HU'),
                Select::make('tags')
                    ->options(Tag::all()->pluck('name', 'id'))
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
                    ->label('Cím')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->searchable(),
                TextColumn::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->label('Meta cím')
                    ->searchable(),
                TextColumn::make('lang')
                    ->label('Nyelv')
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
