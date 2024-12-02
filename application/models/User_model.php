<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function user_list($opt) {        
        
        $strWhere = "where a.idx > -1 ";
        
        if(trim($opt["keyword"]) != ""){
            $strWhere .= "and (a.user_id like '%".$opt["keyword"]."%' or a.user_nm like '%".$opt["keyword"]."%' or a.user_email like '%".$opt["keyword"]."%' or a.company like '%".$opt["keyword"]."%') ";
        }
        
        $sql = "select a.*, b.login_dt, b.device, b.device_info ";
        $sql.= "from tb_user_info as a ";
        $sql.= "left outer join ( ";
        $sql.= "    select user_id, wdate as login_dt, device, device_info ";
        $sql.= "    from tb_user_log ";
        $sql.= "    where idx in (select max(idx) from tb_user_log group by user_id) ";
        $sql.= ") as b on a.user_id=b.user_id ";
        $sql.= $strWhere;
        $listSql = "order by a.idx desc limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();
        
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function user_info($opt) {
        
        $sql = "select * from tb_user_info ";
        $sql.= "where idx=?";
        $list = $this->db->query($sql, [$opt["idx"]])->result_array();
        
        return $list;
        exit;
    }
    
    public function chk_user_duple($user_id){
        
        $sql = "select * from tb_user_info where user_id='".$user_id."' ";
        $dataCnt = $this->db->query($sql)->num_rows();
        
        return ["result"=>$dataCnt==0 ? "ok" : "error", "msg"=>$dataCnt==0 ? "사용 가능한 아이디 입니다." : "이미 사용중인 아이디 입니다."];
        exit;
    }
    
    public function user_save($opt){
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        
        if($opt["editMode"] == "N") {
            //신규등록 시 기존 사용자와의 아이디 중복여부 확인
            $chkDuple = $this->chk_user_duple($opt["user_id"]);
            if($chkDuple["result"] != "ok"){                
                return ["result"=>$chkDuple["result"], "msg"=>$chkDuple["msg"]];
                exit;
            }
        }
        
        $rtnIdx = $opt["idx"];
        
        if($opt["editMode"] == "N") {
            
            $sql = "insert into tb_user_info (user_id, user_pw, user_nm, user_email, company, dept, user_type, optin, optin_dt, use_yn, wuser, wdate) values (";
            $sql.= "'".$opt["user_id"]."', '".md5($opt["user_pw"])."', '".$opt["user_nm"]."', '".$opt["user_email"]."', ";
            $sql.= "'".$opt["company"]."', '".$opt["dept"]."', '".$opt["user_type"]."', '".$opt["optin"]."', ";
            if($opt["optin"]=="Y"){
                $sql.= "now(), ";
            }
            $sql.= "'".$opt["use_yn"]."', '".$session_id."', now() )";            
            $data = $this->db->query($sql);  
            
            $rtnIdx = $this->db->insert_id();
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_user_info set ";
            //암호를 변경하려고 하는 경우에만 암호필드 업데이트
            if(!empty($opt["user_pw"])){
                $sql.= "user_pw = '".md5($opt["user_pw"])."', ";
            }
            $sql.= "user_nm = '".$opt["user_nm"]."', ";
            $sql.= "user_email = '".$opt["user_email"]."', ";
            $sql.= "company = '".$opt["company"]."', ";
            $sql.= "dept = '".$opt["dept"]."', ";
            $sql.= "user_type = '".$opt["user_type"]."', ";
            $sql.= "optin = '".$opt["optin"]."', ";
            //옵트인 미동의였으나 동의함으로 변경했거나 동의함인데 재동의를 한 경우에는 옵트인 날짜를 업데이트
            if( ($opt["optin_old"]=="N" && $opt["optin"] =="Y") || $opt["optin_update"]=="Y"){
                $sql.= "optin_dt = now(), ";
            }            
            $sql.= "use_yn = '".$opt["use_yn"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '$session_id' ";
            $sql.= "where idx=".$opt["idx"]." ";
            $data = $this->db->query($sql);
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update tb_user_info set ";
            $sql.= "use_yn = 'N', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '$session_id' ";
            $sql.= "where idx=".$opt["idx"]." ";
            $data = $this->db->query($sql);
        }
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return (["result"=>"DB_ERROR", "msg"=>$errorMsg]);
        } else {
            $this->db->trans_commit();
            switch ($opt["editMode"]) {
                case "N":
                    $msg = "신규생성 완료";
                    break;
                case "U":
                    $msg = "업데이트 완료";
                    break;
                case "D":
                    $msg = "삭제 완료";
                    break;
            }
            return ["result"=>"ok", "msg"=>$msg, "rtnIdx"=>$rtnIdx];
        }
        exit;        
    }
    
    
    
    public function chk_auth_code($auth_code){
        
        $sql = "select * from tb_auth where BINARY(auth_code)='".$auth_code."' ";
        $dataCnt = $this->db->query($sql)->num_rows();
        
        return $dataCnt;
        exit;
    }
    
    
    
    
    public function user_join($opt){
        
        $this->db->trans_begin();
        $optIn = "null";
        $arrDept = ["마취통증의학과", "중환자의학과", "응급의학과"];
        if($opt["dept_cd"]==99){
            $dept_nm = $opt["txt_dept_nm"];
        }else {
            $dept_nm = $arrDept[$opt["dept_cd"]-1];
        }     
        
        if( $this->user_duple_chk($opt["user_id"]) > 0 ) {
            return ["result"=>"EXIST_ID", "msg"=>""];
            exit;
        }
        
        if( $this->chk_auth_code($opt["auth_code"]) == 0 ) {
            return ["result"=>"AUTH_ERROR", "msg"=>""];
            exit;
        }
        
        if($opt["opt_in_saved"]=="Y"){
            if($opt["opt_in"] == "Y") {
                $optIn = "opt_in";
            }
        } else{
            // 광고수신동의를 하지 않았던 사용자는 수신동의를 Y를 체크하면 수신동의 날짜를 현재날짜로 업데이트
            if($opt["opt_in"]=="Y"){
                $optIn = "now()";
            }
        }
        
        $sql = "insert into tb_user (user_id, user_pw, user_nm, user_email, biz_cd, biz_nm, dept_cd, dept_nm, use_yn, opt_in, admin_yn, wdate, wuser) values (";
        $sql.= "'".$opt["user_id"]."', '".md5($opt["user_pw"])."', '".$opt["user_nm"]."', '".$opt["user_email"]."', ";
        $sql.= "'".$opt["biz_cd"]."', '".$opt["biz_nm"]."', '".$opt["dept_cd"]."', '".$dept_nm."', 'Y', $optIn, '".$opt["admin_yn"]."', now(), 'SYSTEM') ";
        $data = $this->db->query($sql);
        
        $rtnIdx = $this->db->insert_id();
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$errorMsg));
        } else {
            $this->db->trans_commit();
            $resultMsg = "NEW_OK";
            return ["result"=>$resultMsg, "msg"=>"", "rtnIdx"=>$rtnIdx];
        }        
        
        exit;
        
    }
    
    public function user_confirm($opt) {
        
        $conn_ip = getRealClientIp();
        
        if($opt["login_type"]=="login"){
            
            
            $strWhere_1 = "where user_type='".$opt["user_type"]."' and use_yn='Y' and user_id='".$opt["user_id"]."' ";
            $strWhere_2 = " and user_pw='".md5($opt["user_pw"])."' " ;
            
            
            $sql = "select * from tb_user_info ";
            
            $idCnt = $this->db->query($sql.$strWhere_1)->num_rows();
            $userConfirm = $this->db->query($sql.$strWhere_1.$strWhere_2)->num_rows();
            $list = $this->db->query($sql.$strWhere_1.$strWhere_2)->result_array();
            
            if($userConfirm==1){
                $sql = "insert into tb_user_log (user_id, login_type, login_home, device, device_info, log_ip, wdate) values ( ";
                $sql.= "'".$opt["user_id"]."', '".$opt["login_type"]."', '".$opt["user_type"]."', '".$opt["userDevice"]."', '".$opt["deviceInfo"]."', ";
                $sql.= "'".$conn_ip."', now() )";
                $data = $this->db->query($sql);
            }
            
            return ["idCnt" => $idCnt, "userConfirm"=>$userConfirm, "list"=>$list];
            exit;
            
        } elseif($opt["login_type"]=="logout"){
            
            $sql = "insert into tb_user_log (user_id, login_type, device, device_info, log_ip, wdate) values ( ";
            $sql.= "'".$opt["user_id"]."', '".$opt["login_type"]."', '".$opt["userDevice"]."', '".$opt["deviceInfo"]."', ";
            $sql.= "'".$conn_ip."', now() )";
            $data = $this->db->query($sql);
            
            return ["idCnt" => 1, "userConfirm"=>1];
            exit;
        }
    }
    
    
    public function info() {
        
        $sql = "select * from tb_user ";
        $sql.= "where idx=?";
        $list = $this->db->query($sql, [$this->session->userdata["user_idx"]])->result_array();
        
        return $list;
        exit;
    }

    
    public function profile_save($opt) {
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];        
        $optIn = "null";
        $arrDept = ["마취통증의학과", "중환자의학과", "응급의학과"];
        if($opt["dept_cd"]==99){
            $dept_nm = $opt["txt_dept_nm"];
        }else {
            $dept_nm = $arrDept[$opt["dept_cd"]-1];
        }       
        
        // 광고수신동의 했던 사용자인 경우 수신동의에 Y가 들어오면 기존 날짜를 그대로 덮어씌운다
        if($opt["opt_in_saved"]=="Y"){
            if($opt["opt_in"] == "Y") {
                $optIn = "opt_in";
            }
        } else{
            // 광고수신동의를 하지 않았던 사용자는 수신동의를 Y를 체크하면 수신동의 날짜를 현재날짜로 업데이트
            if($opt["opt_in"]=="Y"){
                $optIn = "now()";
            }
        }        
        
        $sql = "update tb_user set ";
        $sql.= "user_nm = '".$opt["user_nm"]."', ";
        $sql.= "user_email = '".$opt["user_email"]."', ";
        $sql.= "biz_nm = '".$opt["biz_nm"]."', ";
        $sql.= "dept_cd = '".$opt["dept_cd"]."', ";        
        $sql.= "dept_nm = '".$dept_nm."', ";
        $sql.= "opt_in = $optIn, ";
        $sql.= "udate = now(), ";
        $sql.= "uuser = '$session_id' ";
        $sql.= "where idx=".$opt["idx"]." and user_id='".$opt["user_id"]."' ";
        $data = $this->db->query($sql);        
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$errorMsg));
        } else {
            $this->db->trans_commit();
            $resultMsg = "UPDATE_OK";
            return ["result"=>$resultMsg, "msg"=>""];
        }        
        
        exit;
        
    }
    
    public function update_password($opt) {
        
        $this->db->trans_begin();
        $session_id = $this->session->userdata["user_id"];
        
        $sql = "update tb_user set ";
        $sql.= "user_pw = '".md5($opt["user_pw"])."', ";
        $sql.= "udate = now(), ";
        $sql.= "uuser = '$session_id' ";
        $sql.= "where idx=".$opt["idx"]." and user_id='".$opt["user_id"]."' ";
        
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$errorMsg));
        } else {
            $this->db->trans_commit();
            $resultMsg = "UPDATE_OK";
            return ["result"=>$resultMsg, "msg"=>""];
        }        
        
        exit;
    }
    
    public function user_reset($opt){
        
        $resetPw = (string)time();
        
        $userChk = "select * from tb_user ";
        $userChk .= "where user_id='".$opt["user_id"]."' and user_email='".$opt["user_email"]."' ";
        $chkCount = $this->db->query($userChk)->num_rows();
        
        if($chkCount == 1){
            $sql = "update tb_user set ";
            $sql.= "user_pw = '".md5($resetPw)."' ";
            $sql.= "where user_id='".$opt["user_id"]."' and user_email='".$opt["user_email"]."' ";
            
            $data = $this->db->query($sql);
            
            return (array("result"=>"CHANGE_OK", "msg"=>$resetPw));
        } else {
            return (array("result"=>"NO_MATCH"));
        }
        
        exit;
    }
    
    public function auth_code() {
        
        $sql = "select * from tb_auth order by idx desc";
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function save_email_log($opt) {
        
        $sql = "insert into tb_email_log (user_id, email_id, mail_msg, wdate) values (";
        $sql.= "'".$opt["user_id"]."', '".$opt["email_id"]."', '".$opt["mail_msg"]."', now()) ";
        $data = $this->db->query($sql);        
    }
    
    
    
    public function auth_save($opt) {
        
        $this->db->trans_begin();
        $session_id = $this->session->userdata["user_id"];
        
        if($opt["editMode"]=="N"){
            $sql = "insert into tb_auth (auth_code, auth_desc, wdate, wuser) values (";
            $sql.= "'".$opt["txtAuthCode"]."', '".$opt["txtAuthDesc"]."', now(), '$session_id') ";
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_auth set ";
            $sql.= "auth_code = '".$opt["txtAuthCode"]."', ";
            $sql.= "auth_desc = '".$opt["txtAuthDesc"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '$session_id' ";
            $sql.= "where idx=".$opt["authIdx"];
        } elseif($opt["editMode"]=="D"){
            $sql = "delete from tb_auth ";
            $sql.= "where idx=".$opt["authIdx"];
        }
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$errorMsg));
        } else {
            $this->db->trans_commit();
            
            switch ($opt["editMode"]) {
                case "N":
                    $resultMsg = "NEW_OK";
                    break;
                case "U":
                    $resultMsg = "UPDATE_OK";
                    break;
                case "D":
                    $resultMsg = "DELETE_OK";
                    break;
            }
            return ["result"=>$resultMsg, "msg"=>""];
        }
        
        exit;
    }
    
    
    
}

?>