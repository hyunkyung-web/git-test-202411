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

	
	public function index()
	{
	    
	    $this->main();
	}
	
	public function main(){
	    $this->load->view('/main');
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
