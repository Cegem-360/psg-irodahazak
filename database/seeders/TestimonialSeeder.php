<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Kovács Péter',
                'client_position' => 'Ügyvezető',
                'client_company' => 'KP Solutions Kft.',
                'testimonial' => 'Kiváló szakmai hozzáállás és gyors ügyintézés jellemezte a PSG Irodaházak csapatát. Az új irodánk tökéletesen megfelel az elvárásainknak, és a bérleti folyamat is zökkenőmentesen zajlott. Csak ajánlani tudom őket!',
                'rating' => 5,
                'project_type' => 'Iroda bérlés',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'Nagy Andrea',
                'client_position' => 'HR vezető',
                'client_company' => 'TechnoMax Zrt.',
                'testimonial' => 'Professzionális szolgáltatás, rugalmas hozzáállás és kiváló ár-érték arány. A PSG csapata minden kérésünkre gyorsan reagált, és segített megtalálni a tökéletes irodát vállalatunk számára.',
                'rating' => 5,
                'project_type' => 'Iroda bérlés',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'Szabó László',
                'client_position' => 'Tulajdonos',
                'client_company' => 'Business Center Kft.',
                'testimonial' => 'Irodaházunk értékesítése során végig támogattak minket. Az értékbecslés pontos volt, a marketing stratégia eredményes, és gyorsan találtak megfelelő vevőt. Korrekt és megbízható partnerek.',
                'rating' => 4,
                'project_type' => 'Irodaház értékesítés',
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'client_name' => 'Molnár Zita',
                'client_position' => 'Pénzügyi igazgató',
                'client_company' => 'Global Trade Ltd.',
                'testimonial' => 'Számunkra a legfontosabb szempont a megbízhatóság volt, és a PSG Irodaházak minden tekintetben megfelelt az elvárásainknak. Transzparens kommunikáció és fair árazás.',
                'rating' => 5,
                'project_type' => 'Iroda bérlés',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'client_name' => 'Tóth Gábor',
                'client_position' => 'Vezérigazgató',
                'client_company' => 'InnovateTech Kft.',
                'testimonial' => 'Kiváló lokációt találtak számunkra Budapest szívében. Az irodaház minden modern elvárásnak megfelel, és a bérleti szerződés feltételei is kedvezőek voltak.',
                'rating' => 4,
                'project_type' => 'Iroda bérlés',
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'client_name' => 'Varga Eszter',
                'client_position' => 'Marketing vezető',
                'client_company' => 'Creative Agency',
                'testimonial' => 'A PSG csapata nemcsak az irodaházat mutatta be, hanem a környék infrastruktúráját is részletesen ismertette. Ez sokat segített a döntésben. Ajánlom mindenkinek!',
                'rating' => 5,
                'project_type' => 'Iroda bérlés',
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
