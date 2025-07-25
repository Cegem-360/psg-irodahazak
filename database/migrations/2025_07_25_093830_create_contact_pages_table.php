<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('language', 2)->default('hu'); // Nyelv kód (hu, en)
            $table->longText('content')->nullable(); // Rich Editor tartalma a kapcsolati információkhoz
            $table->timestamps();

            $table->unique('language'); // Egy nyelvenként csak egy rekord lehet
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
