<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const string SLUG = 'uzemeltetesi-dij-irodaberles';

    /**
     * Run the migrations.
     *
     * The operating fee article (content package 2) is a page of its own at
     * /hirek/uzemeltetesi-dij-irodaberles; this record puts it at the head of
     * the news list and on the home page. Its route comes before the news
     * route, so the record's content is only used for the list and the search.
     */
    public function up(): void
    {
        $authorId = DB::table('users')->where('email', 'richard.fekete@psg-irodahazak.hu')->value('id')
            ?? DB::table('users')->orderBy('id')->value('id');

        // A fresh database has no user yet: nothing to list the article under
        if ($authorId === null || DB::table('news')->where('slug', self::SLUG)->exists()) {
            return;
        }

        $lead = 'Az üzemeltetési díj a bérleti díjon felül fizetett, az irodaház közös költségeit fedező havi összeg. Budapesten 2026 őszén jellemzően 2 200–2 850 HUF/m²/hó, a középérték 2 500 HUF/m²/hó, az euróban árazó házakban 5–6,5 EUR/m²/hó.';

        DB::table('news')->insert([
            'title' => 'Üzemeltetési díj irodabérlésnél: mit tartalmaz, mennyi Budapesten 2026-ban, és mire figyelj az elszámolásnál',
            'slug' => self::SLUG,
            'excerpt' => '<p>'.$lead.'</p>',
            'content' => '<p>'.$lead.'</p>',
            'news_category_id' => DB::table('news_categories')->where('slug', 'ingatlan')->value('id'),
            'user_id' => $authorId,
            'is_published' => true,
            'is_breaking' => false,
            'priority' => 2,
            'views_count' => 0,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('news')->where('slug', self::SLUG)->delete();
    }
};
