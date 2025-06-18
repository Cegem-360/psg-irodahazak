<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove "storage/" prefix from both path fields
        DB::table('galleries')
            ->where('path', 'like', 'storage/%')
            ->orWhere('path_without_size_and_ext', 'like', 'storage/%')
            ->update([
                'path' => DB::raw('REPLACE(path, "storage/", "")'),
                'path_without_size_and_ext' => DB::raw('REPLACE(path_without_size_and_ext, "storage/", "")'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back "storage/" prefix to paths that don't start with "./"
        DB::table('galleries')
            ->where('path', 'not like', './%')
            ->where('path', 'not like', 'storage/%')
            ->update([
                'path' => DB::raw('CONCAT("storage/", path)'),
                'path_without_size_and_ext' => DB::raw('CONCAT("storage/", path_without_size_and_ext)")'),
            ]);
    }
};
