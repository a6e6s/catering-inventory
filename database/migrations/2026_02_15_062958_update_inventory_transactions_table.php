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
        Schema::disableForeignKeyConstraints();
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->foreignUuid('product_id')->nullable()->change();
            $table->foreignUuid('raw_material_id')->nullable()->constrained()->after('product_id');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->foreignUuid('product_id')->nullable(false)->change();
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn('raw_material_id');
        });
        Schema::enableForeignKeyConstraints();
    }
};
