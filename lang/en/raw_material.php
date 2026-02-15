<?php

return [
    'model_label' => 'Raw Material',
    'plural_model_label' => 'Raw Materials',
    'navigation_group' => 'Inventory Management',

    'fields' => [
        'name' => 'Name',
        'unit' => 'Unit',
        'description' => 'Description',
        'min_stock_level' => 'Minimum Stock Level',
        'min_stock_level_helper' => 'Alert when stock falls below this amount.',
        'is_active' => 'Active Status',
        'is_active_helper' => 'Inactive materials cannot be used in new batches.',
        'total_stock' => 'Total Stock',
        'expired_batches' => 'Expired Batches',
        'created_at' => 'Created At',
    ],

    'sections' => [
        'basic_information' => 'Basic Information',
        'inventory_settings' => 'Inventory Settings',
        'statistics' => 'Statistics',
        'usage_info' => 'Usage Information',
    ],

    'columns' => [
        'total_stock' => 'Total Stock',
        'used_in_products' => 'Used In Products',
    ],

    'filters' => [
        'is_active' => 'Active Status',
    ],

    'messages' => [
        'delete_prevented' => 'Cannot delete raw material used in active products.',
    ],
];
