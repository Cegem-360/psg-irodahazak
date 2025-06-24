<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Reference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reference>
 */
final class ReferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $order = 0;

        return [
            'name' => fake()->company(),
            'image' => null, // A képek manuálisan kerülnek feltöltésre
            'order' => $order++,
            'is_active' => fake()->boolean(80), // 80% eséllyel aktív
        ];
    }
}
