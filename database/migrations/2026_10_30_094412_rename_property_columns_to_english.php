<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The property columns came over from the old Hungarian site; they get English
 * names. The "_addons" columns hold the unit shown after a value ("EUR/m2/hó"),
 * so they become "_unit".
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->renameColumn('cim_irsz', 'postal_code');
            $table->renameColumn('cim_varos', 'city');
            $table->renameColumn('cim_utca_addons', 'street_type');
            $table->renameColumn('cim_utca', 'street');
            $table->renameColumn('cim_hazszam', 'house_number');
            $table->renameColumn('osszterulet_addons', 'total_area_unit');
            $table->renameColumn('min_berleti_dij_addons', 'min_rent_unit');
            $table->renameColumn('max_berleti_dij_addons', 'max_rent_unit');
            $table->renameColumn('min_berleti_dij', 'min_rent');
            $table->renameColumn('max_berleti_dij', 'max_rent');
            $table->renameColumn('uzemeletetesi_dij_addons', 'operating_fee_unit');
            $table->renameColumn('uzemeletetesi_dij', 'operating_fee');
            $table->renameColumn('raktar_terulet_addons', 'storage_area_unit');
            $table->renameColumn('raktar_terulet', 'storage_area');
            $table->renameColumn('raktar_berleti_dij_addons', 'storage_rent_unit');
            $table->renameColumn('raktar_berleti_dij', 'storage_rent');
            $table->renameColumn('min_parkolas_dija_addons', 'min_parking_fee_unit');
            $table->renameColumn('max_parkolas_dija_addons', 'max_parking_fee_unit');
            $table->renameColumn('min_parkolas_dija', 'min_parking_fee');
            $table->renameColumn('max_parkolas_dija', 'max_parking_fee');
            $table->renameColumn('parkolas', 'parking');
            $table->renameColumn('kozos_teruleti_arany_addons', 'common_area_ratio_unit');
            $table->renameColumn('kozos_teruleti_arany', 'common_area_ratio');
            $table->renameColumn('min_kiado_addons', 'min_available_area_unit');
            $table->renameColumn('min_kiado', 'min_available_area');
            $table->renameColumn('jelenleg_kiado_addons', 'available_area_unit');
            $table->renameColumn('jelenleg_kiado', 'available_area');
            $table->renameColumn('kodszam', 'code');
            $table->renameColumn('min_berleti_idoszak_addons', 'min_lease_term_unit');
            $table->renameColumn('min_berleti_idoszak', 'min_lease_term');
            $table->renameColumn('elado_v_kiado', 'offer_type');
            $table->renameColumn('azonosito', 'identifier');
            $table->renameColumn('cimke', 'label');
            $table->renameColumn('egyeb', 'other_info');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->renameColumn('postal_code', 'cim_irsz');
            $table->renameColumn('city', 'cim_varos');
            $table->renameColumn('street_type', 'cim_utca_addons');
            $table->renameColumn('street', 'cim_utca');
            $table->renameColumn('house_number', 'cim_hazszam');
            $table->renameColumn('total_area_unit', 'osszterulet_addons');
            $table->renameColumn('min_rent_unit', 'min_berleti_dij_addons');
            $table->renameColumn('max_rent_unit', 'max_berleti_dij_addons');
            $table->renameColumn('min_rent', 'min_berleti_dij');
            $table->renameColumn('max_rent', 'max_berleti_dij');
            $table->renameColumn('operating_fee_unit', 'uzemeletetesi_dij_addons');
            $table->renameColumn('operating_fee', 'uzemeletetesi_dij');
            $table->renameColumn('storage_area_unit', 'raktar_terulet_addons');
            $table->renameColumn('storage_area', 'raktar_terulet');
            $table->renameColumn('storage_rent_unit', 'raktar_berleti_dij_addons');
            $table->renameColumn('storage_rent', 'raktar_berleti_dij');
            $table->renameColumn('min_parking_fee_unit', 'min_parkolas_dija_addons');
            $table->renameColumn('max_parking_fee_unit', 'max_parkolas_dija_addons');
            $table->renameColumn('min_parking_fee', 'min_parkolas_dija');
            $table->renameColumn('max_parking_fee', 'max_parkolas_dija');
            $table->renameColumn('parking', 'parkolas');
            $table->renameColumn('common_area_ratio_unit', 'kozos_teruleti_arany_addons');
            $table->renameColumn('common_area_ratio', 'kozos_teruleti_arany');
            $table->renameColumn('min_available_area_unit', 'min_kiado_addons');
            $table->renameColumn('min_available_area', 'min_kiado');
            $table->renameColumn('available_area_unit', 'jelenleg_kiado_addons');
            $table->renameColumn('available_area', 'jelenleg_kiado');
            $table->renameColumn('code', 'kodszam');
            $table->renameColumn('min_lease_term_unit', 'min_berleti_idoszak_addons');
            $table->renameColumn('min_lease_term', 'min_berleti_idoszak');
            $table->renameColumn('offer_type', 'elado_v_kiado');
            $table->renameColumn('identifier', 'azonosito');
            $table->renameColumn('label', 'cimke');
            $table->renameColumn('other_info', 'egyeb');
        });
    }
};
