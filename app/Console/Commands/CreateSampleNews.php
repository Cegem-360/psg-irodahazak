<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class CreateSampleNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:create-sample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample news articles for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating sample news articles...');

        // Ensure we have a user
        $user = User::first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
            $this->info('Created admin user');
        }

        // Get categories
        $categories = NewsCategory::all();
        if ($categories->isEmpty()) {
            $this->error('No news categories found. Please run the NewsCategorySeeder first.');

            return;
        }

        $newsData = [
            [
                'title' => 'Új irodaház nyílik Budapest belvárosában',
                'content' => 'A főváros szívében egy új, modern irodaház nyitja meg kapuit a következő hónapban. Az épület 15 emeletes és 25.000 négyzetméter irodaterületet kínál...',
                'is_breaking' => true,
                'priority' => 4,
            ],
            [
                'title' => 'Ingatlanpiaci trendek 2025-ben',
                'content' => 'Az idei év jelentős változásokat hozhat az ingatlanpiacon. A szakértők szerint a következő hónapokban...',
                'is_breaking' => false,
                'priority' => 3,
            ],
            [
                'title' => 'Környezetbarát irodaházak a jövő útja',
                'content' => 'A fenntarthatóság egyre fontosabb szempont az irodaházak tervezésénél és üzemeltetésénél...',
                'is_breaking' => false,
                'priority' => 2,
            ],
            [
                'title' => 'Technológiai újítások az ingatlankezelésben',
                'content' => 'A digitalizáció és az automatizáció forradalmasítja az ingatlankezelési szektort...',
                'is_breaking' => false,
                'priority' => 2,
            ],
            [
                'title' => 'Új jogszabályok az irodabérletben',
                'content' => 'Jelentős változások várhatók az irodabérlet területét érintő jogszabályokban...',
                'is_breaking' => true,
                'priority' => 5,
            ],
        ];

        foreach ($newsData as $index => $data) {
            News::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'excerpt' => Str::limit($data['content'], 160),
                'news_category_id' => $categories->random()->id,
                'user_id' => $user->id,
                'is_published' => true,
                'is_breaking' => $data['is_breaking'],
                'published_at' => now()->subDays(rand(0, 10)),
                'priority' => $data['priority'],
                'views_count' => rand(50, 500),
            ]);
        }

        $this->info('Created '.count($newsData).' sample news articles.');
    }
}
