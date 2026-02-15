<?php

return [
    'model_label' => 'Warehouse',
    'plural_model_label' => 'Warehouses',
    'navigation_group' => 'Inventory Management',
    'navigation_badge' => 'Total Warehouses',
    
    'types' => [
        'main' => 'Main Warehouse',
        'association' => 'Association',
        'distribution_point' => 'Distribution Point',
    ],

    'sections' => [
        'basic_information' => 'Basic Information',
        'basic_information_description' => 'Enter the core details of the warehouse.',
        'operational_settings' => 'Operational Settings',
        'operational_settings_description' => 'Manage warehouse capacity and status.',
        'warehouse_details' => 'Warehouse Details',
        'statistics' => 'Statistics',
        'system_info' => 'System Info',
    ],

    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'capacity' => 'Storage Capacity (Units)',
        'capacity_placeholder' => 'Leave empty for unlimited',
        'capacity_helper' => 'Maximum total units this warehouse can hold.',
        'is_active' => 'Active Status',
        'is_active_helper' => 'Inactive warehouses cannot receive new stock.',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At',
    ],

    'columns' => [
        'users_count' => 'Users',
        'batches_count' => 'Batches',
        'stock_count' => 'Stock',
    ],

    'actions' => [
        'toggle_active' => 'Toggle Active Status',
    ],

    'filters' => [
        'type' => 'Type',
        'is_active' => 'Active Status',
    ],

    'widgets' => [
        'total_warehouses' => 'Total Warehouses',
        'total_warehouses_desc' => 'All registered facilities',
        'active_status' => 'Active Status',
        'active_status_desc' => ':active Active / :inactive Inactive',
        'capacity_utilization' => 'Capacity Utilization',
        'capacity_utilization_desc' => 'Average across all facilities',
    ],

    'notifications' => [
        'capacity_warning_title' => 'Capacity Warning',
        'capacity_warning_body' => 'Warehouse ":name" is at :percentage% capacity.',
    ],

    'messages' => [
        'main_warehouse_delete_error' => 'The Main Warehouse cannot be deleted.',
    ],
];
