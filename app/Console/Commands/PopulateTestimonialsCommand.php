<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateTestimonialsCommand extends Command
{
    protected $signature = 'testimonials:populate';
    protected $description = 'Populate testimonials table from contents table';

    public function handle()
    {
        $this->info('Starting testimonials population...');

        $targetIds = [
            59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 
            73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87,
            154, 155, 168, 169, 176, 177, 179, 180, 225, 226, 231, 232,
            250, 251, 252, 253, 271, 272, 277, 278, 290, 291, 292, 293,
            296, 297, 303, 304, 309, 310, 314, 315, 325, 326, 329, 330,
            332, 333
        ];

        try {
            // Create backup first
            $this->info('Creating backup of existing testimonials...');
            $existing = DB::table('testimonials')->get();
            $backupFile = 'testimonials_backup_' . date('Y-m-d_H-i-s') . '.json';
            file_put_contents(storage_path('backups/' . $backupFile), $existing->toJson());
            $this->info("Backup created: {$backupFile}");

            // Get contents to process
            $contents = DB::table('contents')
                ->whereIn('id', $targetIds)
                ->where('status', 'active')
                ->whereNotNull('title')
                ->whereNotNull('lead')
                ->get();

            $this->info("Found {$contents->count()} contents to process.");

            $inserted = 0;
            $bar = $this->output->createProgressBar($contents->count());

            foreach ($contents as $content) {
                // Parse client name and company from title
                $titleParts = explode(',', $content->title, 2);
                $clientName = trim($titleParts[0]);
                $clientCompany = isset($titleParts[1]) ? trim($titleParts[1]) : null;

                // Clean testimonial text - keep HTML but clean up entities
                $testimonial = $content->lead;
                $testimonial = str_replace(['&nbsp;'], [' '], $testimonial);
                $testimonial = trim($testimonial);

                // Insert testimonial
                DB::table('testimonials')->insert([
                    'client_name' => $clientName,
                    'client_position' => null,
                    'client_company' => $clientCompany,
                    'testimonial' => $testimonial,
                    'client_image' => null,
                    'company_logo' => null,
                    'rating' => 5,
                    'project_type' => 'office_rental',
                    'is_featured' => 0,
                    'is_active' => 1,
                    'order' => $content->id,
                    'lang' => strtolower($content->lang),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $inserted++;
                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);
            
            $this->info("Successfully inserted {$inserted} testimonials!");
            $totalCount = DB::table('testimonials')->count();
            $this->info("Total testimonials count: {$totalCount}");

            // Show sample of new testimonials
            $this->info("\nSample of newly added testimonials:");
            $samples = DB::table('testimonials')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(['client_name', 'client_company', 'lang']);
                
            foreach ($samples as $sample) {
                $this->line("- {$sample->client_name} ({$sample->client_company}) [{$sample->lang}]");
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
