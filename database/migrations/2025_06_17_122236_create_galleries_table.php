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
     * The table already exists on production (legacy import); create it only when
     * missing. The `images` column is intentionally omitted because a later
     * migration adds it.
     */
    public function up(): void
    {
        if (Schema::hasTable('galleries')) {
            return;
        }

        Schema::create('galleries', function (Blueprint $table): void {
            $table->id();
            $table->string('path')->nullable();
            $table->integer('target_table_id');
            $table->integer('ord')->nullable()->default(0);
            $table->string('size', 20)->nullable();
            $table->timestamp('date')->nullable();
            $table->string('target_table', 150)->nullable();
            $table->string('path_without_size_and_ext')->nullable();
            $table->string('alt')->nullable();
            $table->integer('gallery_category_id')->nullable()->default(0);
            $table->string('video_url')->nullable();
            $table->timestamps();
            $table->index('target_table_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
