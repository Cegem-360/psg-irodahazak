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
     * The table already exists on production (legacy import); create it only when missing.
     */
    public function up(): void
    {
        if (Schema::hasTable('contents')) {
            return;
        }

        Schema::create('contents', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable()->default('');
            $table->string('status')->nullable()->default('');
            $table->longText('lead')->nullable();
            $table->longText('content')->nullable();
            $table->integer('ord')->nullable()->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('lang', 2)->nullable()->default('HU');
            $table->longText('tags')->nullable();
            $table->string('lead_pic')->nullable()->default('');
            $table->string('sdf')->nullable()->default('');
            $table->string('file')->nullable()->default('');
            $table->integer('ok')->nullable()->default(0);
            $table->string('mysep')->nullable()->default('');
            $table->string('link')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
