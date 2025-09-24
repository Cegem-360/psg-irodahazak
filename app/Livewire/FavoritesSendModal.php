<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\FavoritesSendMail;
use App\Models\Property;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

final class FavoritesSendModal extends Component
{
    public $showSendModal = false;

    public $recipientName;

    public $recipientEmail;

    public $bodyText;

    public $properties = [];

    protected $rules = [
        'recipientName' => 'required',
        'recipientEmail' => 'required|email',
    ];

    protected $listeners = ['openSendFavoritesModal' => 'showModal'];

    public function mount(): void
    {
        $this->bodyText = 'proba';
        $this->loadProperties();
    }

    public function loadProperties(): void
    {
        $favorites = json_decode(Cookie::get('property_favorites', '[]'), true);
        $this->properties = Property::whereIn('id', $favorites)->get()->map(function ($property): array {
            return [
                'title' => $property->title,
                'url' => URL::temporarySignedRoute(
                    app()->getLocale() === 'en'
                        ? ($property->isRent() ? 'en.properties.show' : 'en.properties.show-for-sale')
                        : ($property->isRent() ? 'properties.show' : 'properties.show-for-sale'),
                    now()->addDays(12),
                    ['property' => $property->slug]),

            ];
        })->toArray();
    }

    public function sendFavorites(): void
    {
        $this->validate();
        Mail::to($this->recipientEmail)->send(new FavoritesSendMail(
            $this->recipientName,
            $this->bodyText,
            $this->properties
        ));
        $this->showSendModal = false;
        Notification::make()
            ->title('Kedvencek elküldve')
            ->body('Az ajánlatot elküldtük!')
            ->success()
            ->send();
        session()->flash('success', 'Az ajánlatot elküldtük!');
        Cookie::queue(Cookie::forget('property_favorites'));
        session()->flash('success', 'A kedvencek listája kiürítve!');
    }

    public function showModal(): void
    {
        $this->showSendModal = true;
    }

    public function render()
    {
        return view('livewire.favorites-send-modal');
    }
}
