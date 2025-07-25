<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages\CreateContactPage;
use App\Filament\Resources\ContactPageResource\Pages\EditContactPage;
use App\Filament\Resources\ContactPageResource\Pages\ListContactPages;
use App\Models\ContactPage;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

final class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Kapcsolati oldal';

    protected static ?string $modelLabel = 'Kapcsolati oldal';

    protected static ?string $pluralModelLabel = 'Kapcsolati oldalak';

    protected static ?string $navigationGroup = 'Tartalom';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('language')
                    ->label('Nyelv')
                    ->options([
                        'hu' => 'Magyar',
                        'en' => 'English',
                    ])
                    ->required()
                    ->default('hu'),
                TiptapEditor::make('content')
                    ->label('Kapcsolati információk')
                    ->profile('default')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            'index' => ListContactPages::route('/'),
            'create' => CreateContactPage::route('/create'),
            'edit' => EditContactPage::route('/{record}/edit'),
        ];
    }
}
