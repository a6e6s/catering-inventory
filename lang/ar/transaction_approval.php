<?php

return [
    'singular' => 'موافقة المعاملة',
    'plural' => 'موافقات المعاملات',
    'status' => [
        'pending' => 'قيد الانتظار',
        'approved' => 'تمت الموافقة',
        'rejected' => 'مرفوض',
    ],
    'roles' => [
        'receiver' => 'المستلم',
        'warehouse_manager' => 'مدير المستودع',
        'compliance_officer' => 'مسؤول الامتثال',
    ],
    'fields' => [
        'transaction_id' => 'معرف المعاملة',
        'transaction' => 'المعاملة',
        'approver_role' => 'الدور المطلوب',
        'approver_id' => 'الموافق',
        'step' => 'خطوة الموافقة',
        'status' => 'الحالة',
        'comments' => 'تعليقات',
        'approved_at' => 'تاريخ القرار',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
    ],
    'sections' => [
        'approval_details' => 'تفاصيل الموافقة',
        'comments' => 'التعليقات والملاحظات',
    ],
    'actions' => [
        'approve' => 'موافقة',
        'reject' => 'رفض',
    ],
    'messages' => [
        'approved_success' => 'تمت الموافقة على المعاملة بنجاح.',
        'rejected_success' => 'تم رفض المعاملة بنجاح.',
    ],
    'placeholders' => [
        'comments' => 'قدم سبباً للرفض أو ملاحظات إضافية...',
    ],
];
