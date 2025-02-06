<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/******************************************************************
 *	함수명: request(a, b)
 *	기능: a의 파라미터에 대해서 빈값 및 배열여부 확인 후, 값이 없으면 b를 반환
 ******************************************************************/
function request($getVal, $rtnVal) {
    
    if (isset($getVal) || !empty($getVal)) {
        return addslashes($getVal);
    } else {
        return addslashes(trim($rtnVal));
    }
}

function getPost($obj, $swapVal){
    
    if (isset($_POST[$obj]) && !empty($_POST[$obj])) {        
        if(is_array($_POST[$obj])){
            return($_POST[$obj]);
        } else {
            return addslashes(trim($_POST[$obj]));
        }
    } else {        
        return addslashes(trim($swapVal));
    }
}

function getRequest($obj, $swapVal){
    if (isset($_REQUEST[$obj]) || !empty($_REQUEST[$obj])) {
        return addslashes(trim($_REQUEST[$obj]));
    } else {
        return addslashes(trim($swapVal));
    }
}

function urlRequest($obj, $swapVal){
    if (isset($_REQUEST[$obj]) || !empty($_REQUEST[$obj])) {
        return addslashes(urldecode(trim($_REQUEST[$obj])));
    } else {
        return addslashes(trim($swapVal));
    }
}

function getExist($obj, $swapVal){
    if (!empty(trim($obj))) {
        return addslashes(trim($obj));
    } else {
        return addslashes(trim($swapVal));
    }
}

/**************************************
 * 이미지 사이즈 조정하여 저장하기
 * makeThumbnail($sourcefile, $savePath, $imgWidth, $imgHeight, $quality)
 * $rawFile = 임시파일 ($_file[인수명][tmp_name])
 * $savePath = 최종 저장 될 파일의 경로+파일명
 * $imgWidth = 리사이즈 하고자 하는 가로사이즈
 * $imgHeight = 리사이즈 하고자 하는 세로사이즈
 * $quality = 파일을 저장하고자 하는 품질의 수치
 **************************************/

function makeThumbnail($rawFile, $savePath, $imgWidth, $imgHeight, $quality) {
    // Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
    // and places it at endfile (path/to/thumb.jpg).
    // Load image and get image size.
    
    $img = imagecreatefromjpeg($rawFile);
    $width = imagesx($img);
    $height = imagesy($img);

    //가로형 이미지
    if ($width > $height) {
        $makeWidth = $imgWidth;
        $imgRate = $width/$imgWidth;
        $makeHeight = floor($height/$imgRate);
    //세로형 이미지
    } else {    
        $makeHeight = $imgHeight;
        $imgRate = $height/$imgHeight;
        $makeWidth = floor($width/$imgRate);
    }
    // Create a new temporary image.
    $tmpimg = imagecreatetruecolor($makeWidth, $makeHeight);
    
    // Copy and resize old image into new image.
    imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $makeWidth, $makeHeight, $width, $height);
    // Save thumbnail into a file.
    imagejpeg($tmpimg, $_SERVER["DOCUMENT_ROOT"].$savePath, $quality);
    
    // release the memory
    imagedestroy($tmpimg);
    imagedestroy($img);
    
    return($savePath);
}

function chkStoreFile($rawFile, $type="", $size=10, $extType="", $imgLimitWidth=5000, $imgLimitHeight=5000){
    switch($type){
        case "img":
            $allowExt = ["jpg", "png", "gif"];
            break;
        case "pdf":
            $allowExt = ["pdf"];
            break;
        case "excel":
            $allowExt = ["xls", "xlsx"];
            break;
        default:
            $allowExt = [];
    }
    
    $result = "ok";
    $rawNm = $rawFile["tmp_name"];
    $fileNm = $rawFile["name"];
    $fileSize = number_format($rawFile["size"]/1024/1024, 2);
    $fileType = $rawFile["type"];
    $fileExt = pathinfo($fileNm, PATHINFO_EXTENSION);    
    
    if(count($allowExt)>0){
        $result = $type."의 파일만 업로드가 가능합니다.";
        foreach($allowExt as $row){
            if($row==$fileExt){
                $result = "ok";
            }
        }
    }
    
    if($result == "ok" && $type=="img"){
        $imgSize = getimagesize($rawNm);
        
        if($imgSize[0] > $imgLimitWidth || $imgSize[1] > $imgLimitHeight){
            $result = $imgLimitWidth."x".$imgLimitHeight." 이하의 이미지 파일만 업로드가 가능합니다.";
        } else {
            $result = "ok";
        }
    }
    
    if($result == "ok"){
        $result = $fileSize > $size ? "파일사이즈는 ".$size."Mb 이하이어야 합니다." : "ok";
    }
    
    if($result == "ok"){
        if($extType != ""){
            if($fileExt != $extType){
                $result = $extType."타입의 파일만 업로드가 가능합니다.";
            }
        } else {
            $result = "ok";
        }
    }
    
    return($result);
}

/**************************************
 *                  파일저장
 **************************************/
function storeFile($rawFile, $uploadPath, $customFileNm=Null) {
    
    $saveFileNm = isset($customFileNm) ? $customFileNm.'.'.pathinfo($rawFile["name"], PATHINFO_EXTENSION) : $rawFile["name"];
    $storeNm = $_SERVER["DOCUMENT_ROOT"].$uploadPath.$saveFileNm;
    
    if  ( move_uploaded_file($rawFile["tmp_name"], $storeNm ) != 1 ) {
        return "STORE_ERROR";
        exit;
    } else {
        return $saveFileNm;
    }
}

/**************************************
 *                  파일삭제
 **************************************/
function unlinkFile($fileSavePath) {
    if ( is_file($_SERVER["DOCUMENT_ROOT"].$fileSavePath) ) {
        unlink($_SERVER["DOCUMENT_ROOT"].$fileSavePath);
    }
}

function getDeviceInfo(){
    
    $mobileDevice = ["iPhone", "iPad", "iPod", "IEMobile", "lgtelecom", "PPC", "BlackBerry", "Android", "SM-", "SCH-", "SPH-", "LG-", "CANU", "IM-" ,"EV-","Nokia"];
    
    $userDevice = $_SERVER['HTTP_USER_AGENT'];
    $deviceModel = "PC";
    $deviceType = "PC";
    
    foreach($mobileDevice as $row){
        if (strrpos($userDevice, $row) > -1 ) {
            $deviceModel = $row;
            $deviceType = "MOBILE";
        } else{
            if(strrpos($userDevice, "Mobile") > -1){
                $deviceType = "MOBILE";
            }
        }
    }
    return["device_info"=>$userDevice, "device_model"=>$deviceModel, "device_type"=>$deviceType];
}


function getRealClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'Unknown';
    }
    return $ipaddress;
}


function get_sms_token(){
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sms.gabia.com/oauth/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic ".base64_encode("dwave:6dec698ecef5958399417d7230331444")
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
        $result = json_decode($response);
        $accessToken = "Basic ".base64_encode('dwave:'.$result->access_token);
        return($accessToken);
    }
    
}

function get_sms_remain(){
    //         "Authorization: Basic ".base64_encode('dwave:6dec698ecef5958399417d7230331444')
    
    $accessToken = get_sms_token();
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sms.gabia.com/api/user/info",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$accessToken
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response);
//         print_r($result);
        return($result->data->sms_count);
    }
    
}


function ban_ip(){
    
    $ban_list = ["218.234.149.5", "23.27.202.161"];
    $connect_ip = getRealClientIp();
    
    if(in_array($connect_ip, $ban_list)){
        $msgStr = '<script>';
        $msgStr.= 'alert("You are blocked");';
        $msgStr.= 'location.replace("https://google.com");';
        $msgStr.= '</script>';
        
        echo $msgStr;
    }
    
    
}

?>