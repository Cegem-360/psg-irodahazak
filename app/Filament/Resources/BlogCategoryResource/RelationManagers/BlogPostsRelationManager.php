<?php

declare(strict_types=1);

namespace App\Filament\Resources\BlogCategoryResource\RelationManagers;

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
                Forms\Components\TextInput::make('title')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Szerző')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publikált')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikálva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Megtekintések')
                    ->badge()
                    ->color('primary'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publikált')
                    ->placeholder('Mindegyik')
                    ->trueLabel('Publikált')
                    ->falseLabel('Vázlat'),
            ])
            ->headerActions([
                // A bejegyzéseket a BlogPostResource-ban hozzuk létre
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.blog-posts.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Bulk műveletek
            ]);
    }
}
