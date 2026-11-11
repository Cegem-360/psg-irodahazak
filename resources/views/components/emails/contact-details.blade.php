{{--
    The closing part of the confirmation e-mails sent to visitors: our contact
    details, opening hours, the sign-off and the "automated reply" note.
    CSS: <x-emails.styles.contact-info>.
--}}
<h3>{{ __('Our contact details') }}:</h3>
<div class="contact-info">
    <div class="contact-item">
        <strong>{{ __('Phone') }}:</strong>
        <span>+36 20 381 3917</span>
    </div>
    <div class="contact-item">
        <strong>{{ __('Email') }}:</strong>
        <span>info@psg-irodahazak.hu</span>
    </div>
    <div class="contact-item">
        <strong>{{ __('Office') }}:</strong>
        <span>1016 Budapest, Derék u. 2.</span>
    </div>
</div>

<h3>{{ __('Opening hours') }}:</h3>
<div class="contact-info">
    <div class="contact-item">
        <strong>{{ __('Monday-Friday') }}:</strong>
        <span>9:00 - 18:00</span>
    </div>
    <div class="contact-item">
        <strong>{{ __('Saturday') }}:</strong>
        <span>10:00 - 14:00</span>
    </div>
    <div class="contact-item">
        <strong>{{ __('Sunday') }}:</strong>
        <span>{{ __('Closed') }}</span>
    </div>
</div>

<p>{{ __('If you have an urgent question, please call us at :phone.', ['phone' => '+36 20 381 3917']) }}</p>

<p style="margin-top: 30px;">
    {{ __('Kind regards') }},<br>
    <strong>{{ __('The PSG Irodaházak team') }}</strong>
</p>

<p style="margin-top: 30px; font-size: 14px; color: #666;">
    {{ __('This is an automated reply. Please do not reply to this email.') }}
</p>
