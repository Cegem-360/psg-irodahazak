<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

final class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gazdaság',
                'slug' => 'gazdasag',
                'description' => 'Gazdasági hírek és elemzések',
                'color' => '#10B981',
                'icon' => '💼',
                'sort_order' => 1,
            ],
            [
                'name' => 'Ingatlan',
                'slug' => 'ingatlan',
                'description' => 'Ingatlanpiaci hírek és trendek',
                'color' => '#3B82F6',
                'icon' => '🏠',
                'sort_order' => 2,
            ],
            [
                'name' => 'Irodaház',
                'slug' => 'irodahaz',
                'description' => 'Irodaház bérlési és fejlesztési hírek',
                'color' => '#8B5CF6',
                'icon' => '🏢',
                'sort_order' => 3,
            ],
            [
                'name' => 'Technológia',
                'slug' => 'technologia',
                'description' => 'Technológiai újdonságok',
                'color' => '#F59E0B',
                'icon' => '💻',
                'sort_order' => 4,
            ],
            [
                'name' => 'Jog',
                'slug' => 'jog',
                'description' => 'Jogi változások és szabályozások',
                'color' => '#EF4444',
                'icon' => '⚖️',
                'sort_order' => 5,
            ],
            [
                'name' => 'Környezetvédelem',
                'slug' => 'kornyezetvedelem',
                'description' => 'Fenntarthatósági és környezetvédelmi hírek',
                'color' => '#059669',
                'icon' => '🌱',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            NewsCategory::query()->create($category);
        }
    }
}
