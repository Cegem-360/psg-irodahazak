<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Property;
use App\Services\WatermarkService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

final class AddWatermarkToPropertyPhotos extends Command
{
    protected $signature = 'property:add-watermark-to-photos';

    protected $description = 'Add watermark to all property_photos images of all properties';

    public function handle(WatermarkService $watermarkService)
    {
        $this->info('Starting watermarking process...');

        // Először megszámoljuk az összes képet
        $total = 0;
        Property::chunk(100, function (Collection $properties) use (&$total) {
            foreach ($properties as $property) {
                $photos = $property->property_photos;
                if (is_array($photos)) {
                    $total += count($photos);
                }
            }
        });

        $this->info("Összesen {$total} képet kell feldolgozni.");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $count = 0;
        Property::chunk(100, function (Collection $properties) use ($watermarkService, &$count, $bar) {
            foreach ($properties as $property) {
                $photos = $property->property_photos;
                if (! is_array($photos)) {
                    $this->warn("Property {$property->id} has no photos or photos are not an array.");

                    continue;
                }
                foreach ($photos as $photo) {
                    if (! Storage::exists($photo)) {
                        // A progress bar-t akkor is léptetjük, ha nincs meg a file
                        $this->warn("File not found: {$photo}");
                        $bar->advance();

                        continue;
                    }

                    $file = new File(Storage::path($photo));
                    $watermarkService->addWatermarkFromFile($file);
                    $count++;
                    $bar->advance();
                }
            }
        });
        $bar->finish();
        $this->newLine();
        $this->info("Done. Total watermarked: $count");

        return 0;
    }
}
