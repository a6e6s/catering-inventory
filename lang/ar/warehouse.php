<?php

return [
    'model_label' => 'المستودع',
    'plural_model_label' => 'المستودعات',
    'navigation_group' => 'إدارة المخزون',
    'navigation_badge' => 'إجمالي المستودعات',

    'types' => [
        'main' => 'المستودع الرئيسي',
        'association' => 'جمعية',
        'distribution_point' => 'نقطة توزيع',
    ],

    'sections' => [
        'basic_information' => 'المعلومات الأساسية',
        'basic_information_description' => 'أدخل التفاصيل الأساسية للمستودع.',
        'operational_settings' => 'الإعدادات التشغيلية',
        'operational_settings_description' => 'إدارة سعة وحالة المستودع.',
        'warehouse_details' => 'تفاصيل المستودع',
        'statistics' => 'الإحصائيات',
        'system_info' => 'معلومات النظام',
    ],

    'fields' => [
        'name' => 'الاسم',
        'type' => 'النوع',
        'location' => 'الموقع',
        'capacity' => 'السعة التخزينية (وحدات)',
        'capacity_placeholder' => 'اتركه فارغاً لسعة غير محدودة',
        'capacity_helper' => 'الحد الأقصى للوحدات التي يمكن لهذا المستودع استيعابها.',
        'is_active' => 'حالة النشاط',
        'is_active_helper' => 'المستودعات غير النشطة لا يمكنها استقبال مخزون جديد.',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'deleted_at' => 'تاريخ الحذف',
    ],

    'columns' => [
        'users_count' => 'المستخدمين',
        'batches_count' => 'الدفعات',
        'stock_count' => 'المخزون',
    ],

    'actions' => [
        'toggle_active' => 'تبديل حالة النشاط',
    ],

    'filters' => [
        'type' => 'النوع',
        'is_active' => 'حالة النشاط',
    ],

    'widgets' => [
        'total_warehouses' => 'إجمالي المستودعات',
        'total_warehouses_desc' => 'جميع المرافق المسجلة',
        'active_status' => 'حالة النشاط',
        'active_status_desc' => ':active نشط / :inactive غير نشط',
        'capacity_utilization' => 'استغلال السعة',
        'capacity_utilization_desc' => 'المتوسط عبر جميع المرافق',
    ],

    'notifications' => [
        'capacity_warning_title' => 'تحذير السعة',
        'capacity_warning_body' => 'المستودع ":name" وصل إلى :percentage% من السعة.',
    ],

    'messages' => [
        'main_warehouse_delete_error' => 'لا يمكن حذف المستودع الرئيسي.',
    ],
];
