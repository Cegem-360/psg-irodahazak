 <x-layouts.partials.ajanlat />
 <footer class="p-4 bg-white sm:p-12">
     <div class="mx-auto max-w-screen-xl">
         <div class="md:flex md:gap-8 md:justify-between">
             <div class="mb-6 md:mb-0">
                 <a href="/" class="flex items-center">
                     <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" class="mr-3 h-8 sm:h-16"
                         alt="PSG Irodaházak logo" />
                 </a>
             </div>
             <div class="flex gap-8 lg:gap-20 flex-wrap">
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Contact') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <h4 class="text-sm text-bold">Property Solution Group Kft.</h4>
                         </li>
                         <li class="mb-4">
                             <a href="tel:+36203813917 " class="hover:underline"> +36 20 381 3917 </a>
                         </li>
                         <li class="mb-4">
                             <a href="mailto:info@psg-irodahazak.hu" class="hover:underline">info@psg-irodahazak.hu</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('kapcsolat') }}"
                                 class="hover:underline">{{ __('online contact') }}</a>
                         </li>
                         <li>
                             <a href="#" class="hover:underline"
                                 title="Coming soon">{{ __('login / registration') }}</a>
                         </li>
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Menu') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('home') }}" class="hover:underline ">{{ __('Home') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('kiado-irodak') }}"
                                 class="hover:underline ">{{ __('Rental Offices') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('elado-irodahazak') }}"
                                 class="hover:underline ">{{ __('Office Buildings for Sale') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('news.index') }}"
                                 class="hover:underline ">{{ __('News') }}</a>
                         </li>
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">&nbsp;</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('rolunk') }}"
                                 class="hover:underline ">{{ __('About Us') }}</a>
                         </li>
                         <li class="mb-4">
                             <a href="{{ localized_route('blog.index') }}"
                                 class="hover:underline ">{{ __('Blog') }}</a>
                         </li>
                         <li>
                             <a href="{{ localized_route('kapcsolat') }}"
                                 class="hover:underline">{{ __('Contact') }}</a>
                         </li>
                     </ul>
                 </div>
                 <div>
                     <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">{{ __('Legal Statements') }}</h2>
                     <ul class="text-gray-600">
                         <li class="mb-4">
                             <a href="{{ localized_route('privacy-policy') }}"
                                 class="hover:underline">{{ __('Privacy Policy') }}</a>
                         </li>
                         <li>
                             <a href="{{ localized_route('impresszum') }}"
                                 class="hover:underline">{{ __('Imprint') }}</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
         <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
         <div class="sm:flex sm:items-center sm:justify-between">
             <span class="text-sm text-gray-500 sm:text-center">©2014-{{ date('Y') }} <a href="/"
                     class="hover:underline">Property Solution Group</a> - {{ __('All rights reserved.') }}</span>
             <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
                 <a href="https://www.facebook.com/psgirodahazak" target="_blank"
                     class="text-gray-500 hover:text-gray-900">
                     <x-svg.fb-icon />
                 </a>
             </div>
         </div>
     </div>
 </footer>
