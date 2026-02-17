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
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->decimal('actual_quantity_received', 10, 2)->nullable()->after('quantity');
            $table->timestamp('completed_at')->nullable()->after('transaction_date');
            $table->foreignId('completed_by')->nullable()->constrained('users')->after('completed_at');
            $table->timestamp('rejected_at')->nullable()->after('completed_by');
            $table->foreignId('rejected_by')->nullable()->constrained('users')->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropForeign(['completed_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn([
                'actual_quantity_received',
                'completed_at',
                'completed_by',
                'rejected_at',
                'rejected_by',
            ]);
        });
    }
};
