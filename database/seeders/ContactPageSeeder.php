<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ContactPage;
use Illuminate\Database\Seeder;

final class ContactPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Magyar tartalom
        ContactPage::updateOrCreate(
            ['language' => 'hu'],
            [
                'content' => '<h3 class="mb-3 text-logogray/80 text-xl">Property Solution Group Kft.</h3>
<p class="mb-3 text-gray-600">Iroda: 1016 Budapest, Derék u. 2.</p>
<p class="mb-3 text-gray-600">Tel.: +36 20 381 3917</p>
<p>E-mail: <a class="text-primary" href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a></p>',
            ]
        );

        // Angol tartalom
        ContactPage::updateOrCreate(
            ['language' => 'en'],
            [
                'content' => '<h3 class="mb-3 text-logogray/80 text-xl">Property Solution Group Kft.</h3>
<p class="mb-3 text-gray-600">Office: 1016 Budapest, Derék u. 2.</p>
<p class="mb-3 text-gray-600">Phone: +36 20 381 3917</p>
<p>E-mail: <a class="text-primary" href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a></p>',
            ]
        );
    }
}
