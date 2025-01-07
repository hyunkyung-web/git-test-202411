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

	
	public function index(){
	    
	    $this->list();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function list(){
	    $this->load->view('/article/list');
	}
	
	public function node($idx=-1){
	    
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
	    }
	    
	    $viewData = ["info"=>$info];
	    $this->load->view('/article/node', $viewData);
	}
	
	
	
	
}
