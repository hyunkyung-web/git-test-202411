<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model('member_model', 'memberModel');
    }
    
    private function session_chk(){
        if(!isset($this->session->userdata["member_id"])){
            
            setcookie("target_url", $_SERVER['REQUEST_URI'], time()+3600, "/");
            
            $errMsg = '<script>alert("회원인증이 필요합니다.");';
            $errMsg.= 'location.href="/member/verify";</script>';
            echo $errMsg;
        }
    }
    
    private function invalid_process(){
        $errMsg = '<script>alert("잘못 된 접근입니다.");';
        $errMsg.= 'location.href="/";</script>';
        echo $errMsg;
    }
    
    // 함수: 카카오 curl 통신
    private function curl_kakao($url,$headers = array()){
        
        if(empty($url)){ return false ; }
        
        // URL에서 데이터를 추출하여 쿼리문 생성
        $purl = parse_url($url);
        $postfields = array();
        
        if( !empty($purl['query']) && trim($purl['query']) != ''){
            $postfields = explode("&",$purl['query']);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        if( count($headers) > 0){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        ob_start(); // prevent any output
        $data = curl_exec($ch);
        ob_end_clean(); // stop preventing output
        
        if (curl_error($ch)){ return false;}
        
        curl_close($ch);
        return $data;
    }
    

	
	public function index(){
	    echo 'index';
	    
// 	    $this->login();
// 	    $this->load->view('/admin/login');
	}
	
	public function verify(){
	    
	    if(isset($this->session->userdata["member_id"])){
	        header('Location:/');
	    }	    
	    	    
	    $kakao_state = md5(mt_rand(111111, 999999));	    
	    setcookie('state', $kakao_state, time()+600);
	    
	    $kakao=[
	        "client_id"=>'2549f043e46bbd82676b804343560ca2', 
	        "client_secret"=>'6wttiSwgMRVFTQL4MrxhtXEiTXs3i4En',
	        "redirect_uri"=>'http://localhost:9090/member/kakao_result',
// 	        "redirect_uri"=>'https://kakao.dr-wave.co.kr/member/kakao_result',
	        "state"=>$kakao_state
	    ];
	    
	    $login_auth_url = 'https://kauth.kakao.com/oauth/authorize?response_type=code&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&state='.$kakao["state"].'&prompt=login';
	    

	    $viewData = [
	       "login_auth_url"=>$login_auth_url
	    ];
	    
	    $this->load->view('/member/verify', $viewData);
	}
	
	public function cellphone_valid(){
	    
	    $is_member = $this->memberModel->get_idx(getPost("cellphone", ""));
	    
	    //회원 정보에 등록 된 번호일 경우 메세지를 리턴한다.
	    if(count($is_member)>0){
	        if($is_member[0]["member_status"]=='active'){
	            echo json_encode(['result' => "ok", 'msg'=>"활동회원"]);
	            
	        } else{
	            if($is_member[0]["member_status"]=='expire'){
	                echo json_encode(['result' => "error", 'msg'=>"활동이 정지 된 회원입니다. 고객센터에 문의바랍니다."]);
	            }else {
	                echo json_encode(['result' => "error", 'msg'=>"승인 대기 중인 회원입니다. 승인이 완료되면 가입하신 핸드폰으로 메세지가 발송됩니다."]);
	            }	            
	        }
	    } else{
	        echo json_encode(['result' => "no_member", 'msg'=>"일치하는 회원정보가 없습니다. 회원가입으로 이동합니다."]);
	    }
	    
	}
	
	
	public function kakao_result(){
	    
	    $kakao=[
	        "client_id"=>'2549f043e46bbd82676b804343560ca2',
	        "client_secret"=>'6wttiSwgMRVFTQL4MrxhtXEiTXs3i4En',
	        "redirect_uri"=>'http://localhost:9090/member/kakao_result',
// 	        "redirect_uri"=>'https://kakao.dr-wave.co.kr/member/kakao_result',
	        "token_url"=>'https://kauth.kakao.com/oauth/token?grant_type=authorization_code',
	        "profile_url"=>'https://kapi.kakao.com/v2/user/me'
	    ];
	    
	    
	    // 기본 응답 설정
	    $res = ["result"=>"fail",'code'=>(__LINE__*-1),'msg'=>''];
	    
	    // code && state 체크
	    if(empty($_GET['code']) || empty($_GET['state']) ||  $_GET['state'] != $_COOKIE['state']){	        
	        header('Location:/member/verify');
	        exit;
	    }
	    
	    $token_url = $kakao["token_url"];
	    $token_url.= '&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&client_secret='.$kakao["client_secret"].'&code='.getRequest("code", "");
	    
            //프로필 데이터 요청을 위한 토큰 정보 가져오기
	    $token_result = json_decode($this->curl_kakao($token_url));	    
	    
	    if( empty($token_result)){ throw new Exception("토큰요청 실패", (__LINE__*-1) ); }
	    if( !empty($token_result->error) || empty($token_result->access_token) ){
	        echo '<br/><br/>error=>'.$token_result->error;
	    }
	    
	    // 프로필 요청
	    $header = ["Authorization: Bearer ".$token_result->access_token];
	    $profile_data = json_decode($this->curl_kakao($kakao["profile_url"], $header));
	    
	    // state 초기화
	    setcookie('state','',time()-60); // 300 초동안 유효
	    
	    if( empty($profile_data) || empty($profile_data->id) ){
	        echo '프로필 데이터 요청 실패';
	    } else{
// 	        print_r($profile_data);
	        $res["result"] = 'success';
	        $profile_info = [
	            "uuid"=>$profile_data->id,
	            "name"=>$profile_data->kakao_account->name,
	            "cellphone"=>str_replace('-', '', str_replace('+82 ', '0', $profile_data->kakao_account->phone_number)),	            
	            "email"=>$profile_data->kakao_account->email
	            
	        ];
	        
	        $is_member = $this->memberModel->get_idx($profile_info["cellphone"]);
	        
	        //회원인 경우 세션 설정하고 이동
	        if(count($is_member)>0){
	            if($is_member[0]["member_status"]=='active'){
	                $this->session->set_userdata([
	                    "member_id"=>$is_member[0]["idx"],
	                    "member_nm"=>$is_member[0]["member_nm"],
	                    "member_cellphone"=>$is_member[0]["cellphone"],
	                    "member_email"=>$is_member[0]["member_email"],
	                    "sess_id"=>session_id()
	                ]);
	                
	                $this->memberModel->record_member_log([
	                    "member_id"=> $is_member[0]["idx"],
	                    "log_type"=> 'login'
	                ]);
	                
	                if(!empty(get_cookie("target_url"))){
	                    header('Location:'.get_cookie("target_url"));
	                }else {
	                    header('Location:/');
	                }
	               
	                
	            } else{
	                $msg_str = '<script>';	                
	                $msg_str.= 'alert("승인 대기 중인 정보입니다. 승인이 완료되면 가입하신 핸드폰으로 메세지가 발송됩니다.");';
	                $msg_str.= 'location.replace("/");';
	                $msg_str.= '</script>';
	                echo $msg_str;
	            }	            
	        } else{
	            $form_str = '<form name="frm1" id="frm1" action="/member/signup" method="post">';
	            $form_str.= '<input type="hidden" name="uuid" value="'.$profile_info["uuid"].'" />';
	            $form_str.= '<input type="hidden" name="name" value="'.$profile_info["name"].'" />';
	            $form_str.= '<input type="hidden" name="cellphone" value="'.$profile_info["cellphone"].'" />';
	            $form_str.= '<input type="hidden" name="email" value="'.$profile_info["email"].'" />';
	            $form_str.= '</form><br/>';
	            echo $form_str;
	            
	            $msg_str = '<script>';
	            $msg_str.= 'document.getElementById("frm1").submit();';
	            $msg_str.= 'alert("일치하는 회원정보가 없습니다. 회원가입으로 이동합니다.");';
	            $msg_str.= '</script>';
	            echo $msg_str;
	        }
	    }
	}
	
	public function member_save(){
	    
	    $before_status = "";
	    $alarm_type = 'welcome';
	    
	    if(strlen(getPost("cellphone", ""))!=11){
	        echo json_encode(['result' => 'error', 'msg'=>'필수 입력 누락입니다.']);
	        exit;
	    }
	    
	    $query = $this->memberModel->member_save([
	        "editMode"=> 'C',
	        "idx"=> getPost("idx", -1),
	        "member_nm" => getPost("member_nm", "Unknown"),
	        "member_type" => getPost("member_type", "hcp"),
	        "cellphone" => getPost("cellphone", ""),
	        "member_email" => getPost("member_email", ""),
	        "biz_nm" => getPost("biz_nm", ""),
	        "specialty" => getPost("specialty", ""),
	        "member_status" => getPost("member_status", "hold"),
	        "uuid" => getPost("uuid", "")
	    ]);
	    
	    if(($before_status=="hold" || $before_status=="expire") && getPost("member_status", "hold")=="active"){
	        $alarm_type = "member_active";
	    }elseif($before_status=="active" && getPost("member_status", "hold")=="expire"){
	        $alarm_type = "member_expire";
	    }
	    
	    if ( $query["result"] == "ok") {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"], 'push_msg_type'=>$alarm_type, 'idx' => $query["idx"]]);
	    } else {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"]]);
	    }
	    
	}
	
	public function signup(){
	    
	    $viewData = ["name"=>getPost("name", ""), "cellphone"=>getPost("cellphone", ""), "email"=>getPost("email", ""), "uuid"=>getPost("uuid", "")];
	    
	    $this->load->view('/member/signup', $viewData);
	}
	
	public function term(){
	    
	    $this->load->view('/member/term');
	}
	public function privacy(){
	    
	    $this->load->view('/member/privacy');
	}
	
	public function logout(){
	    
	    if(isset($this->session->userdata["member_id"])){	        
	        
	        $this->memberModel->record_member_log([
	            "member_id" => $this->session->userdata["member_id"],
	            "log_type" => 'logout'
	        ]);
	        
	        $this->session->unset_userdata(["member_id", "member_nm", "member_cellphone", "member_email", "sess_id"]);
// 	        $this->session->sess_destroy();
	    }
	    
	    header('Location:/');
	    
	}
	
	
	
	
	
}