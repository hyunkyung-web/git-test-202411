<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bizmsg extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('member_model', 'memberModel');
        $this->load->model('msg_model', 'msgModel');
        
        //         $this->load->model('contents_model', 'contentsModel');
        //         $this->load->model('hospital_model', 'hospitalModel');
        //         isset($this->session->userdata['userId'])? header('Location:/supervisor/') :"";
        //         $this->load->library('session');
        //         $this->load->helper('cookie');
        //         $this->load->helper('request');
    }
    
    private function session_chk(){
        if(!isset($this->session->userdata["user_id"])){
            $errMsg = '<script>alert("로그인이 필요합니다.");';
            $errMsg.= 'location.href="/admin/login";</script>';
            echo $errMsg;
            exit;
        }
    }
    
    public function index(){
        
        $arr_template = [
            ["key"=>"dwave_test", "name"=>"알림톡_테스트", "msg"=>"안녕하세요. 닥터웨이브입니다.\n알림톡 수신 확인을 위한 테스트 메세지 입니다.\n감사합니다."],
            ["key"=>"dwave_test_1", "name"=>"업무등록", "msg"=>"#{홍길동}님의 task가 정상적으로 등록되었습니다.\ntask 확인하기 #{https://dr-wave.co.kr}"]
        ];
        
        $viewData = [
            "arr_template"=>$arr_template
        ];
        
        $this->load->view('/message/main', $viewData);
        
        
        
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
        
//         $this->session_chk();
        
        $restUrl = "https://api.bizppurio.com/v1/token";
        
        $curl = curl_init();
        
        curl_setopt_array($curl, [
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
        ]);
        
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
    
 
    
    private function get_member_id($cell_phone){        
        
        $result = $this->memberModel->get_info_by_cellphone($cell_phone);
        if(count($result)>0){
            return($result[0]["idx"]);
        }else {
            return("no_member");
        }
    }
    
    public function push_auth_token(){
        
        $access_token = $this->get_access_token();
        $api_type = "sms";
        $from_phone = "025402256";        
        $to_phone = getPost("cellphone", "");
        $ref_key = $msg_type."_".time();
        $auth_token = mt_rand(000000, 999999);
        $talk_msg = '안녕하세요. 인증번호  ['.$auth_token.']입니다.';
        
        $make_token = $this->memberModel->make_auth_token([
            "cellphone"=>$to_phone, "auth_token"=>$auth_token, "sess_id"=>session_id()
        ]);
        
        if($make_token["result"]!="ok"){
            echo json_encode(["result"=>"error", "msg"=>$make_token["msg"]]);
            exit;
        }
        
        
        $content_data = [
            "sms"=>[
                "message"=>$talk_msg
            ]
        ];
        
        $postData = [
            "account"=>"dwave2014", "type"=>$api_type, "from"=>$from_phone, "to"=>$to_phone,
            "country"=>"", "refkey"=>$ref_key, 
            "content"=>$content_data
        ];        
        
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
            //                 echo json_encode(["result"=>"fail", "msg"=>$err]);
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>-1, "template_type"=>$api_type, "cellphone"=>$to_phone, "member_id"=>getPost("member_id", -1), "ref_key"=>"", "message_key"=>"",
                "result_code"=>'curl error',"result_desc"=>$err
            ]);
            
            echo json_encode(["result"=>"fail", "msg"=>$err]);
            
        } else {
            //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
            $result = json_decode($response);
            
            //             $result->code; $result->description; $result->refkey; $result->messagekey; <== 전송결과 인덱스키와 비교해서 최종 전송결과 매칭가능
            
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>-1, "template_type"=>$api_type, "cellphone"=>$to_phone, "member_nm"=>"", "member_id"=>getPost("member_id", -1), "ref_key"=>$result->refkey, "message_key"=>$result->messagekey,
                "result_code"=>$result->code,"result_desc"=>$result->description
            ]);
            
            echo json_encode(["result"=>"ok", "msg"=>$result->description]);
            
        }
        
    }
    
    public function push_system_msg(){
        
        $this->session_chk();
        
        $access_token = $this->get_access_token();
        $api_type = "at";
        $from_phone = "025402256";
        $ref_key = $api_type."_".time();        
        $talk_msg = "";        
        $msg_type = getPost("msg_type", "at");
        $to_phone = getPost("cellphone", "");
        $member_id = getPost("member_id", "");
        
        switch($msg_type){    
            case "member_status_active":
                $talk_msg = "회원가입이 승인되었습니다.\n아래 버튼을 통해 서비스 화면으로\n이동하실 수 있습니다.\n유익한 정보로 찾아 뵙겠습니다.\n\n감사합니다.";
                //                 $btn_data = ["type"=>"WL", "name"=>"DWAVE PRO 바로가기", "url_pc"=>"https://dr-wave.co.kr/round", "url_mobile"=>"https://dr-wave.co.kr/round"];
                
                $content_data = [
                    "at"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "templatecode"=>"member_status_active",
                        "message"=>$talk_msg,
                        "button"=>[["type"=>"WL", "name"=>"서비스 바로가기", "url_pc"=>"https://kakao.dr-wave.co.kr", "url_mobile"=>"https://kakao.dr-wave.co.kr"]]
                    ]
                ];
                
                break;
        } 
        
        $postData = [
            "account"=>"dwave2014", "type"=>$api_type, "from"=>$from_phone, "to"=>$to_phone,
            "content"=>$content_data, "refkey"=>$ref_key
        ];
        
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
            //                 echo json_encode(["result"=>"fail", "msg"=>$err]);
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>-1, "template_type"=>$api_type, "cellphone"=>$to_phone, 
                "member_id"=>$member_id, "ref_key"=>"", "message_key"=>"",
                "result_code"=>'curl error',"result_desc"=>$err
            ]);
            
            echo json_encode(["result"=>"fail", "msg"=>$err]);
            
        } else {
            //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
            $result = json_decode($response);
            
            //             $result->code; $result->description; $result->refkey; $result->messagekey; <== 전송결과 인덱스키와 비교해서 최종 전송결과 매칭가능
            
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>-1, "template_type"=>$api_type, "cellphone"=>$to_phone, "member_nm"=>"", 
                "member_id"=>$member_id, "ref_key"=>$result->refkey, "message_key"=>$result->messagekey,
                "result_code"=>$result->code,"result_desc"=>$result->description
            ]);
            
            echo json_encode(["result"=>"ok", "msg"=>$result->description]);
            
        }
        
        
        
        exit;
        
    
        
    }
    
    public function push_contents_msg(){
        
        $this->session_chk();
        
        $access_token = $this->get_access_token();
        $from_phone = "025402256";        
        
        $api_type = "ft";
        $template_idx = getPost("template_idx", "");
        $msg_target = getPost("msg_target", "");  
        $final_target = explode(",", $msg_target);
        $img_url = getPost("img_url", "");
        $img_link = getPost("img_link", "");
        $template_title = getPost("title", "");
        $template_msg = getPost("template_msg", "");
        $final_msg = $template_title."\n\n".$template_msg;
        $btn_type = $_POST["btn_type"];
        $btn_name = $_POST["btn_name"];
        $btn_link = $_POST["btn_link"];

        $ref_key = $api_type."_".time();
        $exec_cnt = 0;
        $ok_cnt = 0;
        
        foreach($final_target as $cellphone){
            
            $img_data = [];
            $btn_data = [];
            $member_id = "";
            $add_utm="";
            
            $member_id = $this->get_member_id($cellphone);

            $add_utm = 'utm_source='.$member_id.'&utm_medium='.$api_type.'&utm_campaign='.$template_idx;
            
            if(!empty($img_url)){
                if($img_link!=""){
                    if(strpos($img_link, "?")){
                        $img_link = $img_link.'&'.$add_utm;
                    }else {
                        $img_link = $img_link.'?'.$add_utm;
                    }
                    $img_data = [
                        "img_url"=>$img_url, "img_link"=>$img_link
                    ];
                } else {
                    $img_data = ["img_url"=>$img_url];
                }
            }
            
            if(is_array($btn_type)){

                for($i=0; $i<count($btn_type); $i++){
                    
                    if(strpos($btn_link[$i], "?")){
                        $btnLink = $btn_link[$i].'&'.$add_utm;
                    }else {
                        $btnLink = $btn_link[$i].'?'.$add_utm;
                    }
                    $tmpArr = ["type"=>$btn_type[$i], "name"=>$btn_name[$i], "url_pc"=>$btnLink, "url_mobile"=>$btnLink];
                    array_push($btn_data, $tmpArr);
                }
            }
            
            $content_data = [
                "ft"=>[
                    "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                    "message"=>$final_msg, "adflag"=>"Y",
                    "button"=>$btn_data,
                    "image"=>$img_data
                ]
            ];
            
            $postData = [
                "account"=>"dwave2014", "type"=>$api_type, "from"=>$from_phone, "to"=>$cellphone,
                "content"=>$content_data, "refkey"=>$ref_key
            ];
            
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
            
            $exec_cnt++;
            
            if($err) {
//                 echo json_encode(["result"=>"fail", "msg"=>$err]);
                $save_log = $this->msgModel->save_biztalk_log([
                    "template_idx"=>$template_idx, "template_type"=>$api_type, "cellphone"=>$cellphone, "member_id"=>$member_id, "ref_key"=>"", "message_key"=>"",
                    "result_code"=>'curl error',"result_desc"=>$err
                ]);
            } else {
                
                $ok_cnt++;
                //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
                $result = json_decode($response);
                
                //             $result->code; $result->description; $result->refkey; $result->messagekey; <== 전송결과 인덱스키와 비교해서 최종 전송결과 매칭가능
                
                $save_log = $this->msgModel->save_biztalk_log([
                    "template_idx"=>$template_idx, "template_type"=>$api_type, "cellphone"=>$cellphone, "member_nm"=>"", "member_id"=>$member_id, "ref_key"=>$result->refkey, "message_key"=>$result->messagekey,
                    "result_code"=>$result->code,"result_desc"=>$result->description
                ]);
            }
        }
        
        $return_msg = '총 발송: '.$exec_cnt.'건, 발송성공(api성공만 카운트): '.$ok_cnt.'건';
        echo json_encode(["result"=>"ok", "msg"=>$return_msg]);
//         echo json_encode(["result"=>"ok", "msg"=>$result->description.'('.$result->code.')']);
        
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

