{{--
    A label / value row of the admin notification e-mails (CSS: <x-emails.styles.fields>).
    With `message` the row is rendered as the larger message box.

    <x-emails.field :label="__('Name')">{{ $name }}</x-emails.field>
--}}
@props(['label', 'message' => false])

<div class="{{ $message ? 'message-box' : 'field' }}">
    <div class="field-label">{{ $label }}:</div>
    <div class="field-value">{{ $slot }}</div>
</div>
