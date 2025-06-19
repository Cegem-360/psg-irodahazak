<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class UpdatePropertySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:update-slugs {--force : Force update all slugs, even if they already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update property slugs from their titles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');

        $this->info('Starting property slug update...');

        $query = Property::query();

        if (! $force) {
            $query->where(function ($q) {
                $q->whereNull('slug')->orWhere('slug', '');
            });
        }

        $properties = $query->get();

        if ($properties->isEmpty()) {
            $this->info('No properties found to update.');

            return;
        }

        $this->info("Found {$properties->count()} properties to update.");

        $progressBar = $this->output->createProgressBar($properties->count());
        $progressBar->start();

        $updated = 0;
        $duplicates = [];

        foreach ($properties as $property) {
            if (empty($property->title)) {
                $progressBar->advance();

                continue;
            }

            $slug = Str::slug($property->title);

            // Check for duplicate slugs
            $existingProperty = Property::where('slug', $slug)
                ->where('id', '!=', $property->id)
                ->first();

            if ($existingProperty) {
                // Add suffix for duplicates
                $counter = 1;
                $originalSlug = $slug;
                while (Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                    $slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
                $duplicates[] = $property->title;
            }

            $property->update(['slug' => $slug]);
            $updated++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Successfully updated {$updated} property slugs.");

        if (! empty($duplicates)) {
            $this->warn('The following properties had duplicate slugs and were given suffixes:');
            foreach ($duplicates as $title) {
                $this->line("- {$title}");
            }
        }

        $this->info('Property slug update completed!');
    }
}
