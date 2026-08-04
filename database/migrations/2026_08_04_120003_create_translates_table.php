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
     * Backs the Translate model, which is queried by every property card, the
     * property PDF and properties/show — the storefront cannot render without it.
     */
    public function up(): void
    {
        if (Schema::hasTable('translates')) {
            return;
        }

        Schema::create('translates', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->default('')->index();
            $table->string('translated')->default('');
            $table->timestamp('date')->nullable()->useCurrent();
            $table->string('lang', 2)->nullable()->default('EN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translates');
    }
};
