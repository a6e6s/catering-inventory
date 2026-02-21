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

        Schema::create('transaction_approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('transaction_id')->constrained('inventory_transactions');
            $table->string('approver_role')->comment('receiver,warehouse_manager,compliance_officer');
            $table->foreignId('approver_id')->nullable()->constrained('users');
            $table->integer('step')->default(1);
            $table->string('status')->default('pending')->index();
            $table->text('comments')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_approvals');
    }
};
