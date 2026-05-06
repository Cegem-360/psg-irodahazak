<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages\CreateAboutUs;
use App\Filament\Resources\AboutUsResource\Pages\EditAboutUs;
use App\Filament\Resources\AboutUsResource\Pages\ListAboutUs;
use App\Models\AboutUs;
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

final class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Rólunk';

    protected static ?string $modelLabel = 'rólunk oldal';

    protected static ?string $pluralModelLabel = 'rólunk oldalak';

    protected static string|UnitEnum|null $navigationGroup = 'Tartalom';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Rólunk oldal tartalma')
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
                            ->maxLength(255),

                        RichEditor::make('content')
                            ->label('Tartalom')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Aktív')
                            ->default(false)
                            ->helperText('Csak egy rólunk oldal lehet aktív nyelvenkénti egyszerre'),
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
            'index' => ListAboutUs::route('/'),
            'create' => CreateAboutUs::route('/create'),
            'edit' => EditAboutUs::route('/{record}/edit'),
        ];
    }
}
