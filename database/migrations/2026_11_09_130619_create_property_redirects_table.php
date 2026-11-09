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
     * The URLs of permanently deleted properties, so they can answer with a 301
     * to their district's page instead of a 404.
     */
    public function up(): void
    {
        Schema::create('property_redirects', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('offer_type')->nullable();
            $table->string('district')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_redirects');
    }
};
