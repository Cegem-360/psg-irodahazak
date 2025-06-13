<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Imports\PageImporter;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->required()
                    ->maxLength(255),
                TextInput::make('ord')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('template')
                    ->required()
                    ->maxLength(150),
                TextInput::make('parent_id')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('need_login')
                    ->maxLength(25),
                TextInput::make('show_menu')
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('date'),
                TextInput::make('type')
                    ->maxLength(100),
                Textarea::make('content_json')
                    ->columnSpanFull(),
                TextInput::make('title_url')
                    ->maxLength(255),
                TextInput::make('sow_just_super_admin')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('content_category_id')
                    ->numeric(),
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
                TextColumn::make('url')
                    ->searchable(),
                TextColumn::make('ord')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('template')
                    ->searchable(),
                TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('need_login')
                    ->searchable(),
                TextColumn::make('show_menu')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('title_url')
                    ->searchable(),
                TextColumn::make('sow_just_super_admin')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('content_category_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make()->importer(PageImporter::class),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
