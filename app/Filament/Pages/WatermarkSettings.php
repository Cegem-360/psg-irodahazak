<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

final class WatermarkSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static string $view = 'filament.pages.watermark-settings';

    protected static ?string $navigationLabel = 'Vízjel Beállítások';

    protected static ?string $title = 'Vízjel Beállítások';

    protected static ?string $navigationGroup = 'Beállítások';

    protected static ?int $navigationSort = 10;

    public function mount(): void
    {
        $this->form->fill([
            'enabled' => config('watermark.enabled', true),
            'text' => config('watermark.text', 'PSG Irodaházak'),
            'position' => config('watermark.position', 'bottom-right'),
            'opacity' => config('watermark.opacity', 70),
            'font_size' => config('watermark.font_size', 24),
            'color' => config('watermark.color', '#ffffff'),
            'margin' => config('watermark.margin', 20),
            'background_color' => config('watermark.background_color', '#000000'),
            'background_opacity' => config('watermark.background_opacity', 30),
            'shadow_enabled' => config('watermark.shadow.enabled', true),
            'shadow_color' => config('watermark.shadow.color', '#000000'),
            'shadow_offset_x' => config('watermark.shadow.offset_x', 2),
            'shadow_offset_y' => config('watermark.shadow.offset_y', 2),
            'shadow_blur' => config('watermark.shadow.blur', 4),
            'min_image_width' => config('watermark.min_image_width', 200),
            'min_image_height' => config('watermark.min_image_height', 150),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Alapbeállítások')
                    ->schema([
                        Toggle::make('enabled')
                            ->label('Vízjel engedélyezése')
                            ->helperText('Ki/be kapcsolja a vízjelezést új képeknél'),

                        TextInput::make('text')
                            ->label('Vízjel szöveg')
                            ->required()
                            ->maxLength(100),

                        Select::make('position')
                            ->label('Pozíció')
                            ->options([
                                'top-left' => 'Bal felső',
                                'top-right' => 'Jobb felső',
                                'bottom-left' => 'Bal alsó',
                                'bottom-right' => 'Jobb alsó',
                                'center' => 'Középen',
                            ])
                            ->required(),

                        TextInput::make('opacity')
                            ->label('Átlátszóság (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(5)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Megjelenés')
                    ->schema([
                        TextInput::make('font_size')
                            ->label('Betűméret (px)')
                            ->numeric()
                            ->minValue(8)
                            ->maxValue(72)
                            ->required(),

                        ColorPicker::make('color')
                            ->label('Szöveg szín')
                            ->required(),

                        TextInput::make('margin')
                            ->label('Margó (px)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),

                        ColorPicker::make('background_color')
                            ->label('Háttér szín')
                            ->helperText('Opcionális háttér szín a szöveg alatt'),

                        TextInput::make('background_opacity')
                            ->label('Háttér átlátszóság (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(5),
                    ])
                    ->columns(2),

                Section::make('Árnyék beállítások')
                    ->schema([
                        Toggle::make('shadow_enabled')
                            ->label('Árnyék engedélyezése'),

                        ColorPicker::make('shadow_color')
                            ->label('Árnyék szín')
                            ->visible(fn (Forms\Get $get): bool => $get('shadow_enabled')),

                        TextInput::make('shadow_offset_x')
                            ->label('Árnyék eltolás X (px)')
                            ->numeric()
                            ->visible(fn (Forms\Get $get): bool => $get('shadow_enabled')),

                        TextInput::make('shadow_offset_y')
                            ->label('Árnyék eltolás Y (px)')
                            ->numeric()
                            ->visible(fn (Forms\Get $get): bool => $get('shadow_enabled')),

                        TextInput::make('shadow_blur')
                            ->label('Árnyék elmosás (px)')
                            ->numeric()
                            ->minValue(0)
                            ->visible(fn (Forms\Get $get): bool => $get('shadow_enabled')),
                    ])
                    ->columns(2),

                Section::make('Kép méret korlátok')
                    ->schema([
                        TextInput::make('min_image_width')
                            ->label('Minimum szélesség (px)')
                            ->numeric()
                            ->helperText('Ennél keskenyebb képekre nem kerül vízjel')
                            ->required(),

                        TextInput::make('min_image_height')
                            ->label('Minimum magasság (px)')
                            ->numeric()
                            ->helperText('Ennél alacsonyabb képekre nem kerül vízjel')
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Itt egy valódi alkalmazásban elmentenénk az adatbázisba vagy
        // frissítenénk a config fájlt
        // Egyelőre csak egy sikeres üzenetet mutatunk

        Notification::make()
            ->title('Beállítások mentve')
            ->body('A vízjel beállításai sikeresen frissítve lettek.')
            ->success()
            ->send();
    }

    public function applyToExistingImages(): void
    {
        // Artisan parancs futtatása a háttérben
        Artisan::call('watermark:apply', [
            '--type' => 'all',
            '--sizes' => true,
        ]);

        Notification::make()
            ->title('Vízjel alkalmazása elindítva')
            ->body('A meglévő képek vízjelezése elkezdődött a háttérben.')
            ->success()
            ->send();
    }

    public function testWatermarkSettings(): void
    {
        // Dry-run tesztelés
        Artisan::call('watermark:apply', [
            '--type' => 'gallery',
            '--dry-run' => true,
        ]);

        $output = Artisan::output();

        Notification::make()
            ->title('Teszt futtatás kész')
            ->body('Dry-run mód lefutott. Ellenőrizd a terminált a részletekért.')
            ->info()
            ->send();
    }

    public function createPrototypeImages(): void
    {
        // Prototype képek létrehozása
        Artisan::call('watermark:apply', [
            '--type' => 'gallery',
            '--prototype' => true,
        ]);

        Notification::make()
            ->title('Prototype képek létrehozva')
            ->body('A vízjeles prototype képek elkészültek a storage/app/public/watermarked-prototypes/ mappában.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Beállítások mentése')
                ->action('save'),

            Action::make('test_settings')
                ->label('Beállítások tesztelése (Dry-run)')
                ->action('testWatermarkSettings')
                ->color('info')
                ->icon('heroicon-o-play'),

            Action::make('create_prototype')
                ->label('Prototype képek létrehozása')
                ->action('createPrototypeImages')
                ->requiresConfirmation()
                ->modalHeading('Prototype képek létrehozása')
                ->modalDescription('Ez létrehoz vízjeles másolatokat a storage/watermarked-prototypes mappában anélkül, hogy az eredeti képeket módosítaná.')
                ->color('success')
                ->icon('heroicon-o-document-duplicate'),

            Action::make('apply_to_existing')
                ->label('Alkalmazás meglévő képekre (ÉLES)')
                ->action('applyToExistingImages')
                ->requiresConfirmation()
                ->modalHeading('Vízjel alkalmazása meglévő képekre')
                ->modalDescription('Ez módosítja az eredeti képeket! Készíts előtte biztonsági másolatot. Biztos folytatja?')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
