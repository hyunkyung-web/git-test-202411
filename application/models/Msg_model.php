<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Msg_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function template_save($opt){
        
        $this->db->trans_begin();  
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        
        if($opt["editMode"] == "N") {
            
            $sql = "insert into tb_msg_template (";
            $sql.= "template_type, template_cd, template_nm, img_url, img_link, template_msg, profile_type, profile_key, wdate, wuser, use_yn) values (";
            $sql.= "'".$opt["template_type"]."', '".$opt["template_cd"]."', '".$opt["template_nm"]."', ";
            $sql.= "'".$opt["img_url"]."', '".$opt["img_link"]."', ";
            $sql.= "'".$opt["template_msg"]."', '".$opt["profile_type"]."', '".$opt["profile_key"]."', ";
            $sql.= "now(), '".$session_id."', 'Y') ";
            
            $data = $this->db->query($sql);
            $rtn_idx = $this->db->insert_id();

            if(is_array($opt["btn_type"])){
                $col_num = 1;
                $sql = "update tb_msg_template set ";
                
                for($i=0; $i<count($opt["btn_type"]); $i++){
                    if($opt["btn_type"][$i]!="" && $opt["btn_name"][$i]!="" && $opt["btn_link"][$i]!=""){
                        $sql.= "btn_type_".$col_num." = '".$opt["btn_type"][$i]."', ";
                        $sql.= "btn_name_".$col_num." = '".$opt["btn_name"][$i]."', ";
                        $sql.= "btn_link_".$col_num." = '".$opt["btn_link"][$i]."', ";
                        $sql.= "btn_cnt = ".$col_num.", ";
                        $col_num++;
                    }                    
                }
                for($j=$col_num; $j<=5; $j++){
                    $sql.= "btn_type_".$j." = NULL, ";
                    $sql.= "btn_name_".$j." = NULL, ";
                    $sql.= "btn_link_".$j." = NULL, ";
                }
                $sql.= "udate = now(), ";
                $sql.= "uuser = '".$session_id."' ";
                $sql.= "where idx = ".$rtn_idx;
                
                $data = $this->db->query($sql);
            }
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_msg_template set ";            
            $sql.= "template_type = '".$opt["template_type"]."', ";
            $sql.= "template_cd = '".$opt["template_cd"]."', ";
            $sql.= "template_nm = '".$opt["template_nm"]."', ";
            $sql.= "img_url = '".$opt["img_url"]."', ";
            $sql.= "img_link = '".$opt["img_link"]."', ";
            $sql.= "template_msg = '".$opt["template_msg"]."', ";
            $sql.= "profile_type = '".$opt["profile_type"]."', ";
            $sql.= "profile_key = '".$opt["profile_key"]."', ";
            
            if(is_array($opt["btn_type"])){
                $col_num = 1;
                
                for($i=0; $i<count($opt["btn_type"]); $i++){
                    if($opt["btn_type"][$i]!="" && $opt["btn_name"][$i]!="" && $opt["btn_link"][$i]!=""){
                        $sql.= "btn_type_".$col_num." = '".$opt["btn_type"][$i]."', ";
                        $sql.= "btn_name_".$col_num." = '".$opt["btn_name"][$i]."', ";
                        $sql.= "btn_link_".$col_num." = '".$opt["btn_link"][$i]."', ";
                        $sql.= "btn_cnt = ".$col_num.", ";
                        $col_num++;
                    }
                } 
                for($j=$col_num; $j<=5; $j++){
                    $sql.= "btn_type_".$j." = NULL, ";
                    $sql.= "btn_name_".$j." = NULL, ";
                    $sql.= "btn_link_".$j." = NULL, ";
                }
            }
            
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."' ";
            $sql.= "where idx=".$opt["idx"]." ";
           
            $data = $this->db->query($sql);
            $rtn_idx = $opt["idx"];
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update tb_msg_template set ";
            $sql.= "use_yn = 'N', ";            
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."' ";            
            $sql.= "where idx =".$opt["idx"]." ";
            
            $data = $this->db->query($sql);
            $rtn_idx = $opt["idx"];
        }
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            switch ($opt["editMode"]) {
                case "N":
                    $resultMsg = "new ok";
                    break;
                case "U":
                    $resultMsg = "update ok";
                    break;
                case "D":
                    $resultMsg = "delete ok";
                    break;
            }
            return ["result"=>"ok", "msg"=>$resultMsg, "rtn_idx"=>$rtn_idx];
        }    
        
        exit;
        
    }
    
    public function template_list($opt) {
    
        $strWhere = "where (use_yn is null or use_yn != 'N') ";
        
        if($opt["profile_type"] != ''){
            $strWhere.= "and (profile_type = '".$opt["profile_type"]."') ";
        }  
        
        if($opt["template_type"] != ''){
            $strWhere.= "and (template_type = '".$opt["template_type"]."') ";
        }        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (template_cd like '%".$opt["keyword"]."%' or template_nm like '%".$opt["keyword"]."%') ";
        }
        
        $sql = "select * ";
        $sql.= "from tb_msg_template ";
        $sql.= $strWhere;
        $listSql = "order by idx desc limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();            
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function template_open($opt) {
        
        $strWhere = "where idx=".$opt["idx"]." ";
        
        $sql = "select * from tb_msg_template ";
        $sql.= $strWhere;
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    public function save_sms_log($opt){
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        
        $sql = "insert into tb_sms_log (";
        $sql.= "sms_type, event_idx, to_mobile, subject, mail_body, result, remain_cnt, wdate) values (";
        $sql.= "'".$opt["sms_type"]."', ".$opt["event_idx"].", '".$opt["to_mobile"]."', '".$opt["subject"]."', '".$opt["mail_body"]."', ";
        $sql.= "'".$opt["result"]."', ".$opt["remain_cnt"].", now() )";
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

        
    public function biztalk_log($opt){
        
        $strWhere = "where a.idx > -1 ";
        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (b.template_cd like '%".$opt["keyword"]."%' or b.template_nm like '%".$opt["keyword"]."%') ";
        }
        if($opt["template_type"] != ''){
            $strWhere.= "and (b.template_type = '".$opt["template_type"]."') ";
        } 
        
        $sql = "select a.template_idx, ifnull(b.template_type, 'at') as template_type, b.template_cd, ";
        $sql.= "(case when b.template_type is null then '회원가입 승인' else b.template_nm end) as template_nm, ";
        $sql.= "a.cellphone, a.member_id, c.member_nm, a.result_code, a.result_desc, ";
        $sql.= "a.final_code, a.final_desc, a.message_key, a.wdate ";
        $sql.= "from tb_biztalk_log a ";
        $sql.= "left outer join tb_msg_template b on a.template_idx=b.idx ";
        $sql.= "left outer join round_member_list c on a.member_id=c.member_id ";
        $sql.= $strWhere;
        $listSql = "order by a.wdate desc limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
        
    }
    
    public function save_biztalk_log($opt){
        
        $this->db->trans_begin();
        
        $sql = "insert into tb_biztalk_log (template_idx, cellphone, member_nm, member_id, ref_key, message_key, result_code, result_desc, wdate) values (";
        $sql.= "'".$opt["template_idx"]."', '".$opt["cellphone"]."', '".$opt["member_nm"]."', '".$opt["member_id"]."', ";
        $sql.= "'".$opt["ref_key"]."', '".$opt["message_key"]."', '".$opt["result_code"]."', '".$opt["result_desc"]."', now() ) ";
        
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>