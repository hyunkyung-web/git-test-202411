<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {
    
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
	    
	    $this->list();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function list()
	{
	    $this->load->view('/article/list');
	}
	
	public function node()
	{
	    $this->load->view('/article/node');
	}
	
	
	
	
}
