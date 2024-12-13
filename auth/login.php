<?php
include '../connect.php';
$email = filterRequest("email"); 
$password = $_POST['password'];
$language = filterRequest("language");
$statement = $connect->prepare("SELECT `userId`, `fullName`, `email`, `phone`,`token`, `school`, `grade`, `liveSate`, `liveCity` FROM `users` WHERE email = ?");
$statement->execute(array($email));
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();
if ($count > 0 && password_verify($password, $data['password'])) {
    if($data['verification']==2){
        if($language == "ar"){
            echo json_encode(array("status" => "fail","message"=> "خطأ: لم يتم التحقق من حسابك بعد."));
        }else{
            echo json_encode(array("status" => "fail","message"=> "Error: Your account is not verified yet."));
            }
    }else{
        if($language == "ar"){
            echo json_encode(array("status" => "success","message"=> "تم تسجيل الدخول بنجاح."));
        }else{
            echo json_encode(array("status" => "success","message"=> "Login successfully." , "data" => $data));
            }
    }    
} else {
    if($language == "ar"){
        echo json_encode(array("status" => "fail","message"=> "خطأ: البريد الإلكتروني أو كلمة المرور غير صحيحة."));
    }else{
        echo json_encode(array("status" => "fail","message"=> "Error: Email or password is incorrect."));
        }
}
?>



<?php
include '../connect.php';
$email = filterRequest("email"); 
$password = $_POST['password'];
$language = filterRequest("language");
$statement = $connect->prepare("SELECT * FROM `users` WHERE  email = ?");
$statement->execute(array($email));
$data = $statement->fetch(PDO::FETCH_ASSOC);
$count = $statement->rowCount();
if ($count > 0 && password_verify($password, $data['password'])) {
    if($data['verification']==2){
        if($language == "ar"){
            echo json_encode(array("status" => "fail","message"=> "خطأ: لم يتم التحقق من حسابك بعد."));
        }else{
            echo json_encode(array("status" => "fail","message"=> "Error: Your account is not verified yet."));
            }
    }else{
        if($language == "ar"){
            echo json_encode(array("status" => "success","message"=> "تم تسجيل الدخول بنجاح."));
        }else{
            $statement = $connect->prepare("SELECT `userId`, `fullName`, `email`, `phone`,`token`, `school`, `grade`, `liveSate`, `liveCity` FROM `users` WHERE  email = ?");
            $statement->execute(array($email));
            $dataInfo = $statement->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("status" => "success","message"=> "Login successfully." , "data" => $dataInfo));
            }
    }    
} else {
    if($language == "ar"){
        echo json_encode(array("status" => "fail","message"=> "خطأ: البريد الإلكتروني أو كلمة المرور غير صحيحة."));
    }else{
        echo json_encode(array("status" => "fail","message"=> "Error: Email or password is incorrect."));
        }
}
?>