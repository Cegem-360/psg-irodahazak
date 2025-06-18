<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Filament\Resources\BlogCategoryResource\RelationManagers;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Blog Kategóriák';

    protected static ?string $modelLabel = 'Blog Kategória';

    protected static ?string $pluralModelLabel = 'Blog Kategóriák';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Név')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(BlogCategory::class, 'slug', ignoreRecord: true)
                            ->helperText('Automatikusan generálódik a névből'),

                        Forms\Components\Textarea::make('description')
                            ->label('Leírás')
                            ->maxLength(500)
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Megjelenés')
                    ->schema([
                        Forms\Components\ColorPicker::make('color')
                            ->label('Szín')
                            ->default('#3B82F6')
                            ->helperText('A kategória színe'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktív')
                            ->default(true)
                            ->helperText('Inaktív kategóriák nem jelennek meg a weboldalon'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Név')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Szín'),

                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Bejegyzések száma')
                    ->getStateUsing(fn (BlogCategory $record): int => $record->blogPosts()->count())
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Státusz')
                    ->placeholder('Mindegyik')
                    ->trueLabel('Aktív')
                    ->falseLabel('Inaktív'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BlogPostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
