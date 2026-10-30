<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Off-topic posts copied from blog.hu stay readable but are kept out of search
     * results and the sitemap.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->boolean('noindex')->default(false)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropColumn('noindex');
        });
    }
};
