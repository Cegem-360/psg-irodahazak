<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Filament\Exports\PropertyExporter;
use App\Filament\Imports\PropertyImporter;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use App\Services\WatermarkService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Override;
use UnitEnum;

final class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $navigationLabel = 'Ingatlanok';

    protected static ?string $modelLabel = 'Ingatlan';

    protected static ?string $pluralModelLabel = 'Ingatlanok';

    protected static string|UnitEnum|null $navigationGroup = 'Ingatlanok';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('title')
                    ->label('Cím')
                    ->maxLength(255)
                    ->afterStateUpdated(fn (string $state, Set $set): mixed => $set('slug', Str::slug($state, language: 'hu')))
                    ->required()
                    ->live(debounce: 1000),
                TextInput::make('slug')
                    ->label('Slug')
                    ->maxLength(255)
                    ->required()
                    ->unique(Property::class, 'slug', ignoreRecord: true)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Státusz')
                    ->options(PropertyStatus::class)
                    ->enum(PropertyStatus::class)
                    ->required(),
                Toggle::make('featured')
                    ->label('Kiemelt ajánlat')
                    ->helperText('Kijelölés esetén az ingatlan megjelenik a kiemelt ajánlatok között a főoldalon.')
                    ->default(false),

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
                        TextInput::make('available_area')
                            ->label('Jelenleg kiadó')
                            ->maxLength(255),
                        TextInput::make('total_area')
                            ->label('Összterület')
                            ->maxLength(255),
                        Select::make('total_area_unit')
                            ->label('Összterület kiegészítések')
                            ->options([
                                'm2' => 'm2',
                                'ft2' => 'ft2',
                            ])
                            ->default('m2'),
                        TextInput::make('min_lease_term')
                            ->label('Min. bérleti időszak')
                            ->maxLength(255),
                        Select::make('min_lease_term_unit')
                            ->label('Min. bérleti időszak kiegészítések')
                            ->options([
                                'év' => 'év',
                                'hónap' => 'hónap',
                                'nap' => 'nap',
                            ]),
                        TextInput::make('min_available_area')
                            ->label('Min. kiadó')
                            ->maxLength(255),
                        Select::make('min_available_area_unit')
                            ->label('Min. kiadó kiegészítések')
                            ->options([
                                'm2' => 'm2',
                                'ft2' => 'ft2',
                            ])
                            ->default('m2'),
                    ]),
                ]),

                Section::make('bérleti díj')->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('min_rent')
                                ->label(fn (Get $get): string => self::isSaleState($get('offer_type')) ? 'Eladási ár ' : 'Min. bérleti díj')
                                ->maxLength(255),
                            Select::make('min_rent_unit')
                                ->label(fn (Get $get): string => self::isSaleState($get('offer_type')) ? 'Eladási ár addons' : 'Min. bérleti díj addons')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                    'HUF/fő/hó' => 'HUF/fő/hó',
                                    'EUR/fő/hó' => 'EUR/fő/hó',
                                    'EUR/m2' => 'EUR/m2',
                                    'HUF/m2' => 'HUF/m2',
                                    'EUR' => 'EUR',
                                    'HUF' => 'HUF',
                                    'mHUF' => 'mHUF',
                                    'm.EUR' => 'm.EUR',
                                    'm. EUR' => 'm. EUR',
                                    'mrd HUF' => 'mrd HUF',
                                ]),
                            TextInput::make('max_rent')
                                ->hidden(fn (Get $get): bool => self::isSaleState($get('offer_type')))
                                ->label('Max. bérleti díj')
                                ->maxLength(255),
                            Select::make('max_rent_unit')
                                ->hidden(fn (Get $get): bool => self::isSaleState($get('offer_type')))
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
                            TextInput::make('operating_fee')
                                ->label('Üzemeltetési díj')
                                ->maxLength(255),
                            Select::make('operating_fee_unit')
                                ->label('Üzemeltetési díj kiegészítések')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                ]),
                            TextInput::make('storage_area')
                                ->label('Raktár terület')
                                ->maxLength(255),
                            Select::make('storage_area_unit')
                                ->label('Raktár terület kiegészítések')
                                ->options([
                                    'm2' => 'm2',
                                    'ft2' => 'ft2',
                                ])
                                ->default('m2'),
                            TextInput::make('storage_rent')
                                ->label('Raktár bérleti díj')
                                ->maxLength(255),
                            Select::make('storage_rent_unit')
                                ->label('Raktár bérleti díj kiegészítések')
                                ->options([
                                    'EUR/m2/hó' => 'EUR/m2/hó',
                                    'HUF/m2/hó' => 'HUF/m2/hó',
                                ]),
                            Select::make('parking')
                                ->label('Parkolás')
                                ->columnSpanFull()
                                ->options([
                                    'felszíni parkoló' => 'felszíni parkoló',
                                    'teremgarázs' => 'teremgarázs',
                                    'felszíni parkoló és teremgarázs' => 'felszíni parkoló és teremgarázs',
                                    'utcán, közterületen' => 'utcán, közterületen',
                                ]),
                            TextInput::make('min_parking_fee')
                                ->label('Min. parkolás díja')
                                ->maxLength(255),
                            Select::make('min_parking_fee_unit')
                                ->label('Min. parkolás díja kiegészítések')
                                ->options([
                                    'EUR/hely/hó' => 'EUR/hely/hó',
                                    'HUF/hely/hó' => 'HUF/hely/hó',
                                ]),
                            TextInput::make('max_parking_fee')
                                ->label('Max. parkolás díja')
                                ->maxLength(255),
                            Select::make('max_parking_fee_unit')
                                ->label('Max. parkolás díja kiegészítések')
                                ->options([
                                    'EUR/hely/hó' => 'EUR/hely/hó',
                                    'HUF/hely/hó' => 'HUF/hely/hó',
                                ]),
                            TextInput::make('common_area_ratio')
                                ->label('Közös területi arány')
                                ->maxLength(255),
                            Select::make('common_area_ratio_unit')
                                ->label('Közös területi arány kiegészítések')
                                ->options([
                                    '%' => '%',
                                    'm2' => 'm2',
                                    'ft2' => 'ft2',
                                ])->default('%'),
                        ]),
                ]),

                Section::make('Ingatlan hely adatok')->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('postal_code')
                                ->label('Irányítószám')
                                ->maxLength(255),
                            TextInput::make('district')
                                ->label('Kerület')
                                ->maxLength(255),
                            TextInput::make('city')
                                ->label('Város')
                                ->maxLength(255),
                            TextInput::make('street')
                                ->label('Utca')
                                ->maxLength(255),
                            Select::make('street_type')
                                ->options([
                                    'utca' => 'utca',
                                    'út' => 'út',
                                    'körút' => 'körút',
                                    'köz' => 'köz',
                                    'sétány' => 'sétány',
                                    'rakpart' => 'rakpart',
                                    'tér' => 'tér',
                                    'útja' => 'útja',
                                    'körönd' => 'körönd',
                                    'fasor' => 'fasor',
                                ])
                                ->label('Utca kiegészítések'),
                            TextInput::make('house_number')
                                ->label('Házszám')
                                ->maxLength(255),
                            Grid::make()
                                ->schema([
                                    TextInput::make('maps_lat')
                                        ->label('Térkép szélesség')
                                        ->maxLength(255),
                                    TextInput::make('maps_lng')
                                        ->label('Térkép hosszúság')
                                        ->maxLength(255),
                                ]),
                        ]),
                ]),
                Section::make('Műszaki paraméterek')->schema([
                    CheckboxList::make('tags')
                        ->label('Műszaki paraméterek')
                        ->relationship('tags', 'name')
                        ->columns(4)
                        ->gridDirection('row')
                        ->columnSpanFull(),
                ]),
                Section::make('Szolgáltatások')->schema([
                    CheckboxList::make('services')
                        ->label('Szolgáltatások')
                        ->relationship('services', 'name')
                        ->columns(4)
                        ->gridDirection('row')
                        ->columnSpanFull(),
                ]),
                Section::make('Kategóriák')->schema([
                    CheckboxList::make('categories')
                        ->label('Kategóriák')
                        ->relationship('categories', 'name')
                        ->columns(4)
                        ->gridDirection('row')
                        ->columnSpanFull(),
                ]),
                TextInput::make('identifier')
                    ->label('Azonosító')
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Kódszám')
                    ->maxLength(255),
                RichEditor::make('en_content')
                    ->label('Angol tartalom')
                    ->columnSpanFull(),
                TextInput::make('lang')
                    ->label('Nyelv')
                    ->maxLength(2),
                TextInput::make('label')
                    ->label('Címke')
                    ->maxLength(255),
                TextInput::make('service')
                    ->label('Szolgáltatás')
                    ->maxLength(255),
                TextInput::make('maps')
                    ->label('Térképek')
                    ->maxLength(255),
                Select::make('offer_type')
                    ->label('Eladó v. kiadó')
                    ->options(PropertyType::class)
                    ->enum(PropertyType::class)
                    ->live()
                    ->required(),
                DatePicker::make('updated')
                    ->label('Frissítve'),
                RichEditor::make('other_info')
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
                    ->preserveFilenames()
                    ->imagePreviewHeight('250')
                    ->label('Ingatlan fotók')
                    ->image()
                    ->multiple()
                    ->panelLayout('grid')
                    ->visibility('public')
                    ->disabled(fn (string $operation): bool => $operation === 'create')
                    ->directory(fn ($record): string => 'property/'.$record->id.'/gallery_images')
                    ->saveUploadedFileUsing(fn ($file, $record) => resolve(WatermarkService::class)->addWatermark($file, $record))
                    ->openable()
                    ->downloadable()
                    ->columnSpanFull()
                    ->reorderable(),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->columns([
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Kódszám')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Dátum')
                    ->date('Y-m-d')
                    ->sortable(),

            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->recordActions([

                EditAction::make(),
                Action::make('generate_pdf')
                    ->label('PDF')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('success')
                    ->url(fn (Property $record) => URL::temporarySignedRoute(
                        Session::get('locale') === 'en' ? 'en.property.pdf' : 'property.pdf',
                        now()->addDays(21),
                        ['property' => $record->id]
                    ))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->modalHeading('PDF Generálás')
                    ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                    ->modalSubmitActionLabel('PDF Megnyitás'),
            ], position: RecordActionsPosition::BeforeCells)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Properties')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(PropertyExporter::class),
                ImportAction::make('import')
                    ->label('Import Properties')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->importer(PropertyImporter::class),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            /*  ImagesRelationManager::class, */
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'edit' => EditProperty::route('/{record}/edit'),
        ];
    }

    /**
     * Whether the form's "Eladó v. kiadó" state is a sale: an enum once hydrated
     * from the record, the raw value while the form is being edited.
     */
    private static function isSaleState(mixed $state): bool
    {
        return ($state instanceof PropertyType ? $state : PropertyType::tryFrom((string) $state)) === PropertyType::Sale;
    }
}
