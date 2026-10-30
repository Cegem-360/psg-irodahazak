{{--
    The closing part of the confirmation e-mails sent to visitors: our contact
    details, opening hours, the sign-off and the "automated reply" note.
    CSS: <x-emails.styles.contact-info>.
--}}
@php
    $contactDetails = [
        __('Phone') => '+36 20 381 3917',
        __('Email') => 'info@psg-irodahazak.hu',
        __('Office') => '1016 Budapest, Derék u. 2.',
    ];

    $openingHours = [
        __('Monday-Friday') => '9:00 - 18:00',
        __('Saturday') => '10:00 - 14:00',
        __('Sunday') => __('Closed'),
    ];
@endphp

<h3>{{ __('Our contact details') }}:</h3>
<div class="contact-info">
    @foreach ($contactDetails as $label => $value)
        <div class="contact-item">
            <strong>{{ $label }}:</strong>
            <span>{{ $value }}</span>
        </div>
    @endforeach
</div>

<h3>{{ __('Opening hours') }}:</h3>
<div class="contact-info">
    @foreach ($openingHours as $label => $value)
        <div class="contact-item">
            <strong>{{ $label }}:</strong>
            <span>{{ $value }}</span>
        </div>
    @endforeach
</div>

<p>{{ __('If you have an urgent question, please call us at :phone.', ['phone' => '+36 20 381 3917']) }}</p>

<p style="margin-top: 30px;">
    {{ __('Kind regards') }},<br>
    <strong>{{ __('The Property Solution Group team') }}</strong>
</p>

<p style="margin-top: 30px; font-size: 14px; color: #666;">
    {{ __('This is an automated reply. Please do not reply to this email.') }}
</p>
