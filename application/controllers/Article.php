<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model('contents_model', 'contentsModel');
        
//         if($_SERVER["HTTPS"]!="on"){
//             $rtnUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//             header('Location:'.$rtnUri);
//             exit;
//         }
    
    }
    
    private function session_chk(){
        if(!isset($this->session->userdata["member_id"]) && !isset($this->session->userdata["user_id"])){
            
            setcookie("target_url", $_SERVER['REQUEST_URI'], time()+3600, "/");
            
            $errMsg = '<script>alert("회원인증이 필요합니다.");';
            $errMsg.= 'location.href="/member/verify";</script>';
            echo $errMsg;
        }
    }

	
	public function index(){
	    
	    $this->list();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function list(){
	    
	    $this->session_chk();
	    
	    $keyword = "";
	    
	    $query = $this->contentsModel->contents_list([
	        "contents_type"=>"article", "keyword"=>$keyword
	    ]);	    
	    
	    $viewData = ["data"=>$query["list"], "total_count"=>$query["listCount"]];
	    
	    $this->load->view('/article/list', $viewData);
	}
	
	public function node($idx=-1){
	    
	    $this->session_chk();
	    
	    $info = [];
	    $keyVal = [
	        "idx", "contents_type", "title", "body_text", "attach_file"
	    ];
	    
	    $query = $this->contentsModel->contents_info(["idx"=>$idx]);
	    
	    if($query){
	        foreach($query as $row){
	            foreach($keyVal as $col){
	                $info+= [$col => $row[$col]];
	            }
	        }
	    }else {
	        header('Location:/article/list');
	    }
	    
	    $viewData = ["info"=>$info];
	    $this->load->view('/article/node', $viewData);
	}
	
	
	
	
}
