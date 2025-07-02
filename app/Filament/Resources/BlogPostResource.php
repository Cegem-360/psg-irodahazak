<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages\CreateBlogPost;
use App\Filament\Resources\BlogPostResource\Pages\EditBlogPost;
use App\Filament\Resources\BlogPostResource\Pages\ListBlogPosts;
use App\Models\BlogPost;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Alapadatok')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Cím')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Set $set): mixed => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                TextInput::make('slug')
                                    ->label('URL slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(BlogPost::class, 'slug', ignoreRecord: true)
                                    ->helperText('Automatikusan generálódik a címből'),

                                Textarea::make('excerpt')
                                    ->label('Kivonat')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->helperText('Rövid összefoglaló a bejegyzésről. Automatikusan generálódik a tartalomból, ha üresen hagyod.'),
                            ]),

                        Section::make('Tartalom')
                            ->schema([
                                RichEditor::make('content')
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

                Group::make()
                    ->schema([
                        Section::make('Beállítások')
                            ->schema([
                                Select::make('blog_category_id')
                                    ->label('Kategória')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Név')
                                            ->required(),
                                        ColorPicker::make('color')
                                            ->label('Szín')
                                            ->default('#3B82F6'),
                                    ]),

                                Select::make('user_id')
                                    ->label('Szerző')
                                    ->relationship('author', 'name')
                                    ->default(Auth::id())
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Toggle::make('is_published')
                                    ->label('Publikált')
                                    ->default(false)
                                    ->live(),

                                DateTimePicker::make('published_at')
                                    ->label('Publikálás dátuma')
                                    ->default(now())
                                    ->visible(fn (Get $get): bool => $get('is_published'))
                                    ->required(fn (Get $get): bool => $get('is_published')),
                            ]),

                        Section::make('Kép')
                            ->schema([
                                FileUpload::make('featured_image')
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

                        Section::make('SEO')
                            ->schema([
                                KeyValue::make('meta_data')
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
                ImageColumn::make('featured_image')
                    ->label('Kép')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('category.name')
                    ->label('Kategória')
                    ->badge()
                    ->color(fn (BlogPost $record): string => $record->category->color ?? 'primary')
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Szerző')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
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

                TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('published_at')
                    ->label('Publikálva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('blog_category_id')
                    ->label('Kategória')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user_id')
                    ->label('Szerző')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('status')
                    ->label('Státusz')
                    ->form([
                        Select::make('status')
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
                ViewAction::make(),
                EditAction::make(),
                Action::make('toggle_publish')
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
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('publish')
                        ->label('Publikálás')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $records->each->publish();
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('unpublish')
                        ->label('Visszavonás')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function (Collection $records): void {
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
            'index' => ListBlogPosts::route('/'),
            'create' => CreateBlogPost::route('/create'),
            'edit' => EditBlogPost::route('/{record}/edit'),
        ];
    }
}
