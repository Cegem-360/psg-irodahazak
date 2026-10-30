{{--
    A labelled text input bound to a Livewire property, with its validation error.
    `name` is both the wire:model target and the error key; `id` defaults to the name.

    <x-forms.input name="email" id="contact_email" type="email" :label="__('contact.email')"
        :placeholder="__('contact.email_placeholder')" required />
--}}
@props([
    'name',
    'id' => null,
    'label',
    'type' => 'text',
    'placeholder' => null,
    'required' => false,
])

@php
    $id ??= $name;
@endphp

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ $label }}{{ $required ? ' *' : '' }}</label>
    <input type="{{ $type }}" id="{{ $id }}" wire:model="{{ $name }}"
        @class(['block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors', 'border-red-500' => $errors->has($name)])
        placeholder="{{ $placeholder }}" @required($required)>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
