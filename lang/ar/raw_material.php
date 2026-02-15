<?php

return [
    'model_label' => 'مادة خام',
    'plural_model_label' => 'مواد خام',
    'navigation_group' => 'إدارة المخزون',

    'fields' => [
        'name' => 'الاسم',
        'unit' => 'الوحدة',
        'description' => 'الوصف',
        'min_stock_level' => 'الحد الأدنى للمخزون',
        'min_stock_level_helper' => 'تنبيه عند انخفاض المخزون عن هذا الحد.',
        'is_active' => 'الحالة',
        'is_active_helper' => 'لا يمكن استخدام المواد غير النشطة في دفعات جديدة.',
        'total_stock' => 'إجمالي المخزون',
        'expired_batches' => 'الدفعات منتهية الصلاحية',
        'created_at' => 'تاريخ الإنشاء',
    ],

    'sections' => [
        'basic_information' => 'المعلومات الأساسية',
        'inventory_settings' => 'إعدادات المخزون',
        'statistics' => 'الإحصائيات',
        'usage_info' => 'معلومات الاستخدام',
    ],

    'columns' => [
        'total_stock' => 'إجمالي المخزون',
        'used_in_products' => 'مستخدم في منتجات',
    ],

    'filters' => [
        'is_active' => 'الحالة',
    ],

    'messages' => [
        'delete_prevented' => 'لا يمكن حذف مادة خام مستخدمة في منتجات نشطة.',
    ],
];
