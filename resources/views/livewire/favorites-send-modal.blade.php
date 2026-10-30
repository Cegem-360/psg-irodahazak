<div>
    <x-modal wire:model="showSendModal">
        <x-slot name="title">{{ __('Send favorites') }}</x-slot>
        <form wire:submit.prevent="sendFavorites" class="relative">
            <x-forms.honeypot id="favorites-website" />
            <div class="mb-4">
                <input type="text" wire:model.defer="recipientName" class="w-full p-2 border rounded"
                    placeholder="{{ __('Recipient name') }}" required />
            </div>
            <div class="mb-4">
                <input type="email" wire:model.defer="recipientEmail" class="w-full p-2 border rounded"
                    placeholder="{{ __('Recipient email address') }}" required />
            </div>
            <div class="mb-4">
                <textarea wire:model.defer="bodyText" class="w-full p-2 border rounded" placeholder="{{ __('Text') }}"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="$set('showSendModal', false)"
                    class="px-6 py-2 bg-gray-200 rounded">{{ __('Cancel') }}</button>
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded">{{ __('Submit') }}</button>
            </div>
        </form>
    </x-modal>
</div>
