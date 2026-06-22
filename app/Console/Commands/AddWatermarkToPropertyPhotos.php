<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Property;
use App\Services\WatermarkService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

#[Description('Add watermark to all property_photos images of all properties')]
#[Signature('property:add-watermark-to-photos')]
final class AddWatermarkToPropertyPhotos extends Command
{
    public function handle(WatermarkService $watermarkService): int
    {
        $this->info('Starting watermarking process...');

        // Először megszámoljuk az összes képet
        $total = 0;
        Property::chunk(100, function (Collection $properties) use (&$total): void {
            foreach ($properties as $property) {
                $photos = $property->property_photos;
                if (is_array($photos)) {
                    $total += count($photos);
                }
            }
        });

        $this->info(sprintf('Összesen %d képet kell feldolgozni.', $total));
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $count = 0;
        Property::chunk(100, function (Collection $properties) use ($watermarkService, &$count, $bar): void {
            foreach ($properties as $property) {
                $photos = $property->property_photos;
                if (! is_array($photos)) {
                    $this->warn(sprintf('Property %s has no photos or photos are not an array.', $property->id));

                    continue;
                }

                foreach ($photos as $photo) {
                    if (! Storage::exists($photo)) {
                        // A progress bar-t akkor is léptetjük, ha nincs meg a file
                        $this->warn('File not found: '.$photo);
                        $bar->advance();

                        continue;
                    }

                    $file = new File(Storage::path($photo));
                    $dimensions = @getimagesize($file->getPathname());
                    if (! $dimensions) {
                        $this->warn('Could not get image size: '.$photo);
                        $bar->advance();

                        continue;
                    }

                    if ($dimensions[0] < 600) {
                        $this->warn(sprintf('Image too narrow (%dpx): %s', $dimensions[0], $photo));
                        $bar->advance();

                        continue;
                    }

                    $watermarkService->addWatermarkFromFile($file);
                    $count++;
                    $bar->advance();
                }
            }
        });
        $bar->finish();
        $this->newLine();
        $this->info('Done. Total watermarked: '.$count);

        return 0;
    }
}
