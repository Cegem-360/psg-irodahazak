<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-orange-500 px-6 py-4 relative">
                        <button wire:click="closeModal"
                            class="absolute top-2 right-2 text-white hover:text-gray-200 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-xl font-semibold text-white">Kapcsolat</h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="bg-white px-6 py-6">
                        <div class="text-gray-600">
                            <div class="mb-4">
                            </div>
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <div>
                                    <p class="font-medium">Telefon</p>
                                    <a href="tel:+36301234567" class="text-orange-500 hover:text-orange-600 text-lg">+36
                                        30 123 4567</a>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <div>
                                    <p class="font-medium">Email</p>
                                    <a href="mailto:info@psg-irodahazak.hu"
                                        class="text-orange-500 hover:text-orange-600">info@psg-irodahazak.hu</a>
                                </div>
                            </div>
                            @if ($property && $property->contact_person)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">Kapcsolattartó</p>
                                        <p>{{ $property->contact_person }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
