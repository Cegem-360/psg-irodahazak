<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\ProtectsAgainstSpam;
use App\Models\QuoteRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

final class QuoteRequestModal extends Component
{
    use ProtectsAgainstSpam;

    public bool $showModal = false;

    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $company = '';

    public string $message = '';

    public string $subject = '';

    public bool $privacy = false;

    public function mount(): void
    {
        // Show modal only if not closed before (session)
        $this->showModal = ! Session::has('quote_modal_closed');
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'subject' => 'nullable|string|max:255',
            'privacy' => 'required|accepted',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Please enter your name.'),
            'phone.required' => __('Please enter your phone number.'),
            'email.required' => __('Please enter your email address.'),
            'email.email' => __('Please enter a valid email address.'),
            'privacy.required' => __('You must accept the privacy policy.'),
            'privacy.accepted' => __('You must accept the privacy policy.'),
        ];
    }

    #[On('open-request-quote-modal')]
    public function openModal(): void
    {
        $this->showModal = true;
        Session::forget('quote_modal_closed');
    }

    #[On('close-request-quote-modal')]
    public function closeModal(): void
    {
        $this->showModal = false;
        Session::put('quote_modal_closed', true);
        $this->resetForm();
    }

    public function submitForm(): void
    {
        $this->validate();

        if ($this->isBlockedAsSpam('quote-request', maxAttempts: 3, decaySeconds: 600)) {
            return;
        }

        try {
            // Create quote request
            $quoteRequest = QuoteRequest::query()->create([
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
                $message->from(config('mail.notification_from.address'), config('mail.notification_from.name'))
                    ->to(config('mail.admin_address'))
                    ->subject($this->subject ?: 'Új árajánlat kérés érkezett')
                    ->replyTo($this->email, $this->name);
            });
            Mail::send('emails.quote-request', [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'company' => $this->company,
                'subject' => $this->subject,
                'userMessage' => $this->message,
                'quoteId' => $quoteRequest->id,
            ], function ($message): void {
                $message->from(config('mail.notification_from.address'), config('mail.notification_from.name'))
                    ->to(config('mail.agent_address'))
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
            Log::info('Quote request emails sent', [
                'quote_request_id' => $quoteRequest->id,
                'email' => $this->email,
            ]);

            $this->dispatch('notify',
                type: 'success',
                title: 'Árajánlat kérés elküldve',
                body: "Köszönjük az árajánlat kérését! Visszaigazoló e-mailt küldtünk a(z) {$this->email} címre. Hamarosan felvesszük Önnel a kapcsolatot.",
            );
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
            $this->dispatch('notify',
                type: 'danger',
                title: 'Hiba történt',
                body: 'Sajnáljuk, az árajánlat kérés küldése sikertelen volt. Kérjük, próbálja újra később.',
            );

        }
    }

    public function render(): Factory|View
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
        $this->website = '';
        $this->resetValidation();
    }
}
