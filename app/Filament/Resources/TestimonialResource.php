<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Filament\Resources\TestimonialResource\Pages\ViewTestimonial;
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Rolunk mondták';

    protected static ?string $modelLabel = 'Rolunk';

    protected static ?string $pluralModelLabel = 'Rolunk';

    protected static ?string $navigationGroup = 'Rolunk mondták';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ügyfél adatai')
                    ->columns(3)
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Név')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_company')
                            ->label('Cég')
                            ->maxLength(255)
                            ->placeholder('Pl. PSG Irodaházak Kft.'),
                        TextInput::make('client_position')
                            ->label('Pozíció')
                            ->maxLength(255)
                            ->placeholder('Pl. Ügyvezető igazgató'),
                    ]),
                RichEditor::make('testimonial')
                    ->label('Vélemény')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('client_image')
                    ->label('Ügyfél képe')
                    ->directory('testimonial/images')
                    ->image(),

                Toggle::make('is_featured')
                    ->label('Kiemelt')
                    ->default(false),
                Toggle::make('is_active')
                    ->label('Aktív')
                    ->required(),

                Select::make('lang')
                    ->required()
                    ->options([
                        'hu' => 'Magyar',
                        'en' => 'Angol',
                    ])
                    ->default('hu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->label('Cím')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),

                TextColumn::make('testimonial')
                    ->label('Vélemény')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('lang')
                    ->label('Nyelv')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hu' => 'Magyar',
                        'en' => 'Angol',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
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
            'view' => ViewTestimonial::route('/{record}'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
