<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ──────────────────────────────────────────────
        // 1. Define ALL Permissions
        // ──────────────────────────────────────────────

        $permissions = [
            // Inventory Transaction
            'view_any_inventory_transaction',
            'view_inventory_transaction',
            'create_inventory_transaction',
            'update_inventory_transaction',
            'delete_inventory_transaction',
            'restore_inventory_transaction',
            'force_delete_inventory_transaction',
            'approve_inventory_transaction',

            // Transaction Approval
            'view_any_transaction_approval',
            'view_transaction_approval',
            'update_transaction_approval',
            'delete_transaction_approval',
            'approve_transaction_approval',
            'reject_transaction_approval',

            // Distribution Record
            'view_any_distribution_record',
            'view_distribution_record',
            'create_distribution_record',
            'update_distribution_record',
            'delete_distribution_record',
            'restore_distribution_record',
            'force_delete_distribution_record',
            'verify_distribution_record',
            'reject_distribution_record',

            // Product
            'view_any_product',
            'view_product',
            'create_product',
            'update_product',
            'delete_product',

            // Raw Material
            'view_any_raw_material',
            'view_raw_material',
            'create_raw_material',
            'update_raw_material',
            'delete_raw_material',

            // Batch
            'view_any_batch',
            'view_batch',
            'create_batch',
            'update_batch',
            'delete_batch',

            // Product Stock
            'view_any_product_stock',
            'view_product_stock',

            // Warehouse
            'view_any_warehouse',
            'view_warehouse',
            'create_warehouse',
            'update_warehouse',
            'delete_warehouse',

            // Distribution Area
            'view_any_distribution_area',
            'view_distribution_area',
            'create_distribution_area',
            'update_distribution_area',
            'delete_distribution_area',

            // User Management
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ──────────────────────────────────────────────
        // 2. Define Roles & Assign Permissions
        // ──────────────────────────────────────────────

        // --- Admin: Full access ---
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // --- Warehouse Staff ---
        $staff = Role::firstOrCreate(['name' => 'warehouse_staff']);
        $staff->givePermissionTo([
            // Transactions: create, view/edit/delete own drafts
            'view_any_inventory_transaction',
            'view_inventory_transaction',
            'create_inventory_transaction',
            'update_inventory_transaction',
            'delete_inventory_transaction',
            // Transaction Approvals: view own
            'view_any_transaction_approval',
            'view_transaction_approval',
            // Distribution Records: view + create
            'view_any_distribution_record',
            'view_distribution_record',
            'create_distribution_record',
            // Products: view
            'view_any_product',
            'view_product',
            // Raw Materials: view
            'view_any_raw_material',
            'view_raw_material',
            // Batches: view
            'view_any_batch',
            'view_batch',
            // Product Stock: view own warehouse
            'view_any_product_stock',
            'view_product_stock',
            // Warehouses: view all, update own
            'view_any_warehouse',
            'view_warehouse',
            'update_warehouse',
            // Distribution Areas: view + create
            'view_any_distribution_area',
            'view_distribution_area',
            'create_distribution_area',
        ]);

        // --- Receiver ---
        $receiver = Role::firstOrCreate(['name' => 'receiver']);
        $receiver->givePermissionTo([
            // Transactions: view incoming + approve
            'view_any_inventory_transaction',
            'view_inventory_transaction',
            'approve_inventory_transaction',
            // Transaction Approvals: view
            'view_any_transaction_approval',
            'view_transaction_approval',
            // Products: view (for reference)
            'view_any_product',
            'view_product',
            // Warehouses: view
            'view_any_warehouse',
            'view_warehouse',
        ]);

        // --- Compliance Officer ---
        $compliance = Role::firstOrCreate(['name' => 'compliance_officer']);
        $compliance->givePermissionTo([
            // Transactions: view waste/distribution + approve
            'view_any_inventory_transaction',
            'view_inventory_transaction',
            'approve_inventory_transaction',
            // Transaction Approvals: view
            'view_any_transaction_approval',
            'view_transaction_approval',
            // Distribution Records: view + verify/reject
            'view_any_distribution_record',
            'view_distribution_record',
            'verify_distribution_record',
            'reject_distribution_record',
            // Distribution Areas: view
            'view_any_distribution_area',
            'view_distribution_area',
        ]);
    }
}
