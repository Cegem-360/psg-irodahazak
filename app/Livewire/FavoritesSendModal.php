<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\ProtectsAgainstSpam;
use App\Mail\FavoritesSendMail;
use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class FavoritesSendModal extends Component
{
    use ProtectsAgainstSpam;

    public bool $showSendModal = false;

    #[Validate('required')]
    public string $recipientName = '';

    #[Validate('required|email')]
    public string $recipientEmail = '';

    public string $bodyText = '';

    /**
     * The links that go into the email; locked so the client cannot swap in arbitrary URLs.
     *
     * @var list<array{title: string, url: string}>
     */
    #[Locked]
    public array $properties = [];

    public function mount(): void
    {
        $this->loadProperties();
    }

    public function loadProperties(): void
    {
        $favorites = json_decode((string) Cookie::get('property_favorites', '[]'), true);
        $favorites = is_array($favorites) ? $favorites : [];
        $this->properties = Property::query()->active()->whereIn('id', $favorites)->get()->map(fn ($property): array => [
            'title' => $property->title,
            'url' => URL::temporarySignedRoute(
                app()->getLocale() === 'en'
                    ? ($property->isRent() ? 'en.properties.show' : 'en.properties.show-for-sale')
                    : ($property->isRent() ? 'properties.show' : 'properties.show-for-sale'),
                now()->addDays(12),
                ['property' => $property->slug]),

        ])->all();
    }

    public function sendFavorites(): void
    {
        $this->validate();

        if ($this->isBlockedAsSpam('favorites-send', maxAttempts: 5, decaySeconds: 3600)) {
            return;
        }

        Mail::to($this->recipientEmail)->send(new FavoritesSendMail(
            $this->recipientName,
            $this->bodyText,
            $this->properties
        ));
        $this->showSendModal = false;
        $this->dispatch('notify',
            type: 'success',
            title: __('Favorites sent'),
            body: __('We have sent the offer to :email!', ['email' => $this->recipientEmail]),
        );
        Cookie::queue(Cookie::forget('property_favorites'));
        session()->flash('success', __('The favorites list has been cleared!'));
    }

    #[On('openSendFavoritesModal')]
    public function showModal(): void
    {
        $this->showSendModal = true;
    }

    public function render(): Factory|View
    {
        return view('livewire.favorites-send-modal');
    }
}
