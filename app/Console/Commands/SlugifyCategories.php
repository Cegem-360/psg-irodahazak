<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Description('Frissíti a categories tábla slug mezőjét a name alapján, magyar ékezetes karakterek cseréjével.')]
#[Signature('category:slugify {--dry-run : Csak kiírja, mit módosítana, nem ír az adatbázisba}')]
final class SlugifyCategories extends Command
{
    public function handle(): void
    {
        $categories = Category::all();
        $replace = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ú' => 'u', 'ü' => 'u', 'ű' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ö' => 'o', 'Ő' => 'o',
            'Ú' => 'u', 'Ü' => 'u', 'Ű' => 'u',
        ];
        foreach ($categories as $category) {
            $slugBase = strtr($category->name, $replace);
            $slug = Str::slug($slugBase);
            if ($category->slug !== $slug) {
                if ($this->option('dry-run')) {
                    $this->info(sprintf('[DRY RUN] %s => %s', $category->name, $slug));
                } else {
                    $category->slug = $slug;
                    $category->save();
                    $this->info(sprintf('Frissítve: %s => %s', $category->name, $slug));
                }
            }
        }

        $this->info('Kész.');
    }
}
