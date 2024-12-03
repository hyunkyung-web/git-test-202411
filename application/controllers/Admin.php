<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
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
	    
	    echo 'hyun!!';
	    
	    
// 	    $this->login();
// 	    $this->load->view('/admin/login');
	}
	
	
	public function login()
	{
	    $this->load->view('/admin/login');
	}
	
	public function contents_list()
	{
	    $this->load->view('/admin/contents_list');
	}
	
	public function contents_form()
	{
	    $this->load->view('/admin/contents_form');
	}
	
	
	
	
}
