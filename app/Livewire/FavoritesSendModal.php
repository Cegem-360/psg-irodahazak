<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\ProtectsAgainstSpam;
use App\Mail\FavoritesSendMail;
use App\Services\FavoriteProperties;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Emails the visitor's favorite properties to a recipient, then empties the list.
 */
final class FavoritesSendModal extends Component
{
    use ProtectsAgainstSpam;

    public bool $showSendModal = false;

    #[Validate('required|string|max:255')]
    public string $recipientName = '';

    #[Validate('required|email|max:255')]
    public string $recipientEmail = '';

    #[Validate('nullable|string|max:2000')]
    public string $bodyText = '';

    public function sendFavorites(FavoriteProperties $favorites): void
    {
        $this->validate();

        // Read from the cookie at send time, so the email matches the list on screen.
        $properties = $favorites->properties();

        if ($properties->isEmpty()) {
            $this->addError('recipientEmail', __('Your favorites list is empty.'));

            return;
        }

        if ($this->isBlockedAsSpam('favorites-send', maxAttempts: 5, decaySeconds: 3600)) {
            return;
        }

        Mail::to($this->recipientEmail)->send(new FavoritesSendMail($this->recipientName, $this->bodyText, $properties));

        $favorites->clear();
        $this->dispatch('set-cookie', name: FavoriteProperties::COOKIE, value: '[]', days: 365);
        $this->dispatch('refresh-favorites');

        $this->dispatch('notify',
            type: 'success',
            title: __('Favorites sent'),
            body: __('We have sent the offer to :email!', ['email' => $this->recipientEmail]),
        );

        $this->reset('showSendModal', 'recipientName', 'recipientEmail', 'bodyText');
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
