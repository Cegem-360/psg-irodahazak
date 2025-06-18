<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Blog Bejegyzések';

    protected static ?string $modelLabel = 'Blog Bejegyzés';

    protected static ?string $pluralModelLabel = 'Blog Bejegyzések';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
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
                                    ->label('URL slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(BlogPost::class, 'slug', ignoreRecord: true)
                                    ->helperText('Automatikusan generálódik a címből'),

                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Kivonat')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->helperText('Rövid összefoglaló a bejegyzésről. Automatikusan generálódik a tartalomból, ha üresen hagyod.'),
                            ]),

                        Forms\Components\Section::make('Tartalom')
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->label('Tartalom')
                                    ->required()
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Beállítások')
                            ->schema([
                                Forms\Components\Select::make('blog_category_id')
                                    ->label('Kategória')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Név')
                                            ->required(),
                                        Forms\Components\ColorPicker::make('color')
                                            ->label('Szín')
                                            ->default('#3B82F6'),
                                    ]),

                                Forms\Components\Select::make('user_id')
                                    ->label('Szerző')
                                    ->relationship('author', 'name')
                                    ->default(Auth::id())
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Toggle::make('is_published')
                                    ->label('Publikált')
                                    ->default(false)
                                    ->live(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publikálás dátuma')
                                    ->default(now())
                                    ->visible(fn (Forms\Get $get): bool => $get('is_published'))
                                    ->required(fn (Forms\Get $get): bool => $get('is_published')),
                            ]),

                        Forms\Components\Section::make('Kép')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Kiemelt kép')
                                    ->image()
                                    ->directory('blog')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ]),
                            ]),

                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\KeyValue::make('meta_data')
                                    ->label('Meta adatok')
                                    ->keyLabel('Kulcs')
                                    ->valueLabel('Érték')
                                    ->addActionLabel('Meta adat hozzáadása')
                                    ->default([
                                        'meta_title' => '',
                                        'meta_description' => '',
                                        'meta_keywords' => '',
                                    ]),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Kép')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategória')
                    ->badge()
                    ->color(fn (BlogPost $record): string => $record->category->color ?? 'primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Szerző')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'scheduled' => 'warning',
                        'draft' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Publikált',
                        'scheduled' => 'Ütemezett',
                        'draft' => 'Vázlat',
                        default => 'Ismeretlen',
                    }),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikálva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategória')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Szerző')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('status')
                    ->label('Státusz')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'published' => 'Publikált',
                                'scheduled' => 'Ütemezett',
                                'draft' => 'Vázlat',
                            ])
                            ->placeholder('Válassz státuszt'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['status'], function (Builder $query, string $status): Builder {
                            return match ($status) {
                                'published' => $query->where('is_published', true)
                                    ->whereNotNull('published_at')
                                    ->where('published_at', '<=', now()),
                                'scheduled' => $query->where('is_published', true)
                                    ->whereNotNull('published_at')
                                    ->where('published_at', '>', now()),
                                'draft' => $query->where('is_published', false),
                                default => $query,
                            };
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_publish')
                    ->label(fn (BlogPost $record): string => $record->is_published ? 'Visszavonás' : 'Publikálás')
                    ->icon(fn (BlogPost $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (BlogPost $record): string => $record->is_published ? 'warning' : 'success')
                    ->action(function (BlogPost $record): void {
                        if ($record->is_published) {
                            $record->unpublish();
                        } else {
                            $record->publish();
                        }
                    })
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publikálás')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each->publish();
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Visszavonás')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each->unpublish();
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
