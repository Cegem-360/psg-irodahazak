<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Gallery;
use Illuminate\Console\Command;

final class UpdatePathWithoutSizeAndExt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:update-path-without-size {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update path_without_size_and_ext column based on the path column';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting to update path_without_size_and_ext...');

        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        $galleries = Gallery::whereNotNull('path')->get();

        $this->info('Found '.$galleries->count().' gallery records');

        $progressBar = $this->output->createProgressBar($galleries->count());
        $progressBar->start();

        $totalUpdated = 0;

        foreach ($galleries as $gallery) {
            // Extract path without size and extension
            // Example: property/100/gallery/garage_800x600.jpg -> property/100/gallery/garage
            $path = $gallery->path;
            $pathWithoutSizeAndExt = preg_replace('/_\d+x\d+\.(jpg|png|jpeg)$/', '', $path);

            if ($gallery->path_without_size_and_ext !== $pathWithoutSizeAndExt) {
                if (! $isDryRun) {
                    $gallery->update(['path_without_size_and_ext' => $pathWithoutSizeAndExt]);
                }

                $totalUpdated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($isDryRun) {
            $this->info(sprintf('DRY RUN: Would update %d gallery records', $totalUpdated));
        } else {
            $this->info(sprintf('Successfully updated %d gallery records', $totalUpdated));
        }

        return 0;
    }
}
