<?php

return [
    'single' => 'مخزون المنتج',
    'plural' => 'مخزونات المنتجات',
    'navigation_label' => 'مخزونات المنتجات',
    'fields' => [
        'product' => 'المنتج',
        'warehouse' => 'المستودع',
        'batch' => 'الدفعة',
        'quantity' => 'الكمية',
        'last_updated' => 'آخر تحديث',
        'status' => 'الحالة',
    ],
    'sections' => [
        'stock_information' => 'معلومات المخزون',
        'quantity_and_status' => 'الكمية والحالة',
    ],
    'placeholders' => [
        'no_specific_batch' => 'لا توجد دفعة محددة',
        'na' => 'غير متاح',
    ],
    'filters' => [
        'low_stock' => 'المخزون المنخفض فقط',
    ],
    'units_suffix' => 'وحدات',
    'status_options' => [
        'in_stock' => 'متوفر',
        'low_stock' => 'منخفض',
        'out_of_stock' => 'نفد المخزون',
    ],
];
