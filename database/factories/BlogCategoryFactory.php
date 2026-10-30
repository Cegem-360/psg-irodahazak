<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogCategory>
 */
final class BlogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Hírek' => '#EF4444',
            'Útmutatók' => '#3B82F6',
            'Tippek' => '#10B981',
            'Technológia' => '#8B5CF6',
            'Üzlet' => '#F59E0B',
            'Lifestyle' => '#EC4899',
            'Utazás' => '#06B6D4',
            'Gasztronómia' => '#84CC16',
        ];

        $name = fake()->randomElement(array_keys($categories));

        return [
            'name' => $name,
            // Eight names only, so the slug gets a suffix to stay unique across a test's categories.
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'description' => fake()->paragraph(3),
            'color' => $categories[$name],
            'is_active' => fake()->boolean(90), // 90% aktív
        ];
    }
}
