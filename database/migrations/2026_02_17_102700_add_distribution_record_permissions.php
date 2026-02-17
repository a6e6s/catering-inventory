<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_any_distribution_record',
            'view_distribution_record',
            'create_distribution_record',
            'update_distribution_record',
            'delete_distribution_record',
            'restore_distribution_record',
            'force_delete_distribution_record',
            'verify_distribution_record',
            'reject_distribution_record',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign to Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        // Assign to Compliance Officer
        $complianceRole = Role::firstOrCreate(['name' => 'compliance_officer']);
        $complianceRole->givePermissionTo([
            'view_any_distribution_record',
            'view_distribution_record',
            'verify_distribution_record',
            'reject_distribution_record',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'view_any_distribution_record',
            'view_distribution_record',
            'create_distribution_record',
            'update_distribution_record',
            'delete_distribution_record',
            'restore_distribution_record',
            'force_delete_distribution_record',
            'verify_distribution_record',
            'reject_distribution_record',
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
};
