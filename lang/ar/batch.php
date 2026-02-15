<?php

return [
    'single' => 'دفعة',
    'plural' => 'الدفعات',
    'navigation_label' => 'الدفعات',
    'fields' => [
        'raw_material' => 'المادة الخام',
        'warehouse' => 'المستودع',
        'lot_number' => 'رقم التشغيلة (Lot)',
        'quantity' => 'الكمية الحالية',
        'original_quantity' => 'الكمية الأصلية',
        'received_date' => 'تاريخ الاستلام',
        'expiry_date' => 'تاريخ الانتهاء',
        'status' => 'الحالة',
        'notes' => 'ملاحظات',
        'days_until_expiry' => 'أيام حتى الانتهاء',
    ],
    'status' => [
        'active' => 'نشط',
        'expired' => 'منتهي الصلاحية',
        'quarantined' => 'محجور',
    ],
    'actions' => [
        'mark_as_expired' => 'تحديد كمنتهي الصلاحية',
        'quarantine' => 'حجر الدفعة',
    ],
    'sections' => [
        'general' => 'معلومات عامة',
        'dates' => 'التواريخ والحالة',
    ],
    'messages' => [
        'near_expiry' => 'ينتهي خلال :days يوم',
        'expired' => 'منتهي',
    ],
    'widgets' => [
        'expiring_soon' => 'تنتهي قريباً (7 أيام)',
        'expiring_soon_desc' => 'دفعات تحتاج إلى الانتباه',
        'already_expired' => 'منتهية الصلاحية',
        'already_expired_desc' => 'دفعات تم تحديدها كمنتهية',
        'low_quantity' => 'دفعات منخفضة الكمية',
        'low_quantity_desc' => 'دفعات نشطة أقل من 50 وحدة',
    ],
];
