<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
//         $this->load->model('event_model', 'eventModel');
        
//         if($_SERVER["HTTPS"]!="on"){
//             $rtnUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//             header('Location:'.$rtnUri);
//             exit;
//         }
    
    }
    
    private function session_chk(){
        if(!isset($this->session->userdata["member_id"])){
            setcookie("target_url", $_SERVER['REQUEST_URI'], time()+3600, "/");
            $errMsg = '<script>alert("회원인증이 필요합니다.");';
            $errMsg.= 'location.href="/member/verify";</script>';
            echo $errMsg;
            exit;
        }
    }

	
	public function index()
	{
// 	    $this->session_chk();
	    $this->main();
	}
	
	public function main(){
// 	    $this->session_chk();
	    $this->load->view('/main');
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
