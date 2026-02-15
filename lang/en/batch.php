<?php

return [
    'single' => 'Batch',
    'plural' => 'Batches',
    'navigation_label' => 'Batches',
    'fields' => [
        'raw_material' => 'Raw Material',
        'warehouse' => 'Warehouse',
        'lot_number' => 'Lot Number',
        'quantity' => 'Quantity',
        'original_quantity' => 'Original Quantity',
        'received_date' => 'Received Date',
        'expiry_date' => 'Expiry Date',
        'status' => 'Status',
        'notes' => 'Notes',
        'days_until_expiry' => 'Days until Expiry',
    ],
    'status' => [
        'active' => 'Active',
        'expired' => 'Expired',
        'quarantined' => 'Quarantined',
    ],
    'actions' => [
        'mark_as_expired' => 'Mark as Expired',
        'quarantine' => 'Quarantine',
    ],
    'sections' => [
        'general' => 'General Information',
        'dates' => 'Dates & Status',
    ],
    'messages' => [
        'near_expiry' => 'Expires in :days days',
        'expired' => 'Expired',
    ],
    'widgets' => [
        'expiring_soon' => 'Expiring Soon (7 days)',
        'expiring_soon_desc' => 'Batches needing attention',
        'already_expired' => 'Already Expired',
        'already_expired_desc' => 'Batches marked as expired',
        'low_quantity' => 'Low Quantity Batches',
        'low_quantity_desc' => 'Active batches below 50 units',
    ],
];
