<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class member_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function member_list($opt) {   
        
        $strWhere = "where member_id > -1 ";
        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (member_nm like '%".$opt["keyword"]."%' or email_addr like '%".$opt["keyword"]."%' ";
            $strWhere.= "or biz_nm like '%".$opt["keyword"]."%' or cellphone like '%".$opt["keyword"]."%') ";
        }
        
        $sql = "select * ";
        $sql.= "from round_member_list ";
        $sql.= $strWhere;
        $listSql = "order by member_id desc limit ?, ?";    
        
        $listCount = $this->db->query($sql)->num_rows();
        
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function member_address_book(){
        $sql = "select * ";
        $sql.= "from round_member_list ";
        $sql.= "where member_status <> 'expire' ";
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    
    public function member_info($opt) {
        
        $sql = "select * from round_member_list ";
        $sql.= "where member_id=?";
        $list = $this->db->query($sql, [$opt["member_id"]])->result_array();
        
        return $list;
        exit;
    }
    
    public function get_member_cellphone($opt) {
        
        $sql = "select * from round_member_list ";
        $sql.= "where member_id=?";
        $list = $this->db->query($sql, $opt)->result_array();
        
        return $list;
        exit;
    }
    
    public function get_member_id($opt) {
        
        $sql = "select * from round_member_list ";
        $sql.= "where member_status <> 'expire' and cellphone=?";        
        $list = $this->db->query($sql, $opt)->result_array();
        
        return $list;
        exit;
    }
    
    private function create_valid($cellphone){
        
        $sql = "select * from round_member_list where cellphone='".$cellphone."' ";
        $dataCnt = $this->db->query($sql)->num_rows();

        
        return ["result"=>$dataCnt==0 ? "ok" : "error", "msg"=>$dataCnt==0 ? "사용 가능" : "사용중인 연락처입니다."];
        exit;
    }
    
    public function member_save($opt){
        
        $this->db->trans_begin();
        
        if($opt["editMode"] == "N"||$opt["editMode"] == "C") {          
            //신규등록 시 기존 사용자와의 아이디 중복여부 확인
            $valid_result = $this->create_valid($opt["cellphone"]);
            
            if($valid_result["result"] != "ok"){                
                return ["result"=>$valid_result["result"], "msg"=>$valid_result["msg"]];
                exit;
            }
        }
        
        $member_id = $opt["member_id"];
        
        if($opt["editMode"] == "N"||$opt["editMode"]=="C") {
            
            $sql = "insert into round_member_list (member_nm, member_type, cellphone, email_addr, biz_nm, specialty, license_num, signup_dt, optin, optin_dt, ";
            $sql.= "member_status, wuser, wdate) values (";
            $sql.= "'".$opt["member_nm"]."', '".$opt["member_type"]."', '".$opt["cellphone"]."', ";
            $sql.= "'".$opt["email_addr"]."', '".$opt["biz_nm"]."', '".$opt["specialty"]."', '".$opt["license_num"]."', ";            
            $sql.= " now(), 'Y', now(), ";

            
            if($opt["editMode"]=="C"){
                $sql.= "'hold', 'SYSTEM', now() ) ";
            } else {
                $sql.= "'hold', '".$this->session->userdata["user_id"]."', now() ) ";
            }
            
            $data = $this->db->query($sql);            
            $member_id = $this->db->insert_id();
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update round_member_list set ";            
            $sql.= "member_nm = '".$opt["member_nm"]."', ";            
            $sql.= "email_addr = '".$opt["email_addr"]."', ";
            $sql.= "cellphone = '".$opt["cellphone"]."', ";            
            $sql.= "biz_nm = '".$opt["biz_nm"]."', ";
            $sql.= "specialty = '".$opt["specialty"]."', ";
            $sql.= "license_num = '".$opt["license_num"]."', ";
            $sql.= "member_status = '".$opt["member_status"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$this->session->userdata["user_id"]."' ";
            $sql.= "where member_id=".$member_id." ";
            $data = $this->db->query($sql);
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update round_member_list set ";
            $sql.= "member_status = 'expire', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$this->session->userdata["user_id"]."' ";
            $sql.= "where member_id=".$member_id." ";
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
                case "C":
                    $msg = "회원가입 완료. 가입이 승인되면 가입하신 핸드폰으로 메세지가 발송됩니다.";
                    break;
                case "U":
                    $msg = "업데이트 완료";
                    break;
                case "D":
                    $msg = "삭제 완료";
                    break;
            }
            return ["result"=>"ok", "msg"=>$msg, "member_id"=>$member_id];
        }
        exit;        
    }
    
    
    
    public function chk_auth_code($auth_code){
        
        $sql = "select * from tb_auth where BINARY(auth_code)='".$auth_code."' ";
        $dataCnt = $this->db->query($sql)->num_rows();
        
        return $dataCnt;
        exit;
    }    
    
    public function member_valid($opt) {
        
        $conn_ip = getRealClientIp();
        
        if($opt["login_type"]=="login"){
            
            
            $strWhere = "where member_nm='".$opt["member_nm"]."' and cellphone='".$opt["cellphone"]."' ";
            $strWhere_1 = "and member_status='active' " ;
            
            $sql = "select * from round_member_list ";
            
            $member_cnt = $this->db->query($sql.$strWhere)->num_rows();
            $valid_cnt = $this->db->query($sql.$strWhere.$strWhere_1)->num_rows();
            $list = $this->db->query($sql.$strWhere)->result_array();
            
            if($valid_cnt==1){
                $member_id = $list[0]["member_id"];
                $sql = "insert into round_member_log (log_type, member_id, member_nm, user_device, device_info, log_ip, wdate) values ( ";
                $sql.= "'LOGIN', '".$member_id."', '".$opt["member_nm"]."', '".$opt["user_device"]."', '".$opt["device_info"]."', ";
                $sql.= "'".$conn_ip."', now() )";                
                $data = $this->db->query($sql);
                
                return ["valid_result"=>"true", "list"=>$list];
                
            }else {
                if($member_cnt == 1){
                    return ["valid_result"=>"hold", "list"=>$list];
                }
                else {
                    return ["valid_result"=>"false", "list"=>$list];
                }
            }
            
            
            exit;
            
        } elseif($opt["login_type"]=="logout"){
            
            $sql = "insert into round_member_log (log_type, member_id, member_nm, user_device, device_info, log_ip, wdate) values ( ";
            $sql.= "'LOGOUT', '".$opt["member_id"]."', '".$opt["member_nm"]."', '".$opt["user_device"]."', '".$opt["device_info"]."', ";
            $sql.= "'".$conn_ip."', now() )";
            $data = $this->db->query($sql);
            
            return ["valid_result"=>$userConfirm, "list"=>$list];
            exit;
        }
    }
    
    
    public function info() {
        
        $sql = "select * from tb_user ";
        $sql.= "where idx=?";
        $list = $this->db->query($sql, [$this->session->userdata["member_idx"]])->result_array();
        
        return $list;
        exit;
    }

    
    public function profile_save($opt) {
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["member_id"];        
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
        $sql.= "member_nm = '".$opt["member_nm"]."', ";
        $sql.= "member_email = '".$opt["member_email"]."', ";
        $sql.= "biz_nm = '".$opt["biz_nm"]."', ";
        $sql.= "dept_cd = '".$opt["dept_cd"]."', ";        
        $sql.= "dept_nm = '".$dept_nm."', ";
        $sql.= "opt_in = $optIn, ";
        $sql.= "udate = now(), ";
        $sql.= "uuser = '$session_id' ";
        $sql.= "where idx=".$opt["idx"]." and member_id='".$opt["member_id"]."' ";
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
        $session_id = $this->session->userdata["member_id"];
        
        $sql = "update tb_user set ";
        $sql.= "member_pw = '".md5($opt["member_pw"])."', ";
        $sql.= "udate = now(), ";
        $sql.= "uuser = '$session_id' ";
        $sql.= "where idx=".$opt["idx"]." and member_id='".$opt["member_id"]."' ";
        
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
    
    public function member_reset($opt){
        
        $resetPw = (string)time();
        
        $userChk = "select * from tb_user ";
        $userChk .= "where member_id='".$opt["member_id"]."' and member_email='".$opt["member_email"]."' ";
        $chkCount = $this->db->query($userChk)->num_rows();
        
        if($chkCount == 1){
            $sql = "update tb_user set ";
            $sql.= "member_pw = '".md5($resetPw)."' ";
            $sql.= "where member_id='".$opt["member_id"]."' and member_email='".$opt["member_email"]."' ";
            
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
        
        $sql = "insert into tb_email_log (member_id, email_id, mail_msg, wdate) values (";
        $sql.= "'".$opt["member_id"]."', '".$opt["email_id"]."', '".$opt["mail_msg"]."', now()) ";
        $data = $this->db->query($sql);        
    }
    
    
    
    public function auth_save($opt) {
        
        $this->db->trans_begin();
        $session_id = $this->session->userdata["member_id"];
        
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