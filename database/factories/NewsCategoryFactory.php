<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsCategory>
 */
final class NewsCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Gazdaság',
            'Politika',
            'Sport',
            'Technológia',
            'Kultúra',
            'Egészség',
            'Tudomány',
            'Környezetvédelem',
            'Oktatás',
            'Társadalom',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(10),
            'color' => fake()->hexColor(),
            'icon' => fake()->randomElement(['📰', '💼', '⚽', '💻', '🎭', '🏥', '🔬', '🌱', '📚', '👥']),
            'is_active' => fake()->boolean(90),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
