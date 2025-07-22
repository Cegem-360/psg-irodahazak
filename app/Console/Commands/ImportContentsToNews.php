<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class ImportContentsToNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:import-contents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import lead and content from contents table to News model for specific IDs.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ids = [
            44, 88, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 170, 171, 172, 173, 174, 175, 178, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 222, 223, 224, 227, 228, 229, 230, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 254, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265, 266, 267, 268, 269, 270, 273, 274, 275, 276, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 289, 294, 295, 298, 299, 300, 301, 302, 305, 306, 307, 308, 311, 312, 313, 316, 317, 318, 319, 320, 321, 322, 323, 324, 327, 328, 331, 334, 335, 336,
        ];

        $contents = DB::table('contents')
            ->whereIn('id', $ids)
            ->select('id', 'lead', 'content', 'title', 'link')
            ->get();

        foreach ($contents as $content) {
            News::updateOrCreate(
                ['title' => str_replace(['\"'], ['"', ''], $content->title)],
                [
                    'title' => str_replace(['\"'], ['"', ''], $content->title),
                    'excerpt' => str_replace(['\"', '\n'], ['"', "\n\r"], $content->lead),
                    'content' => str_replace(['\"', '\n'], ['"', "\n\r"], $content->content),
                    'source' => $content->link,

                ]
            );
            // $this->info("ID: {$content->id} | Lead: {$content->lead} | Content: {$content->content}");
        }

        $this->info('Import finished.');
    }
}
