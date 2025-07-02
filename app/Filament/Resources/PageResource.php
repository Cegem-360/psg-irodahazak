<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Imports\PageImporter;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
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

    protected static ?string $navigationLabel = 'Oldalak';

    protected static ?string $modelLabel = 'Oldal';

    protected static ?string $pluralModelLabel = 'Oldalak';

    protected static ?string $navigationGroup = 'Tartalom';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Cím')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->maxLength(255),
                TextInput::make('ord')
                    ->label('Sorrend')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('template')
                    ->label('Sablon')
                    ->required()
                    ->maxLength(150),
                TextInput::make('parent_id')
                    ->label('Szülő ID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('show_menu')
                    ->label('Megjelenés menüben')
                    ->numeric()
                    ->default(0),
                TextInput::make('type')
                    ->label('Típus')
                    ->maxLength(100),
                Textarea::make('content_json')
                    ->label('Tartalom JSON')
                    ->columnSpanFull(),
                TextInput::make('title_url')
                    ->label('Cím URL')
                    ->maxLength(255),
                TextInput::make('sow_just_super_admin')
                    ->label('Csak superadmin')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('content_category_id')
                    ->label('Tartalom kategória ID')
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
                    ->label('Cím')
                    ->searchable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable(),
                TextColumn::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('template')
                    ->label('Sablon')
                    ->searchable(),
                TextColumn::make('parent_id')
                    ->label('Szülő ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('show_menu')
                    ->label('Menü')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Típus')
                    ->searchable(),
                TextColumn::make('title_url')
                    ->label('Cím URL')
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
