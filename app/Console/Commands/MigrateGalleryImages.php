<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Gallery;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class MigrateGalleryImages extends Command
{
    protected $signature = 'gallery:migrate-images {--dry-run : Show what would be done without making changes}';

    protected $description = 'Migrate gallery images from property folders to gallery folder and update database paths';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        }

        $galleries = Gallery::whereNotNull('path')
            ->where('path', '!=', '')
            ->get();

        $this->info("Found {$galleries->count()} gallery records to process");

        $processed = 0;
        $errors = 0;

        foreach ($galleries as $gallery) {
            try {
                $this->processGalleryImage($gallery, $isDryRun);
                $processed++;
            } catch (Exception $e) {
                $this->error("Error processing gallery ID {$gallery->id}: ".$e->getMessage());
                $errors++;
            }
        }

        $this->info("✅ Processed: {$processed}");
        if ($errors > 0) {
            $this->error("❌ Errors: {$errors}");
        }

        if ($isDryRun) {
            $this->info('To actually perform the migration, run: php artisan gallery:migrate-images');
        }
    }

    private function processGalleryImage(Gallery $gallery, bool $isDryRun)
    {
        $currentPath = $gallery->path;

        // Remove leading "./" if present
        $currentPath = mb_ltrim($currentPath, './');

        // Skip if already in gallery folder
        if (str_contains($currentPath, 'uploads/gallery/')) {
            $this->line("⏭️  Gallery {$gallery->id}: Already in gallery folder");

            return;
        }

        // Check if file exists
        $fullCurrentPath = storage_path('app/public/'.$currentPath);
        if (! File::exists($fullCurrentPath)) {
            $this->warn("⚠️  Gallery {$gallery->id}: File not found: {$currentPath}");

            return;
        }

        // Generate new filename
        $fileInfo = pathinfo($currentPath);
        $timestamp = time();
        $newFilename = $timestamp.'_'.$gallery->id.'_'.$fileInfo['basename'];
        $newPath = 'uploads/gallery/'.$newFilename;
        $fullNewPath = storage_path('app/public/'.$newPath);

        $this->line("📁 Gallery {$gallery->id}:");
        $this->line("   From: {$currentPath}");
        $this->line("   To:   {$newPath}");

        if (! $isDryRun) {
            // Create directory if it doesn't exist
            $newDir = dirname($fullNewPath);
            if (! File::exists($newDir)) {
                File::makeDirectory($newDir, 0755, true);
            }

            // Copy file to new location
            if (File::copy($fullCurrentPath, $fullNewPath)) {
                // Update database
                $gallery->update([
                    'path' => './'.$newPath,
                    'path_without_size_and_ext' => './'.pathinfo($newPath, PATHINFO_DIRNAME).'/'.pathinfo($newPath, PATHINFO_FILENAME),
                ]);

                $this->info("✅ Gallery {$gallery->id}: Migrated successfully");

                // Optionally delete old file (uncomment if you want to remove originals)
                // File::delete($fullCurrentPath);
            } else {
                throw new Exception('Failed to copy file');
            }
        }
    }
}
