<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $title = $this->faker->sentence(6, true);
        $isPublished = $this->faker->boolean(70); // 70% publikált

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->generateRichContent(),
            'featured_image' => null, // Egyelőre nincs kép
            'blog_category_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'meta_data' => [
                'meta_title' => $title,
                'meta_description' => $this->faker->paragraph(1),
                'meta_keywords' => implode(', ', $this->faker->words(5)),
            ],
            'views_count' => $this->faker->numberBetween(0, 1000),
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes): array {
            return [
                'is_published' => true,
                'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }

    public function draft(): Factory
    {
        return $this->state(function (array $attributes): array {
            return [
                'is_published' => false,
                'published_at' => null,
            ];
        });
    }

    private function generateRichContent(): string
    {
        $content = '';
        $paragraphs = $this->faker->numberBetween(5, 10);

        for ($i = 0; $i < $paragraphs; $i++) {
            $content .= '<p>'.$this->faker->paragraph($this->faker->numberBetween(3, 8)).'</p>';

            // Véletlenszerűen hozzáadunk címsorokat
            if ($this->faker->boolean(30)) {
                $content .= '<h3>'.$this->faker->sentence(4).'</h3>';
            }

            // Véletlenszerűen hozzáadunk listákat
            if ($this->faker->boolean(20)) {
                $content .= '<ul>';
                for ($j = 0; $j < $this->faker->numberBetween(3, 6); $j++) {
                    $content .= '<li>'.$this->faker->sentence(8).'</li>';
                }

                $content .= '</ul>';
            }
        }

        return $content;
    }
}
