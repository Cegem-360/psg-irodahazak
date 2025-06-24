<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Gallery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class PopulateGalleryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:populate-images {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the images column in galleries table with all image filenames from storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to populate gallery images...');

        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        // Get all unique target_table_id values from galleries
        $propertyIds = Gallery::distinct()->pluck('target_table_id')->filter();

        $this->info('Found '.$propertyIds->count().' unique properties');

        $progressBar = $this->output->createProgressBar($propertyIds->count());
        $progressBar->start();

        $totalUpdated = 0;

        foreach ($propertyIds as $propertyId) {
            $storagePath = "property/{$propertyId}/gallery";

            // Check if the directory exists
            if (! Storage::disk('public')->exists($storagePath)) {
                $progressBar->advance();

                continue;
            }

            // Get all files in the directory
            $files = Storage::disk('public')->files($storagePath);

            if (empty($files)) {
                $progressBar->advance();

                continue;
            }

            // Extract just the filenames (not the full path)
            $imageNames = array_map(function ($file) {
                return basename($file);
            }, $files);

            // Sort the image names for consistency
            sort($imageNames);

            if (! $isDryRun) {
                // Update all galleries for this property
                $updated = Gallery::where('target_table_id', $propertyId)
                    ->update(['images' => $imageNames]);

                $totalUpdated += $updated;
            } else {
                // For dry run, just count what would be updated
                $count = Gallery::where('target_table_id', $propertyId)->count();
                $totalUpdated += $count;

                $this->newLine();
                $this->line("Property {$propertyId}: ".count($imageNames)." images found, {$count} gallery records would be updated");
                $this->line('Images: '.implode(', ', array_slice($imageNames, 0, 5)).(count($imageNames) > 5 ? '...' : ''));
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($isDryRun) {
            $this->info("DRY RUN: Would update {$totalUpdated} gallery records");
        } else {
            $this->info("Successfully updated {$totalUpdated} gallery records");
        }

        return 0;
    }
}
