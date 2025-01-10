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
    
    }

	
	public function index(){
	    
	    $this->list();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function call(){
	    $this->load->view('/support/call');
	}
	
	
	
	
	
	
}
