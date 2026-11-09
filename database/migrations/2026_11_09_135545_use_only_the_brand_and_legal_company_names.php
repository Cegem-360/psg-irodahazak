<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The company appears only as "PSG Irodaházak" or under its legal name,
     * Property Solution Group Kft.: the English imprint said "Ltd." and a news
     * article of our own "PSG Kft.". The clients' testimonials are quotes and
     * stay as they were written.
     */
    public function up(): void
    {
        DB::table('impressum')
            ->where('content', 'like', '%Property Solution Group Ltd.%')
            ->update(['content' => DB::raw("REPLACE(content, 'Property Solution Group Ltd.', 'Property Solution Group Kft.')")]);

        foreach (['excerpt', 'content'] as $column) {
            DB::table('news')
                ->where($column, 'like', '%A PSG Kft.%')
                ->update([$column => DB::raw("REPLACE({$column}, 'A PSG Kft.', 'A Property Solution Group Kft.')")]);
        }
    }
};
