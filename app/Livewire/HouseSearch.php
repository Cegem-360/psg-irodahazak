<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\House;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class HouseSearch extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    // public House $record;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('House Type')
                    ->options([
                        'proba' => 'Probation',
                    ])
                    ->required(),
                TextInput::make('location')
                    ->label('Location')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
    }

    public function render(): View
    {
        return view('livewire.house-search');
    }
}
