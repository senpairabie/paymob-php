<?php

define('MB', 1048576);

function filterRequest($requestName)
{
    return  htmlspecialchars(strip_tags($_POST[$requestName]));
}



function filterRequest2($requestName)
{
    return  htmlspecialchars(strip_tags($_GET[$requestName]));
}

function uplodeImageForCourse($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../../uploads/imageCourse/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}


function uplodeImage($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../../uploads/imageProfile/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}

  function uplodeImageUser($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../../uploads/imageProfile/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
  }

function uplodeFileMessage($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../uploads/messages/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}

function deleteFile($path, $imageName)
{
    if (file_exists($path . "/" . $imageName)) {
        unlink($path . "/" . $imageName);
    }
}


//for security
function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {

        if ($_SERVER['PHP_AUTH_USER'] != "fares" ||  $_SERVER['PHP_AUTH_PW'] != "fares102030") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}



function getAllData($table, $where = null, $values = null, $json = true)
{
    global $connect;
    $data = array();
    if ($where == null) {
        $stmt = $connect->prepare("select * from $table ");
    } else {
        $stmt = $connect->prepare("select * from $table where $where ");
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo  json_encode(array("status" => "success", "data" => $data));
        } else {
            echo  json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return (array("status" => "success", "data" => $data));
        } else {
            return (array("status" => "failure"));
        }
    }
}  


function updateData($table, $data, $where, $json = true)
{
    global $connect;
    $cols = array();
    $vals = array();
    
    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = " `$key` = ? ";
    }

    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where ";
    $stmt = $connect->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}





function getAllData2($table, $where = null, $values = null, $json = true)
{
    global $connect;
    $data = array();
    if ($where == null) {
        $stmt = $connect->prepare("select * from $table ");
    } else {
        $stmt = $connect->prepare("select * from $table where $where ");
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo  json_encode(array("data" => $data));
        } else {
            echo  json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return (array("data" => $data));
        } else {
            return (array("status" => "failure"));
        }
    }
}  








function uplodeImage101($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../upload/roomImage/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}


function uplodeImage102($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg","svg" );
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../upload/roomBachgroundImage/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}







function uploadfile($audioRequest){
    global $messageError;
    $audioName = $_FILES[$audioRequest]['name'];
    $audioTmp  = $_FILES[$audioRequest]['tmp_name'];
    $audioSize = $_FILES[$audioRequest]['size'];
    $allowExt  = array("mp3", "wav", "ogg", "m4a","opus");
    $strToArray = explode(".", $audioName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($audioName) && !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    if ($audioSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($audioTmp, "../upload/audiochats/" . $audioName);
        return $audioName;
    } else {
        return "fail";
    }
}



function uploadVideoFileForCourse($videoRequest){
    global $messageError;
    $videoName = rand(100, 10000) . $_FILES[$videoRequest]['name'];
    $videoTmp  = $_FILES[$videoRequest]['tmp_name'];
    $videoSize = $_FILES[$videoRequest]['size'];
    $allowExt  = array("mp4", "avi", "mov", "mkv", "wmv"); 
    $strToArray = explode(".", $videoName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);
    if (!empty($videoName) && !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    if ($videoSize > 50 * MB) { 
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($videoTmp, "../../uploads/videoForCourse/" . $videoName);
        return $videoName;
    } else {
        return "fail";
    }
}


function uplodeImage5($imageRequest){
    global $messageError;
    $imageName = rand(100, 10000) . $_FILES[$imageRequest]['name'];
    $imageTmp  = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt  = array("jpg", "png", "gif", "pdf", "jpeg");
    $strToArray = explode(".", $imageName);
    $ext       = end($strToArray);
    $convert   = strtolower($ext);

    if (!empty($imageName)  &&  !in_array($ext, $allowExt)) {
        $messageError[] = "Extension";
    }
    //$imageSize   ====> byte
    if ($imageSize > 2 * MB) {
        $messageError[] = "Size";
    }
    if (empty($messageError)) {
        move_uploaded_file($imageTmp, "../upload/image/" . $imageName);
        return $imageName;
    } else {
        return "fail";
    }
}
function generateRandomToken($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%^&*()_+=-/?><,.>
  <{}[]}~'; $token='' ; $characterCount=strlen($characters); for ($i=0; $i < $length; $i++) { $token
    .=$characters[rand(0, $characterCount - 1)]; } return $token; } ?>