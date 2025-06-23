<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\News;
use App\Services\WatermarkService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class ApplyWatermarkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watermark:apply 
                           {--type=all : Típus megadása (all, gallery, blog, news)}
                           {--force : Meglévő vízjeles képek felülírása}
                           {--sizes : Különböző méretű változatok létrehozása}
                           {--dry-run : Csak szimuláció, nem módosítja a képeket}
                           {--prototype : Prototípus képek létrehozása külön mappába}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vízjel alkalmazása a meglévő képekre';

    private WatermarkService $watermarkService;

    public function __construct(WatermarkService $watermarkService)
    {
        parent::__construct();
        $this->watermarkService = $watermarkService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $force = $this->option('force');
        $createSizes = $this->option('sizes');
        $dryRun = $this->option('dry-run');
        $prototype = $this->option('prototype');

        if ($dryRun) {
            $this->warn('DRY-RUN mód: A képek nem lesznek módosítva!');
        }

        if ($prototype) {
            $this->warn('PROTOTYPE mód: Vízjeles képek külön mappába kerülnek!');
            $this->info('Prototype mappa: storage/app/public/watermarked-prototypes/');
            // Létrehozzuk a prototype mappát ha nem létezik
            Storage::disk('public')->makeDirectory('watermarked-prototypes');
        }

        $this->info('Vízjel alkalmazása elkezdődött...');

        if ($type === 'all' || $type === 'gallery') {
            $this->processGalleryImages($force, $createSizes, $dryRun, $prototype);
        }

        if ($type === 'all' || $type === 'blog') {
            $this->processBlogImages($force, $createSizes, $dryRun, $prototype);
        }

        if ($type === 'all' || $type === 'news') {
            $this->processNewsImages($force, $createSizes, $dryRun, $prototype);
        }

        $this->info('Vízjel alkalmazása befejezve!');
    }

    private function processGalleryImages(bool $force, bool $createSizes, bool $dryRun, bool $prototype = false): void
    {
        $this->info('Galéria képek feldolgozása...');

        $galleries = Gallery::whereNotNull('path')->get();
        $bar = $this->output->createProgressBar($galleries->count());

        $processedCount = 0;
        $skippedCount = 0;

        foreach ($galleries as $gallery) {
            if ($gallery->path && Storage::disk('public')->exists(mb_ltrim($gallery->path, './'))) {
                if ($dryRun) {
                    $this->line(" [DRY-RUN] Feldolgozná: {$gallery->path}");
                    $processedCount++;
                } elseif ($prototype) {
                    // Prototype módban külön mappába mentjük
                    $prototypePath = 'watermarked-prototypes/'.mb_ltrim($gallery->path, './');
                    $prototypeDir = dirname($prototypePath);
                    Storage::disk('public')->makeDirectory($prototypeDir);

                    $success = $this->watermarkService->applyWatermarkToPrototype($gallery->path, $prototypePath, $gallery->target_table);

                    if ($success) {
                        $this->line(" ✓ [PROTOTYPE] {$gallery->path} -> {$prototypePath}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ [PROTOTYPE] Hiba: {$gallery->path}");
                    }
                } else {
                    $success = $this->watermarkService->applyWatermark($gallery->path, $gallery->target_table);

                    if ($success && $createSizes) {
                        $sizes = [/* '160x160', '300x200', */ '800x600', '1200x800'];
                        $this->watermarkService->createWatermarkedSizes($gallery->path, $sizes, $gallery->target_table);
                    }

                    if ($success) {
                        $this->line(" ✓ {$gallery->path}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ Hiba: {$gallery->path}");
                    }
                }
            } else {
                $skippedCount++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Galéria: {$processedCount} feldolgozva, {$skippedCount} kihagyva");
    }

    private function processBlogImages(bool $force, bool $createSizes, bool $dryRun, bool $prototype = false): void
    {
        $this->info('Blog képek feldolgozása...');

        $blogPosts = BlogPost::whereNotNull('featured_image')->get();
        $bar = $this->output->createProgressBar($blogPosts->count());

        $processedCount = 0;
        $skippedCount = 0;

        foreach ($blogPosts as $blogPost) {
            if ($blogPost->featured_image && Storage::disk('public')->exists($blogPost->featured_image)) {
                if ($dryRun) {
                    $this->line(" [DRY-RUN] Feldolgozná: {$blogPost->featured_image}");
                    $processedCount++;
                } elseif ($prototype) {
                    // Prototype módban külön mappába mentjük
                    $prototypePath = 'watermarked-prototypes/'.$blogPost->featured_image;
                    $prototypeDir = dirname($prototypePath);
                    Storage::disk('public')->makeDirectory($prototypeDir);

                    $success = $this->watermarkService->applyWatermarkToPrototype($blogPost->featured_image, $prototypePath, 'blog');

                    if ($success) {
                        $this->line(" ✓ [PROTOTYPE] {$blogPost->featured_image} -> {$prototypePath}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ [PROTOTYPE] Hiba: {$blogPost->featured_image}");
                    }
                } else {
                    $success = $this->watermarkService->applyWatermark($blogPost->featured_image, 'blog');

                    if ($success && $createSizes) {
                        $sizes = ['300x200', '600x400', '800x533', '1200x800'];
                        $this->watermarkService->createWatermarkedSizes($blogPost->featured_image, $sizes, 'blog');
                    }

                    if ($success) {
                        $this->line(" ✓ {$blogPost->featured_image}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ Hiba: {$blogPost->featured_image}");
                    }
                }
            } else {
                $skippedCount++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Blog: {$processedCount} feldolgozva, {$skippedCount} kihagyva");
    }

    private function processNewsImages(bool $force, bool $createSizes, bool $dryRun, bool $prototype = false): void
    {
        $this->info('Hírek képeinek feldolgozása...');

        $newsItems = News::whereNotNull('featured_image')->get();
        $bar = $this->output->createProgressBar($newsItems->count());

        $processedCount = 0;
        $skippedCount = 0;

        foreach ($newsItems as $news) {
            if ($news->featured_image && Storage::disk('public')->exists($news->featured_image)) {
                if ($dryRun) {
                    $this->line(" [DRY-RUN] Feldolgozná: {$news->featured_image}");
                    $processedCount++;
                } elseif ($prototype) {
                    // Prototype módban külön mappába mentjük
                    $prototypePath = 'watermarked-prototypes/'.$news->featured_image;
                    $prototypeDir = dirname($prototypePath);
                    Storage::disk('public')->makeDirectory($prototypeDir);

                    $success = $this->watermarkService->applyWatermarkToPrototype($news->featured_image, $prototypePath, 'news');

                    if ($success) {
                        $this->line(" ✓ [PROTOTYPE] {$news->featured_image} -> {$prototypePath}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ [PROTOTYPE] Hiba: {$news->featured_image}");
                    }
                } else {
                    $success = $this->watermarkService->applyWatermark($news->featured_image, 'news');

                    if ($success && $createSizes) {
                        $sizes = ['300x200', '600x400', '800x533', '1200x800'];
                        $this->watermarkService->createWatermarkedSizes($news->featured_image, $sizes, 'news');
                    }

                    if ($success) {
                        $this->line(" ✓ {$news->featured_image}");
                        $processedCount++;
                    } else {
                        $this->error(" ✗ Hiba: {$news->featured_image}");
                    }
                }
            } else {
                $skippedCount++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Hírek: {$processedCount} feldolgozva, {$skippedCount} kihagyva");
    }
}
