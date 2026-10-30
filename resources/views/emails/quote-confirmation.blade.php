<x-emails :title="__('Quote request confirmation')" accent="#3b82f6"
    :heading="__('Thank you for your quote request!')">
    <x-slot:styles>
        <x-emails.styles.contact-info />
    </x-slot:styles>

    <p>{{ __('Dear :name!', ['name' => $name]) }}</p>

    <p>{!! __('Thank you for requesting an online quote from us. We have received your request and our colleague will contact you <strong>within 24 hours</strong>.') !!}
    </p>

    <x-emails.contact-details />
</x-emails>
