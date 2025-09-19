<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class MigrateGalleryToPropertyPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:migrate-gallery-photos {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate gallery images to property_photos array field with relative paths';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting to migrate gallery images to property_photos...');

        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        // Get all properties with gallery images
        $properties = Property::with('images')->get();

        $this->info('Found '.$properties->count().' properties');

        $progressBar = $this->output->createProgressBar($properties->count());
        $progressBar->start();

        $totalUpdated = 0;
        $totalPhotos = 0;

        foreach ($properties as $property) {
            $galleryImages = $property->images()->orderBy('ord')->get();

            if ($galleryImages->isEmpty()) {
                $progressBar->advance();

                continue;
            }

            $photoPaths = [];

            foreach ($galleryImages as $galleryImage) {
                // Get the base path without size and extension
                $pathWithoutSizeAndExt = $galleryImage->path_without_size_and_ext;

                if ($pathWithoutSizeAndExt) {
                    // Find the best available image variant for this base path in the gallery directory
                    $galleryDirectoryPath = "property/{$galleryImage->target_table_id}/gallery/";
                    $baseName = basename($pathWithoutSizeAndExt);

                    // Look for the best image variant (largest available size)
                    $bestImage = $this->findBestImageVariant($galleryDirectoryPath, $baseName);

                    if ($bestImage && $this->fileExists($galleryDirectoryPath.$bestImage)) {
                        $photoPaths[] = $galleryDirectoryPath.$bestImage;
                        $totalPhotos++;
                    }
                } else {
                    // Fallback to original path if path_without_size_and_ext is not available
                    $relativePath = $this->getRelativePath($galleryImage->path);

                    if ($relativePath && $this->fileExists($relativePath)) {
                        $photoPaths[] = $relativePath;
                        $totalPhotos++;
                    }
                }
            }

            // Remove duplicates (keep order from gallery images ord field)
            $photoPaths = array_unique($photoPaths);

            if (! empty($photoPaths)) {
                if (! $isDryRun) {
                    $property->update([
                        'property_photos' => $photoPaths,
                    ]);
                }

                $totalUpdated++;

                if ($isDryRun) {
                    $this->newLine();
                    $this->line(sprintf(
                        'Property ID %s (%s): %d photos would be added',
                        $property->id,
                        $property->title,
                        count($photoPaths)
                    ));

                    // Show first few paths as example
                    $examplePaths = array_slice($photoPaths, 0, 3);
                    $this->line('Example paths: '.implode(', ', $examplePaths).(count($photoPaths) > 3 ? '...' : ''));
                }
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($isDryRun) {
            $this->info(sprintf('DRY RUN: Would update %d properties with %d total photos', $totalUpdated, $totalPhotos));
        } else {
            $this->info(sprintf('Successfully updated %d properties with %d total photos', $totalUpdated, $totalPhotos));
        }

        return 0;
    }

    /**
     * Convert full path to relative path
     */
    private function getRelativePath(string $path): string
    {
        // Remove leading ./ if present
        $path = mb_ltrim($path, './');

        // Remove storage/ prefix if present (since we want relative to public storage)
        $path = preg_replace('/^storage\//', '', $path);

        return $path;
    }

    /**
     * Check if file exists in public storage
     */
    private function fileExists(string $relativePath): bool
    {
        return Storage::disk('public')->exists($relativePath);
    }

    /**
     * Find the best image variant for a given base name (largest available size)
     */
    private function findBestImageVariant(string $directoryPath, string $baseName): ?string
    {
        if (! Storage::disk('public')->exists($directoryPath)) {
            return null;
        }

        $files = Storage::disk('public')->files($directoryPath);

        // Filter only image files that match the base name
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
        $sizePreferences = ['1280x800', '800x600']; // Ordered by preference (largest first)
        $matchingFiles = [];
        $originalFile = null;

        foreach ($files as $file) {
            $fileName = basename($file);
            $extension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($extension, $imageExtensions)) {
                // Check if this file starts with our base name
                $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);

                // Remove size patterns like _800x600 from filename for comparison
                $cleanFileBaseName = preg_replace('/_\d+x\d+$/', '', $fileBaseName);
                $cleanBaseName = preg_replace('/_\d+x\d+$/', '', pathinfo($baseName, PATHINFO_FILENAME));

                if ($cleanFileBaseName === $cleanBaseName) {
                    // Check if it's the original file (no size in name)
                    if (! preg_match('/_\d+x\d+\./', $fileName)) {
                        $originalFile = $fileName;
                    }

                    // Check for specific sizes
                    foreach ($sizePreferences as $size) {
                        if (mb_strpos($fileName, "_$size.") !== false) {
                            $matchingFiles[$size] = $fileName;
                        }
                    }
                }
            }
        }

        // Return the best available image in order of preference
        foreach ($sizePreferences as $size) {
            if (isset($matchingFiles[$size])) {
                return $matchingFiles[$size];
            }
        }

        // If no preferred sizes found, return original if exists
        return $originalFile;
    }
}
