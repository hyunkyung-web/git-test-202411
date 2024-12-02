<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Qlink_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function list($opt) {
        
        $strWhere = "where idx > 0 ";
        $strWhere.= " and (title like '%".$opt["keyword"]."%' or target_url like '%".$opt["keyword"]."%' or short_url like '%".$opt["keyword"]."%') ";
        
        $sql = "select * from tb_qlink_list ";
        $sql.= $strWhere;
        $sql.= "order by wdate desc ";
        $listSql = "limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        } else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return array('list'=>$list, 'listCount'=>$listCount);
        exit;
    }
    
    public function chk_hash_key($valid_key){
        $sql = "select * from tb_qlink_list where hash_key = '".$valid_key."' ";        
        $listCount = $this->db->query($sql)->num_rows();
      
        if($listCount == 0){
            return true;
        } else {
            return false;
        }
        
    }
    
    public function info($idx) {
        
        $sql = "select * from tb_qlink_list where idx=".$idx;        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return array('list'=>$list, 'listCount'=>$listCount);
        exit;
    }
    
    
    public function save($opt) {
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        $conn_ip = getRealClientIp();

        if ($opt["editMode"] == "N" ){
            $sql = " insert into tb_qlink_list (title, hash_key, target_url, short_url, expire_dt, use_yn, log_ip, wuser, wdate) values ( ";
            $sql.= " '".$opt["title"]."', ";
            $sql.= " '".$opt["hash_key"]."', ";
            $sql.= " '".$opt["target_url"]."', ";
            $sql.= " '".$opt["short_url"]."',";
            $sql.= " '".$opt["expire_dt"]."', ";
            $sql.= " '".$opt["use_yn"]."', ";
            $sql.= " '".$conn_ip."', ";
            $sql.= " '".$session_id."', ";
            $sql.= " now() ) ";            
            $data = $this->db->query($sql);
        }
        
        //메일발송 후 발송 플래그 처리
        elseif ($opt["editMode"] == "U" ) {
            $sql = "update tb_qlink_list set ";
            $sql.= "title = '".$opt["title"]."', ";
            $sql.= "target_url = '".$opt["target_url"]."', ";
            $sql.= "expire_dt = '".$opt["expire_dt"]."', ";
            $sql.= "use_yn = '".$opt["use_yn"]."', ";
            $sql.= "log_ip = '".$conn_ip."', ";
            $sql.= "uuser = '".$session_id."', ";
            $sql.= "udate = now() ";
            $sql.= "where idx=".$opt["idx"]."";
            $data = $this->db->query($sql);
        }
        
        if (!$data) {
            $errorMsg = $this->db->_error_message();
            $errorNum = $this->db->_error_number();
            $rtnError = $errorMsg.'[error code:'.$errorNum.']';
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$rtnError));
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>"save ok"];
        }
        exit;
    }
    
    function get_url($hashKey){
        
        $strWhere = "where use_yn='Y' and expire_dt>='".date('Y-m-d')."' ";
        $strWhere.= "and hash_key='".$hashKey."' ";     
        
        $sql = "select * from tb_qlink_list ";
        $sql.= $strWhere;
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        if($listCount == 1){
            $usql = "update tb_qlink_list set log_cnt = ifnull(log_cnt, 0)+1 ";
            $usql.= $strWhere;
            $updateCnt = $this->db->query($usql);
            
            $result = true;
            $targetUrl = $list[0]["target_url"];
            $msg = "ok";
        } else {
            $result = false;
            $targetUrl = "";
            $msg = "등록되지 않았거나 만료 된 URL입니다. 다시 확인해주세요.";
        }
        
        return ["result"=>$result, "target_url"=>$targetUrl, "msg"=>$msg];
        exit;
        
    }
    
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>