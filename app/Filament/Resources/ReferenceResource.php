<?php

declare(strict_types=1);

namespace App\Filament\Resources;

<<<<<<< HEAD
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ReferenceResource\Pages\ListReferences;
use App\Filament\Resources\ReferenceResource\Pages\CreateReference;
use App\Filament\Resources\ReferenceResource\Pages\EditReference;
use App\Filament\Resources\ReferenceResource\Pages;
use App\Models\Reference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
=======
use App\Filament\Resources\ReferenceResource\Pages\CreateReference;
use App\Filament\Resources\ReferenceResource\Pages\EditReference;
use App\Filament\Resources\ReferenceResource\Pages\ListReferences;
use App\Models\Reference;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
use Filament\Tables\Table;

final class ReferenceResource extends Resource
{
    protected static ?string $model = Reference::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

<<<<<<< HEAD
    protected static ?string $navigationLabel = 'Referenciák';

    protected static ?string $modelLabel = 'Referencia';

    protected static ?string $pluralModelLabel = 'Referenciák';

    protected static ?int $navigationSort = 4;
=======
    protected static ?string $navigationLabel = 'References';

    protected static ?string $modelLabel = 'Reference';

    protected static ?string $pluralModelLabel = 'References';

    protected static ?int $navigationSort = 30;
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
<<<<<<< HEAD
                    ->label('Név')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label('Kép')
                    ->image()
                    ->directory('references')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->optimize('webp')
                    ->resize(50)
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->label('Sorrend')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->helperText('0 = első, 1 = második, stb.'),
                Toggle::make('is_active')
                    ->label('Aktív')
=======
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->imageEditor()
                    ->directory('references'),

                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Order Number')
                    ->helperText(__('Used for sorting references')),

                Toggle::make('is_active')
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
<<<<<<< HEAD
                ImageColumn::make('image')
                    ->label('Kép')
                    ->circular()
                    ->size(50),
                TextColumn::make('name')
                    ->label('Név')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success'),
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
                TextColumn::make('updated_at')
                    ->label('Módosítva')
                    ->dateTime('Y-m-d H:i')
=======
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image')
                    ->size(60),

                TextColumn::make('order')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
<<<<<<< HEAD
                    ->label('Aktív')
                    ->placeholder('Összes')
                    ->trueLabel('Csak aktív')
                    ->falseLabel('Csak inaktív'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Szerkesztés'),
                DeleteAction::make()
                    ->label('Törlés'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Törlés'),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->paginationPageOptions([10, 25, 50]);
=======
                    ->label('Active Status'),
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
            ->defaultSort('order', 'asc');
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
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
            'index' => ListReferences::route('/'),
            'create' => CreateReference::route('/create'),
            'edit' => EditReference::route('/{record}/edit'),
        ];
    }
}
