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
        if (Schema::hasTable('post_codes')) {
            return;
        }

        Schema::create('post_codes', function (Blueprint $table): void {
            $table->id();
            $table->string('iranyitoszam', 4)->default('');
            $table->string('helyiseg', 64)->default('');
            $table->string('megye', 64)->default('');
            $table->timestamps();
            $table->unique('iranyitoszam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_codes');
    }
};
