<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class member_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function member_list($opt) {
        
        $strWhere = "where member_id > -1 ";
        
        if(trim($opt["keyword"]) != ""){
            if(mb_strpos(trim($opt["keyword"]), '+')){
                
                $andKeyword = explode("+", $opt["keyword"]);
                
                foreach($andKeyword as $row){
                    $strWhere.= "and (member_nm like '%".trim($row)."%' or member_email like '%".trim($row)."%' ";
                    $strWhere.= "or biz_nm like '%".trim($row)."%' or cellphone like '%".trim($row)."%') ";
                }
            } elseif(mb_strpos(trim($opt["keyword"]), ',')){
                $andKeyword = explode(",", $opt["keyword"]);
                $rowCnt = 0;
                foreach($andKeyword as $row){
                    if($rowCnt==0){
                        $strWhere.= 'and ';
                    } else{
                        $strWhere.= 'or ';
                    }
                    $strWhere.= "(member_nm like '%".trim($row)."%' or member_email like '%".trim($row)."%' ";
                    $strWhere.= "or biz_nm like '%".trim($row)."%' or cellphone like '%".trim($row)."%') ";
                    
                    $rowCnt++;
                }
                
            }else{
                $strWhere.= "and (member_nm like '%".trim($opt["keyword"])."%' or member_email like '%".trim($opt["keyword"])."%' ";
                $strWhere.= "or biz_nm like '%".trim($opt["keyword"])."%' or cellphone like '%".trim($opt["keyword"])."%') ";
            }
        }        
        
        $sql = "select * ";
        $sql.= "from tb_member ";
        $sql.= $strWhere;
        $sql.= "order by member_id desc ";
        $listSql = "limit ?, ? ";
        
        $listCount = $this->db->query($sql)->num_rows();
        
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function member_info($opt) {
        
        $sql = "select * from tb_member ";
        $sql.= "where member_id=?";
        $list = $this->db->query($sql, [$opt["member_id"]])->result_array();
        
        return $list;
    }
    
    private function compare_trust_member($opt){
        
        $strWhere = "where cellphone='".$opt["cellphone"]."' ";
        $sql = "select * from tb_trust_member_list ";
        $sql.= $strWhere;
        $data_cnt = $this->db->query($sql)->num_rows();
        
        return $data_cnt;
    }
    
    public function member_save($opt){
        
        $verifyMember = $this->compare_trust_member($opt);
        $memberStatus = $verifyMember>0 ? 'active' : 'hold';

        $this->db->trans_begin();
        
        $session_id = getExist($this->session->userdata["user_id"], 'noname');
        
        if($opt["editMode"] == "N" || $opt["editMode"] == "C") {
            //신규등록 시 기존 사용자와의 아이디 중복여부 확인
            $valid_result = $this->signup_valid($opt["cellphone"]);
            
            if($valid_result["result"] != "ok"){
                return ["result"=>$valid_result["result"], "msg"=>$valid_result["msg"]];
                exit;
            }
        }
        
        $member_id = $opt["member_id"];
        
        if($opt["editMode"] == "N" || $opt["editMode"] == "C") {
            
            $sql = "insert into tb_member (member_nm, member_type, cellphone, member_email, biz_nm, specialty, uuid, signup_dt, optin, optin_dt, ";
            $sql.= "member_status, wuser, wdate) values (";
            $sql.= "'".$opt["member_nm"]."', '".$opt["member_type"]."', '".$opt["cellphone"]."', ";
            $sql.= "'".$opt["member_email"]."', '".$opt["biz_nm"]."', '".$opt["specialty"]."', '".$opt["uuid"]."', ";
            $sql.= " now(), 'Y', now(), ";
            $sql.= "'".$memberStatus."', '".$session_id."', now() ) "; 
            
            $data = $this->db->query($sql);                
            $member_id = $this->db->insert_id();
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_member set ";
            $sql.= "member_nm = '".$opt["member_nm"]."', ";
            $sql.= "member_type = '".$opt["member_type"]."', ";
            $sql.= "member_email = '".$opt["member_email"]."', ";
            $sql.= "cellphone = '".$opt["cellphone"]."', ";
            $sql.= "biz_nm = '".$opt["biz_nm"]."', ";
            $sql.= "specialty = '".$opt["specialty"]."', ";
            $sql.= "uuid = '".$opt["uuid"]."', ";
            $sql.= "member_status = '".$opt["member_status"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."' ";
            $sql.= "where member_id=".$member_id." ";
            $data = $this->db->query($sql);
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update tb_member set ";
            $sql.= "member_status = 'expire', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."' ";
            $sql.= "where member_id=".$member_id." ";
            $data = $this->db->query($sql);
        }
        
        if (!$data) {
            
            $errorMsg = $this->db->error();            
            $this->db->trans_rollback();
            
            echo $errorMsg;
            exit;
            
            return (["result"=>"DB_ERROR", "msg"=>$errorMsg]);
        } else {
            $this->db->trans_commit();
            switch ($opt["editMode"]) {
                case ($opt["editMode"]=="N" || $opt["editMode"]=="C"):
                    if($memberStatus=="active"){
                        $msg = "회원가입 완료. 가입이 승인되었습니다. 지금 바로 서비스를 이용하실 수 있습니다.";
                    }else {
                        $msg = "회원가입 완료. 가입이 승인되면 가입하신 핸드폰으로 메세지가 발송됩니다.";
                    }
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
    
    private function signup_valid($cellphone){
        
        $sql = "select * from tb_member where cellphone='".$cellphone."' ";
        $dataCnt = $this->db->query($sql)->num_rows();
        
        
        return ["result"=>$dataCnt==0 ? "ok" : "error", "msg"=>$dataCnt==0 ? "사용 가능" : "이미 회원가입 된 연락처이거나 승인 대기 중입니다."];
        exit;
    }
    
    
    
    
    public function member_address_book(){
        $sql = "select * ";
        $sql.= "from tb_member ";
        $sql.= "where member_status <> 'expire' ";
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    
    
    
    public function get_member_cellphone($opt) {
        
        $sql = "select * from tb_member ";
        $sql.= "where member_id=?";
        $list = $this->db->query($sql, $opt)->result_array();
        
        return $list;
        exit;
    }
    
    public function get_info_by_cellphone($cellphone) {
        
        $sql = "select * from tb_member ";
        $sql.= "where member_status <> 'expire' and cellphone='".$cellphone."' ";
        $sql.= "order by member_id desc limit 1 ";
        
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    private function chk_make_auth_token($cellphone, $sess_id){
        
        $strWhere = "where timestampdiff(minute, wdate, now())<=5 ";
        $strWhere.= "and cellphone='".$cellphone."' and sess_id='".$sess_id."' ";
        $strWhere.= "order by wdate desc limit 1 ";
        
        $sql = "select * from tb_auth_token ";
        $sql.= $strWhere;
        $dataCnt = $this->db->query($sql)->num_rows();
        
        if($dataCnt==0){
            return "ok";
        }else {
            return "fail";
        }
        
    }
    
    public function make_auth_token($opt){
        
        $make_valid = $this->chk_make_auth_token($opt["cellphone"], $opt["sess_id"]);
        
        if($make_valid != "ok"){
            return ["result"=>"fail", "msg"=>'인증번호를 이미 발송했습니다. 인증번호 발급은 5분에 1회 발송됩니다.'];
            exit;
        }
        
        $this->db->trans_begin();
        
        $sql = "insert into tb_auth_token (cellphone, auth_token, sess_id, wdate) values (";
        $sql.= "'".$opt["cellphone"]."', '".$opt["auth_token"]."', '".$opt["sess_id"]."', now() ) ";
        
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>"save ok"];
        }
        
        exit;
        
    }
    
    public function verify_auth_token($opt){
        
        $strWhere = "where timestampdiff(minute, wdate, now())<=5 ";
        $strWhere.= "and cellphone='".$opt["cellphone"]."' and auth_token='".$opt["auth_token"]."' and sess_id='".$opt["sess_id"]."' ";
        $strWhere.= "order by wdate desc limit 1 ";
        
        $sql = "select * from tb_auth_token ";
        $sql.= $strWhere;
        $dataCnt = $this->db->query($sql)->num_rows();
        
        if($dataCnt==1){
            return ["result"=>"ok", "msg"=>"인증번호 확인 통과"];
        }else {
            return ["result"=>"fail", "msg"=>"인증번호 확인 실패"];
        }
        
    }
    
    public function record_member_log($opt){
        
        $mobileDevice = ["iPhone", "iPod", "IEMobile", "Mobile", "lgtelecom", "PPC", "BlackBerry", "SCH-", "SPH-", "LG-", "CANU", "IM-" ,"EV-","Nokia"];
        $deviceInfo = $_SERVER['HTTP_USER_AGENT'];
        $userDevice = "PC";
        $connectIp = getRealClientIp();
        
        for ($i=0; $i <= count($mobileDevice)-1; $i++ ) {
            if ( strrpos($deviceInfo, $mobileDevice[$i]) > -1 ) {
                $userDevice = "MOBILE";
            }
        }
        
        $sql = "insert into tb_member_log (log_type, member_id, user_device, device_info, connect_ip, wdate) values ( ";
        $sql.= "'".$opt["log_type"]."', '".$opt["member_id"]."', '".$userDevice."', '".$deviceInfo."', '".$connectIp."', now() )";
        $this->db->query($sql);
    }
    
}

?>