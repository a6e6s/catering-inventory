<?php

return [
    'singular' => 'سجل التوزيع',
    'plural' => 'سجلات التوزيع',
    'status' => [
        'pending' => 'قيد الانتظار',
        'verified' => 'تم التحقق',
        'rejected' => 'مرفوض',
    ],
    'fields' => [
        'id' => 'المعرف',
        'transaction_id' => 'معرف المعاملة',
        'transaction' => 'المعاملة',
        'distribution_area' => 'منطقة التوزيع',
        'beneficiaries_served' => 'المستفيدون الذين تم خدمتهم',
        'beneficiaries_helper' => 'العدد المقدر أو الفعلي للأشخاص الذين تم خدمتهم.',
        'photos' => 'دليل الصور (حد أقصى 5)',
        'photo_gallery' => 'معرض الصور',
        'notes' => 'ملاحظات / مشاهدات',
        'verified_by' => 'تم التحقق بواسطة',
        'verified_at' => 'تاريخ التحقق',
        'rejection_reason' => 'سبب الرفض',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
    ],
    'sections' => [
        'distribution_details' => 'تفاصيل التوزيع',
        'evidence' => 'الأدلة',
        'verification' => 'التحقق',
        'record_information' => 'معلومات السجل',
        'verification_details' => 'تفاصيل التحقق',
    ],
    'actions' => [
        'verify' => 'تحقق',
        'reject' => 'رفض',
    ],
    'placeholders' => [
        'no_photos' => 'لم يتم تحميل أي صور',
    ],
];
