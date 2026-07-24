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
     * On the production database this table already exists (it was imported from
     * the legacy system), so we only create it when it is missing. The `district`,
     * `featured` and `property_photos` columns are intentionally omitted here
     * because later migrations add them.
     */
    public function up(): void
    {
        if (Schema::hasTable('properties')) {
            return;
        }

        Schema::create('properties', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable()->default('');
            $table->mediumText('slug')->nullable();
            $table->string('status')->nullable()->default('');
            $table->longText('content')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->integer('ord')->nullable()->default(0);
            $table->string('meta_title')->nullable();
            $table->longText('meta_title_en')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->longText('meta_keywords_en')->nullable();
            $table->mediumText('meta_description')->nullable();
            $table->longText('meta_description_en')->nullable();

            foreach ([
                'construction_year', 'total_area', 'jelenleg_kiado', 'max_berleti_dij',
                'uzemeletetesi_dij', 'raktar_terulet', 'raktar_berleti_dij', 'parkolas',
                'kozos_teruleti_arany', 'cim_irsz', 'cim_varos', 'cim_utca', 'cim_hazszam',
            ] as $column) {
                $table->string($column)->nullable()->default('');
            }

            $table->string('maps_lat')->nullable();
            $table->string('maps_lng')->nullable();
            $table->string('azonosito')->nullable();

            foreach ([
                'osszterulet_addons', 'max_berleti_dij_addons', 'min_berleti_dij',
                'min_berleti_dij_addons', 'raktar_terulet_addons', 'raktar_berleti_dij_addons',
                'uzemeletetesi_dij_addons', 'min_parkolas_dija', 'min_parkolas_dija_addons',
                'max_parkolas_dija', 'max_parkolas_dija_addons', 'kozos_teruleti_arany_addons',
                'min_kiado', 'min_kiado_addons', 'jelenleg_kiado_addons', 'kodszam',
            ] as $column) {
                $table->string($column)->nullable()->default('');
            }

            $table->longText('en_content')->nullable();
            $table->string('min_berleti_idoszak')->nullable()->default('');
            $table->string('min_berleti_idoszak_addons')->nullable()->default('');
            $table->string('cim_utca_addons')->nullable()->default('');
            $table->string('lang', 2)->nullable()->default('');
            $table->string('cimke')->nullable()->default('');
            $table->string('service')->nullable()->default('');
            $table->string('maps')->nullable()->default('');
            $table->string('elado_v_kiado')->nullable()->default('');
            $table->string('updated', 10)->nullable()->default('');
            $table->longText('egyeb')->nullable();
            $table->tinyInteger('vat')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
