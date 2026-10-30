<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Tells the IndexNow search engines (Bing, Yandex, ...) that the given pages changed.
 */
final class SubmitUrlsToIndexNow implements ShouldQueue
{
    use Queueable;

    /**
     * @param  list<string>  $urls
     */
    public function __construct(public array $urls) {}

    public function handle(): void
    {
        $key = config('seo.indexnow.key');

        if (blank($key) || $this->urls === []) {
            return;
        }

        try {
            $response = Http::timeout(10)->post(config('seo.indexnow.endpoint'), [
                'host' => parse_url((string) config('app.url'), PHP_URL_HOST),
                'key' => $key,
                'keyLocation' => url($key.'.txt'),
                'urlList' => $this->urls,
            ]);

            if ($response->failed()) {
                Log::warning('IndexNow submission failed', ['status' => $response->status(), 'urls' => $this->urls]);
            }
        } catch (Throwable $throwable) {
            // A failed ping must never break saving the property in the admin.
            Log::warning('IndexNow submission failed', ['error' => $throwable->getMessage(), 'urls' => $this->urls]);
        }
    }
}
