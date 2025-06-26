<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
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

final class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Rólunk';

    protected static ?string $modelLabel = 'rólunk oldal';

    protected static ?string $pluralModelLabel = 'rólunk oldalak';

    protected static ?string $navigationGroup = 'Tartalom';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Rólunk oldal tartalma')
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
                    ->color(fn ($state) => match ($state) {
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}
