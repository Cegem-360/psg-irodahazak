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
     * Legacy pivot behind Page::contents() and Content::pages().
     */
    public function up(): void
    {
        if (Schema::hasTable('page_content')) {
            return;
        }

        Schema::create('page_content', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('page_id')->nullable()->index();
            $table->unsignedBigInteger('content_id')->nullable()->index();
            $table->unsignedBigInteger('property_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_content');
    }
};
