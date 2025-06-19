<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

final class CleanPropertyContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:clean-content {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove \\n\\n characters from property content fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        $this->info('Starting property content cleanup...');

        // Get properties that have content with actual newlines or literal \n\n
        $properties = Property::whereNotNull('content')
            ->where('content', '!=', '')
            ->where(function ($query) {
                $query->where('content', 'like', '%\\n\\n%')  // literal \n\n
                    ->orWhere('content', 'like', "%\n\n%");  // actual newlines
            })
            ->get();

        if ($properties->isEmpty()) {
            $this->info('No properties found with \\n\\n in content field.');

            return;
        }

        $this->info("Found {$properties->count()} properties with \\n\\n in content field.");

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        $progressBar = $this->output->createProgressBar($properties->count());
        $progressBar->start();

        $updated = 0;

        foreach ($properties as $property) {
            $originalContent = $property->content;
            $cleanedContent = $originalContent;

            // Check what type of newlines we have
            $hasLiteralNewlines = mb_strpos($originalContent, '\\n\\n') !== false;
            $hasActualNewlines = mb_strpos($originalContent, "\n\n") !== false;

            // Remove literal \n\n
            if ($hasLiteralNewlines) {
                $cleanedContent = str_replace('\\n\\n', '', $cleanedContent);
            }

            // Clean up actual multiple newlines (replace 2+ newlines with single newline)
            if ($hasActualNewlines) {
                $cleanedContent = preg_replace('/\n{2,}/', "\n", $cleanedContent);
            }

            $cleanedContent = mb_trim($cleanedContent);

            if ($originalContent !== $cleanedContent) {
                if ($dryRun) {
                    $this->line("\nProperty ID {$property->id} - Title: {$property->title}");
                    $this->line('Has literal \\n\\n: '.($hasLiteralNewlines ? 'YES' : 'NO'));
                    $this->line('Has actual newlines: '.($hasActualNewlines ? 'YES' : 'NO'));
                    $this->line('Original length: '.mb_strlen($originalContent));
                    $this->line('Cleaned length: '.mb_strlen($cleanedContent));

                    // Show a small sample
                    $sample = mb_substr($originalContent, 0, 200);
                    $this->line('Sample content: '.json_encode($sample));
                    $this->line('---');
                } else {
                    $property->update(['content' => $cleanedContent]);
                }
                $updated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($dryRun) {
            $this->info("Would update {$updated} properties.");
            $this->info('Run without --dry-run to apply changes.');
        } else {
            $this->info("Successfully cleaned content for {$updated} properties.");
        }

        $this->info('Property content cleanup completed!');
    }
}
