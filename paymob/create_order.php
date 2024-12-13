<?php
// create_order.php

include 'init.php'; // تضمين ملف تهيئة الاتصال

if (!isset($auth_token)) {
    die('Auth token is not set.');
}

// إعداد بيانات الطلب
$order_data = array(
    "auth_token" => $auth_token,
    "delivery_needed" => false,
    "amount_cents" => 10000, // القيمة بالمليم
    "currency" => "EGP",
    "items" => array()
);

// تنفيذ طلب CURL لإنشاء الطلب
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://accept.paymobsolutions.com/api/ecommerce/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit; // الخروج في حالة حدوث خطأ
}
curl_close($ch);

// تحليل الاستجابة للحصول على order_id
$orderResponse = json_decode($response, true);
if (isset($orderResponse['id'])) {
    $order_id = $orderResponse['id'];

    // إعادة توجيه المستخدم إلى صفحة الدفع
    header("Location: get_payment_link.php?order_id=" . $order_id);
    exit(); // تأكد من إنهاء السكربت بعد إعادة التوجيه
} else {
    echo "Error creating order: " . print_r($orderResponse, true);
}
?>