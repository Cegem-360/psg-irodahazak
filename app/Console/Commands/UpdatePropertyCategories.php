<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class UpdatePropertyCategories extends Command
{
    protected $signature = 'property:update-categories {--dry-run : Csak kiírja, mit módosítana, nem ír az adatbázisba}';

    protected $description = 'Update Property categories from pages table and backup affected records (alapértelmezetten dry-run)';

    public function handle(): void
    {
        $pages = DB::table('pages')
            ->where('type', 'property_category')
            ->where('template', 'Ingatlan')
            ->get();

        foreach ($pages as $page) {
            // content_id lehet string vagy json string, pl. '["43"]' vagy '43'
            $contentIdRaw = str_replace('\\', '', $page->content_id); // eltávolítja a visszaperjeleket
            $contentIds = json_decode($contentIdRaw, true);
            foreach ($contentIds ?? [] as $propertyId) {
                $property = Property::find($propertyId);
                if ($property) {
                    if (! is_array($property->categories)) {
                        $property->update(['categories' => []]);
                    }

                    $tmpCategories = $property->categories ?? [];
                    // Szűrjük ki a már nem létező kategóriákat
                    $tmpCategories = array_values(array_filter($tmpCategories, function ($catName) {
                        return Category::where('name', $catName)->exists();
                    }));
                    // Új kategória hozzáadása, ha létezik
                    if (Category::where('name', $page->title)->exists()) {
                        if (! in_array($page->title, $tmpCategories, true)) {
                            $tmpCategories[] = $page->title;
                        }
                    } else {
                        $this->warn('Kategória nem található: '.$page->title);
                    }

                    $property->update(['categories' => $tmpCategories]);
                }
            }
        }
    }
}
