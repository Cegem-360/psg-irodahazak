<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Property;
use App\Models\Service;
use App\Models\Tag;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class ConvertJsonToManyToMany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:convert-json-relations {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert JSON stored tags, services, and categories to many-to-many relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('🔍 Running in DRY RUN mode - no changes will be made');
        }

        $this->info('🚀 Starting conversion of JSON relations to many-to-many...');

        DB::beginTransaction();

        try {
            $properties = Property::whereNotNull('tags')
                ->orWhereNotNull('services')
                ->orWhereNotNull('categories')
                ->get();

            $this->info("📊 Found {$properties->count()} properties with JSON relations");

            $convertedCount = 0;

            foreach ($properties as $property) {
                $this->convertPropertyRelations($property, $dryRun);
                $convertedCount++;

                if ($convertedCount % 50 === 0) {
                    $this->info("✅ Processed {$convertedCount} properties...");
                }
            }

            if (! $dryRun) {
                DB::commit();
                $this->info("🎉 Successfully converted {$convertedCount} properties!");
            } else {
                DB::rollBack();
                $this->info("🔍 DRY RUN completed - {$convertedCount} properties would be converted");
            }

        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Error during conversion: '.$e->getMessage());

            return 1;
        }

        return 0;
    }

    private function convertPropertyRelations(Property $property, bool $dryRun): void
    {
        $this->line("Processing Property ID: {$property->id} - {$property->title}");

        // Convert Tags
        if ($property->tags && is_array($property->tags)) {
            $this->convertTags($property, $property->tags, $dryRun);
        }

        // Convert Services
        if ($property->services && is_array($property->services)) {
            $this->convertServices($property, $property->services, $dryRun);
        }

        // Convert Categories
        if ($property->categories && is_array($property->categories)) {
            $this->convertCategories($property, $property->categories, $dryRun);
        }
    }

    private function convertTags(Property $property, array $tagNames, bool $dryRun): void
    {
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            if (empty($tagName)) {
                continue;
            }

            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;

            if (! $dryRun) {
                $this->line("  🏷️  Tag: {$tagName} (ID: {$tag->id})");
            }
        }

        if (! $dryRun && ! empty($tagIds)) {
            $property->tags()->sync($tagIds);
        }

        $this->line('  📝 Would sync '.count($tagIds).' tags');
    }

    private function convertServices(Property $property, array $serviceNames, bool $dryRun): void
    {
        $serviceIds = [];

        foreach ($serviceNames as $serviceName) {
            if (empty($serviceName)) {
                continue;
            }

            $service = Service::firstOrCreate(['name' => $serviceName]);
            $serviceIds[] = $service->id;

            if (! $dryRun) {
                $this->line("  🔧 Service: {$serviceName} (ID: {$service->id})");
            }
        }

        if (! $dryRun && ! empty($serviceIds)) {
            $property->services()->sync($serviceIds);
        }

        $this->line('  📝 Would sync '.count($serviceIds).' services');
    }

    private function convertCategories(Property $property, array $categoryNames, bool $dryRun): void
    {
        $categoryIds = [];

        foreach ($categoryNames as $categoryName) {
            if (empty($categoryName)) {
                continue;
            }

            $category = Category::firstOrCreate(['name' => $categoryName]);
            $categoryIds[] = $category->id;

            if (! $dryRun) {
                $this->line("  📂 Category: {$categoryName} (ID: {$category->id})");
            }
        }

        if (! $dryRun && ! empty($categoryIds)) {
            $property->categories()->sync($categoryIds);
        }

        $this->line('  📝 Would sync '.count($categoryIds).' categories');
    }
}
