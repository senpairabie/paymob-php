<?php
include '../connect.php';

function isValidToken($token, $connect) {
    $stmt = $connect->prepare("SELECT COUNT(*) FROM token WHERE token = ?");
    $stmt->execute(array($token));
    $count = $stmt->fetchColumn();
    return $count > 0;
}

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';

if (!isValidToken($token, $connect)) {
    exit();
}

$userName = filterRequest("userName");
$email = filterRequest("email");
$language = filterRequest("language");

if (empty($email)) {
    $errorMsg = ($language == "ar") ? "خطأ: البريد الإلكتروني مطلوب." : "Error: Email is required.";
    echo json_encode(array("status" => "fail", "message" => $errorMsg));
    exit();
}

try {
    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(array($email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(array(
            "status" => "success",
            "message" => ($language == "ar") ? "تم تسجيل الدخول بنجاح." : "Logged in successfully.",
            "data" => $user
        ));
    } else {
        $token = generateRandomToken(100);
        $stmt = $connect->prepare("INSERT INTO users (fullName, email, token) VALUES (?, ?, ?)");
        $stmt->execute(array($userName, $email, $token));
        $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(array($email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode(array(
            "status" => "success",
            "message" => ($language == "ar") ? "تم تسجيل الدخول بنجاح." : "Logged in successfully.",
            "data" => $user
        ));
    }
} catch (PDOException $e) {
    $errorMsg = ($language == "ar") ? "حدث خطأ أثناء تسجيل الدخول." : "Error occurred while logging in. Error details: " . $e->getMessage();
    echo json_encode(array("status" => "fail", "message" => $errorMsg));
}
?>