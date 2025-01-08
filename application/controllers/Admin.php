<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        $this->load->model('contents_model', 'contentsModel');
        $this->load->model('msg_model', 'msgModel');
        $this->load->model('user_model', 'userModel');
        $this->load->model('member_model', 'memberModel');

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


	public function index(){
	    $this->main();
	}
	
	public function login(){
	    $this->load->view('/admin/login');
	}

	public function main(){
	    $this->load->view('/admin/main');
	}

	public function contents_list($page=1){
	    
	    $schType = getRequest("sch_1", "");
	    $keyword = getRequest("sch_2", "");
	    $schData = ["sch_1"=>$schType, "sch_2"=>$keyword];
	    
	    //리스트에 보여줄 게시물의 갯수
	    $pageSize = 10;
	    //페이징에 보여줄 페이지의 갯수
	    $blockSize = 5;
	    //쿼리로 조회 할 DB의 주소 시작번호(start) 가져올 갯수(end)
	    $startPage = ($page-1) * $pageSize;
	    $endPage = $pageSize;
	    
	    $query = $this->contentsModel->contents_list([
	        "keyword"=>$keyword, "start"=>$startPage, "end"=>$endPage
	    ]);
	    
	    $totalRecord = $query["listCount"];
	    $totalPage = ceil($totalRecord/$pageSize);
	    
	    $viewData = ["menuNum"=>100, "schData"=>$schData, "data"=>$query["list"], "totalRecord"=>$totalRecord, "page"=>$page,
	        "listFnc"=>"contentsList", "blockSize"=>$blockSize, "totalPage"=>$totalPage
	    ];
	    
	    // 	    $pageData = ["listFnc"=>"eventList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage, "page"=>$page];
	    $this->load->view('/admin/contents_list', $viewData);
	    
	}

	public function contents_form($idx=-1){
	    
	    $editMode = $idx==-1 ? "N" : "U";
	    
	    $info = [];
	    $keyVal = [
	        "idx", "contents_type", "description", "title", "body_text", "attach_file"
	    ];

	    $query = $this->contentsModel->contents_info(["idx"=>$idx]);
	    
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
	        $info["idx"] = -1;
	        $info["contents_type"] = "article";
	    }
	    
	    $viewData = ["menuNum"=>110, "editMode"=>$editMode, "info"=>$info];	    
	    $this->load->view('/admin/contents_form', $viewData);
	    
	}
	
	public function contents_save(){
	    
	    $uploadPath = "/public/data/attach/";
	    $webPath = "/public/data/attach/";	    
	    $customFileNm = date('ymd').rand(0001, 9999);
	    
	    $rawFile = $_FILES["attach_file"];
	    
	    if(getPost("editMode", "N")=="N"){
	        
	        if(!empty($rawFile["tmp_name"])){
	            $chkFile = chkStoreFile($rawFile, "", 10, "", "", "");
	            if($chkFile != "ok"){
	                echo json_encode(['result' => "file_check_error", "msg"=>$chkFile]);
	                exit;
	            }else {
	                $webPath .= $customFileNm.'.'.pathinfo($rawFile["name"], PATHINFO_EXTENSION);
	                $storeResult = storeFile($rawFile, $uploadPath, $customFileNm);
	            }
	        }else {
	            $webPath = "";
	        }
	        
	    } else{
	        
	        $foreData = $this->contentsModel->contents_info(["idx"=>getPost("idx", -1)]);
	        $foreWebPath = $foreData[0]["attach_file"];

	        if(!empty($rawFile["tmp_name"])){
	            $chkFile = chkStoreFile($rawFile, "", 10, "", "", "");
	            if($chkFile != "ok"){
	                echo json_encode(['result' => "file_check_error", "msg"=>$chkFile]);
	                exit;
	            }else {
	                unlinkFile($foreWebPath);
	                $webPath .= $customFileNm.'.'.pathinfo($rawFile["name"], PATHINFO_EXTENSION);
	                $storeResult = storeFile($rawFile, $uploadPath, $customFileNm);
	            }
	        }else {
	            $webPath = $foreWebPath;
	        }
	    }
	   
	    $query = $this->contentsModel->contents_save([
	        "editMode"=> getPost("editMode", "N"),
	        "idx"=> getPost("idx", -1),
	        "contents_type" => getPost("contents_type", "article"),
	        "description" => getPost("description", ""),
	        "title" => getPost("title", ""),
	        "body_text" => getPost("body_text", ""),
	        "attach_file" => $webPath
	    ]);
	    
	    if ( $query["result"] == "ok") {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"], 'idx' => $query["idx"]]);
	    } else {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"]]);
	    }
	    
	}
	
	public function member_list($page=1){
	    // 	    $page = getRequest("page", 1);
	    $schType = getRequest("sch_1", "");
	    $keyword = getRequest("sch_2", "");
	    $schData = ["sch_1"=>$schType, "sch_2"=>$keyword];
	    
	    //리스트에 보여줄 게시물의 갯수
	    $pageSize = 10;
	    //페이징에 보여줄 페이지의 갯수
	    $blockSize = 5;
	    //쿼리로 조회 할 DB의 주소 시작번호(start) 가져올 갯수(end)
	    $startPage = ($page-1) * $pageSize;
	    $endPage = $pageSize;
	    
	    $query = $this->memberModel->member_list([
	        "keyword"=>$keyword, "start"=>$startPage, "end"=>$endPage
	    ]);
	  	    
	    $totalRecord = $query["listCount"];
	    $totalPage = ceil($totalRecord/$pageSize);
	    
	    $viewData = ["menuNum"=>800, "schData"=>$schData, "data"=>$query["list"], "totalRecord"=>$totalRecord, "page"=>$page,
	        "listFnc"=>"memberList", "blockSize"=>$blockSize, "totalPage"=>$totalPage
	    ];
	    
	    // 	    $pageData = ["listFnc"=>"eventList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage, "page"=>$page];
	    $this->load->view('/admin/member_list', $viewData);
	}
	
	public function member_form($idx=-1){
	    
	    $editMode = $idx==-1 ? "N" : "U";

	    
	    $query = $this->memberModel->member_info(["idx"=>$idx]);
	 
	    $info = [];
	    $keyVal = [
	        "idx", "member_nm", "member_type", "member_email", "cellphone", "biz_nm", "specialty", "uuid", "member_status", "signup_dt"
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
	        $info["idx"] = -1;
	        $info["member_type"] = "hcp";
	        $info["member_status"] = "hold";
	    }
	    
	    $viewData = ["menuNum"=>810, "editMode"=>$editMode, "info"=>$info];
	    
	    $this->load->view('/admin/member_form', $viewData);
	}
	
	public function member_save(){
	    
	    $before_status = getPost("before_status", "");
	    $alarm_type = getPost("editMode", "C")=="C" ? 'welcome' : '';
	    
	    $query = $this->memberModel->member_save([
	        "editMode"=> getPost("editMode", "C"),
	        "idx"=> getPost("idx", -1),
	        "member_nm" => getPost("member_nm", "Unknown"),
	        "member_type" => getPost("member_type", "hcp"),
	        "cellphone" => getPost("cellphone", ""),
	        "member_email" => getPost("member_email", ""),
	        "biz_nm" => getPost("biz_nm", ""),
	        "specialty" => getPost("specialty", ""),
	        "license_num" => getPost("license_num", ""),
	        "member_status" => getPost("member_status", "hold")
	    ]);
	    
	    if(($before_status=="hold" || $before_status=="expire") && getPost("member_status", "hold")=="active"){
	        $alarm_type = "member_active";
	    }elseif($before_status=="active" && getPost("member_status", "hold")=="expire"){
	        $alarm_type = "member_expire";
	    }
	    
	    if ( $query["result"] == "ok") {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"], 'push_msg_type'=>$alarm_type, 'idx' => $query["idx"]]);
	    } else {
	        echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"]]);
	    }
	    
	}
	
	public function user_list($page=1){
	    
	    // 	    $page = getRequest("page", 1);
	    $template_type = getRequest("sch_1", "");
	    $keyword = getRequest("sch_2", "");
	    $schData = ["sch_1"=>$template_type, "sch_2"=>$keyword];
	    
	    //리스트에 보여줄 게시물의 갯수
	    $pageSize = 10;
	    //페이징에 보여줄 페이지의 갯수
	    $blockSize = 5;
	    //쿼리로 조회 할 DB의 주소 시작번호(start) 가져올 갯수(end)
	    $startPage = ($page-1) * $pageSize;
	    $endPage = $pageSize;
	    
	    $query = $this->userModel->user_list([
	        "keyword"=>$keyword, "start"=>$startPage, "end"=>$endPage
	    ]);
	    
	    
	    $totalRecord = $query["listCount"];
	    $totalPage = ceil($totalRecord/$pageSize);
	    
	    $viewData = ["menuNum"=>900, "schData"=>$schData, "data"=>$query["list"], "totalRecord"=>$totalRecord, "page"=>$page,
	        "listFnc"=>"userList", "blockSize"=>$blockSize, "totalPage"=>$totalPage
	    ];
	    
	    // 	    $pageData = ["listFnc"=>"eventList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage, "page"=>$page];	    
	    $this->load->view('/admin/user_list', $viewData);
	    // 	    $this->load->view('/admin/inc_paging', $pageData);
	}

	public function user_form($idx=-1){
	    
// 	    $idxNo = getPost("idxNo", -1);	    
	    
	    $editMode = $idx==-1 ? "N" : "U";
	    
	    $query = $this->userModel->user_info(["idx"=>$idx]);	    
	    
	    $info = [];
	    $keyVal = [
	        "idx", "user_id", "user_pw", "user_nm", "user_email", "cellphone", "company", "dept", "user_type", "optin", "optin_dt", "use_yn"
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
	        $info["idx"] = -1;
	        $info["use_yn"] = "Y";
	        $info["user_type"] = "user";
	    }
	    
	    
	    $viewData = ["menuNum"=>910, "editMode"=>$editMode, "info"=>$info];
	    
	    $this->load->view('/admin/user_form', $viewData);
	}
	
	public function user_save(){	    

	    $query = $this->userModel->user_save([
	        "editMode"=> getPost("editMode", "N"),
	        "idx"=> getPost("idx", -1),
	        "user_id" => getPost("user_id", ""),
	        "user_pw" => getPost("user_pw", ""),
	        "user_nm" => getPost("user_nm", ""),
	        "user_email" => getPost("user_email", ""),
	        "cellphone" => getPost("cellphone", ""),
	        "company" => getPost("company", ""),
	        "dept" => getPost("dept", ""),
	        "user_type" => getPost("user_type", "user"),
	        "optin" => getPost("optin", "N"),
	        "optin_dt" => getPost("optin_dt", "Null"),
	        "optin_old" => getPost("optin_old", "N"),
	        "optin_update" => getPost("optin_update", "N"),
	        "use_yn" => getPost("use_yn", "Y")
	    ]);
	    
	    echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"]]);
	    exit;
	}
	
	public function user_duplicate_check(){
	    
	    if(getPost("user_id", "")){
	        $query = $this->userModel->chk_user_duple(getPost("user_id", ""));
	    }else {
	        echo json_encode(['result' => "error", 'msg'=>"아이디를 입력하세요"]);
	        exit;
	    }
	    
	    echo json_encode(['result' => $query["result"], 'msg'=>$query["msg"]]);
	    exit;
	    
	}
	

	public function template_list($page=1){
	    
	    // 	    $page = getRequest("page", 1);
	    $template_type = getRequest("sch_1", "");
	    $keyword = getRequest("sch_2", "");
	    $schData = ["sch_1"=>$template_type, "sch_2"=>$keyword];
	    
	    //리스트에 보여줄 게시물의 갯수
	    $pageSize = 5;
	    //페이징에 보여줄 페이지의 갯수
	    $blockSize = 5;
	    //쿼리로 조회 할 DB의 주소 시작번호(start) 가져올 갯수(end)
	    $startPage = ($page-1) * $pageSize;
	    $endPage = $pageSize;
	    
	    $query = $this->msgModel->template_list([
	        "template_type"=>$template_type, "keyword"=>$keyword, "profile_type"=>"", "start"=>$startPage, "end"=>$endPage
	    ]);
	    
	    
	    $totalRecord = $query["listCount"];
	    $totalPage = ceil($totalRecord/$pageSize);
	    
	    $viewData = ["menuNum"=>200, "schData"=>$schData, "data"=>$query["list"], "totalRecord"=>$totalRecord, "page"=>$page,
	        "listFnc"=>"templateList", "blockSize"=>$blockSize, "totalPage"=>$totalPage
	    ];
	    
	    // 	    $pageData = ["listFnc"=>"eventList()", "blockSize"=>$blockSize, "totalPage"=>$totalPage, "page"=>$page];
	    $this->load->view('/admin/template_list', $viewData);
	    // 	    $this->load->view('/admin/inc_paging', $pageData);
	}
	
	
	public function template_form($idx=-1){	    
	    
// 	    $idx = getPost("idx", -1);
	    $editMode = $idx==-1 ? "N" : "U";
	    
	    $dataProfile = [
	        ["key"=>"71f2b61aeb5a6c01fd9f10dd0a34e55d9f07d3af", "profile_nm"=>"닥터웨이브"]
	    ];
	    
	    $img_data = [
	        ["img_name"=>"뉴스안내_241119", "img_url"=>"https://mud-kage.kakao.com/dn/xRPSI/btsKOqGeRa7/QVKEY9vwUAd1NPvh3zyuJ1/img_l.jpg"],
	        ["img_name"=>"행사안내_241119", "img_url"=>"https://mud-kage.kakao.com/dn/bAZVG0/btsKNwgmdVI/Ia0cinMIxeNJB0TGIEEBK1/img_l.jpg"],
	        ["img_name"=>"온라인부스", "img_url"=>"https://mud-kage.kakao.com/dn/bnmtrK/btrZde0Mgf3/DiAEC3O5R2YfR6Y6pEv79K/img_l.jpg"],
	        ["img_name"=>"마이크로사이트", "img_url"=>"https://mud-kage.kakao.com/dn/ffQoH/btrZkzhJAsU/ebLISy9o1K62jRitT2PtlK/img_l.jpg"]
	    ];
	    
	    $query = $this->msgModel->template_info(["idx"=>$idx]);
	    $info = [];
	    $keyVal = [
	        "idx", "profile_type", "profile_key",
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
	    
// 	    $this->session_chk("admin");
	    
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
	        echo json_encode(['result' => 'ok', 'msg'=>$query["msg"], 'idx'=>$query["idx"]]);
	    } else {
	        echo json_encode(['result' => 'db_error', 'msg'=>$query["msg"]]);
	    }
	    exit;
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
