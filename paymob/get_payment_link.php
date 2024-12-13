<?php
// get_payment_link.php

include 'init.php'; // تضمين ملف تهيئة الاتصال

// تحقق من وجود order_id في عنوان URL
if (!isset($_GET['order_id'])) {
    die("لم يتم إنشاء الطلب بنجاح.");
}

$order_id = $_GET['order_id']; // استقبل order_id من عنوان URL

// إعداد البيانات المطلوبة للحصول على مفتاح الدفع
$payment_key_request = array(
    "auth_token" => $auth_token,
    "amount_cents" => 10000, // القيمة بالمليم
    "expiration" => 3600,
    "order_id" => $order_id,
    "billing_data" => array(
        "apartment" => "803",
        "email" => "example@example.com",
        "floor" => "42",
        "first_name" => "John",
        "street" => "Some Street",
        "building" => "8028",
        "phone_number" => "+201234567890",
        "shipping_method" => "PKG",
        "postal_code" => "01898",
        "city" => "Cairo",
        "country" => "EG",
        "last_name" => "Doe",
        "state" => "Cairo"
    ),
    "currency" => "EGP",
    "integration_id" => "4869813", // استبدل بهذا ID التكامل الصحيح
    "lock_order_when_paid" => true
);

// تنفيذ طلب CURL للحصول على مفتاح الدفع
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://accept.paymobsolutions.com/api/acceptance/payment_keys");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_key_request));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit; // الخروج في حالة حدوث خطأ
}
curl_close($ch);

// تحليل الاستجابة للحصول على مفتاح الدفع
$paymentKeyResponse = json_decode($response, true);
if (isset($paymentKeyResponse['token'])) {
    $payment_key = $paymentKeyResponse['token'];

    // عرض رابط الدفع
  echo "رابط الدفع: <a href='https://accept.paymobsolutions.com/api/acceptance/iframes/879277?payment_token=" . $payment_key . "'>اضغط هنا للدفع</a>";
} else {
    echo "حدث خطأ أثناء الحصول على مفتاح الدفع: " . $response;
}
?>