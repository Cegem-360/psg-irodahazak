<div>
    <x-modal wire:model="showSendModal">
        <x-slot name="title">Kedvencek kiküldése</x-slot>
        <form wire:submit.prevent="sendFavorites">
            <div class="mb-4">
                <input type="text" wire:model.defer="recipientName" class="w-full p-2 border rounded"
                    placeholder="Címzett neve" required />
            </div>
            <div class="mb-4">
                <input type="email" wire:model.defer="recipientEmail" class="w-full p-2 border rounded"
                    placeholder="Címzett e-mail címe" required />
            </div>
            <div class="mb-4">
                <textarea wire:model.defer="bodyText" class="w-full p-2 border rounded" placeholder="Szöveg"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="$set('showSendModal', false)"
                    class="px-6 py-2 bg-gray-200 rounded">Mégse</button>
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded">Elküld</button>
            </div>
        </form>
    </x-modal>
</div>
