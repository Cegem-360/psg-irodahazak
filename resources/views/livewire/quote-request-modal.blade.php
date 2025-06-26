<div>
    <div>
        <!-- Small Tab (default state) - hover to expand -->
        @if (!$showModal)
            <div class="fixed top-1/4 right-0 transform -translate-y-1/2 z-50 group">
                <div
                    class="bg-orange-500 hover:bg-orange-600 text-white rounded-l-lg shadow-lg transition-all duration-300 ease-in-out overflow-hidden
                           w-12 group-hover:w-auto py-3 px-3">

                    <!-- Content wrapper -->
                    <div class="flex items-center group-hover:flex-col group-hover:space-y-2 space-x-0">
                        <!-- Icon - always visible -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 5c0-1.1.9-2 2-2h2V1h10v2h2c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5zm12 5c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h7c.55 0 1-.45 1-1zm-3 4c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1h4c.55 0 1-.45 1-1z" />
                        </svg>

                        <!-- Text and phone - appears on hover -->
                        <div class="hidden group-hover:block">
                            <div class="text-center mb-2">
                                <div class="text-sm font-bold whitespace-nowrap">{{ __('modal.online') }}</div>
                                <div class="text-sm whitespace-nowrap">{{ __('modal.quote_request') }}</div>
                            </div>

                            <!-- Phone number - clickable -->
                            <a href="tel:+36203813917"
                                class="relative z-20 flex items-center justify-center space-x-1 text-white hover:text-yellow-300 transition-colors duration-200 p-1 rounded hover:bg-orange-600"
                                onclick="event.stopPropagation()">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span class="text-xs hover:underline cursor-pointer">+36 20 381 3917</span>
                            </a>
                        </div>
                    </div>

                    <!-- Modal open button (invisible overlay) -->
                    <button wire:click="openModal" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        title="{{ __('modal.quote_request_title') }}">
                    </button>
                </div>
            </div>
        @endif

        <!-- Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true" x-data x-init="document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        $wire.closeModal();
                    }
                });">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal">
                    </div>

                    <!-- Modal panel -->
                    <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        onclick="event.stopPropagation()">
                        <!-- Modal Header (Orange) -->
                        <div class="bg-orange-500 px-6 py-4 relative">
                            <button wire:click="closeModal"
                                class="absolute top-2 right-2 text-white hover:text-gray-200 p-2 z-10" type="button"
                                title="{{ __('modal.close') }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <h3 class="text-lg font-semibold text-white">{{ __('modal.online_contact') }}</h3>
                        </div>

                        <!-- Modal Body -->
                        <div class="bg-white px-6 py-6">
                            @if (session()->has('success'))
                                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                    <div class="flex">
                                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ session('success') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if (session()->has('error'))
                                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                    <div class="flex">
                                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ session('error') }}</span>
                                    </div>
                                </div>
                            @endif

                            <form wire:submit.prevent="submitForm" class="space-y-4">
                                <!-- Name Field -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }}</label>
                                    <input type="text" id="name" wire:model="name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                        placeholder="{{ __('modal.enter_your_name') }}">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Company Field -->
                                <div>
                                    <label for="company"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('modal.company_name') }}</label>
                                    <input type="text" id="company" wire:model="company"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('company') border-red-500 @enderror"
                                        placeholder="{{ __('modal.enter_company_name') }}">
                                    @error('company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Field -->
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('modal.phone_number') }}</label>
                                    <input type="tel" id="phone" wire:model="phone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                        placeholder="+36 20 381 3917">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('modal.email_address') }}</label>
                                    <input type="email" id="email" wire:model="email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                        placeholder="pelda@email.hu">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Property Selection -->
                                <div>
                                    <label for="property"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('modal.office_building_name') }}</label>
                                    <select id="property" wire:model="selectedProperty"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">{{ __('modal.select_office_building') }}</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}">{{ $property->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Message Field -->
                                <div>
                                    <label for="message"
                                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Message') }}</label>
                                    <textarea id="message" wire:model="message" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="{{ __('modal.write_your_request') }}"></textarea>
                                </div>

                                <!-- Privacy Checkbox -->
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="privacy" type="checkbox" wire:model="privacy"
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 @error('privacy') border-red-500 @enderror">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="privacy" class="font-light text-gray-500">
                                            {{ __('modal.i_accept_the') }}
                                            <a class="font-medium text-blue-600 hover:underline"
                                                href="{{ localized_route('privacy-policy') }}" target="_blank">
                                                {{ __('modal.privacy_policy') }}
                                            </a>
                                        </label>
                                        @error('privacy')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone Display -->
                                <div class="flex items-center justify-center">
                                    <a href="tel:+36203813917"
                                        class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg cursor-pointer">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span class="font-medium hover:underline">
                                            +36 20 381 3917
                                        </span>
                                    </a>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex space-x-3 pt-4">
                                    <button type="button" wire:click="closeModal"
                                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                        {{ __('modal.cancel') }}
                                    </button>
                                    <button type="submit"
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                        {{ __('modal.send') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
