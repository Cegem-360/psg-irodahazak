<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Hírek';

    protected static ?string $modelLabel = 'hír';

    protected static ?string $pluralModelLabel = 'hírek';

    protected static ?string $navigationGroup = 'Hírek';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Cím')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(News::class, 'slug', ignoreRecord: true),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Kivonat')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Tartalom')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Tartalom')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Kiemelt kép')
                            ->image()
                            ->directory('news')
                            ->maxSize(2048),
                    ]),

                Forms\Components\Section::make('Kategorizálás')
                    ->schema([
                        Forms\Components\Select::make('news_category_id')
                            ->label('Kategória')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Név')
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required(),
                            ]),

                        Forms\Components\Select::make('priority')
                            ->label('Prioritás')
                            ->options([
                                1 => 'Alacsony',
                                2 => 'Normál',
                                3 => 'Magas',
                                4 => 'Sürgős',
                                5 => 'Kritikus',
                            ])
                            ->default(2)
                            ->required(),

                        Forms\Components\Toggle::make('is_breaking')
                            ->label('Fontos hír')
                            ->default(false),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Publikálás')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikált')
                            ->default(false)
                            ->live(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publikálás időpontja')
                            ->visible(fn (Forms\Get $get): bool => $get('is_published'))
                            ->default(now()),

                        Forms\Components\Select::make('user_id')
                            ->label('Szerző')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())
                            ->required(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Kép')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategória')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray'),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Szerző')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('priority_label')
                    ->label('Prioritás')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Kritikus' => 'danger',
                        'Sürgős' => 'warning',
                        'Magas' => 'info',
                        'Normál' => 'success',
                        'Alacsony' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_breaking')
                    ->label('Fontos')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'published' => 'success',
                        'scheduled' => 'info',
                        'draft' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'published' => 'Publikált',
                        'scheduled' => 'Ütemezett',
                        'draft' => 'Vázlat',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikálva')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('news_category_id')
                    ->label('Kategória')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('priority')
                    ->label('Prioritás')
                    ->options([
                        1 => 'Alacsony',
                        2 => 'Normál',
                        3 => 'Magas',
                        4 => 'Sürgős',
                        5 => 'Kritikus',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publikált'),

                Tables\Filters\TernaryFilter::make('is_breaking')
                    ->label('Fontos hír'),

                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Publikálva ettől'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Publikálva eddig'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Publikálás')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(fn (News $record) => $record->publish())
                    ->visible(fn (News $record) => ! $record->is_published),
                Tables\Actions\Action::make('unpublish')
                    ->label('Publikálás visszavonása')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->action(fn (News $record) => $record->unpublish())
                    ->visible(fn (News $record) => $record->is_published),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publikálás')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(fn ($records) => $records->each->publish()),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Publikálás visszavonása')
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->unpublish()),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
