<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\FavoritesSendMail;
use App\Models\Property;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

final class FavoritesSendModal extends Component
{
    public $showSendModal = false;

    public $recipientName;

    public $recipientEmail;

    public $salutation;

    public $bodyText;

    public $properties = [];

    protected $rules = [
        'recipientName' => 'required',
        'recipientEmail' => 'required|email',
    ];

    protected $listeners = ['openSendFavoritesModal' => 'showModal'];

    public function mount()
    {
        $this->bodyText = 'proba';
        $this->salutation = 'Cegem360';
        $this->loadProperties();
    }

    public function loadProperties()
    {
        $favorites = json_decode(Cookie::get('property_favorites', '[]'), true);
        $this->properties = Property::whereIn('id', $favorites)->get()->map(function ($property) {
            return [
                'title' => $property->title,
                'url' => route('properties.show', ['property' => $property->slug]),
            ];
        })->toArray();
    }

    public function sendFavorites()
    {
        $this->validate();
        Mail::to($this->recipientEmail)->send(new FavoritesSendMail(
            $this->recipientName,
            $this->salutation,
            $this->bodyText,
            $this->properties
        ));
        $this->showSendModal = false;
        session()->flash('success', 'Az ajánlatot elküldtük!');
    }

    public function showModal()
    {
        $this->showSendModal = true;
    }

    public function render()
    {
        return view('livewire.favorites-send-modal');
    }
}
