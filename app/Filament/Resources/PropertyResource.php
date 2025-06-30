<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\PropertyExporter;
use App\Filament\Imports\PropertyImporter;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Filament\Resources\PropertyResource\Pages\ViewProperty;
use App\Filament\Resources\PropertyResource\RelationManagers\ImagesRelationManager;
use App\Models\Property;
use App\Models\Service;
use App\Models\Tag;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ingatlanok';

    protected static ?string $modelLabel = 'Ingatlan';

    protected static ?string $pluralModelLabel = 'Ingatlanok';

    protected static ?string $navigationGroup = 'Ingatlanok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Cím')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Státusz')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
                Toggle::make('featured')
                    ->label('Kiemelt ajánlat')
                    ->helperText('Kijelölés esetén az ingatlan megjelenik a kiemelt ajánlatok között a főoldalon.')
                    ->default(false),
                RichEditor::make('lead')
                    ->label('Bevezető')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Tartalom')
                    ->columnSpanFull(),
                DateTimePicker::make('date')
                    ->label('Dátum')
                    ->required(),
                TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->label('Meta cím')
                    ->maxLength(255),
                Textarea::make('meta_title_en')
                    ->label('Meta cím (angol)')
                    ->columnSpanFull(),
                Textarea::make('meta_keywords')
                    ->label('Meta kulcsszavak')
                    ->columnSpanFull(),
                Textarea::make('meta_keywords_en')
                    ->label('Meta kulcsszavak (angol)')
                    ->columnSpanFull(),
                Textarea::make('meta_description')
                    ->label('Meta leírás')
                    ->columnSpanFull(),
                Textarea::make('meta_description_en')
                    ->label('Meta leírás (angol)')
                    ->columnSpanFull(),
                Section::make('Ingatlan adatok')->schema([
                    Grid::make()->schema([
                        TextInput::make('construction_year')
                            ->label('Építés éve')
                            ->maxLength(255),
                        TextInput::make('jelenleg_kiado')
                            ->label('Jelenleg kiadó')
                            ->maxLength(255),
                        TextInput::make('total_area')
                            ->label('Összterület')
                            ->maxLength(255),
                        Select::make('osszterulet_addons')
                            ->label('Összterület kiegészítések')
                            ->options([
                                'm2' => 'm²',
                                'ft2' => 'ft²',
                            ])
                            ->default('m2'),
                        TextInput::make('min_berleti_idoszak')
                            ->label('Min. bérleti időszak')
                            ->maxLength(255),
                        Select::make('min_berleti_idoszak_addons')
                            ->label('Min. bérleti időszak kiegészítések')
                            ->options([
                                'év' => 'év',
                                'hónap' => 'hónap',
                                'nap' => 'nap',
                            ]),
                        TextInput::make('min_kiado')
                            ->label('Min. kiadó')
                            ->maxLength(255),
                        Select::make('min_kiado_addons')
                            ->label('Min. kiadó kiegészítések')
                            ->options([
                                'm2' => 'm²',
                                'ft2' => 'ft²',
                            ])
                            ->default('m2'),
                    ]),
                ]),

                Section::make('bérleti díj')->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('min_berleti_dij')
                                ->label('Min. bérleti díj')
                                ->maxLength(255),
                            Select::make('min_berleti_dij_addons')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                    'HUF/fő/hó' => 'HUF/fő/hó',
                                    'EUR/fő/hó' => 'EUR/fő/hó',
                                ]),
                            TextInput::make('max_berleti_dij')
                                ->label('Max. bérleti díj')
                                ->maxLength(255),
                            Select::make('max_berleti_dij_addons')
                                ->label('Max. bérleti díj kiegészítések')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                    'HUF/fő/hó' => 'HUF/fő/hó',
                                    'EUR/fő/hó' => 'EUR/fő/hó',
                                ]),
                        ]),
                ]),
                Section::make('egyéb díj')->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('uzemeletetesi_dij')
                                ->label('Üzemeltetési díj')
                                ->maxLength(255),
                            Select::make('uzemeletetesi_dij_addons')
                                ->label('Üzemeltetési díj kiegészítések')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                ]),
                            TextInput::make('raktar_terulet')
                                ->label('Raktár terület')
                                ->maxLength(255),
                            Select::make('raktar_terulet_addons')
                                ->label('Raktár terület kiegészítések')
                                ->options([
                                    'm2' => 'm²',
                                    'ft2' => 'ft²',
                                ])
                                ->default('m2'),
                            TextInput::make('raktar_berleti_dij')
                                ->label('Raktár bérleti díj')
                                ->maxLength(255),
                            Select::make('raktar_berleti_dij_addons')
                                ->label('Raktár bérleti díj kiegészítések')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                ]),
                            Select::make('parkolas')
                                ->label('Parkolás')
                                ->columnSpanFull()
                                ->options([
                                    'felszíni parkoló' => 'Felszíni parkoló',
                                    'teremgarázs' => 'Teremgarázs',
                                    'felszíni parkoló és teremgarázs' => 'Felszíni parkoló és teremgarázs',
                                ]),
                            TextInput::make('min_parkolas_dija')
                                ->label('Min. parkolás díja')
                                ->maxLength(255),
                            Select::make('min_parkolas_dija_addons')
                                ->label('Min. parkolás díja kiegészítések')
                                ->options([
                                    'EUR/hely/hó' => 'EUR/hely/hó',
                                    'HUF/hely/hó' => 'HUF/hely/hó',
                                ]),
                            TextInput::make('max_parkolas_dija')
                                ->label('Max. parkolás díja')
                                ->maxLength(255),
                            Select::make('max_parkolas_dija_addons')
                                ->label('Max. parkolás díja kiegészítések')
                                ->options([
                                    'EUR/hely/hó' => 'EUR/hely/hó',
                                    'HUF/hely/hó' => 'HUF/hely/hó',
                                ]),
                            TextInput::make('kozos_teruleti_arany')
                                ->label('Közös területi arány')
                                ->maxLength(255),
                            Select::make('kozos_teruleti_arany_addons')
                                ->label('Közös területi arány kiegészítések')
                                ->options([
                                    '%' => '%',
                                    'm2' => 'm²',
                                    'ft2' => 'ft²',
                                ])->default('%'),
                        ]),
                ]),

                Section::make('Ingatlan hely adatok')->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('cim_irsz')
                                ->label('Irányítószám')
                                ->maxLength(255),
                            TextInput::make('cim_varos')
                                ->label('Város')
                                ->maxLength(255),
                            TextInput::make('cim_utca')
                                ->label('Utca')
                                ->maxLength(255),
                            Select::make('cim_utca_addons')
                                ->options([
                                    'none' => 'Nincs',
                                    'street' => 'Utca',
                                    'street_and_number' => 'Utca és házszám',
                                ])
                                ->label('Utca kiegészítések'),
                            TextInput::make('cim_hazszam')
                                ->label('Házszám')
                                ->maxLength(255),
                            TextInput::make('maps_lat')
                                ->label('Térkép szélesség')
                                ->maxLength(255),
                            TextInput::make('maps_lng')
                                ->label('Térkép hosszúság')
                                ->maxLength(255),
                        ]),
                ]),

                Select::make('tags')
                    ->label('Címkék')
                    ->options(Tag::all()->pluck('name', 'id'))
                    ->preload()
                    ->multiple()
                    ->columnSpanFull(),
                Select::make('services')
                    ->label('Szolgáltatások')
                    ->options(Service::all()->pluck('name', 'id'))
                    ->preload()
                    ->multiple()
                    ->columnSpanFull(),

                TextInput::make('azonosito')
                    ->label('Azonosító')
                    ->maxLength(255),

                TextInput::make('kodszam')
                    ->label('Kódszám')
                    ->maxLength(255),
                Textarea::make('en_content')
                    ->label('Angol tartalom')
                    ->columnSpanFull(),

                TextInput::make('lang')
                    ->label('Nyelv')
                    ->maxLength(2),
                TextInput::make('cimke')
                    ->label('Címke')
                    ->maxLength(255),
                TextInput::make('service')
                    ->label('Szolgáltatás')
                    ->maxLength(255),
                TextInput::make('maps')
                    ->label('Térképek')
                    ->maxLength(255),
                Select::make('elado_v_kiado')
                    ->label('Eladó v. kiadó')
                    ->options([
                        'kiado-iroda' => 'Kiadó',
                        'elado-iroda' => 'Eladó',
                    ])
                    ->required(),
                TextInput::make('updated')
                    ->label('Frissítve')
                    ->maxLength(10),
                RichEditor::make('egyeb')
                    ->label('Egyéb')
                    ->columnSpanFull(),
                Select::make('vat')
                    ->label('ÁFA')
                    ->options([
                        '1' => 'Igen',
                        '0' => 'Nem',
                    ])
                    ->default('1'),
                FileUpload::make('property_photos')
                    ->label('Ingatlan fotók')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->visibility('public')
                    ->directory(fn ($record) => 'property/'.$record->id.'/gallery_images')
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->columnSpanFull()
                    ->reorderable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('first_image')
                    ->label('Kép')
                    ->disk('public')
                    ->visibility('public')
                    ->getStateUsing(fn (Property $record): ?string => $record->first_image_url)
                    ->height(60)
                    ->width(80),
                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                IconColumn::make('featured')
                    ->label('Kiemelt')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('images_count')
                    ->label('Képek száma')
                    ->counts('images'),
                TextColumn::make('construction_year')
                    ->label('Építés éve')
                    ->searchable(),
                TextColumn::make('total_area')
                    ->label('Összterület')
                    ->searchable(),
                TextColumn::make('jelenleg_kiado')
                    ->label('Jelenleg kiadó')
                    ->searchable(),
                TextColumn::make('jelenleg_kiado_addons')
                    ->label('Jelenleg kiadó kiegészítések'),
                TextColumn::make('max_berleti_dij')
                    ->label('Max. bérleti díj')
                    ->searchable(),
                TextColumn::make('uzemeletetesi_dij')
                    ->label('Üzemeltetési díj')
                    ->searchable(),
                TextColumn::make('raktar_terulet')
                    ->label('Raktár terület')
                    ->searchable(),
                TextColumn::make('raktar_berleti_dij')
                    ->label('Raktár bérleti díj')
                    ->searchable(),
                TextColumn::make('parkolas')
                    ->label('Parkolás')
                    ->searchable(),
                TextColumn::make('parkolas_dija')
                    ->label('Parkolás díja')
                    ->searchable(),
                TextColumn::make('kozos_teruleti_arany')
                    ->label('Közös területi arány')
                    ->searchable(),
                TextColumn::make('cim_irsz')
                    ->label('Irányítószám')
                    ->searchable(),
                TextColumn::make('cim_varos')
                    ->label('Város')
                    ->searchable(),
                TextColumn::make('cim_utca')
                    ->label('Utca')
                    ->searchable(),
                TextColumn::make('cim_hazszam')
                    ->label('Házszám')
                    ->searchable(),
                TextColumn::make('maps_lat')
                    ->label('Térkép szélesség')
                    ->searchable(),
                TextColumn::make('maps_lng')
                    ->label('Térkép hosszúság')
                    ->searchable(),
                TextColumn::make('azonosito')
                    ->label('Azonosító')
                    ->searchable(),
                TextColumn::make('osszterulet_addons')
                    ->searchable(),
                TextColumn::make('max_berleti_dij_addons')
                    ->searchable(),
                TextColumn::make('parkolas_dija_addons')
                    ->searchable(),
                TextColumn::make('min_berleti_dij')
                    ->searchable(),
                TextColumn::make('min_berleti_dij_addons')
                    ->searchable(),
                TextColumn::make('raktar_terulet_addons')
                    ->searchable(),
                TextColumn::make('raktar_berleti_dij_addons')
                    ->searchable(),
                TextColumn::make('uzemeletetesi_dij_addons')
                    ->searchable(),
                TextColumn::make('min_parkolas_dija')
                    ->searchable(),
                TextColumn::make('min_parkolas_dija_addons')
                    ->searchable(),
                TextColumn::make('max_parkolas_dija')
                    ->searchable(),
                TextColumn::make('max_parkolas_dija_addons')
                    ->searchable(),
                TextColumn::make('kozos_teruleti_arany_addons')
                    ->searchable(),
                TextColumn::make('min_kiado')
                    ->searchable(),

                TextColumn::make('kodszam')
                    ->searchable(),
                TextColumn::make('min_berleti_idoszak')
                    ->searchable(),
                TextColumn::make('lang')
                    ->searchable(),
                TextColumn::make('cimke')
                    ->searchable(),
                TextColumn::make('service')
                    ->searchable(),
                TextColumn::make('maps')
                    ->searchable(),
                TextColumn::make('elado_v_kiado')
                    ->searchable(),
                TextColumn::make('vat')
                    ->label('ÁFA')

                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('generate_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (Property $record) => route('property.pdf', $record))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->modalHeading('PDF Generálás')
                    ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                    ->modalSubmitActionLabel('PDF Megnyitás'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Properties')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exporter(PropertyExporter::class),
                ImportAction::make('import')
                    ->label('Import Properties')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->importer(PropertyImporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'view' => ViewProperty::route('/{record}'),
            'edit' => EditProperty::route('/{record}/edit'),
        ];
    }
}
