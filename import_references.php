<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use App\Models\Reference;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Laravel alkalmazás inicializálása
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// References temp mappa elérési útja
$tempPath = 'references_tmp';
$targetPath = 'references';

// Győződjünk meg, hogy létezik a célmappa
if (! Storage::disk('public')->exists($targetPath)) {
    Storage::disk('public')->makeDirectory($targetPath);
}

// Fájlok lekérése a temp mappából
$files = Storage::disk('public')->files($tempPath);

// Fájlok csoportosítása név szerint
$groupedFiles = [];
foreach ($files as $file) {
    $filename = basename($file);

    // .DS_Store fájlok kihagyása
    if ($filename === '.DS_Store') {
        continue;
    }

    // Név kinyerése az első _ előtti részből
    $nameParts = explode('_', $filename);
    $baseName = $nameParts[0];

    // Ha több részből áll a név (pl. "abc_logo"), akkor az első két részt vesszük
    if (count($nameParts) > 1 && mb_strlen($baseName) <= 3) {
        $baseName = $nameParts[0].'_'.$nameParts[1];
    }

    if (! isset($groupedFiles[$baseName])) {
        $groupedFiles[$baseName] = [];
    }

    $groupedFiles[$baseName][] = $file;
}

echo 'Talált csoportok: '.count($groupedFiles)."\n";

$processedCount = 0;
$skippedCount = 0;

foreach ($groupedFiles as $baseName => $files) {
    // Keresünk 1280x800 méretű fájlt
    $targetFile = null;
    foreach ($files as $file) {
        if (mb_strpos(basename($file), '1280x800') !== false) {
            $targetFile = $file;
            break;
        }
    }

    if (! $targetFile) {
        echo "Nincs 1280x800 méretű fájl a(z) '{$baseName}' csoportban, kihagyjuk.\n";
        $skippedCount++;

        continue;
    }

    $filename = basename($targetFile);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Új fájlnév generálása
    $newFilename = Str::slug($baseName).'.'.$extension;
    $newPath = $targetPath.'/'.$newFilename;

    // Ellenőrizzük, hogy már létezik-e ilyen nevű referencia
    $existingReference = Reference::where('name', $baseName)->first();
    if ($existingReference) {
        echo "Már létezik referencia ezzel a névvel: '{$baseName}', kihagyjuk.\n";
        $skippedCount++;

        continue;
    }

    try {
        // Fájl másolása a célmappába
        $fileContent = Storage::disk('public')->get($targetFile);
        Storage::disk('public')->put($newPath, $fileContent);

        // Referencia létrehozása az adatbázisban
        Reference::create([
            'name' => $baseName,
            'image' => $newPath,
            'order' => $processedCount + 1,
            'is_active' => true,
        ]);

        echo "Sikeresen feldolgozva: '{$baseName}' -> '{$newFilename}'\n";
        $processedCount++;

    } catch (Exception $e) {
        echo "Hiba történt a(z) '{$baseName}' feldolgozása során: ".$e->getMessage()."\n";
        $skippedCount++;
    }
}

echo "\n=== Összesítő ===\n";
echo "Sikeresen feldolgozott referenciák: {$processedCount}\n";
echo "Kihagyott fájlok: {$skippedCount}\n";
echo 'Összes csoport: '.count($groupedFiles)."\n";

echo "\nA script futása befejeződött.\n";
