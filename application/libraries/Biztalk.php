<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biztalk {
    
    
    
    public function echo_test($parm="Welcome"){
        
        $rtn_result = 'thank you ==> '.$parm;
        
        return $rtn_result;
        
    }
    
    public function get_message(){
        $arr_template = [
            ["key"=>"dwave_test", "name"=>"알림톡_테스트", "msg"=>"안녕하세요. 닥터웨이브입니다.\n알림톡 수신 확인을 위한 테스트 메세지 입니다.\n감사합니다.", "btn_type"=>"WL", "btn_name"=>"닥터웨이브 바로가기", "btn_link"=>"https://dr-wave.co.kr"],
            ["key"=>"dwave_test_1", "name"=>"업무등록", "msg"=>"#{홍길동}님의 task가 정상적으로 등록되었습니다.\ntask 확인하기 #{https://dr-wave.co.kr}", "btn_type"=>"WL", "btn_name"=>"Dr-wave 바로가기", "btn_link"=>"http://dr-wave.co.kr"]
        ];
        
        $template_key = getPost("template_key", "");
        
        foreach($arr_template as $row){
            if($row["key"] == $template_key){
                echo json_encode(["msg"=>$row["msg"], "btn_type"=>$row["btn_type"], "btn_name"=>$row["btn_name"], "btn_link"=>$row["btn_link"]]);
                exit;
            }
        }
        
    }
    
    public function get_access_token(){
        
        $restUrl = "https://api.bizppurio.com/v1/token";
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $restUrl,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json; charset=utf-8",
                "Authorization: Basic ".base64_encode("dwave2014:Dnpdlqm#0901!")
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //             CURLOPT_POSTFIELDS => json_encode($data),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:<br/>" . $err;
            //             echo json_encode(["result"=>"fail", "msg"=>$err]);
        } else {
            //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
            $token = json_decode($response);
            return($token -> accesstoken);
        }
        
        exit;
    }
    
    public function send_kakao(){
        
        $access_token = $this->get_access_token();
        $secPassKey = "0901";
        $secKey = getPost("talk_seckey", "");
        $msg_type = getPost("msg_type", "at");
        $from_phone = "025402256";
        $to_phone = getPost("to_phone", "");
        $talk_msg = getPost("talk_msg", "");
        $ref_key = $msg_type."_".time();
        
        $template_code = getPost("template_code", "");
        $btn_type = $_POST["btn_type"];
        $btn_name = $_POST["btn_name"];
        $btn_link = $_POST["btn_link"];
        
        $img_url = getPost("img_url", "");
        $img_href = getPost("img_href", "");
        //         $rawFile = $_FILES["file_img"];
        //         $uploadPath = "/public/data/biz/";
        
        $img_data = [];
        $btn_data = [];
        
        if(!empty($img_url)){
            if($img_href!=""){
                $img_data = [
                    "img_url"=>$img_url, "img_link"=>$img_href
                ];
            } else {
                $img_data = ["img_url"=>$img_url];
            }
        }
        
        //         if(!empty($rawFile["tmp_name"])){
        //             $chkFile = chkStoreFile($rawFile, "img", 0.5, "", 800, 400);
        //             if($chkFile != "ok"){
        //                 echo json_encode(array('result' => "file_check_error", "msg"=>$chkFile));
        //                 exit;
        //             } else {
        //                 $storeResult = storeFile($rawFile, $uploadPath, substr(time(), -8));
        //                 $img_url = "https://dr-wave.co.kr".$uploadPath.$storeResult;
        //                 if($img_href!=""){
        //                     $img_data = [
        //                         "img_url"=>$img_url, "img_link"=>$img_href
        //                     ];
        //                 } else {
        //                     $img_data = ["img_url"=>$img_url];
        //                 }
        //             }
        //         }
        
        if(count($btn_type)>0){
            for($i=0; $i<count($btn_type); $i++){
                $tmpArr = ["type"=>$btn_type[$i], "name"=>$btn_name[$i], "url_pc"=>$btn_link[$i], "url_mobile"=>$btn_link[$i]];
                array_push($btn_data, $tmpArr);
            }
        }
        
        if($msg_type=="at"){
            if($btn_type!=""){
                $content_data = [
                    "at"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "templatecode"=>$template_code,
                        "message"=>$talk_msg,
                        "button"=>$btn_data
                    ]
                ];
            } else {
                $content_data = [
                    "at"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "templatecode"=>$template_code,
                        "message"=>$talk_msg
                    ]
                ];
            }
        } elseif($msg_type=="ft"){
            
            if(!empty($img_url) && !empty($btn_type)){
                $content_data = [
                    "ft"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "message"=>$talk_msg, "adflag"=>"Y",
                        "button"=>$btn_data,
                        "image"=>$img_data
                    ]
                ];
            } elseif(!empty($img_url) && empty($btn_type)) {
                $content_data = [
                    "ft"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "message"=>$talk_msg, "adflag"=>"Y",
                        "image"=>$img_data
                    ]
                ];
            } elseif(empty($img_url) && !empty($btn_type)) {
                $content_data = [
                    "ft"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "message"=>$talk_msg, "adflag"=>"Y",
                        "button"=>$btn_data
                    ]
                ];
            } else {
                $content_data = [
                    "ft"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "message"=>$talk_msg, "adflag"=>"Y"
                    ]
                ];
            }
        }
        
        $postData = [
            "account"=>"dwave2014", "refkey"=>$ref_key, "type"=>$msg_type, "from"=>$from_phone, "to"=>$to_phone,
            "content"=>$content_data
        ];
        
        //         print_r(json_encode($postData));
        //         print_r($postData);
        //         exit;
        
        if($secPassKey != $secKey){
            echo json_encode(["result"=>"fail", "msg"=>"비밀번호가 일치하지 않습니다."]);
            exit;
        }
        
        $restUrl = "https://api.bizppurio.com/v3/message";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $restUrl,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json; charset=utf-8",
                "Authorization: Bearer ".$access_token.""
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($postData),
            //             CURLOPT_POSTFIELDS => json_encode($postData),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if($err) {
            //             echo "cURL Error #:" . $err;
            echo json_encode(["result"=>"fail", "msg"=>$err]);
        } else {
            //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
            $result = json_decode($response);
            
            //             $result->code;
            //             $result->description;
            //             $result->refkey;
            //             $result->messagekey; <== 전송결과 인덱스키와 비교해서 최종 전송결과 매칭가능
            
            
            echo json_encode(["result"=>"ok", "msg"=>$result->description.'('.$result->code.')']);
        }
        
        exit;
        
    }
    
}


?>
