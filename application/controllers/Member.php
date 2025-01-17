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
	        "profile_url"=>'https://kapi.kakao.com/v2/user/me',
	        "redirect_uri"=>'http://localhost/member/kakao_callback',
	        "state"=>md5(mt_rand(111111, 999999))
	    ];
	    
	    $login_auth_url = 'https://kauth.kakao.com/oauth/authorize?response_type=code&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&state='.$kakao["state"].'&prompt=login';
	    $login_token_url = 'https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id='.$kakao["client_id"].'&redirect_uri='.$kakao["redirect_uri"].'&client_secret='.$kakao["client_secret"].'&code='.$kakao["code"];

	    $viewData = [
	       "login_auth_url"=>$login_auth_url, "login_token_url"=>$login_token_url
	    ];
	    
	    $this->load->view('/member/verify', $viewData);
	}
	
	public function kakao_callback(){
	    
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
