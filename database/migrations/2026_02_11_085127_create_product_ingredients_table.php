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

        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('raw_material_id')->constrained();
            $table->decimal('quantity_required', 10, 2);
            $table->string('unit');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ingredients');
    }
};
