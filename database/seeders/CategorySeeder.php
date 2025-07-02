<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

final class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Azonnal költözhető',
            'Kiemelt ajánlatok',
            'Eladó irodaházak',
            'Kiadó azonnali szolgáltatott irodák',
            'Kiadó pesti irodák',
            'Kiadó belvárosi irodák',
            'Kiadó irodák V. kerület',
            'Kiadó Váci úti irodák',
            'Kiadó budai irodák',
            'Kiadó bel-budai irodák',
            'Kiadó irodák XI. kerület',
            'Kiadó zöld irodák',
            'Kiadó klasszikus irodaházak',
            'Kiadó új irodaházak',
            'Eladó iroda',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}
