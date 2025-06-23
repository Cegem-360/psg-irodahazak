<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

final class WatermarkService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Vízjel alkalmazása a képre
     *
     * @param  string  $imagePath  A kép útvonal
     * @param  string|null  $targetType  Célzott típus (property, gallery, stb.)
     * @return bool Sikeres volt-e a vízjelezés
     */
    public function applyWatermark(string $imagePath, ?string $targetType = null): bool
    {
        try {
            // Ellenőrizzük, hogy engedélyezett-e a vízjelezés
            if (! config('watermark.enabled', true)) {
                return true; // Nem alkalmazunk vízjelet, de ez nem hiba
            }

            // Ellenőrizzük, hogy a típusra alkalmazzuk-e
            if ($targetType && ! in_array($targetType, config('watermark.apply_to_types', ['property']))) {
                return true; // Nem alkalmazunk vízjelet erre a típusra
            }

            // Kép betöltése
            $fullPath = Storage::disk('public')->path(mb_ltrim($imagePath, './'));

            if (! file_exists($fullPath)) {
                Log::warning("Watermark: Kép nem található: {$fullPath}");

                return false;
            }

            $image = $this->manager->read($fullPath);

            // Ellenőrizzük a kép méretét
            $minWidth = config('watermark.min_image_width', 300);
            $minHeight = config('watermark.min_image_height', 200);

            if ($image->width() < $minWidth || $image->height() < $minHeight) {
                Log::info("Watermark: Kép túl kicsi a vízjelhez: {$image->width()}x{$image->height()}");

                return true; // Nem alkalmazunk vízjelet, de ez nem hiba
            }

            // Vízjel alkalmazása
            $this->addTextWatermark($image);

            // Kép mentése
            $image->save($fullPath);

            Log::info("Watermark alkalmazva: {$imagePath}");

            return true;

        } catch (Exception $e) {
            Log::error('Watermark hiba: '.$e->getMessage(), [
                'imagePath' => $imagePath,
                'targetType' => $targetType,
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Több méretű változat létrehozása vízjellel
     */
    public function createWatermarkedSizes(string $originalPath, array $sizes, ?string $targetType = null): bool
    {
        try {
            $basePath = pathinfo($originalPath, PATHINFO_DIRNAME);
            $filename = pathinfo($originalPath, PATHINFO_FILENAME);
            $extension = pathinfo($originalPath, PATHINFO_EXTENSION);

            $fullOriginalPath = Storage::disk('public')->path(mb_ltrim($originalPath, './'));

            if (! file_exists($fullOriginalPath)) {
                Log::warning("Watermark sizes: Eredeti kép nem található: {$fullOriginalPath}");

                return false;
            }

            $originalImage = $this->manager->read($fullOriginalPath);

            foreach ($sizes as $size) {
                [$width, $height] = explode('x', $size);
                $width = (int) $width;
                $height = (int) $height;

                // Új kép létrehozása átméretezéssel
                $resizedImage = $originalImage->scale($width, $height);

                // Vízjel alkalmazása az átméretezett képre
                $this->addTextWatermark($resizedImage);

                // Új fájlnév
                $newFilename = "{$filename}_{$size}.{$extension}";
                $newPath = "{$basePath}/{$newFilename}";
                $fullNewPath = Storage::disk('public')->path(mb_ltrim($newPath, './'));

                // Kép mentése
                $resizedImage->save($fullNewPath);

                Log::info("Watermark size létrehozva: {$newPath}");
            }

            return true;

        } catch (Exception $e) {
            Log::error('Watermark sizes hiba: '.$e->getMessage(), [
                'originalPath' => $originalPath,
                'sizes' => $sizes,
                'targetType' => $targetType,
            ]);

            return false;
        }
    }

    /**
     * Vízjel alkalmazása prototípus képre (eredeti nem módosul)
     *
     * @param  string  $originalImagePath  Az eredeti kép útvonal
     * @param  string  $prototypeImagePath  A prototípus kép útvonal
     * @param  string|null  $targetType  Célzott típus (property, gallery, stb.)
     * @return bool Sikeres volt-e a vízjelezés
     */
    public function applyWatermarkToPrototype(string $originalImagePath, string $prototypeImagePath, ?string $targetType = null): bool
    {
        try {
            // Ellenőrizzük, hogy engedélyezett-e a vízjelezés
            if (! config('watermark.enabled', true)) {
                return true; // Nem alkalmazunk vízjelet, de ez nem hiba
            }

            // Ellenőrizzük, hogy a típusra alkalmazzuk-e
            if ($targetType && ! in_array($targetType, config('watermark.apply_to_types', ['property']))) {
                return true; // Nem alkalmazunk vízjelet erre a típusra
            }

            // Eredeti kép betöltése
            $originalFullPath = Storage::disk('public')->path(mb_ltrim($originalImagePath, './'));

            if (! file_exists($originalFullPath)) {
                Log::warning("Watermark Prototype: Eredeti kép nem található: {$originalFullPath}");

                return false;
            }

            $image = $this->manager->read($originalFullPath);

            // Ellenőrizzük a kép méretét
            $minWidth = config('watermark.min_image_width', 300);
            $minHeight = config('watermark.min_image_height', 200);

            if ($image->width() < $minWidth || $image->height() < $minHeight) {
                Log::info("Watermark Prototype: Kép túl kicsi a vízjelhez: {$image->width()}x{$image->height()}");

                return true; // Nem alkalmazunk vízjelet, de ez nem hiba
            }

            // Vízjel alkalmazása
            $this->addTextWatermark($image);

            // Prototípus kép mentése (új helyre)
            $prototypeFullPath = Storage::disk('public')->path($prototypeImagePath);
            $image->save($prototypeFullPath);

            Log::info("Watermark prototype létrehozva: {$originalImagePath} -> {$prototypeImagePath}");

            return true;

        } catch (Exception $e) {
            Log::error('Watermark prototype hiba: '.$e->getMessage(), [
                'originalImagePath' => $originalImagePath,
                'prototypeImagePath' => $prototypeImagePath,
                'targetType' => $targetType,
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Szöveges vízjel hozzáadása
     */
    private function addTextWatermark(ImageInterface $image): void
    {
        $text = config('watermark.text', 'PSG Irodaházak');
        $position = config('watermark.position', 'bottom-right');
        $opacity = config('watermark.opacity', 50);
        $fontSize = config('watermark.font_size', 24);
        $color = config('watermark.color', '#ffffff');
        $margin = config('watermark.margin', 20);
        $fontPath = config('watermark.font_path');

        // Szín konvertálása
        $textColor = $this->hexToRgb($color);
        $shadowColor = $this->hexToRgb(config('watermark.shadow.color', '#000000'));

        // Pozíció számítása
        $coordinates = $this->calculatePosition($image, $position, $margin, $fontSize, $text);

        // Árnyék hozzáadása (ha engedélyezve van)
        if (config('watermark.shadow.enabled', true)) {
            $shadowOffsetX = config('watermark.shadow.offset_x', 2);
            $shadowOffsetY = config('watermark.shadow.offset_y', 2);

            $image->text(
                $text,
                $coordinates['x'] + $shadowOffsetX,
                $coordinates['y'] + $shadowOffsetY,
                function ($font) use ($fontSize, $fontPath, $shadowColor, $opacity) {
                    $font->size($fontSize);
                    if ($fontPath && file_exists($fontPath)) {
                        $font->file($fontPath);
                    }
                    $font->color(sprintf('rgba(%d,%d,%d,%.2f)',
                        $shadowColor['r'],
                        $shadowColor['g'],
                        $shadowColor['b'],
                        $opacity / 100
                    ));
                    $font->align('left');
                    $font->valign('top');
                }
            );
        }

        // Fő szöveg hozzáadása
        $image->text(
            $text,
            $coordinates['x'],
            $coordinates['y'],
            function ($font) use ($fontSize, $fontPath, $textColor, $opacity) {
                $font->size($fontSize);
                if ($fontPath && file_exists($fontPath)) {
                    $font->file($fontPath);
                }
                $font->color(sprintf('rgba(%d,%d,%d,%.2f)',
                    $textColor['r'],
                    $textColor['g'],
                    $textColor['b'],
                    $opacity / 100
                ));
                $font->align('left');
                $font->valign('top');
            }
        );
    }

    /**
     * Pozíció számítása a képen
     */
    private function calculatePosition(ImageInterface $image, string $position, int $margin, int $fontSize, string $text): array
    {
        $imageWidth = $image->width();
        $imageHeight = $image->height();

        // Szöveg szélesség becsült számítása (kb. 60% a font méretnek karakterenként)
        $textWidth = mb_strlen($text) * ($fontSize * 0.6);
        $textHeight = $fontSize;

        switch ($position) {
            case 'top-left':
                return ['x' => $margin, 'y' => $margin];

            case 'top-right':
                return [
                    'x' => $imageWidth - $textWidth - $margin,
                    'y' => $margin,
                ];

            case 'bottom-left':
                return [
                    'x' => $margin,
                    'y' => $imageHeight - $textHeight - $margin,
                ];

            case 'bottom-right':
                return [
                    'x' => $imageWidth - $textWidth - $margin,
                    'y' => $imageHeight - $textHeight - $margin,
                ];

            case 'center':
                return [
                    'x' => ($imageWidth - $textWidth) / 2,
                    'y' => ($imageHeight - $textHeight) / 2,
                ];

            default:
                return [
                    'x' => $imageWidth - $textWidth - $margin,
                    'y' => $imageHeight - $textHeight - $margin,
                ];
        }
    }

    /**
     * Hex szín konvertálása RGB-re
     */
    private function hexToRgb(string $hex): array
    {
        $hex = mb_ltrim($hex, '#');

        if (mb_strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return [
            'r' => hexdec(mb_substr($hex, 0, 2)),
            'g' => hexdec(mb_substr($hex, 2, 2)),
            'b' => hexdec(mb_substr($hex, 4, 2)),
        ];
    }
}
