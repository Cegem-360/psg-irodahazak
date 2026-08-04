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
     * Legacy table that predates the Laravel rewrite, so it was never covered by a
     * migration. Mirrors production, which has no created_at/updated_at.
     */
    public function up(): void
    {
        if (Schema::hasTable('pages')) {
            return;
        }

        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->integer('ord')->default(0);
            $table->string('template', 150);
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->integer('show_menu')->nullable()->default(0);
            $table->string('type', 100)->nullable();
            $table->longText('content_id')->nullable();
            $table->string('title_url')->nullable();
            $table->integer('content_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
