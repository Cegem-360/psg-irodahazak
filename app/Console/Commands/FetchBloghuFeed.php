<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SimpleXMLElement;

/**
 * Copies the posts of the company's blog.hu blog. It runs daily over the same
 * feed, so a post is only saved when something in it changed: otherwise its
 * updated_at, which is the post's dateModified and its sitemap lastmod, would
 * move to the date of every run.
 */
#[Description('Fetches the latest blog.hu posts and saves them to BlogPost.')]
#[Signature('bloghu:fetch-feed')]
final class FetchBloghuFeed extends Command
{
    public const string FEED_URL = 'https://psgirodahazak.blog.hu/rss';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $response = Http::timeout(20)->get(self::FEED_URL);
        } catch (ConnectionException $exception) {
            $this->error('Nem sikerült lekérni az RSS feedet: '.$exception->getMessage());

            return self::FAILURE;
        }

        $rss = $response->successful() ? simplexml_load_string($response->body()) : false;

        if (! $rss instanceof SimpleXMLElement || ! isset($rss->channel->item)) {
            $this->error('Nem találhatóak bejegyzések az RSS feedben.');

            return self::FAILURE;
        }

        $saved = 0;

        foreach ($rss->channel->item as $item) {
            $title = mb_trim((string) $item->title);
            $link = mb_trim((string) $item->link);
            $description = (string) $item->description;
            $pubDate = mb_trim((string) $item->pubDate);

            if ($title === '' || $link === '' || $description === '' || $pubDate === '') {
                continue;
            }

            $post = BlogPost::query()->firstOrNew(['slug' => Str::slug($title)]);

            $post->fill([
                'title' => $title,
                'featured_image' => (string) ($item->children('blh', true)->image ?? ''),
                'excerpt' => Str::limit(strip_tags($description), 160),
                'content' => $description,
                'is_published' => true,
                'published_at' => Carbon::parse($pubDate)->setTimezone(config('app.timezone')),
                'meta_data' => ['source' => $link],
                'link' => $link,
            ]);

            if ($post->isDirty()) {
                $post->save();
                $saved++;
            }
        }

        $this->info($saved.' új vagy módosult bejegyzés mentve.');

        return self::SUCCESS;
    }
}
