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
    protected $description = 'Remove \\n\\n characters from property content and en_content fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        $this->info('Starting property content cleanup...');

        // Get properties that have content with actual newlines or literal \n\n in either content or en_content
        $properties = Property::where(function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->whereNotNull('content')
                    ->where('content', '!=', '')
                    ->where(function ($contentQuery) {
                        $contentQuery->where('content', 'like', '%\\n\\n%')  // literal \n\n
                            ->orWhere('content', 'like', "%\n\n%");  // actual newlines
                    });
            })->orWhere(function ($subQuery) {
                $subQuery->whereNotNull('en_content')
                    ->where('en_content', '!=', '')
                    ->where(function ($enContentQuery) {
                        $enContentQuery->where('en_content', 'like', '%\\n\\n%')  // literal \n\n
                            ->orWhere('en_content', 'like', "%\n\n%");  // actual newlines
                    });
            });
        })->get();

        if ($properties->isEmpty()) {
            $this->info('No properties found with \\n\\n in content or en_content fields.');

            return;
        }

        $this->info("Found {$properties->count()} properties with \\n\\n in content or en_content fields.");

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        $progressBar = $this->output->createProgressBar($properties->count());
        $progressBar->start();

        $updated = 0;

        foreach ($properties as $property) {
            $changes = [];

            // Process content field
            if (! empty($property->content)) {
                $originalContent = $property->content;
                $cleanedContent = $this->cleanContentField($originalContent);

                if ($originalContent !== $cleanedContent) {
                    $changes['content'] = $cleanedContent;

                    if ($dryRun) {
                        $this->showFieldChanges('content', $property, $originalContent, $cleanedContent);
                    }
                }
            }

            // Process en_content field
            if (! empty($property->en_content)) {
                $originalEnContent = $property->en_content;
                $cleanedEnContent = $this->cleanContentField($originalEnContent);

                if ($originalEnContent !== $cleanedEnContent) {
                    $changes['en_content'] = $cleanedEnContent;

                    if ($dryRun) {
                        $this->showFieldChanges('en_content', $property, $originalEnContent, $cleanedEnContent);
                    }
                }
            }

            if (! empty($changes)) {
                if (! $dryRun) {
                    $property->update($changes);
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

    /**
     * Clean a content field by removing literal \n\n and excessive newlines
     */
    private function cleanContentField(string $content): string
    {
        $cleanedContent = $content;

        // Remove literal \n\n
        if (mb_strpos($content, '\\n\\n') !== false) {
            $cleanedContent = str_replace('\\n\\n', '', $cleanedContent);
        }

        // Clean up actual multiple newlines (replace 2+ newlines with single newline)
        if (mb_strpos($content, "\n\n") !== false) {
            $cleanedContent = preg_replace('/\n{2,}/', "\n", $cleanedContent);
        }

        return mb_trim($cleanedContent);
    }

    /**
     * Show changes for a specific field in dry-run mode
     */
    private function showFieldChanges(string $fieldName, Property $property, string $original, string $cleaned): void
    {
        $hasLiteralNewlines = mb_strpos($original, '\\n\\n') !== false;
        $hasActualNewlines = mb_strpos($original, "\n\n") !== false;

        $this->line("\nProperty ID {$property->id} - Title: {$property->title}");
        $this->line("Field: {$fieldName}");
        $this->line('Has literal \\n\\n: '.($hasLiteralNewlines ? 'YES' : 'NO'));
        $this->line('Has actual newlines: '.($hasActualNewlines ? 'YES' : 'NO'));
        $this->line('Original length: '.mb_strlen($original));
        $this->line('Cleaned length: '.mb_strlen($cleaned));

        // Show a small sample
        $sample = mb_substr($original, 0, 200);
        $this->line('Sample content: '.json_encode($sample));
        $this->line('---');
    }
}
