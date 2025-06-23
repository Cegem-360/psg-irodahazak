<?php

require_once __DIR__ . '/bootstrap/app.php';

$app = app();

use App\Services\WatermarkService;
use Illuminate\Support\Facades\Storage;

$watermarkService = $app->make(WatermarkService::class);

// Tesztelés egy konkrét képpel
$originalImagePath = 'property/67/gallery/krausz_palota_1_160x160.jpg';
$prototypeImagePath = 'watermarked-prototypes/test_image.jpg';

// Létrehozzuk a prototype mappa struktúrát
Storage::disk('public')->makeDirectory('watermarked-prototypes');

echo "Eredeti kép: " . $originalImagePath . "\n";
echo "Prototype kép: " . $prototypeImagePath . "\n";

$result = $watermarkService->applyWatermarkToPrototype($originalImagePath, $prototypeImagePath, 'gallery');

if ($result) {
    echo "✓ Sikeresen létrejött a prototype kép!\n";
    echo "Ellenőrzés: " . (Storage::disk('public')->exists($prototypeImagePath) ? "Fájl létezik" : "Fájl nem létezik") . "\n";
} else {
    echo "✗ Hiba történt a prototype kép létrehozásakor!\n";
}
