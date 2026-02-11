<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->index();
            $table->foreignUuid('from_warehouse_id')->nullable()->constrained('warehouses');
            $table->foreignUuid('to_warehouse_id')->nullable()->constrained('warehouses');
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('batch_id')->nullable()->constrained();
            $table->decimal('quantity', 10, 2);
            $table->string('status')->default('draft')->index();
            $table->foreignId('initiated_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date')->useCurrent()->index();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
