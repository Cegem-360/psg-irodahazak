<?php

declare(strict_types=1);

namespace App\Filament\Resources;

<<<<<<< HEAD
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Filament\Resources\TestimonialResource\Pages\ViewTestimonial;
=======
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
<<<<<<< HEAD
                TextInput::make('client_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('client_position')
                    ->maxLength(255),
                TextInput::make('client_company')
                    ->maxLength(255),
                Textarea::make('testimonial')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('client_image')
                    ->image(),
                TextInput::make('company_logo')
                    ->maxLength(255),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(5),
                TextInput::make('project_type')
                    ->maxLength(255),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('lang')
                    ->required()
                    ->options([
                        'hu' => 'Magyar',
                        'en' => 'Angol',
                    ])
                    ->default('hu'),
=======
                Section::make('Ügyfél adatok')
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Ügyfél neve')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_position')
                            ->label('Pozíció')
                            ->maxLength(255),
                        TextInput::make('client_company')
                            ->label('Cég')
                            ->maxLength(255),
                        FileUpload::make('client_image')
                            ->label('Ügyfél képe')
                            ->image()
                            ->directory('testimonials/clients'),
                        FileUpload::make('company_logo')
                            ->label('Cég logó')
                            ->image()
                            ->directory('testimonials/logos'),
                    ])->columns(2),
                    
                Section::make('Vélemény')
                    ->schema([
                        Textarea::make('testimonial')
                            ->label('Vélemény szöveg')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Select::make('rating')
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
                        TextInput::make('project_type')
                            ->label('Projekt típus')
                            ->maxLength(255)
                            ->placeholder('pl. Iroda bérlés, Ingatlan eladás'),
                    ])->columns(2),
                    
                Section::make('Beállítások')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Kiemelt')
                            ->helperText('Kiemelt vélemények a főoldalon jelennek meg'),
                        Toggle::make('is_active')
                            ->label('Aktív')
                            ->default(true)
                            ->helperText('Csak az aktív vélemények jelennek meg a weboldalon'),
                        TextInput::make('order')
                            ->label('Sorrend')
                            ->numeric()
                            ->default(0)
                            ->helperText('Kisebb szám = előrébb jelenik meg'),
                    ])->columns(3),
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
<<<<<<< HEAD
                    ->searchable(),
                TextColumn::make('client_position')
                    ->searchable(),
                TextColumn::make('client_company')
                    ->searchable(),
                ImageColumn::make('client_image'),
                TextColumn::make('company_logo')
                    ->searchable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('project_type')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lang')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hu' => 'Magyar',
                        'en' => 'Angol',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
=======
                    ->label('Ügyfél')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_company')
                    ->label('Cég')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('testimonial')
                    ->label('Vélemény')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),
                TextColumn::make('rating')
                    ->label('Értékelés')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '5' => 'success',
                        '4' => 'info',
                        '3' => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => $state . ' ⭐')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Kiemelt')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning'),
                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),
                TextColumn::make('order')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
<<<<<<< HEAD
                //
=======
                TernaryFilter::make('is_featured')
                    ->label('Kiemelt')
                    ->placeholder('Összes')
                    ->trueLabel('Csak kiemelt')
                    ->falseLabel('Nem kiemelt'),
                TernaryFilter::make('is_active')
                    ->label('Státusz')
                    ->placeholder('Összes')
                    ->trueLabel('Aktív')
                    ->falseLabel('Inaktív'),
                SelectFilter::make('rating')
                    ->label('Értékelés')
                    ->options([
                        5 => '5 csillag',
                        4 => '4 csillag',
                        3 => '3 csillag',
                        2 => '2 csillag',
                        1 => '1 csillag',
                    ]),
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
<<<<<<< HEAD
=======
                DeleteAction::make(),
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
<<<<<<< HEAD
            'view' => ViewTestimonial::route('/{record}'),
=======
>>>>>>> 53c1f31 (Refactor controllers and models for improved type hinting and code clarity)
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
