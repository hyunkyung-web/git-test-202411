<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model('contents_model', 'contentsModel');
        
//         if($_SERVER["HTTPS"]!="on"){
//             $rtnUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//             header('Location:'.$rtnUri);
//             exit;
//         }

        ban_ip();
    
    }

    
    private function session_chk(){
        if(!isset($this->session->userdata["member_id"])){
            
            setcookie("target_url", $_SERVER['REQUEST_URI'], time()+300, "/");
//             cookie_return_url();            
            $errMsg = '<script>alert("회원인증이 필요합니다.");';
            $errMsg.= 'location.href="/member/verify";</script>';
            echo $errMsg;
        }
    }    
 	
	public function index(){
	    
	    $this->list();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function call(){
	    
	    $this->session_chk();
	    
	    $this->load->view('/support/call');
	}
	
	
	
	
	
	
}
