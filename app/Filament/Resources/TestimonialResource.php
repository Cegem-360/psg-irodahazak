<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Rólunk mondták';

    protected static ?string $modelLabel = 'Vélemény';

    protected static ?string $pluralModelLabel = 'Vélemények';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ügyfél adatok')
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->label('Ügyfél neve')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('client_position')
                            ->label('Pozíció')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('client_company')
                            ->label('Cég')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('client_image')
                            ->label('Ügyfél képe')
                            ->image()
                            ->directory('testimonials/clients'),
                        Forms\Components\FileUpload::make('company_logo')
                            ->label('Cég logó')
                            ->image()
                            ->directory('testimonials/logos'),
                    ])->columns(2),

                Forms\Components\Section::make('Vélemény')
                    ->schema([
                        Forms\Components\Textarea::make('testimonial')
                            ->label('Vélemény szöveg')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('rating')
                            ->label('Értékelés')
                            ->options([
                                1 => '1 csillag',
                                2 => '2 csillag',
                                3 => '3 csillag',
                                4 => '4 csillag',
                                5 => '5 csillag',
                            ])
                            ->default(5)
                            ->required(),
                        Forms\Components\TextInput::make('project_type')
                            ->label('Projekt típus')
                            ->maxLength(255)
                            ->placeholder('pl. Iroda bérlés, Ingatlan eladás'),
                    ])->columns(2),

                Forms\Components\Section::make('Beállítások')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Kiemelt')
                            ->helperText('Kiemelt vélemények a főoldalon jelennek meg'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktív')
                            ->default(true)
                            ->helperText('Csak az aktív vélemények jelennek meg a weboldalon'),
                        Forms\Components\TextInput::make('order')
                            ->label('Sorrend')
                            ->numeric()
                            ->default(0)
                            ->helperText('Kisebb szám = előrébb jelenik meg'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Ügyfél')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_company')
                    ->label('Cég')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('testimonial')
                    ->label('Vélemény')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (mb_strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Értékelés')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '5' => 'success',
                        '4' => 'info',
                        '3' => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => $state.' ⭐')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Kiemelt')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Kiemelt')
                    ->placeholder('Összes')
                    ->trueLabel('Csak kiemelt')
                    ->falseLabel('Nem kiemelt'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Státusz')
                    ->placeholder('Összes')
                    ->trueLabel('Aktív')
                    ->falseLabel('Inaktív'),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Értékelés')
                    ->options([
                        5 => '5 csillag',
                        4 => '4 csillag',
                        3 => '3 csillag',
                        2 => '2 csillag',
                        1 => '1 csillag',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order')
            ->reorderable('order');
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
