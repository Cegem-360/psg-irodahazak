<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use App\Models\QuoteRequest;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

final class QuoteRequestModal extends Component
{
    public $showModal = false;

    public $name = '';

    public $phone = '';

    public $email = '';

    public $company = '';

    public $message = '';

    public $subject = '';

    public $properties = [];

    public $privacy = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'company' => 'nullable|string|max:255',
        'message' => 'nullable|string|max:1000',
        'subject' => 'nullable|string|max:255',
        'privacy' => 'required|accepted',
    ];

    protected $messages = [
        'name.required' => 'A név megadása kötelező.',
        'phone.required' => 'A telefonszám megadása kötelező.',
        'email.required' => 'Az email cím megadása kötelező.',
        'email.email' => 'Kérjük, adjon meg egy érvényes email címet.',
        'privacy.required' => 'Az adatvédelmi nyilatkozat elfogadása kötelező.',
        'privacy.accepted' => 'Az adatvédelmi nyilatkozat elfogadása kötelező.',
    ];

    protected $listeners = [
        'open-request-quote-modal' => 'openModal',
        'close-request-quote-modal' => 'closeModal',
    ];

    public function mount(): void
    {

        // Show modal only if not closed before (session)
        $this->showModal = ! Session::has('quote_modal_closed');

        // Load all active properties for dropdown
        $this->properties = Property::active()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();
    }

    public function openModal(): void
    {
        $this->showModal = true;
        Session::forget('quote_modal_closed');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        Session::put('quote_modal_closed', true);
        $this->resetForm();
    }

    public function submitForm(): void
    {
        $this->validate();

        try {
            // Create quote request
            $quoteRequest = QuoteRequest::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'company' => $this->company,
                'message' => $this->message,
                'subject' => $this->subject,
                'status' => 'new',
            ]);

            // Send email notification to admin
            Mail::send('emails.quote-request', [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'company' => $this->company,
                'subject' => $this->subject,
                'userMessage' => $this->message,
                'quoteId' => $quoteRequest->id,
            ], function ($message): void {
                $message->to('info@psg-irodahazak.hu')
                    ->subject($this->subject ?: 'Új árajánlat kérés érkezett')
                    ->replyTo($this->email, $this->name);
            });

            // Send confirmation email to user
            Mail::send('emails.quote-confirmation', [
                'name' => $this->name,
            ], function ($message): void {
                $message->to($this->email, $this->name)
                    ->subject($this->subject ?: 'Árajánlat kérés megerősítése - PSG Irodaházak');
            });
            Notification::make()
                ->title('Árajánlat kérés sikeres')
                ->body('Köszönjük az árajánlat kérését! Hamarosan felvesszük Önnel a kapcsolatot.')
                ->success()
                ->send();
            $this->closeModal();

        } catch (Exception $exception) {

            Log::error('Quote request submission failed', [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'company' => $this->company,
                'message' => $this->message,
                'subject' => $this->subject,
                'error' => $exception->getMessage(),
            ]);
            Notification::make()
                ->title('Hiba történt')
                ->body('Sajnáljuk, az árajánlat kérés küldése sikertelen volt. Kérjük, próbálja újra később.')
                ->danger()
                ->send();

        }
    }

    public function render()
    {
        return view('livewire.quote-request-modal');
    }

    private function resetForm(): void
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->company = '';
        $this->message = '';
        $this->subject = '';
        $this->privacy = false;
        $this->resetValidation();
    }
}
