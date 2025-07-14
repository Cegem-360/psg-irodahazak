<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BlogPost;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class FetchBloghuFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bloghu:fetch-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the latest blog.hu posts and saves them to BlogPost.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $feedUrl = 'https://psgirodahazak.blog.hu/rss'; // Itt cseréld le a saját blogod RSS címére

        try {
            $rss = simplexml_load_file($feedUrl);
        } catch (Exception $exception) {
            $this->error('Nem sikerült lekérni az RSS feedet: '.$exception->getMessage());

            return 1;
        }

        if (! $rss || (! property_exists($rss->channel, 'item') || $rss->channel->item === null)) {
            $this->error('Nem találhatóak bejegyzések az RSS feedben.');

            return 1;
        }

        $count = 0;
        dump($rss->channel);
        foreach ($rss->channel->item as $item) {

            $title = (string) $item->title;
            $link = (string) $item->link;
            $description = (string) $item->description;
            $pubDate = date('Y-m-d H:i:s', strtotime((string) $item->pubDate));
            $featuredImage = (string) $item->enclosure['url'] ?? null;
            $blog = BlogPost::firstOrCreate([
                'slug' => Str::slug($title),
            ]);
            $blog->update([
                'title' => $title,
                'featured_image' => $featuredImage,
                'excerpt' => Str::limit(strip_tags($description), 160),
                'content' => $description,
                'is_published' => true,
                'published_at' => $pubDate,
                'meta_data' => ['source' => $link],
            ]);
            $count++;
        }

        $this->info($count.' új bejegyzés mentve.');

        return 0;
    }
}
