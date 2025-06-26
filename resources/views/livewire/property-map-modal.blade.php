<div>
    <!-- Debug button - remove after testing -->

    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
            wire:key="property-map-modal">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-orange-500 px-6 py-4 relative">
                        <button wire:click="closeModal"
                            class="absolute top-2 right-2 text-white hover:text-gray-200 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-xl font-semibold text-white">Helyszín</h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="bg-white px-6 py-6">
                        <div class="text-gray-600">
                            <p class="text-lg font-medium mb-2">{{ $title['title'] }}</p>

                            <div class="mt-4 h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">Itt jelenik meg a térkép</p>
                                <!-- Itt lehet Google Maps vagy más térkép szolgáltatás integrálása -->
                                @if ($property)
                                    <!-- Debug információ -->
                                    <div class="absolute top-2 left-2 text-xs text-gray-400">
                                        ID: {{ $property->id }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
