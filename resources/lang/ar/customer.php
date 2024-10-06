<?php

return [
    'name' => [
        'required' => 'الاسم مطلوب.',
        'string' => 'يجب أن يكون الاسم نصًا صحيحًا.',
    ],
    'email' => [
        'required' => 'البريد الإلكتروني مطلوب.',
        'email' => 'يرجى تقديم عنوان بريد إلكتروني صالح.',
        'unique' => 'هذا البريد الإلكتروني مسجل بالفعل.',
    ],
    'password' => [
        'required' => 'كلمة المرور مطلوبه.',
        'min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.',
        'confirmed' => 'تأكيد كلمة المرور لا يتطابق.',
    ],
    'phone_number' => [
        'required' => 'رقم الهاتف مطلوب.',
        'size' => 'يجب أن يتكون رقم الهاتف من 11 رقمًا بالضبط.',
        'unique' => 'رقم الهاتف هذا مسجل بالفعل.',
    ],
    'profile_retrieved_successfully' => 'تم استرجاع الملف الشخصي بنجاح.',
    'profile_retrieval_failed' => 'فشل في استرجاع الملف الشخصي: :error',
    'profile_updated_successfully' => 'تم تحديث الملف الشخصي بنجاح.',
    'profile_update_failed' => 'فشل في تحديث الملف الشخصي: :error',
    'account_deleted_successfully' => 'تم حذف حساب العميل بنجاح.',
    'account_deletion_failed' => 'فشل في حذف الحساب: :error',
    'customer_not_found' => 'لم يتم العثور على العميل.',
    'customer_retrieved_successfully' => 'تم استرجاع العميل بنجاح.',
    'customer_retrieval_failed' => 'فشل في استرجاع العميل: :error',
    'validation_errors' => 'حدثت أخطاء في التحقق.',
];
