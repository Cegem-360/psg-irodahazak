<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fekete Richárd (2026-11-25): the operating fee article is not a news item.
     * Its news record is removed, so the news list and the home page news block
     * are as before; the article stays at its own URL, in the sitemap and in
     * llms.txt.
     */
    public function up(): void
    {
        DB::table('news')->where('slug', 'uzemeltetesi-dij-irodaberles')->delete();
    }
};
