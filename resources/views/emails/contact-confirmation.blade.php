<x-emails :title="__('Contact message confirmation')" accent="#1a365d"
    :heading="__('Thank you for your message!')">
    <x-slot:styles>
        <x-emails.styles.contact-info />
    </x-slot:styles>

    <p>{{ __('Dear :name!', ['name' => $name]) }}</p>
    <p>
        {{ __('Thank you for contacting us. We have received your message and our colleague will contact you shortly.') }}
    </p>

    <p><strong>{{ __('Your message') }}:</strong></p>
    <div class="contact-info">
        <p><strong>{{ __('Subject') }}:</strong>
            {{ __($contact_subject) }}
        </p>
        <p style="margin-top: 15px;">{{ $userMessage }}</p>
    </div>

    <x-emails.contact-details />
</x-emails>
