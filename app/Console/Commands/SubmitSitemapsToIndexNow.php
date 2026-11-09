<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SubmitUrlsToIndexNow;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Submit every URL of the generated sitemaps to IndexNow (e.g. after setting up the key)')]
#[Signature('indexnow:submit-sitemaps {--path= : The sitemap index (defaults to public/sitemap.xml)}')]
final class SubmitSitemapsToIndexNow extends Command
{
    /** IndexNow accepts at most 10 000 URLs per request. */
    private const int BATCH_SIZE = 10_000;

    public function handle(): int
    {
        if (blank(config('seo.indexnow.key'))) {
            $this->error('INDEXNOW_KEY is not set.');

            return self::FAILURE;
        }

        $indexPath = $this->option('path') ?: public_path('sitemap.xml');

        if (! is_file($indexPath)) {
            $this->error('No sitemap at '.$indexPath.'; run sitemap:generate first.');

            return self::FAILURE;
        }

        // The index lists the sitemaps by URL; they are written next to it.
        $urls = collect($this->locations($indexPath))
            ->flatMap(fn (string $sitemapUrl): array => $this->locations(dirname((string) $indexPath).'/'.basename((string) parse_url($sitemapUrl, PHP_URL_PATH))))
            ->unique()
            ->values();

        $failed = false;

        foreach ($urls->chunk(self::BATCH_SIZE) as $batch) {
            $status = new SubmitUrlsToIndexNow($batch->values()->all())->submit();
            $accepted = in_array($status, [200, 202], true);
            $failed = $failed || ! $accepted;

            $this->line(sprintf('%d URLs: HTTP %s', $batch->count(), $status ?? 'error'));
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * The <loc> values of a sitemap or sitemap index file.
     *
     * @return list<string>
     */
    private function locations(string $path): array
    {
        if (! is_file($path)) {
            return [];
        }

        preg_match_all('#<loc>\s*([^<\s]+)\s*</loc>#', (string) file_get_contents($path), $matches);

        return array_map(html_entity_decode(...), $matches[1]);
    }
}
