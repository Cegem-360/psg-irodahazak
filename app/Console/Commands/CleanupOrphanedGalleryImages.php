<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Gallery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class CleanupOrphanedGalleryImages extends Command
{
    protected $signature = 'gallery:cleanup-orphaned {--dry-run : Show what would be deleted without making changes}';

    protected $description = 'Remove gallery records that point to non-existent files';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        }

        // Find gallery records with old paths (not in uploads/gallery)
        $orphanedRecords = Gallery::where('path', 'not like', '%uploads/gallery%')
            ->whereNotNull('path')
            ->where('path', '!=', '')
            ->get();

        $this->info("Found {$orphanedRecords->count()} potentially orphaned gallery records");

        $toDelete = collect();
        $existing = collect();

        foreach ($orphanedRecords as $gallery) {
            $currentPath = mb_ltrim($gallery->path, './');
            $fullPath = storage_path('app/public/'.$currentPath);

            if (File::exists($fullPath)) {
                $existing->push($gallery);
                $this->line("✅ Gallery {$gallery->id}: File exists at {$currentPath}");
            } else {
                $toDelete->push($gallery);
                $this->line("❌ Gallery {$gallery->id}: File missing at {$currentPath}");
            }
        }

        $this->info("\nSummary:");
        $this->info("Files that still exist: {$existing->count()}");
        $this->info("Files that are missing (will be deleted): {$toDelete->count()}");

        if ($toDelete->count() > 0) {
            if (! $isDryRun) {
                if ($this->confirm("Do you want to delete {$toDelete->count()} orphaned gallery records?")) {
                    $deletedIds = $toDelete->pluck('id')->toArray();
                    Gallery::whereIn('id', $deletedIds)->delete();
                    $this->info("✅ Deleted {$toDelete->count()} orphaned gallery records");
                } else {
                    $this->info('❌ Deletion cancelled by user');
                }
            } else {
                $this->info('To actually delete these records, run: php artisan gallery:cleanup-orphaned');
            }
        } else {
            $this->info('✅ No orphaned records to clean up');
        }

        if ($existing->count() > 0) {
            $this->info("\n⚠️  There are {$existing->count()} files that still exist in old locations.");
            $this->info("You may want to run 'php artisan gallery:migrate-images' again to move them.");
        }
    }
}
