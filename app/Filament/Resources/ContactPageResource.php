<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages\CreateContactPage;
use App\Filament\Resources\ContactPageResource\Pages\EditContactPage;
use App\Filament\Resources\ContactPageResource\Pages\ListContactPages;
use App\Models\ContactPage;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Kapcsolati oldal';

    protected static ?string $modelLabel = 'Kapcsolati oldal';

    protected static ?string $pluralModelLabel = 'Kapcsolati oldalak';

    protected static string|UnitEnum|null $navigationGroup = 'Tartalom';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('language')
                    ->label('Nyelv')
                    ->options([
                        'hu' => 'Magyar',
                        'en' => 'English',
                    ])
                    ->required()
                    ->default('hu'),
                RichEditor::make('content')
                    ->label('Kapcsolati információk')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Kapcsolati oldal kép')
                    ->image()
                    ->downloadable()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('contact-pages')
                    ->visibility('public')
                    ->maxSize(2048), // 2 MB
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->columns([
                TextColumn::make('language')
                    ->label('Nyelv')
                    ->searchable(),
                TextColumn::make('content')
                    ->label('Tartalom')
                    ->html()
                    ->limit(100)
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Utolsó módosítás')
                    ->dateTime()
                    ->sortable(),
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
            'index' => ListContactPages::route('/'),
            'create' => CreateContactPage::route('/create'),
            'edit' => EditContactPage::route('/{record}/edit'),
        ];
    }
}
