<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Impresszum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

final class ImpresszumPage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Impresszum';

    protected static ?string $title = 'Impresszum szerkesztése';

    protected static string $view = 'filament.pages.impresszum-page';

    protected static ?int $navigationSort = 100;

    public function mount(): void
    {
        $impresszum = Impresszum::first();

        if ($impresszum) {
            $this->form->fill($impresszum->toArray());
        } else {
            $this->form->fill([
                'title' => 'Impresszum',
                'content' => '',
                'is_active' => true,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Cím')
                    ->required()
                    ->maxLength(255)
                    ->default('Impresszum'),

                RichEditor::make('content')
                    ->label('Tartalom')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                        'undo',
                        'redo',
                    ]),

                Toggle::make('is_active')
                    ->label('Aktív')
                    ->default(true),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Ha van már impresszum, frissítjük, ha nincs, létrehozzuk
        $impresszum = Impresszum::first();

        if ($impresszum) {
            $impresszum->update($data);
        } else {
            Impresszum::create($data);
        }

        Notification::make()
            ->title('Impresszum mentve')
            ->success()
            ->send();
    }

    public function getTitle(): string|Htmlable
    {
        return 'Impresszum szerkesztése';
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Mentés')
                ->action('save')
                ->color('primary'),
        ];
    }
}
