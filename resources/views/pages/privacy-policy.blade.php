<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('Privacy Policy'), 'url' => localized_route('privacy-policy')],
]">
    <x-slot name="title">{{ __('Privacy Notice | PSG Irodaházak') }}</x-slot>
    <x-slot name="metaDescription">{{ __('The general privacy notice of Property Solution Group Kft. for visitors and clients of the psg-irodahazak.hu website.') }}</x-slot>
    <x-page-section>
        <h1 class="text-2xl font-bold mb-4">{{ __('General Privacy Notice') }}</h1>
        <ul class="mb-6">
            <li><strong>{{ __('Company name:') }}</strong> Property Solution Group Kft.</li>
            <li><strong>{{ __('Registered office:') }}</strong> 1016 Budapest, Derék utca 2.</li>
            <li><strong>{{ __('Company registration number:') }}</strong> 01-09-191972</li>
            <li><strong>{{ __('Tax number:') }}</strong> 24963200-2-41</li>
        </ul>
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">{{ __('Data controller and data processor roles') }}</h2>
            <p>
                {!! __('As a <strong>data controller</strong>, our company determines the purposes and means of processing personal data alone or jointly with others, and as a <strong>data processor</strong> it processes personal data on behalf of the data controller.') !!}
            </p>
            <p>
                {!! __('<strong>Data processing (controlling)</strong> means any operation or set of operations performed on personal data or sets of personal data, whether or not by automated means, such as collection, recording, organisation, structuring, storage, adaptation or alteration, retrieval, consultation, use, disclosure by transmission, dissemination or otherwise making available, alignment or combination, restriction, erasure or destruction.') !!}
            </p>
            <p>
                {!! __('<strong>Data processing on behalf of a controller</strong> is data handling of a technical nature, without any right of disposal or decision over the data.') !!}
            </p>
            <p>
                {!! __('<strong>Personal data</strong> means any information relating to an identified or identifiable natural person ("data subject"). An identifiable natural person is one who can be identified, directly or indirectly, in particular by reference to an identifier such as a name, an identification number, location data, an online identifier or to one or more factors specific to the physical, physiological, genetic, mental, economic, cultural or social identity of that natural person.') !!}
            </p>
            <p>
                {{ __('As a data controller and data processor, our company respects the privacy of all persons who provide personal data to it and is committed to protecting such data.') }}
            </p>
        </section>
        <section class="mb-6">
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-2">I.</h3>
                <p class="mb-2">
                    {{ __('Pursuant to Article 13 of the GDPR, our company provides the following information to data subjects:') }}
                </p>
                <div class="mb-2">
                    <span class="font-semibold">{{ __('Data controller details:') }}</span>
                    <ul class="list-none ml-0">
                        <li>{{ __('Company name:') }} Property Solution Group Kft.</li>
                        <li>{{ __('Registered office:') }} 1016 Budapest, Derék utca 2.</li>
                        <li>{{ __('Web page:') }} psg-irodahazak.hu</li>
                        <li>{{ __('Contact person: :name, managing director', ['name' => 'Fekete József Richárd']) }}</li>
                        <li>{{ __('Phone:') }} +36 20 381 3917</li>
                        <li>{{ __('E-mail:') }} info@psg-irodahazak.hu</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">{{ __('Data processing:') }}</span>
                    <div class="mb-2">
                        <span class="underline">{{ __('Data processors:') }}</span>
                        <div class="mt-2">
                            <span class="font-semibold">{{ __('CRM system') }}</span>
                            <ul class="list-none ml-0">
                                <li>{{ __('Name:') }} DevMonkeys Software Kft. (MomoCRM)</li>
                                <li>{{ __('Address:') }} 1141 Budapest, Vízakna utca 4.</li>
                                <li>{{ __('Phone:') }} +36 20 500 1530</li>
                                <li>{{ __('E-mail:') }} hello@momocrm.hu</li>
                                <li>{{ __('Website:') }} <a href="https://momocrm.com/"
                                        class="text-blue-600 underline">https://momocrm.com/</a></li>
                                <li>{{ __('Stored data:') }} {{ __('data stored in the CRM system') }}</li>
                                <li>{{ __('Operations:') }} {{ __('operation of the CRM system') }}</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">{{ __('Web analytics') }}</span>
                            <ul class="list-none ml-0">
                                <li>{{ __('Name:') }} Google Ireland Limited</li>
                                <li>{{ __('Address:') }} Gordon House Barrow Street Dublin 4, Ireland</li>
                                <li>{{ __('Phone:') }} N/A</li>
                                <li>{{ __('E-mail:') }} N/A</li>
                                <li>{{ __('Website:') }} <a href="https://www.google.com/"
                                        class="text-blue-600 underline">https://www.google.com/</a></li>
                                <li>{{ __('Stored data:') }} {{ __('website visit data, visitor identification cookie') }}</li>
                                <li>{{ __('Operations:') }} {{ __('analysis of website visit data') }}</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">{{ __('Development, server services, data backups, email and document management') }}</span>
                            <ul class="list-none ml-0">
                                <li>{{ __('Name:') }} e-Communication Kft.</li>
                                <li>{{ __('Address:') }} 1141 Budapest, Vízakna utca 4.</li>
                                <li>{{ __('Phone:') }} +36 1 613 2634</li>
                                <li>{{ __('E-mail:') }} hello@e-com.hu</li>
                                <li>{{ __('Website:') }} <a href="https://e-com.hu/"
                                        class="text-blue-600 underline">https://e-com.hu/</a></li>
                                <li>{{ __('Stored data:') }} {{ __('correspondence, calendar entries, phone contacts, encrypted static files.') }}<br>
                                    {{ __('encrypted data backups') }}</li>
                                <li>{{ __('Operations:') }} {{ __('email service, document management, calendar service, hosting, server monitoring') }}</li>
                            </ul>
                            <ul class="list-disc ml-6 mt-2 text-sm">
                                <li>{{ __('Only the narrowest necessary group of people has access to servers containing live data.') }}</li>
                                <li>{{ __('All access is strictly logged and protected in multiple ways with SSH keys and passwords.') }}
                                </li>
                                <li>{{ __('The data processor may only carry out instructions that are recorded in writing.') }}</li>
                                <li>{{ __('A written contract must be concluded between the data controller and the data processor, which must specify the data transferred by the data controller to the data processor and the activities the data processor performs with them.') }}</li>
                                <li>{{ __('Employees handling personal data are bound by confidentiality.') }}
                                </li>
                                <li>{{ __('To guarantee data security, the data processor implements organisational and technical measures.') }}</li>
                                <li>{{ __('The data processor assists the data controller in fulfilling its obligations.') }}
                                </li>
                                <li>{{ __('At the choice of the data controller, the data processor returns all personal data to the data controller or deletes it and deletes existing copies, with one exception: if Member State or Union law requires the storage of the data.') }}</li>
                                <li>{{ __('The data processor facilitates and allows audits and on-site inspections conducted by the data controller or by an auditor mandated by it.') }}</li>
                                <li>{{ __('If the data processor engages another data processor, the same obligations apply to it as were originally established by the contract between the data processor and the data controller.') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">{{ __('Data protection officer:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('Pursuant to Article 37 of the GDPR, our company is not obliged to appoint a data protection officer') }}
                        </li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">{{ __('Data protection requests:') }}</span>
                    <span>
                        {{ __('if you have any request or question regarding data processing, you can send your request by post to 1016 Budapest, Derék utca 2. or electronically to info@psg-irodahazak.hu. We will send our reply without delay, but no later than within 30 days, to the address you specify.') }}
                    </span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">{{ __('Data transfers abroad:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('we do not transfer data outside the European Economic Area (EEA).') }}</li>
                    </ul>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-2">II.</h3>
                <span class="font-semibold">{{ __('Purpose, legal basis and duration of our company\'s data processing:') }}</span>
                <div class="mb-2">
                    <span class="underline">{{ __('Purposes of data processing:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('in connection with providing online and in-person real estate brokerage services, we process the data of those using the service on the basis of a quotation, order or contract, for the purpose of fulfilling legal obligations and maintaining client relationships;') }}</li>
                        <li>{{ __('marketing activities for potential clients;') }}</li>
                        <li>{{ __('processing the data of employees and applicants (under conditions set out in a separate policy);') }}
                        </li>
                        <li>{{ __('processing the contact details of contractual partners for the purpose of performing the contract;') }}
                        </li>
                        <li>{{ __('fulfilling client orders;') }}</li>
                        <li>{{ __('for the purpose of fulfilling obligations prescribed by law') }}</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="underline">{{ __('Legal basis for data processing:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('GDPR Article 6(1)(a): consent of the data subject') }}</li>
                        <li>{{ __('GDPR Article 6(1)(b): necessary for the performance of a contract') }}</li>
                        <li>{{ __('GDPR Article 6(1)(c): necessary for compliance with a legal obligation') }}</li>
                        <li>{{ __('GDPR Article 6(1)(a): legitimate interest, a balancing of interests is always required') }}</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="underline">{{ __('Legal basis of individual data processing activities:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('issuing invoices in accordance with accounting legislation: legal basis: GDPR Article 6(1)(c)') }}</li>
                        <li>{{ __('contact: legal basis (for the data of partners\' employees, the data processing) legal basis: GDPR Article 6(1)(f). Legitimate interest of the data controller: business continuity.') }}</li>
                        <li>{{ __('processing employee data: GDPR Article 6(1)(b) and (c).') }}</li>
                        <li>{{ __('processing data of contractual partners: legal basis GDPR Article 6(1)(b)') }}</li>
                        <li>{{ __('marketing activities: legal basis: GDPR Article 6(1)(a).') }}<br>
                            {{ __('A Facebook page is also operated for marketing purposes, but no separate database is created and no profiling takes place.') }}</li>
                        <li>{{ __('online registration legal basis: GDPR Article 6(1)(a)') }}</li>
                        <li>{{ __('operation of security cameras legal basis: GDPR Article 6(1)(f). Legitimate interest of the data controller: protection of property and, in the case of employees, the legitimate employer interest defined in the Labour Code.') }}
                        </li>
                    </ul>
                    <div class="mt-2 text-sm">
                        {{ __('When processing the personal data of a data subject on the basis of legitimate interest, we carry out a balancing of interests, during which:') }}
                        <ul class="list-disc ml-6">
                            <li>{{ __('we identify and record the legitimate interest') }}</li>
                            <li>{{ __('we identify and record the interests and rights of the data subject') }}</li>
                            <li>{{ __('assessment based on the principles of necessity and proportionality, purpose limitation, data minimisation and storage limitation') }}</li>
                            <li>{{ __('we inform the data subject about the balancing of interests') }}</li>
                        </ul>
                        {{ __('The data subject has the right to object, on the basis of which we no longer process the personal data, unless the processing is justified by compelling grounds (e.g. in the case of data that must necessarily be processed in connection with employment)') }}<br>
                        {{ __('There are no compelling grounds in the case of direct marketing; in the event of an objection, the data must be deleted.') }}<br>
                        {{ __('(Direct marketing includes advertisements that approach potential clients directly. This can be done electronically, by phone call, by post, etc. Special rules apply to each method. Here the data subject is the recipient of the advertisement, i.e. the person whom the advertisement reaches or targets. The personal data of the data subject may be processed, for example, by the operator of a website or webshop.)') }}
                    </div>
                </div>
                <div class="mb-2">
                    <span class="underline">{{ __('Duration of data processing:') }}</span>
                    <ul class="list-disc ml-6">
                        <li>{{ __('Due to legal obligations, we retain invoices for at least 8 years. The documents underlying invoicing are retained for 8 years.') }}</li>
                        <li>{{ __('Retention period of documents underlying employment: 50 years.') }}</li>
                        <li>{{ __('Data provided for contact purposes are retained for 1 year after the relationship ends.') }}
                        </li>
                        <li>{{ __('Retention of data related to the performance of contracts: 5 years.') }}</li>
                    </ul>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-2">III.</h3>
                <span class="font-semibold">{{ __('Rights of data subjects:') }}</span>
                <ul class="list-disc ml-6">
                    <li>{{ __('right of access (to learn the data and whether data processing is taking place);') }}</li>
                    <li>{{ __('rectification of data that is outdated or incorrect;') }}</li>
                    <li>{{ __('erasure (only in the case of data processing based on consent);') }}</li>
                    <li>{{ __('restriction of the processing of data;') }}</li>
                    <li>{{ __('prohibiting the use of personal data for direct marketing purposes;') }}</li>
                    <li>{{ __('transfer of their personal data to a third-party service provider, or prohibiting such transfer;') }}
                    </li>
                    <li>{{ __('requesting a copy of any personal data processed by the data controller; or') }}</li>
                    <li>{{ __('objecting to the use of personal data.') }}</li>
                </ul>
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-2">IV.</h3>
                <span class="font-semibold">{{ __('Personal data breach:') }}</span>
                <p class="mb-2">
                    {{ __('A breach of security leading to the accidental or unlawful destruction, loss, alteration, unauthorised disclosure of, or access to, the personal data processed.') }}
                </p>
                <p class="mb-2">
                    {{ __('Our company ensures a level of data security appropriate to the risk associated with data processing; in the event of a breach, without delay and no later than 72 hours after becoming aware of it, our data protection officer or, in the absence thereof, the data controller/data processor or its representative notifies the supervisory authority and also informs the data subject.') }}
                </p>
                <p class="mb-2">
                    {{ __('After becoming aware of a personal data breach, our company immediately takes the necessary security measures to eliminate and remedy the damage underlying the personal data breach.') }}
                </p>
                <p>
                    {{ __('We notify the data subject of the measures taken and their results.') }}
                </p>
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-2">V.</h3>
                <span class="font-semibold">{{ __('Information on legal remedies:') }}</span>
                <p class="mb-2">
                    {{ __('In Hungary, the data protection supervisory authority is the Hungarian National Authority for Data Protection and Freedom of Information (hereinafter: NAIH, address: 1125 Budapest, Szilágyi Erzsébet fasor 22/C, e-mail: ugyfelszolgalat@naih.hu). The data subject may lodge a complaint with the NAIH if they consider that the processing of personal data relating to them does not comply with legal requirements.') }}
                </p>
                <p>
                    {{ __('Judicial review may be initiated against the decision of the NAIH.') }}
                </p>
            </div>
            <div class="mb-4">
                <h3 class="font-bold text-lg mb-2">VI.</h3>
                <span class="font-semibold">{{ __('Information on records:') }}</span>
                <p class="mb-2">
                    {{ __('Our company processes and handles data lawfully, transparently and verifiably.') }}
                </p>
                <div class="mt-4">
                    <p>{{ __('Dated: Budapest, 25 May 2018.') }}</p>
                    <p>{{ __(':name managing director', ['name' => 'Fekete József Richárd']) }}</p>
                    <p>Property Solution Group Kft.</p>
                </div>
            </div>
        </section>
    </x-page-section>
</x-layouts.app>
