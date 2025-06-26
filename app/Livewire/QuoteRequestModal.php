<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use App\Models\QuoteRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

final class QuoteRequestModal extends Component
{
    public $showModal = false;

    public $name = '';

    public $phone = '';

    public $email = '';

    public $message = '';

    public $selectedProperty;

    public $properties = [];

    public $privacy = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'message' => 'nullable|string|max:1000',
        'selectedProperty' => 'nullable|exists:properties,id',
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

    public function mount(): void
    {
        // Always show the small tab initially
        $this->showModal = false;

        // Load all active properties for dropdown
        $this->properties = Property::active()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();
    }

    public function openModal(): void
    {
        $this->showModal = true;
        session()->forget('quote_modal_closed');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
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
                'message' => $this->message,
                'property_id' => $this->selectedProperty,
                'property_name' => $this->selectedProperty ? Property::find($this->selectedProperty)?->title : null,
                'status' => 'new',
            ]);

            // Send email notification to admin
            Mail::send('emails.quote-request', [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'userMessage' => $this->message,
                'propertyName' => $this->selectedProperty ? Property::find($this->selectedProperty)?->title : 'Nincs megadva',
                'quoteId' => $quoteRequest->id,
            ], function ($message): void {
                $message->to('info@psg-irodahazak.hu')
                    ->subject('Új árajánlat kérés érkezett')
                    ->replyTo($this->email, $this->name);
            });

            // Send confirmation email to user
            Mail::send('emails.quote-confirmation', [
                'name' => $this->name,
                'propertyName' => $this->selectedProperty ? Property::find($this->selectedProperty)?->title : 'Nincs megadva',
            ], function ($message): void {
                $message->to($this->email, $this->name)
                    ->subject('Árajánlat kérés megerősítése - PSG Irodaházak');
            });

            session()->flash('success', 'Köszönjük az érdeklődését! Hamarosan felvesszük Önnel a kapcsolatot.');
            $this->closeModal();

        } catch (Exception $exception) {

            Log::error('Quote request submission failed', [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'message' => $this->message,
                'property_id' => $this->selectedProperty,
                'error' => $exception->getMessage(),
            ]);
            session()->flash('error', 'Hiba történt az árajánlat kérés küldése során. Kérjük, próbálja újra később.');
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
        $this->message = '';
        $this->selectedProperty = null;
        $this->privacy = false;
        $this->resetValidation();
    }
}
