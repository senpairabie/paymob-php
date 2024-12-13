<?php
include '../connect.php'; // تضمين ملف الاتصال بقاعدة البيانات

$api_key = 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBd05EUXdNaXdpYm1GdFpTSTZJakUzTXpBM09UY3hPRFF1T1RVME1qYzBJbjAuajJ3QVJnNUwyeTAxaHdLUXhUamwtZEJVTUhpM19YU0FrenBzY2NzdjlickFlSEZNZzY1U2NaMDlkM0hxOWF3UGs4QUVBWjNOSzhSQ1NZZFc3NnpfdVE='; // استبدل هذه بالقيمة الحقيقية لمفتاح الـ API الخاص بك

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://accept.paymobsolutions.com/api/auth/tokens");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("api_key" => $api_key)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$responseData = json_decode($response, true);
$auth_token = $responseData['token'];
?>