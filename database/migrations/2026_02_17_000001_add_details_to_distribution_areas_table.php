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
        Schema::table('distribution_areas', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name')->unique();
            $table->integer('capacity')->default(200)->after('contact_phone');
            $table->string('distribution_frequency')->default('weekly')->after('capacity');
            $table->text('notes')->nullable()->after('distribution_frequency');
            $table->string('photo_thumbnail')->nullable()->after('notes');
            $table->boolean('requires_photo_verification')->default(true)->after('photo_thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_areas', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 
                'capacity', 
                'distribution_frequency', 
                'notes', 
                'photo_thumbnail',
                'requires_photo_verification'
            ]);
        });
    }
};
