<?php

declare(strict_types=1);

use App\Console\Commands\FetchBloghuFeed;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

function bloghuFeed(string $description = '<p>A cikk eleje.</p>'): string
{
    return <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <rss xmlns:blh="https://blog.hu/2007/bloghurss/" version="2.0">
         <channel>
          <item>
           <title>Miért pont a hűtőket támadják?</title>
           <link>https://psgirodahazak.blog.hu/2026/11/08/miert_pont</link>
           <pubDate>Sun, 08 Nov 2026 22:46:02 +0100</pubDate>
           <description><![CDATA[{$description}]]></description>
           <blh:image>https://m.blog.hu/ps/psgirodahazak/image/huto.jpg</blh:image>
          </item>
         </channel>
        </rss>
        XML;
}

it('saves a new blog.hu post with its publication time in UTC', function (): void {
    /** @var TestCase $this */
    Http::fake([FetchBloghuFeed::FEED_URL => Http::response(bloghuFeed())]);

    $this->artisan('bloghu:fetch-feed')->assertSuccessful();

    $post = BlogPost::query()->sole();

    expect($post->slug)->toBe('miert-pont-a-hutoket-tamadjak')
        ->and($post->featured_image)->toBe('https://m.blog.hu/ps/psgirodahazak/image/huto.jpg')
        ->and($post->published_at->toIso8601String())->toBe('2026-11-08T21:46:02+00:00');
});

it('leaves updated_at of an unchanged post alone on the next daily run', function (): void {
    /** @var TestCase $this */
    Http::fake([FetchBloghuFeed::FEED_URL => Http::response(bloghuFeed())]);
    $this->artisan('bloghu:fetch-feed')->assertSuccessful();
    $firstSaved = BlogPost::query()->sole()->updated_at;

    $this->travel(1)->days();
    $this->artisan('bloghu:fetch-feed')->assertSuccessful();

    expect(BlogPost::query()->sole()->updated_at->equalTo($firstSaved))->toBeTrue();
});

it('moves updated_at when the post changed on blog.hu', function (): void {
    /** @var TestCase $this */
    Http::fake([FetchBloghuFeed::FEED_URL => Http::sequence()
        ->push(bloghuFeed())
        ->push(bloghuFeed('<p>A cikk javított eleje.</p>'))]);
    $this->artisan('bloghu:fetch-feed')->assertSuccessful();

    $this->travel(1)->days();
    $this->artisan('bloghu:fetch-feed')->assertSuccessful();

    expect(BlogPost::query()->sole()->updated_at->toDateTimeString())->toBe(now()->toDateTimeString());
});
