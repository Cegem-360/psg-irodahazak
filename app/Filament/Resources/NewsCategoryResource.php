<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsCategoryResource\Pages\CreateNewsCategory;
use App\Filament\Resources\NewsCategoryResource\Pages\EditNewsCategory;
use App\Filament\Resources\NewsCategoryResource\Pages\ListNewsCategories;
use App\Models\NewsCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class NewsCategoryResource extends Resource
{
    protected static ?string $model = NewsCategory::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Hírkategóriák';

    protected static ?string $modelLabel = 'hírkategória';

    protected static ?string $pluralModelLabel = 'hírkategóriák';

    protected static ?string $navigationGroup = 'Hírek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Név')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Set $set): mixed => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(NewsCategory::class, 'slug', ignoreRecord: true),

                Textarea::make('description')
                    ->label('Leírás')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                ColorPicker::make('color')
                    ->label('Szín')
                    ->default('#3B82F6'),

                TextInput::make('icon')
                    ->label('Ikon')
                    ->maxLength(255)
                    ->placeholder('🏢'),

                TextInput::make('sort_order')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktív')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Név')
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),

                ColorColumn::make('color')
                    ->label('Szín'),

                TextColumn::make('icon')
                    ->label('Ikon'),

                TextColumn::make('news_count')
                    ->label('Hírek száma')
                    ->counts('news'),

                TextColumn::make('sort_order')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),

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
                TernaryFilter::make('is_active')
                    ->label('Aktív'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => ListNewsCategories::route('/'),
            'create' => CreateNewsCategory::route('/create'),
            'edit' => EditNewsCategory::route('/{record}/edit'),
        ];
    }
}
