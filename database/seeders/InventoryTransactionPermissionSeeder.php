<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InventoryTransactionPermissionSeeder extends Seeder
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
            'view_any_inventory_transaction',
            'view_inventory_transaction',
            'create_inventory_transaction',
            'update_inventory_transaction',
            'delete_inventory_transaction',
            'restore_inventory_transaction',
            'force_delete_inventory_transaction',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin role
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permissions);
    }
}
