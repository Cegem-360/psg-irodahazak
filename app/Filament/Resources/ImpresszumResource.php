<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ImpresszumResource\Pages\CreateImpresszum;
use App\Filament\Resources\ImpresszumResource\Pages\EditImpresszum;
use App\Filament\Resources\ImpresszumResource\Pages\ListImpresszums;
use App\Models\Impresszum;
use BackedEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

final class ImpresszumResource extends Resource
{
    protected static ?string $model = Impresszum::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Impresszum';

    protected static ?string $modelLabel = 'impresszum';

    protected static ?string $pluralModelLabel = 'impresszumok';

    protected static string|UnitEnum|null $navigationGroup = 'Tartalom';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Impresszum tartalma')
                    ->schema([
                        Select::make('language')
                            ->label('Nyelv')
                            ->options([
                                'hu' => 'Magyar',
                                'en' => 'English',
                            ])
                            ->default('hu')
                            ->required(),

                        TextInput::make('title')
                            ->label('Cím')
                            ->required()
                            ->maxLength(255)
                            ->default('Impresszum'),

                        RichEditor::make('content')
                            ->label('Tartalom')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Aktív')
                            ->default(false)
                            ->helperText('Csak egy impresszum lehet aktív nyelvenkénti egyszerre'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('language')
                    ->label('Nyelv')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'hu' => 'Magyar',
                        'en' => 'English',
                        default => $state,
                    })
                    ->color(fn ($state): string => match ($state) {
                        'hu' => 'success',
                        'en' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

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
                SelectFilter::make('language')
                    ->label('Nyelv')
                    ->options([
                        'hu' => 'Magyar',
                        'en' => 'English',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->defaultSort('language', 'asc');
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
            'index' => ListImpresszums::route('/'),
            'create' => CreateImpresszum::route('/create'),
            'edit' => EditImpresszum::route('/{record}/edit'),
        ];
    }
}
