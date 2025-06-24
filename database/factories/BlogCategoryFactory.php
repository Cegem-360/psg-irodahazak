<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $name = $this->faker->randomElement(array_keys($categories));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'color' => $categories[$name],
            'is_active' => $this->faker->boolean(90), // 90% aktív
        ];
    }
}
