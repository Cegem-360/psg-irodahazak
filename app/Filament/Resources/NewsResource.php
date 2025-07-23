<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages\CreateNews;
use App\Filament\Resources\NewsResource\Pages\EditNews;
use App\Filament\Resources\NewsResource\Pages\ListNews;
use App\Models\News;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
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
                Section::make('Alapadatok')
                    ->schema([
                        TextInput::make('title')
                            ->label('Cím')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->live()
                            ->afterStateUpdated(fn (string $operation, $state, Set $set): mixed => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(News::class, 'slug', ignoreRecord: true),
                        TextInput::make('source')
                            ->label('Forrás')
                            ->maxLength(255)
                            ->placeholder('Pl. https://example.com'),
                        RichEditor::make('excerpt')
                            ->label('Alcím')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Tartalom')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Tartalom')
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('featured_image')
                            ->label('Kiemelt kép')
                            ->image()
                            ->directory('news')
                            ->maxSize(2048),
                    ]),

                Section::make('Kategorizálás')
                    ->schema([
                        Select::make('news_category_id')
                            ->label('Kategória')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Név')
                                    ->required(),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required(),
                            ]),

                        Select::make('priority')
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

                        Toggle::make('is_breaking')
                            ->label('Fontos hír')
                            ->default(false),
                    ])
                    ->columns(3),

                Section::make('Publikálás')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publikált')
                            ->default(false)
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Publikálás időpontja')
                            ->visible(fn (Get $get): bool => $get('is_published'))
                            ->default(now()),

                        Select::make('user_id')
                            ->label('Szerző')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Metaadatok')
                    ->schema([
                        DateTimePicker::make('created_at')
                            ->label('Létrehozás időpontja')
                            ->disabled()
                            ->dehydrated(false),

                        DateTimePicker::make('updated_at')
                            ->label('Utolsó frissítés')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Kép')
                    ->square()
                    ->toggleable()
                    ->size(60),

                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->limit(50)
                    ->weight(FontWeight::Bold),

                TextColumn::make('category.name')
                    ->label('Kategória')
                    ->badge()
                    ->toggleable()
                    ->color(fn ($record) => $record->category?->color ?? 'gray'),

                TextColumn::make('author.name')
                    ->label('Szerző')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('priority_label')
                    ->label('Prioritás')
                    ->badge()
                    ->toggleable()
                    ->color(fn ($state): string => match ($state) {
                        'Kritikus' => 'danger',
                        'Sürgős' => 'warning',
                        'Magas' => 'info',
                        'Normál' => 'success',
                        'Alacsony' => 'gray',
                        default => 'gray',
                    }),

                IconColumn::make('is_breaking')
                    ->label('Fontos')
                    ->boolean()
                    ->toggleable()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning'),

                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->toggleable()
                    ->color(fn ($state): string => match ($state) {
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

                TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextInputColumn::make('published_at')
                    ->label('Publikálva')
                    ->type('date')
                    ->getStateUsing(fn ($record) => $record->published_at ? $record->published_at->format('Y-m-d') : '')
                    ->afterStateUpdated(function ($record, $state): void {
                        $record->update(['published_at' => $state]);
                    })
                    ->sortable()
                    ->toggleable(),

                TextInputColumn::make('updated_at')
                    ->label('Frissítve')
                    ->type('date')
                    ->getStateUsing(fn ($record) => $record->updated_at ? $record->updated_at->format('Y-m-d') : '')
                    ->afterStateUpdated(function ($record, $state): void {
                        $record->update(['updated_at' => $state]);
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('news_category_id')
                    ->label('Kategória')
                    ->relationship('category', 'name'),

                SelectFilter::make('priority')
                    ->label('Prioritás')
                    ->options([
                        1 => 'Alacsony',
                        2 => 'Normál',
                        3 => 'Magas',
                        4 => 'Sürgős',
                        5 => 'Kritikus',
                    ]),

                TernaryFilter::make('is_published')
                    ->label('Publikált'),

                TernaryFilter::make('is_breaking')
                    ->label('Fontos hír'),

                Filter::make('published_at')
                    ->form([
                        DatePicker::make('published_from')
                            ->label('Publikálva ettől'),
                        DatePicker::make('published_until')
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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('publish')
                    ->label('Publikálás')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(fn (News $record) => $record->publish())
                    ->visible(fn (News $record): bool => ! $record->is_published),
                Action::make('unpublish')
                    ->label('Publikálás visszavonása')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->action(fn (News $record) => $record->unpublish())
                    ->visible(fn (News $record) => $record->is_published),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('publish')
                        ->label('Publikálás')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(fn ($records) => $records->each->publish()),
                    BulkAction::make('unpublish')
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
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}
