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
        // Remove ./uploads and replace with storage/ for both path fields
        DB::table('galleries')
            ->where('path', 'like', '%./uploads%')
            ->orWhere('path_without_size_and_ext', 'like', '%./uploads%')
            ->update([
                'path' => DB::raw('REPLACE(path, "./uploads", "storage")'),
                'path_without_size_and_ext' => DB::raw('REPLACE(path_without_size_and_ext, "./uploads/", "")'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes: replace storage with ./uploads
        DB::table('galleries')
            ->where('path', 'like', '%storage%')
            ->orWhere('path_without_size_and_ext', 'like', '%storage%')
            ->update([
                'path' => DB::raw('REPLACE(path, "storage", "./uploads")'),
                'path_without_size_and_ext' => DB::raw('REPLACE(path_without_size_and_ext, "", "./uploads")'),
            ]);
    }
};
