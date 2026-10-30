<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\SendQuoteRequest;
use App\Enums\InquirySubject;
use App\Livewire\Concerns\ProtectsAgainstSpam;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'subject' => ['nullable', Rule::enum(InquirySubject::class)],
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

    public function submitForm(SendQuoteRequest $sendQuoteRequest): void
    {
        $validated = $this->validate();

        if ($this->isBlockedAsSpam('quote-request', maxAttempts: 3, decaySeconds: 600)) {
            return;
        }

        try {
            $quoteRequest = $sendQuoteRequest->handle(Arr::except($validated, ['privacy']));
        } catch (Exception $exception) {
            // The request itself may already be saved; the visitor's details are in the database, not the log.
            Log::error('Quote request submission failed', ['error' => $exception->getMessage()]);

            $this->dispatch('notify',
                type: 'danger',
                title: __('An error occurred'),
                body: __('Sorry, the quote request could not be sent. Please try again later.'),
            );

            return;
        }

        Log::info('Quote request emails sent', ['quote_request_id' => $quoteRequest->id]);

        $this->dispatch('notify',
            type: 'success',
            title: __('Quote request sent'),
            body: __('Thank you for your quote request! We have sent a confirmation email to :email. We will contact you shortly.', ['email' => $quoteRequest->email]),
        );

        $this->closeModal();
    }

    public function render(): Factory|View
    {
        return view('livewire.quote-request-modal');
    }

    private function resetForm(): void
    {
        $this->reset('name', 'phone', 'email', 'company', 'message', 'subject', 'privacy', 'website');
        $this->resetValidation();
    }
}
