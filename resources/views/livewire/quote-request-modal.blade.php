<div>
    <!-- Floating Quote Request Button (Orange) -->
    @if(!$showModal && !$modalClosed)
        <div class="fixed top-1/2 right-0 transform -translate-y-1/2 z-50 transition-all duration-300 ease-in-out">
            <button 
                wire:click="openModal"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-l-lg shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 5c0-1.1.9-2 2-2h2V1h10v2h2c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5zm12 5c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h7c.55 0 1-.45 1-1zm-3 4c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h4c.55 0 1-.45 1-1z"/>
                </svg>
                <div class="text-left">
                    <div class="text-sm font-bold">ONLINE</div>
                    <div class="text-sm">AJÁNLATKÉRÉS!</div>
                </div>
            </button>
        </div>
    @endif

    <!-- Small Tab when Modal is Closed -->
    @if($showTab && !$showModal)
        <div class="fixed top-1/2 right-0 transform -translate-y-1/2 z-50">
            <button 
                wire:click="openModal"
                class="bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-l-lg shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105"
                title="Árajánlat kérés"
            >
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 5c0-1.1.9-2 2-2h2V1h10v2h2c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5zm12 5c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h7c.55 0 1-.45 1-1zm-3 4c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h4c.55 0 1-.45 1-1z"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header (Blue) -->
                    <div class="bg-blue-500 px-6 py-4 relative">
                        <button 
                            wire:click="closeModal"
                            class="absolute top-2 right-2 text-white hover:text-gray-200 p-2"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-lg font-semibold text-white">Online kapcsolatfelvétel</h3>
                    </div>

                    <!-- Modal Body -->
                    <div class="bg-white px-6 py-6">
                        @if (session()->has('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <form wire:submit.prevent="submitForm" class="space-y-4">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Név</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    wire:model="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    placeholder="Adja meg a nevét"
                                >
                                @error('name') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefonszám</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    wire:model="phone"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                    placeholder="+36 20 381 3917"
                                >
                                @error('phone') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail cím</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    wire:model="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                    placeholder="pelda@email.hu"
                                >
                                @error('email') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Property Selection -->
                            <div>
                                <label for="property" class="block text-sm font-medium text-gray-700 mb-1">Irodaház neve</label>
                                <select 
                                    id="property" 
                                    wire:model="selectedProperty"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Válasszon irodaházat</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}">{{ $property->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Üzenet</label>
                                <textarea 
                                    id="message" 
                                    wire:model="message"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Írja le kérését..."
                                ></textarea>
                            </div>

                            <!-- Privacy Checkbox -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input 
                                        id="privacy" 
                                        type="checkbox" 
                                        wire:model="privacy"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 @error('privacy') border-red-500 @enderror"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy" class="font-light text-gray-500">
                                        Elfogadom az 
                                        <a class="font-medium text-blue-600 hover:underline" href="{{ localized_route('privacy-policy') }}" target="_blank">
                                            Adatkezelési tájékoztatót
                                        </a>
                                    </label>
                                    @error('privacy') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Display -->
                            <div class="flex items-center justify-center bg-gray-50 p-3 rounded-md">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <span class="text-gray-700 font-medium">+36 20 381 3917</span>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex space-x-3 pt-4">
                                <button 
                                    type="button"
                                    wire:click="closeModal"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors duration-200"
                                >
                                    MÉGSE
                                </button>
                                <button 
                                    type="submit"
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200"
                                >
                                    ELKÜLD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
