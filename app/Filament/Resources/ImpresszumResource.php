<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ImpresszumResource\Pages\CreateImpresszum;
use App\Filament\Resources\ImpresszumResource\Pages\EditImpresszum;
use App\Filament\Resources\ImpresszumResource\Pages\ListImpresszums;
use App\Models\Impresszum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class ImpresszumResource extends Resource
{
    protected static ?string $model = Impresszum::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Impresszum';

    protected static ?string $modelLabel = 'impresszum';

    protected static ?string $pluralModelLabel = 'impresszumok';

    protected static ?string $navigationGroup = 'Tartalom';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Impresszum tartalma')
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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
