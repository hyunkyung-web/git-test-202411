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
	
	public function verify()
	{
	    
	    $this->load->view('/member/verify');
	}
	
	public function signup()
	{
	    
	    $this->load->view('/member/signup');
	}
	
	public function term()
	{
	    
	    $this->load->view('/member/term');
	}
	public function privacy()
	{
	    
	    $this->load->view('/member/privacy');
	}
	
	
	
	
	
}
