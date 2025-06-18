<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategóriák létrehozása előre definiált adatokkal
        $categories = [
            [
                'name' => 'Hírek',
                'slug' => 'hirek',
                'description' => 'Legfrissebb hírek és újdonságok',
                'color' => '#EF4444',
                'is_active' => true,
            ],
            [
                'name' => 'Útmutatók',
                'slug' => 'utmutatok',
                'description' => 'Részletes útmutatók és how-to cikkek',
                'color' => '#3B82F6',
                'is_active' => true,
            ],
            [
                'name' => 'Tippek',
                'slug' => 'tippek',
                'description' => 'Hasznos tippek és trükkök',
                'color' => '#10B981',
                'is_active' => true,
            ],
            [
                'name' => 'Technológia',
                'slug' => 'technologia',
                'description' => 'Tech hírek és fejlesztések',
                'color' => '#8B5CF6',
                'is_active' => true,
            ],
            [
                'name' => 'Üzlet',
                'slug' => 'uzlet',
                'description' => 'Üzleti tanácsok és stratégiák',
                'color' => '#F59E0B',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            \App\Models\BlogCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Első felhasználó lekérése vagy létrehozása
        $user = \App\Models\User::first();
        if (! $user) {
            $user = \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        }

        // Blog bejegyzések létrehozása kategóriánként
        $categories = \App\Models\BlogCategory::all();

        foreach ($categories as $category) {
            // 3-5 bejegyzés kategóriánként
            $postCount = rand(3, 5);

            for ($i = 0; $i < $postCount; $i++) {
                \App\Models\BlogPost::factory()->create([
                    'blog_category_id' => $category->id,
                    'user_id' => $user->id,
                    'is_published' => rand(0, 1) ? true : false,
                ]);
            }
        }
    }
}
