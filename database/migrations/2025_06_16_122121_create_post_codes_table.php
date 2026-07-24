<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Duplicate historical migration for `post_codes`. The table (with its `id`
     * column) is created by the sibling migration, so this only backfills the `id`
     * column on legacy databases where it might be missing.
     */
    public function up(): void
    {
        if (Schema::hasTable('post_codes') && ! Schema::hasColumn('post_codes', 'id')) {
            Schema::table('post_codes', function (Blueprint $table): void {
                $table->id();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left blank; the table lifecycle is owned by the sibling migration.
    }
};
