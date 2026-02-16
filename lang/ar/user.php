<?php

return [
    'singular' => 'مستخدم',
    'plural' => 'المستخدمين',
    'roles' => [
        'admin' => 'مدير النظام',
        'warehouse_manager' => 'مدير المستودع',
        'receiver' => 'المستلم',
        'compliance_officer' => 'مسؤول الامتثال',
    ],
    'fields' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'warehouse' => 'المستودع',
        'phone' => 'رقم الهاتف',
        'role' => 'الدور',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'email_verified_at' => 'تاريخ تأكيد البريد',
    ],
    'sections' => [
        'user_details' => 'تفاصيل المستخدم',
        'security' => 'الأمان',
    ],
    'actions' => [
        'create' => 'إنشاء مستخدم',
    ],
];
