<?php

declare(strict_types=1);

namespace App\Filament\Resources\BlogCategoryResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

final class BlogPostsRelationManager extends RelationManager
{
    protected static string $relationship = 'blogPosts';

    protected static ?string $title = 'Blog Bejegyzések';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Cím')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Szerző')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Publikált')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),

                TextColumn::make('published_at')
                    ->label('Publikálva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->badge()
                    ->color('primary'),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Publikált')
                    ->placeholder('Mindegyik')
                    ->trueLabel('Publikált')
                    ->falseLabel('Vázlat'),
            ])
            ->headerActions([
                // A bejegyzéseket a BlogPostResource-ban hozzuk létre
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.blog-posts.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Bulk műveletek
            ]);
    }
}
