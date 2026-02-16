<?php

return [
    'single' => 'Inventory Transaction',
    'plural' => 'Inventory Transactions',
    'navigation_label' => 'Inventory Transactions',
    'fields' => [
        'transaction_date' => 'Transaction Date',
        'type' => 'Type',
        'status' => 'Status',
        'from_warehouse' => 'From Warehouse',
        'to_warehouse' => 'To Warehouse',
        'product' => 'Product',
        'batch' => 'Batch',
        'quantity' => 'Quantity',
        'initiated_by' => 'Initiated By',
        'notes' => 'Notes',
    ],
    'types' => [
        'transfer' => 'Transfer (Main → Association)',
        'return' => 'Return (Association → Main)',
        'waste' => 'Waste / Disposal',
        'distribution' => 'Distribution (Final)',
        'adjustment' => 'Adjustment (Manual)',
    ],
    'sections' => [
        'transaction_details' => 'Transaction Details',
        'warehouse_information' => 'Warehouse Information',
        'item_details' => 'Item Details',
        'movement_details' => 'Movement Details',
        'transaction_information' => 'Transaction Information',
    ],
    'actions' => [
        'approve' => 'Approve',
        'reject' => 'Reject',
    ],
    'placeholders' => [
        'select_batch' => 'Select Batch',
        'select_product_first' => 'Select Product First',
        'na' => '-',
    ],
];
