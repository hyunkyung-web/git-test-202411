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
    
    private function get_member_number($member_id){
        
        $query = $this->memberModel->get_member_cellphone($member_id);
        return($query[0]["cellphone"]);
        
    }
    
    private function get_member_id($cell_phone){        
        
        $result = $this->memberModel->get_idx($cell_phone);
        if(count($result)>0){
            return($result[0]["idx"]);
        }else {
            return("no_member");
        }
        
        
    }
    
    public function push_system_msg(){
        
        $this->session_chk("admin");
        
        $access_token = $this->get_access_token();
        $msg_type = "at";
        $from_phone = "025402256";
        $to_phone = $this->get_member_number(getPost("member_id", -1));    
        
        $ref_key = $msg_type."_".time();
        
        $talk_msg = "";
        
        $template_code = getPost("template_code", "");
        
        $img_data = [];
//         $btn_data = [];
        
        switch($template_code){
            case "member_active":
                $talk_msg = "선생님 안녕하세요.\n\n계정 사용이 승인되었습니다.\n아래 버튼을 통해 서비스 화면으로\n이동하실 수 있습니다.\n앞으로 많은 관심 부탁드립니다.\n\n감사합니다.";                
//                 $btn_data = ["type"=>"WL", "name"=>"DWAVE PRO 바로가기", "url_pc"=>"https://dr-wave.co.kr/round", "url_mobile"=>"https://dr-wave.co.kr/round"];
                
                $content_data = [
                    "at"=>[
                        "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
                        "templatecode"=>$template_code,
                        "message"=>$talk_msg,
                        "button"=>[["type"=>"WL", "name"=>"DWAVE PRO 바로가기", "url_pc"=>"https://dr-wave.co.kr/round", "url_mobile"=>"https://dr-wave.co.kr/round"]]
                    ]
                ];
                
                break;
        }        
        
        $postData = [
            "account"=>"dwave2014", "refkey"=>$ref_key, "type"=>$msg_type, "from"=>$from_phone, "to"=>$to_phone,
            "content"=>$content_data
        ];
        
        //         print_r(json_encode($postData));
        //         print_r($postData);
        //         exit;
        
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
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>"0", "cellphone"=>$to_phone, "member_id"=>getPost("member_id", -1), 
                "ref_key"=>"", "message_key"=>"",
                "result_code"=>'curl error',"result_desc"=>$err
            ]);
            
            echo json_encode(["result"=>"fail", "msg"=>$err]);
        } else {
            //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
            $result = json_decode($response);
            
            $save_log = $this->msgModel->save_biztalk_log([
                "template_idx"=>"0", "cellphone"=>$to_phone, "member_nm"=>"", "member_id"=>getPost("member_id", -1),
                "ref_key"=>$result->refkey, "message_key"=>$result->messagekey,
                "result_code"=>$result->code,"result_desc"=>$result->description
            ]);
            
            echo json_encode(["result"=>"ok", "msg"=>$result->description.'('.$result->code.')']);
        }
        
        exit;
        
    
        
    }
    
    public function push_contents_msg(){
        
        $this->session_chk();
        
        $access_token = $this->get_access_token();
        $from_phone = "025402256";        
        
        $template_idx = getPost("template_idx", "");
        $template_type = getPost("template_type", "ft");   
        $msg_target = getPost("msg_target", "");  
        $arr_target = explode(",", $msg_target);
        $img_url = getPost("img_url", "");
        $img_link = getPost("img_link", "");
        $template_title = getPost("title", "");
        $template_msg = getPost("template_msg", "");
        $final_msg = $template_title."\n\n".$template_msg;
        $btn_type = $_POST["btn_type"];
        $btn_name = $_POST["btn_name"];
        $btn_link = $_POST["btn_link"];

        $ref_key = $template_type."_".time();
        $exec_cnt = 0;
        $ok_cnt = 0;
        
        foreach($arr_target as $row){            
            
            $img_data = [];
            $btn_data = [];
            $member_id = "";
            $add_utm="";
            
            $member_id = $this->get_member_id($row);

            $add_utm = 'utm_source='.$member_id.'&utm_medium='.$template_type.'&utm_campaign='.$template_idx;
            
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
            
                
//             if(!empty($img_url) && !empty($btn_type)){
//                 $content_data = [
//                     "ft"=>[
//                         "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
//                         "message"=>$final_msg, "adflag"=>"Y",
//                         "button"=>$btn_data,
//                         "image"=>$img_data
//                     ]
//                 ];
//             } elseif(!empty($img_url) && empty($btn_type)) {
//                 $content_data = [
//                     "ft"=>[
//                         "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
//                         "message"=>$final_msg, "adflag"=>"Y",
//                         "image"=>$img_data
//                     ]
//                 ];
//             } elseif(empty($img_url) && !empty($btn_type)) {
//                 $content_data = [
//                     "ft"=>[
//                         "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
//                         "message"=>$final_msg, "adflag"=>"Y",
//                         "button"=>$btn_data
//                     ]
//                 ];
//             } else {
//                 $content_data = [
//                     "ft"=>[
//                         "senderkey"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af",
//                         "message"=>$final_msg, "adflag"=>"Y"
//                     ]
//                 ];
//             }
                        
            $postData = [
                "account"=>"dwave2014", "refkey"=>$ref_key, "type"=>$template_type, "from"=>$from_phone, "to"=>$row,
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
            
            $exec_cnt++;
            
            if($err) {
//                 echo json_encode(["result"=>"fail", "msg"=>$err]);
                $save_log = $this->msgModel->save_biztalk_log([
                    "template_idx"=>$template_idx, "template_type"=>$template_type, "cellphone"=>$row, "member_id"=>$member_id, "ref_key"=>"", "message_key"=>"",
                    "result_code"=>'curl error',"result_desc"=>$err
                ]);
            } else {
                
                $ok_cnt++;
                //json 결과 값을 디코딩 후에 액세스토큰 정보를 생성하고 리턴
                $result = json_decode($response);
                
                //             $result->code; $result->description; $result->refkey; $result->messagekey; <== 전송결과 인덱스키와 비교해서 최종 전송결과 매칭가능
                
                $save_log = $this->msgModel->save_biztalk_log([
                    "template_idx"=>$template_idx, "template_type"=>$template_type, "cellphone"=>$row, "member_nm"=>"", "member_id"=>$member_id, "ref_key"=>$result->refkey, "message_key"=>$result->messagekey,
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

