<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-orange-500 px-8 py-5">
                        <h3 class="text-2xl font-semibold text-white text-center">Kapcsolatfelvétel</h3>
                    </div> <!-- Modal Body -->
                    <div class="bg-white px-6 py-6">
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <a href="mailto:info@psg-irodahazak.hu"
                                class="bg-blue-600 text-white text-center px-4 py-3 hover:bg-blue-700 transition-colors text-sm font-medium">
                                INFO@PSG-IRODAHAZAK.HU
                            </a>

                            <a href="tel:+36203813917"
                                class="bg-blue-600 text-white text-center px-4 py-3 hover:bg-blue-700 transition-colors text-sm font-medium">
                                +36 20 381 3917
                            </a>

                            <a href="#"
                                class="bg-blue-600 text-white text-center px-4 py-3 hover:bg-blue-700 transition-colors text-sm font-medium">
                                ONLINE KAPCSOLATFELVÉTEL
                            </a>
                        </div>

                        @if ($property && $property->contact_person)
                            <div class="text-center mb-6 pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600">Kapcsolattartó</p>
                                <p class="text-gray-900 font-medium">{{ $property->contact_person }}</p>
                            </div>
                        @endif

                        <div class="text-center">
                            <button wire:click="closeModal"
                                class="bg-white text-gray-700 px-8 py-2 border border-gray-300 hover:bg-gray-50 transition-colors">
                                MÉGSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
