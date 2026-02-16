<?php

return [
    'single' => 'Product Stock',
    'plural' => 'Product Stocks',
    'navigation_label' => 'Product Stocks',
    'fields' => [
        'product' => 'Product',
        'warehouse' => 'Warehouse',
        'batch' => 'Batch',
        'quantity' => 'Quantity',
        'last_updated' => 'Last Updated',
        'status' => 'Status',
    ],
    'sections' => [
        'stock_information' => 'Stock Information',
        'quantity_and_status' => 'Quantity & Status',
    ],
    'placeholders' => [
        'no_specific_batch' => 'No specific batch',
        'na' => 'N/A',
    ],
    'filters' => [
        'low_stock' => 'Low Stock Only',
    ],
    'units_suffix' => 'Units',
    'status_options' => [
        'in_stock' => 'In Stock',
        'low_stock' => 'Low Stock',
        'out_of_stock' => 'Out of Stock',
    ],
];
