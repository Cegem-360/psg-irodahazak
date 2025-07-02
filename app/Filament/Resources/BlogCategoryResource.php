<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages\CreateBlogCategory;
use App\Filament\Resources\BlogCategoryResource\Pages\EditBlogCategory;
use App\Filament\Resources\BlogCategoryResource\Pages\ListBlogCategories;
use App\Filament\Resources\BlogCategoryResource\RelationManagers\BlogPostsRelationManager;
use App\Models\BlogCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
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

final class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Blog Kategóriák';

    protected static ?string $modelLabel = 'Blog Kategória';

    protected static ?string $pluralModelLabel = 'Blog Kategóriák';

    protected static ?string $navigationGroup = 'Blog';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Alapadatok')
                    ->schema([
                        TextInput::make('name')
                            ->label('Név')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set): mixed => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->label('URL slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(BlogCategory::class, 'slug', ignoreRecord: true)
                            ->helperText('Automatikusan generálódik a névből'),

                        Textarea::make('description')
                            ->label('Leírás')
                            ->maxLength(500)
                            ->rows(3),
                    ])->columns(2),

                Section::make('Megjelenés')
                    ->schema([
                        ColorPicker::make('color')
                            ->label('Szín')
                            ->default('#3B82F6')
                            ->helperText('A kategória színe'),

                        Toggle::make('is_active')
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
                TextColumn::make('name')
                    ->label('Név')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ColorColumn::make('color')
                    ->label('Szín'),

                TextColumn::make('posts_count')
                    ->label('Bejegyzések száma')
                    ->getStateUsing(fn (BlogCategory $record): int => $record->blogPosts()->count())
                    ->badge()
                    ->color('primary'),

                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Státusz')
                    ->placeholder('Mindegyik')
                    ->trueLabel('Aktív')
                    ->falseLabel('Inaktív'),
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
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            BlogPostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogCategories::route('/'),
            'create' => CreateBlogCategory::route('/create'),
            'edit' => EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
