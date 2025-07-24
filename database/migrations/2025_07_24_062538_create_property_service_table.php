<?php

declare(strict_types=1);

use App\Models\Property;
use App\Models\Service;
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
        Schema::create('property_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Property::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Service::class)->constrained()->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_service');
    }
};
