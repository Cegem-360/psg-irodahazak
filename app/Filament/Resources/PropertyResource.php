<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PropertyExporter;
use App\Filament\Imports\PropertyImporter;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255),
                TextInput::make('status')
                    ->maxLength(255),
                Textarea::make('lead')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->columnSpanFull(),
                DateTimePicker::make('date')
                    ->required(),
                TextInput::make('ord')
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->maxLength(255),
                Textarea::make('meta_title_en')
                    ->columnSpanFull(),
                Textarea::make('meta_keywords')
                    ->columnSpanFull(),
                Textarea::make('meta_keywords_en')
                    ->columnSpanFull(),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                Textarea::make('meta_description_en')
                    ->columnSpanFull(),
                TextInput::make('epites_eve')
                    ->maxLength(255),
                TextInput::make('osszterulet')
                    ->maxLength(255),
                TextInput::make('jelenleg_kiado')
                    ->maxLength(255),
                TextInput::make('min__kiado')
                    ->maxLength(255),
                TextInput::make('min__berleti_dij')
                    ->maxLength(255),
                TextInput::make('max_berleti_dij')
                    ->maxLength(255),
                TextInput::make('uzemeletetesi_dij')
                    ->maxLength(255),
                TextInput::make('raktar_terulet')
                    ->maxLength(255),
                TextInput::make('raktar_berleti_dij')
                    ->maxLength(255),
                TextInput::make('parkolas')
                    ->maxLength(255),
                TextInput::make('parkolas_dija')
                    ->maxLength(255),
                TextInput::make('kozos_teruleti_arany')
                    ->maxLength(255),
                TextInput::make('min__berleti_idoszak')
                    ->maxLength(255),
                TextInput::make('cim_irsz')
                    ->maxLength(255),
                TextInput::make('cim_varos')
                    ->maxLength(255),
                TextInput::make('cim_utca')
                    ->maxLength(255),
                TextInput::make('cim_hazszam')
                    ->maxLength(255),
                Textarea::make('cimke_json')
                    ->columnSpanFull(),
                Textarea::make('service_json')
                    ->columnSpanFull(),
                TextInput::make('maps_lat')
                    ->maxLength(255),
                TextInput::make('maps_lng')
                    ->maxLength(255),
                TextInput::make('azonosito')
                    ->maxLength(255),
                TextInput::make('min._kiado')
                    ->maxLength(255),
                TextInput::make('min._berleti_dij')
                    ->maxLength(255),
                TextInput::make('min._berleti_idoszak')
                    ->maxLength(255),
                TextInput::make('osszterulet_addons')
                    ->maxLength(255),
                TextInput::make('min._berleti_dij_addons')
                    ->maxLength(255),
                TextInput::make('max_berleti_dij_addons')
                    ->maxLength(255),
                TextInput::make('parkolas_dija_addons')
                    ->maxLength(255),
                TextInput::make('min_berleti_dij')
                    ->maxLength(255),
                TextInput::make('min_berleti_dij_addons')
                    ->maxLength(255),
                TextInput::make('raktar_terulet_addons')
                    ->maxLength(255),
                TextInput::make('raktar_berleti_dij_addons')
                    ->maxLength(255),
                TextInput::make('uzemeletetesi_dij_addons')
                    ->maxLength(255),
                TextInput::make('min_parkolas_dija')
                    ->maxLength(255),
                TextInput::make('min_parkolas_dija_addons')
                    ->maxLength(255),
                TextInput::make('max_parkolas_dija')
                    ->maxLength(255),
                TextInput::make('max_parkolas_dija_addons')
                    ->maxLength(255),
                TextInput::make('min._kiado_addons')
                    ->maxLength(255),
                TextInput::make('kozos_teruleti_arany_addons')
                    ->maxLength(255),
                TextInput::make('min._berleti_idoszak_addons')
                    ->maxLength(255),
                TextInput::make('min_kiado')
                    ->maxLength(255),
                TextInput::make('min_kiado_addons')
                    ->maxLength(255),
                TextInput::make('jelenleg_kiado_addons')
                    ->maxLength(255),
                TextInput::make('kodszam')
                    ->maxLength(255),
                Textarea::make('en_content')
                    ->columnSpanFull(),
                TextInput::make('min_berleti_idoszak')
                    ->maxLength(255),
                TextInput::make('min_berleti_idoszak_addons')
                    ->maxLength(255),
                TextInput::make('cim_utca_addons')
                    ->maxLength(255),
                TextInput::make('lang')
                    ->maxLength(2),
                TextInput::make('cimke')
                    ->maxLength(255),
                TextInput::make('service')
                    ->maxLength(255),
                TextInput::make('maps')
                    ->maxLength(255),
                TextInput::make('elado_v__kiado')
                    ->maxLength(255),
                TextInput::make('elado_v__kiado_addons')
                    ->maxLength(255),
                TextInput::make('updated')
                    ->maxLength(10),
                TextInput::make('test')
                    ->maxLength(255),
                Textarea::make('egyeb')
                    ->columnSpanFull(),
                TextInput::make('afa')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ord')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('epites_eve')
                    ->searchable(),
                TextColumn::make('osszterulet')
                    ->searchable(),
                TextColumn::make('jelenleg_kiado')
                    ->searchable(),
                TextColumn::make('min__kiado')
                    ->searchable(),
                TextColumn::make('min__berleti_dij')
                    ->searchable(),
                TextColumn::make('max_berleti_dij')
                    ->searchable(),
                TextColumn::make('uzemeletetesi_dij')
                    ->searchable(),
                TextColumn::make('raktar_terulet')
                    ->searchable(),
                TextColumn::make('raktar_berleti_dij')
                    ->searchable(),
                TextColumn::make('parkolas')
                    ->searchable(),
                TextColumn::make('parkolas_dija')
                    ->searchable(),
                TextColumn::make('kozos_teruleti_arany')
                    ->searchable(),
                TextColumn::make('min__berleti_idoszak')
                    ->searchable(),
                TextColumn::make('cim_irsz')
                    ->searchable(),
                TextColumn::make('cim_varos')
                    ->searchable(),
                TextColumn::make('cim_utca')
                    ->searchable(),
                TextColumn::make('cim_hazszam')
                    ->searchable(),
                TextColumn::make('maps_lat')
                    ->searchable(),
                TextColumn::make('maps_lng')
                    ->searchable(),
                TextColumn::make('azonosito')
                    ->searchable(),
                TextColumn::make('min._kiado')
                    ->searchable(),
                TextColumn::make('min._berleti_dij')
                    ->searchable(),
                TextColumn::make('min._berleti_idoszak')
                    ->searchable(),
                TextColumn::make('osszterulet_addons')
                    ->searchable(),
                TextColumn::make('min._berleti_dij_addons')
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
                TextColumn::make('min._kiado_addons')
                    ->searchable(),
                TextColumn::make('kozos_teruleti_arany_addons')
                    ->searchable(),
                TextColumn::make('min._berleti_idoszak_addons')
                    ->searchable(),
                TextColumn::make('min_kiado')
                    ->searchable(),
                TextColumn::make('min_kiado_addons')
                    ->searchable(),
                TextColumn::make('jelenleg_kiado_addons')
                    ->searchable(),
                TextColumn::make('kodszam')
                    ->searchable(),
                TextColumn::make('min_berleti_idoszak')
                    ->searchable(),
                TextColumn::make('min_berleti_idoszak_addons')
                    ->searchable(),
                TextColumn::make('cim_utca_addons')
                    ->searchable(),
                TextColumn::make('lang')
                    ->searchable(),
                TextColumn::make('cimke')
                    ->searchable(),
                TextColumn::make('service')
                    ->searchable(),
                TextColumn::make('maps')
                    ->searchable(),
                TextColumn::make('elado_v__kiado')
                    ->searchable(),
                TextColumn::make('elado_v__kiado_addons')
                    ->searchable(),
                TextColumn::make('updated')
                    ->searchable(),
                TextColumn::make('test')
                    ->searchable(),
                TextColumn::make('afa')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(PropertyExporter::class),
                ImportAction::make()
                    ->importer(PropertyImporter::class),
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
            'index' => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'edit' => EditProperty::route('/{record}/edit'),
        ];
    }
}
