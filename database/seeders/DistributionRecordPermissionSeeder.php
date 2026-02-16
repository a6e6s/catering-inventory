<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DistributionRecordPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
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

        // Assign permissions to admin role
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permissions);
    }
}
