<?php

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
        Schema::create('distribution_area_warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('distribution_area_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('warehouse_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['distribution_area_id', 'warehouse_id'], 'dist_area_wh_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_area_warehouses');
    }
};
