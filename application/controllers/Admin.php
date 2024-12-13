<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        $this->load->model('msg_model', 'msgModel');

//         $this->load->model('event_model', 'eventModel');

//         if($_SERVER["HTTPS"]!="on"){
//             $rtnUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//             header('Location:'.$rtnUri);
//             exit;
//         }

    }
    
    private function session_chk($type){
        if($type=="admin"){
            if(!isset($this->session->userdata["user_id"]) || $this->session->userdata["user_type"] != "admin"){
                $errMsg = '<script>alert("관리자 로그인이 필요합니다.");';
                $errMsg.= 'location.href="/admin/login";</script>';
                echo $errMsg;
                exit;
            }
        } else {
            if(!isset($this->session->userdata["user_id"])){
                $errMsg = '<script>alert("관리자 로그인이 필요합니다.");';
                $errMsg.= 'location.href="/";</script>';
                echo $errMsg;
                exit;
            }
        }
    }


	public function index()
	{
	    $this->main();
	}
	
	public function login()
	{
	    $this->load->view('/admin/login');
	}

	public function main()
	{
	    $this->load->view('/admin/main');
	}

	public function contents_list()
	{
	    $viewData = ["menuNum"=>100];
	    $this->load->view('/admin/contents_list', $viewData);
	}

	public function contents_form()
	{
	    $viewData = ["menuNum"=>110];
	    $this->load->view('/admin/contents_form', $viewData);
	}

	public function user_list()
	{
	    $viewData = ["menuNum"=>900];
	    $this->load->view('/admin/user_list', $viewData);
	}

	public function user_form()
	{
	    $viewData = ["menuNum"=>910];
	    $this->load->view('/admin/user_form', $viewData);
	}
	
	
	public function template_form()
	{	    
	    
	    $idx = getPost("idx", -1);
	    $editMode = $idx==-1 ? "N" : "U";
	    
	    $dataProfile = [
	        ["key"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af", "profile_nm"=>"dr-wave"]
	    ];
	    
	    $img_data = [
	        ["img_name"=>"뉴스안내_241119", "img_url"=>"https://mud-kage.kakao.com/dn/xRPSI/btsKOqGeRa7/QVKEY9vwUAd1NPvh3zyuJ1/img_l.jpg"],
	        ["img_name"=>"행사안내_241119", "img_url"=>"https://mud-kage.kakao.com/dn/bAZVG0/btsKNwgmdVI/Ia0cinMIxeNJB0TGIEEBK1/img_l.jpg"],
	        ["img_name"=>"온라인부스", "img_url"=>"https://mud-kage.kakao.com/dn/bnmtrK/btrZde0Mgf3/DiAEC3O5R2YfR6Y6pEv79K/img_l.jpg"],
	        ["img_name"=>"마이크로사이트", "img_url"=>"https://mud-kage.kakao.com/dn/ffQoH/btrZkzhJAsU/ebLISy9o1K62jRitT2PtlK/img_l.jpg"]
	    ];
	    
	    $query = $this->msgModel->template_open(["idx"=>$idx]);
	    $info = [];
	    $keyVal = [
	        "profile_type", "profile_key",
	        "template_type", "template_cd", "template_nm", "template_msg",
	        "img_url", "img_link",
	        "btn_type_1", "btn_name_1", "btn_link_1", "btn_type_2", "btn_name_2", "btn_link_2",
	        "btn_type_3", "btn_name_3", "btn_link_3", "btn_type_4", "btn_name_4", "btn_link_4",
	        "btn_type_5", "btn_name_5", "btn_link_5", "btn_cnt"
	    ];
	    
	    if($query){
	        foreach($query as $row){
	            foreach($keyVal as $col){
	                $info+= [$col => $row[$col]];
	            }
	        }
	    } else {
	        foreach($keyVal as $col){
	            $info+= [$col => ''];	            
	        }
	        $info["template_type"]="ft";
	    }
	    
	    $viewData = ["menuNum"=>210, "editMode"=>$editMode, "info"=>$info, "idx"=>$idx, "dataProfile"=>$dataProfile, "img_data"=>$img_data];
	    $this->load->view('/admin/template_form', $viewData);
	}
	
	public function template_save(){
	    
	    $this->session_chk("admin");
	    
	    $query = $this->msgModel->template_save([
	        "editMode"=> getPost("editMode", "N"),
	        "idx"=> getPost("idx", -1),
	        "profile_type"=> getPost("profile_type", ""),
	        "profile_key"=> getPost("profile_key", ""),
	        "template_type"=> getPost("template_type", "at"),
	        "template_cd"=> getPost("template_cd", ""),
	        "img_url"=> getPost("img_url", ""),
	        "img_link"=> getPost("img_link", ""),
	        "template_nm"=> getPost("template_nm", ""),
	        "template_msg"=> getPost("template_msg", ''),
	        "btn_type"=> getPost("btn_type", ""),
	        "btn_name"=> getPost("btn_name", ""),
	        "btn_link"=> getPost("btn_link", "")
	    ]);
	    
	    if ( $query["result"] != "db_error") {
	        echo json_encode(['result' => 'ok', 'msg'=>$query["msg"], 'rtn_idx'=>$query["rtn_idx"]]);
	    } else {
	        echo json_encode(['result' => 'db_error', 'msg'=>$query["msg"]]);
	    }
	    exit;
	}
	
	public function template_list(){
	    
	    $page = getPost("page", 1);
	    $template_type = getPost("sch_1", "");
	    $keyword = getPost("sch_2", "");
	    $schData = ["sch_1"=>$template_type, "sch_2"=>$keyword, "page"=>$page];
	    
	    //리스트에 보여줄 게시물의 갯수
	    $pageSize = 10;
	    //페이징에 보여줄 페이지의 갯수
	    $blockSize = 10;
	    //쿼리로 조회 할 DB의 주소 시작번호(start) 가져올 갯수(end)
	    $startPage = ($page-1) * $pageSize;
	    $endPage = $pageSize;
	    
	    $query = $this->msgModel->template_list([
	        "template_type"=>$template_type, "keyword"=>$keyword, "profile_type"=>"", "start"=>$startPage, "end"=>$endPage
	    ]);
	    
	    
	    $totalRecord = $query["listCount"];
	    $totalPage = ceil($totalRecord/$pageSize);
	    
	    $viewData = ["menuNum"=>200, "schData"=>$schData, "data"=>$query["list"], "totalRecord"=>$totalRecord, "pageSize"=>$pageSize, "page"=>$page,
	        "listFnc"=>"templateList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage
	    ];
	    
	    // 	    $pageData = ["listFnc"=>"eventList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage, "page"=>$page];
	    $this->load->view('/admin/template_list', $viewData);
	    // 	    $this->load->view('/admin/inc_paging', $pageData);
	}
	
	
	

	
	public function get_message(){
	    
	    $this->session_chk("admin");
	    $idx = getPost("idx", -1);
	    $btnStr='';
	    
	    $query = $this->msgModel->template_open(["idx"=>$idx])[0];
	    
	    if($query["btn_cnt"]>=1){
	        for($i=1; $i<=$query["btn_cnt"]; $i++){
	            $btnStr.='<tr>';
	            $btnStr.='<td>';
	            $btnStr.='<button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp;';
	            $btnStr.='<select name="btn_type[]">';
	            $btnStr.='<option value="">타입</option>';
	            $btnStr.='<option value="WL" ';
	            $btnStr.= $query["btn_type_".$i] == "WL" ? "selected" : "";
	            $btnStr.='>웹버튼</option>';
	            $btnStr.='</select>';
	            $btnStr.='</td>';
	            $btnStr.='<td><input type="text" name="btn_name[]" placeholder="버튼명" value="'.$query["btn_name_".$i].'"></td>';
	            $btnStr.='</tr>';
	            $btnStr.='<tr>';
	            $btnStr.='<td colspan="2"><input type="text" name="btn_link[]" placeholder="연결링크" value="'.$query["btn_link_".$i].'"></td>';
	            $btnStr.='</tr>';
	        }
	    }
	    
	    echo json_encode(["msg"=>$query["template_msg"], "img_url"=>$query["img_url"], "img_link"=>$query["img_link"], "btn_data"=>$btnStr]);
	    
	}






}
