<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\SendContactMessage;
use App\Models\Property;
use App\Models\Translate;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * The contact form of the contact page and of the property pages. On a property
 * page the subject is the building, preselected; elsewhere it is a general topic.
 */
final class ContactForm extends Component
{
    /** The property the form is shown on; null on the contact page. */
    #[Locked]
    public ?int $selectedPropertyId = null;

    /** Whether the subject list offers rental (true) or for-sale (false) buildings; null for general topics. */
    #[Locked]
    public ?bool $selectedPropertyTypeIsRent = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    public string $contact_subject = '';

    public string $message = '';

    public bool $privacy = false;

    public bool $sent = false;

    public function mount(): void
    {
        if ($this->selectedPropertyId !== null) {
            $this->contact_subject = (string) Property::query()->whereKey($this->selectedPropertyId)->value('title');
        }
    }

    /**
     * The subject options as value => label.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function subjects(): array
    {
        if ($this->selectedPropertyTypeIsRent === null) {
            return [
                'iroda_keresese' => __('contact.subject_office_search'),
                'iroda_kiadas' => __('contact.subject_office_rental'),
                'ingatlan_ertekeles' => __('contact.subject_property_valuation'),
                'befektetes' => __('contact.subject_investment'),
                'tanacadas' => __('contact.subject_consulting'),
                'egyeb' => __('contact.subject_other'),
            ];
        }

        $properties = Property::query()->active()
            ->when($this->selectedPropertyTypeIsRent, fn ($query) => $query->rent(), fn ($query) => $query->sale())
            ->orderBy('title')
            ->pluck('title');

        $translations = app()->getLocale() === 'en'
            ? Translate::query()->whereIn('name', $properties)->pluck('translated', 'name')
            : collect();

        return $properties
            ->mapWithKeys(fn (string $title): array => [$title => $translations->get($title) ?: $title])
            ->all();
    }

    public function submit(SendContactMessage $sendContactMessage): void
    {
        $validated = $this->validate(SendContactMessage::rules(), SendContactMessage::messages());

        try {
            $sendContactMessage->handle($validated);
        } catch (Exception $exception) {
            Log::error('Contact form email sending failed', [
                'error' => $exception->getMessage(),
                'data' => $validated,
            ]);

            $this->dispatch('notify',
                type: 'danger',
                title: __('Contact message failed to send!'),
                body: __('An error occurred while sending the message. Please try again later or call us by phone.'),
            );

            return;
        }

        $this->reset('name', 'email', 'phone', 'company', 'message', 'privacy');
        $this->sent = true;

        $this->dispatch('notify',
            type: 'success',
            title: __('Contact message sent successfully!'),
            body: __('Thank you for your message! We have sent a confirmation email to :email. We will contact you shortly.', ['email' => $validated['email']]),
        );
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
