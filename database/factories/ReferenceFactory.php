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
        return [
            'name' => fake()->company(),
            'image' => fake()->imageUrl(400, 200, 'business'),
            'order' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }
}
