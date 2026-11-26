<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ArticlePageKey;
use App\Filament\Resources\ArticlePageResource\Pages\EditArticlePage;
use App\Filament\Resources\ArticlePageResource\Pages\ListArticlePages;
use App\Models\ArticlePage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

/**
 * The fixed article pages (rental fee overview, operating fee article). Their
 * routes are in the code, so records are only edited, never created or deleted.
 */
final class ArticlePageResource extends Resource
{
    protected static ?string $model = ArticlePage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Díjak és cikkek';

    protected static ?string $modelLabel = 'cikkoldal';

    protected static ?string $pluralModelLabel = 'díjak és cikkek';

    protected static string|UnitEnum|null $navigationGroup = 'Tartalom';

    protected static ?int $navigationSort = 3;

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Cím, keresőtalálat és dátumok')
                    ->columns(2)
                    ->schema([
                        TextInput::make('headline')
                            ->label('Főcím (H1)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('short_title')
                            ->label('Rövid cím')
                            ->helperText('A morzsamenüben és a láblécben.')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('link_label')
                            ->label('Hivatkozás szövege')
                            ->helperText('Az ingatlan-adatlapok bérleti díja alatt és a bevezető nélküli kategóriaoldalakon.')
                            ->maxLength(255)
                            ->visible(fn (?ArticlePage $record): bool => $record?->key === ArticlePageKey::RentalFees),
                        TextInput::make('meta_title')
                            ->label('Keresőben megjelenő cím (title)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Keresőben megjelenő leírás (meta description)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        DatePicker::make('published_on')
                            ->label('Megjelenés dátuma')
                            ->required(),
                        DatePicker::make('last_updated_on')
                            ->label('Utolsó frissítés')
                            ->helperText('Az oldalon látható dátum és a keresőknek jelzett módosítási dátum.')
                            ->required()
                            ->afterOrEqual('published_on'),
                    ]),
                Section::make('Szöveg')
                    ->schema([
                        RichEditor::make('body')
                            ->label('Cikk szövege')
                            ->helperText('A főcím és a dátum alatt, a gyakori kérdések előtt. A táblázat celláiba kattintva a sorok és oszlopok a táblázat-gombokkal bővíthetők vagy törölhetők.')
                            ->required()
                            ->toolbarButtons([
                                ['bold', 'italic', 'link', 'small'],
                                ['h2', 'h3', 'paragraph'],
                                ['blockquote', 'bulletList', 'orderedList'],
                                ['table', 'tableAddRowAfter', 'tableDeleteRow', 'tableAddColumnAfter', 'tableDeleteColumn', 'tableToggleHeaderCell'],
                                ['undo', 'redo'],
                            ]),
                        RichEditor::make('cta')
                            ->label('Ajánlatkérő doboz szövege')
                            ->helperText('Az „Ajánlatot kérek” gomb fölött.')
                            ->toolbarButtons(['bold', 'italic', 'link', 'undo', 'redo']),
                    ]),
                Section::make('Gyakori kérdések')
                    ->description('Az oldalon és a keresőknek szóló FAQ-adatban is szó szerint ez jelenik meg.')
                    ->schema([
                        Repeater::make('faqs')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('question')
                                    ->label('Kérdés')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('answer')
                                    ->label('Válasz')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->addActionLabel('Új kérdés')
                            ->reorderable()
                            ->collapsible()
                            ->minItems(1),
                    ]),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Oldal'),
                TextColumn::make('headline')
                    ->label('Főcím')
                    ->limit(80),
                TextColumn::make('last_updated_on')
                    ->label('Utolsó frissítés')
                    ->date('Y. m. d.'),
            ])
            ->paginated(false)
            ->recordActions([
                EditAction::make(),
                Action::make('open')
                    ->label('Megnyitás')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (ArticlePage $record): string => $record->key->url())
                    ->openUrlInNewTab(),
            ]);
    }

    #[Override]
    public static function canCreate(): bool
    {
        return false;
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListArticlePages::route('/'),
            'edit' => EditArticlePage::route('/{record}/edit'),
        ];
    }
}
