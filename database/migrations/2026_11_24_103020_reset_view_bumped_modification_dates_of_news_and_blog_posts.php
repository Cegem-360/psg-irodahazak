<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Every page view of a news item, and every daily blog.hu import of a blog
     * post, moved its updated_at to that day, so dateModified and the sitemap
     * lastmod showed the last visit instead of the last edit. The real edit
     * dates are lost; the closest known date is the publication of the article,
     * or for a news item its creation in the admin if that was later. A blog
     * post was created when it was first imported, not when it was written.
     */
    public function up(): void
    {
        foreach (['news', 'blog_posts'] as $table) {
            DB::table($table)->select(['id', 'created_at', 'published_at', 'updated_at'])->orderBy('id')
                ->each(function (object $row) use ($table): void {
                    $dates = array_filter($table === 'news' ? [$row->created_at, $row->published_at] : [$row->published_at ?? $row->created_at]);

                    if ($dates === []) {
                        return;
                    }

                    $modified = collect($dates)->map(fn (string $date): Carbon => Carbon::parse($date))->max();

                    if ($row->updated_at === null || Carbon::parse($row->updated_at)->greaterThan($modified)) {
                        DB::table($table)->where('id', $row->id)->update(['updated_at' => $modified->toDateTimeString()]);
                    }
                });
        }
    }
};
