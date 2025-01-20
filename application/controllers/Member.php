<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
//         $this->load->model('event_model', 'eventModel');
        
//         if($_SERVER["HTTPS"]!="on"){
//             $rtnUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//             header('Location:'.$rtnUri);
//             exit;
//         }
    
    }

	
	public function index()
	{	    
	    
// 	    $this->login();
// 	    $this->load->view('/admin/login');
	}
	
	public function verify(){
	    
	    $kakao=[
	        "client_id"=>'2549f043e46bbd82676b804343560ca2', 
	        "client_secret"=>'6wttiSwgMRVFTQL4MrxhtXEiTXs3i4En',
	        "redirect_uri"=>'http://localhost/member/kakao_result',
	        "state"=>md5(mt_rand(111111, 999999))
	    ];
	    
	    $login_auth_url = 'https://kauth.kakao.com/oauth/authorize?response_type=code&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&state='.$kakao["state"].'&prompt=login';
	    

	    $viewData = [
	       "login_auth_url"=>$login_auth_url
	    ];
	    
	    $this->load->view('/member/verify', $viewData);
	}
	
	// 함수: 카카오 curl 통신
	public function curl_kakao($url,$headers = array()){
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
	
	public function kakao_result(){
	    try{
    	    $kakao=[
    	        "client_id"=>'2549f043e46bbd82676b804343560ca2',
    	        "client_secret"=>'6wttiSwgMRVFTQL4MrxhtXEiTXs3i4En',
    	        "token_url"=>'https://kauth.kakao.com/oauth/token?grant_type=authorization_code',
    	        "profile_url"=>'https://kapi.kakao.com/v2/user/me'
    	    ];
    	    
    	    
    	    // 기본 응답 설정
    	    $res = ['rst'=>'fail','code'=>(__LINE__*-1),'msg'=>''];
    	    
    	    // code && state 체크
    	    if(empty($_GET['code']) || empty($_GET['state']) ||  $_GET['state'] != $_COOKIE['state']){
    	        throw new Exception("인증실패", (__LINE__*-1) );
    	        echo 'empty';
    	    }
    	    
    	    $token_url = $kakao["token_url"];
    	    $token_url.= '&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&client_secret='.$kakao["client_secret"].'&code='.getRequest("code", "");
    	    
    	    
    	    $token_result = json_decode($this->curl_kakao($token_url));
    	    
    	    if( empty($token_result)){ throw new Exception("토큰요청 실패", (__LINE__*-1) ); }
    	    if( !empty($token_result->error) || empty($token_result->access_token) ){
    	        throw new Exception("토큰인증 에러", (__LINE__*-1) );
    	    }
    	    
    	    // 프로필 요청
    	    $header = ["Authorization: Bearer ".$token_result->access_token];
    	    $profile_data = json_decode($this->curl_kakao($kakao["profile_url"], $header));
    	    if( empty($profile_data) || empty($profile_data->id) ){ 
    	        throw new Exception("프로필요청 실패", (__LINE__*-1) ); 
    	    }
	    }
	    catch(Exception $e){
	        if(!empty($e->getMessage())){ $res['msg'] = $e->getMessage(); }
	        if(!empty($e->getMessage())){ $res['code'] = $e->getCode(); }
	    }
	    
	    
	    // 성공처리
	    if($res['rst'] == 'success'){
	        print_r($profile_data);
	        echo '<br/><br/>'.$profile_data->id;
	        echo '<br/>'.$profile_data->kakao_account->phone_number;
	        echo '<br/>'.$profile_data->kakao_account->email;
	    }
	    
	    // 실패처리
	    else{
	        
	    }
	    
	    // state 초기화
	    // 	setcookie('state','',time()-60); // 300 초동안 유효
	    
	}
	
	public function signup(){
	    
	    $this->load->view('/member/signup');
	}
	
	public function term(){
	    
	    $this->load->view('/member/term');
	}
	public function privacy(){
	    
	    $this->load->view('/member/privacy');
	}
	
	
	
	
	
}
