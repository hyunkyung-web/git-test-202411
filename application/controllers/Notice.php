<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {
    
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
    
    
    
    private function set_callback_url(){
        setcookie("callback_url", $_SERVER['REQUEST_URI'], time()+3600, "/");
    }
    
    private function session_chk(){
        if(!isset($this->session->userdata["member_id"])){
            
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
	        "contents_type"=>"notice", "keyword"=>$keyword
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
	
	public function save_reply(){
	    
	    $editMode = getPost("editMode", "N");
	    $idx = getPost("idx", -1);
	    $contents_idx = getPost("contents_idx", -1);
	    $reply_text = getPost("reply_text", "");
	    
	    $query = $this->contentsModel->save_reply([
	        "editMode"=>$editMode, "idx"=>$idx, "contents_idx"=>$contents_idx, "reply_text"=>$reply_text
	    ]);
	    
	    
	    echo json_encode(['result' => $query["result"], "msg"=>$query["msg"]]);
	    
	}
	
	public function save_like(){
	    
	    $contents_idx = getPost("contents_idx", -1);
	    
	    $query = $this->contentsModel->save_like([
	        "contents_idx"=>$contents_idx
	    ]);
	    
	    
	    echo json_encode(['result' => $query["result"], "msg"=>$query["msg"]]);
	    
	}
	
	public function ajax_reply_like_list(){
	    
	    $this->session_chk();
	    
	    $data = $this->contentsModel->ajax_reply_like_list([
	        "contents_idx"=>getPost("contents_idx", -1)
	    ]);
	    
	    $viewData = [
	        "reply_list"=>$data["reply_list"], "reply_cnt"=>$data["reply_cnt"],
	        "like_list"=>$data["like_list"], "like_cnt"=>$data["like_cnt"], "my_like_cnt"=>$data["my_like_cnt"]
	    ];
	    
	    $this->load->view('/article/ajax_reply_list', $viewData);
	}
	
	
	
	public function download(){
	    $attach_path = getRequest("file", "");
	    $file_loc = $_SERVER['DOCUMENT_ROOT'].$attach_path;
	    $file_name = str_replace("/public/data/attach/", "", $attach_path);
        
        if($file_name && file_exists($file_loc)){
        
            Header("Content-type: application/octet-stream");
            Header("Content-Length: ".(string)(filesize($file_loc))); //다운로드 게이지를 나타냅니다.
            Header("Content-Disposition: attachment; filename=$file_name"); //파일을 무조건 다운로드 합니다.
            Header("Content-Transfer-Encoding: binary");
            Header("Pragma: no-cache");
            Header("Cache-Control: cache, must-revalidate"); //다운로드 확인창에서 다운로드 하지 않고 바로 열 수 있습니다.
            Header("Expires: 0");
            
            
            $fp = fopen($file_loc, "rb");
            while(!feof($fp)) {
                echo fread($fp, filesize($file_loc));
                flush();
            }
            fclose ($fp);
            exit;
            
        }
        else {
            
            $msgStr = '<script language="JavaScript">';
            $msgStr.= 'alert("File not found.");';
            $msgStr.= '</script>';
            
            echo $msgStr;
            exit;
        }
	    
	}
	
	
	
	
}
