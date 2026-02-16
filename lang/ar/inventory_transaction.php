<?php

return [
    'single' => 'حركة المخزون',
    'plural' => 'حركات المخزون',
    'navigation_label' => 'حركات المخزون',
    'fields' => [
        'transaction_date' => 'تاريخ الحركة',
        'type' => 'النوع',
        'status' => 'الحالة',
        'from_warehouse' => 'من المستودع',
        'to_warehouse' => 'إلى المستودع',
        'product' => 'المنتج',
        'batch' => 'الدفعة',
        'quantity' => 'الكمية',
        'initiated_by' => 'بواسطة',
        'notes' => 'ملاحظات',
    ],
    'types' => [
        'transfer' => 'نقل (رئيسي ← جمعية)',
        'return' => 'إرجاع (جمعية ← رئيسي)',
        'waste' => 'إتلاف / هدر',
        'distribution' => 'توزيع (نهائي)',
        'adjustment' => 'تعديل (يدوي)',
    ],
    'sections' => [
        'transaction_details' => 'تفاصيل الحركة',
        'warehouse_information' => 'معلومات المستودع',
        'item_details' => 'تفاصيل الصنف',
        'movement_details' => 'تفاصيل النقل',
        'transaction_information' => 'معلومات الحركة',
    ],
    'actions' => [
        'approve' => 'اعتماد',
        'reject' => 'رفض',
    ],
    'placeholders' => [
        'select_batch' => 'اختر الدفعة',
        'select_product_first' => 'اختر المنتج أولاً',
        'na' => '-',
    ],
];
