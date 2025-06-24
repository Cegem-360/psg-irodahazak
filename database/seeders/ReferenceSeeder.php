<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Reference;
use Illuminate\Database\Seeder;

final class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $references = [
            [
                'name' => 'ABC Kft.',
                'order' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'XYZ Zrt.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Demo Bt.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Teszt Kft.',
                'order' => 3,
                'is_active' => false,
            ],
        ];

        foreach ($references as $reference) {
            Reference::create($reference);
        }
    }
}
