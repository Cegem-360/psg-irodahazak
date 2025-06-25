<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
final class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);
        $content = fake()->paragraphs(10, true);
        $publishedAt = fake()->boolean(80) ? fake()->dateTimeBetween('-1 month', '+1 week') : null;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(15),
            'content' => $content,
            'featured_image' => fake()->boolean(70) ? fake()->imageUrl(800, 600, 'news') : null,
            'news_category_id' => NewsCategory::factory(),
            'user_id' => User::factory(),
            'is_published' => $publishedAt !== null,
            'is_breaking' => fake()->boolean(10),
            'published_at' => $publishedAt,
            'meta_data' => [
                'seo_title' => $title,
                'seo_description' => fake()->sentence(20),
                'tags' => fake()->words(3),
            ],
            'views_count' => fake()->numberBetween(0, 5000),
            'priority' => fake()->randomElement([1, 2, 2, 2, 3, 3, 4, 5]), // Weighted towards normal priority
        ];
    }
}
