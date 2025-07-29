<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\File;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Image;

final class WatermarkService
{
    public function addWatermark($file, $record)
    {
        // 1. Get the file path
        $filePath = $file->getRealPath();
        $filename = $file->getClientOriginalName(); // Or generate a unique name

        $image = Image::load($filePath);
        $image = $image->watermark(resource_path('images/psg-irodahazak-logo.png'), AlignPosition::Middle, 10, 10, alpha: 30);

        // Sanitize filename to remove special characters
        $sanitizedFilename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        $storagePath = 'property/'.$record->id.'/gallery_images/'.$sanitizedFilename;
        $fullStoragePath = storage_path('app/public/'.$storagePath);

        // Create directory if it doesn't exist
        $directory = dirname($fullStoragePath);
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $image->save($fullStoragePath);

        return $storagePath; // Return the relative path
    }

    public function addWatermarkFromFile(File $file)
    {
        // 1. Get the file path
        $filePath = $file->getRealPath();

        $image = Image::load($filePath);
        $image = $image->watermark(resource_path('images/psg-irodahazak-logo.png'), AlignPosition::Middle, 30, 10, alpha: 30);

        $image->save($filePath);

    }
}
