 <x-layouts.partials.ajanlat />
 <footer class="p-4 bg-white sm:p-12">
     <div class="mx-auto max-w-screen-xl">
         <div class="md:flex md:gap-8 md:justify-between">
             <div class="mb-6 md:mb-0">
                 <a href="/" class="flex items-center">
                     <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" class="mr-3 h-8 sm:h-16"
                         alt="PSG Irodaházak logo" loading="lazy">
                 </a>
             </div>
             <div class="flex gap-8 lg:gap-20 flex-wrap">
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Contact') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <h4 class="text-bold">Property Solution Group Kft.</h4>
                         </li>
                         <li class="mb-4">
                             <a href="tel:+36203813917 "
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200"> +36 20 381
                                 3917 </a>
                         </li>
                         <li class="mb-4">
                             <a href="mailto:info@psg-irodahazak.hu"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">info@psg-irodahazak.hu</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('kapcsolat') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('online contact') }}</a>
                         </li>
                         <li>
                             <a href="{{ route('filament.admin.auth.login') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200"
                                 title="Coming soon">{{ __('login') }}</a>
                         </li>
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Menu') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('home') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Homepage') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('kiado-irodak') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Rental Offices') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('elado-irodahazak') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Office Buildings for Sale') }}</a>
                         </li>
                         @if (app()->getLocale() === 'hu')
                             <li class="mb-4">
                                 <a href="{{ localized_route('news.index') }}"
                                     class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('News') }}</a>
                             </li>
                         @endif
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">&nbsp;</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('rolunk') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('About Us') }}</a>
                         </li>

                         </li>
                         <li>
                             <a href="{{ localized_route('kapcsolat') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Contact') }}</a>
                         </li>
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Legal Statements') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('privacy-policy') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Privacy Policy') }}</a>
                         </li>
                         <li>
                             <a href="{{ localized_route('impressum') }}"
                                 class="hover:underline hover:text-blue-600 transition-colors duration-200">{{ __('Imprint') }}</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
         <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
         <div class="sm:flex sm:items-center sm:justify-between">
             <span class="text-sm text-gray-500 sm:text-center">©2014-{{ date('Y') }} <a href="/"
                     class="hover:underline hover:text-blue-600 transition-colors duration-200">Property Solution
                     Group</a> - {{ __('All rights reserved.') }}</span>
             <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
                 <a href="https://www.facebook.com/psgirodahazak" target="_blank"
                     class="text-gray-500 hover:text-blue-600 transition-colors duration-200">
                     <x-svg.fb-icon />
                 </a>
             </div>
         </div>
     </div>
 </footer>
