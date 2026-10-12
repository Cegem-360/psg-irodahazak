<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
final class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);
        $isPublished = fake()->boolean(70); // 70% publikált

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => $this->generateRichContent(),
            'featured_image' => null, // Egyelőre nincs kép
            'blog_category_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'meta_data' => [
                'meta_title' => $title,
                'meta_description' => fake()->paragraph(1),
                'meta_keywords' => implode(', ', fake()->words(5)),
            ],
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }

    public function published(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    public function draft(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    private function generateRichContent(): string
    {
        $content = '';
        $paragraphs = fake()->numberBetween(5, 10);

        for ($i = 0; $i < $paragraphs; $i++) {
            $content .= '<p>'.fake()->paragraph(fake()->numberBetween(3, 8)).'</p>';

            // Véletlenszerűen hozzáadunk címsorokat
            if (fake()->boolean(30)) {
                $content .= '<h3>'.fake()->sentence(4).'</h3>';
            }

            // Véletlenszerűen hozzáadunk listákat
            if (fake()->boolean(20)) {
                $content .= '<ul>';
                for ($j = 0; $j < fake()->numberBetween(3, 6); $j++) {
                    $content .= '<li>'.fake()->sentence(8).'</li>';
                }

                $content .= '</ul>';
            }
        }

        return $content;
    }
}
