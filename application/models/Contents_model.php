<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Contents_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function contents_list($opt) {
        
        $strWhere = "where idx > -1 ";
        
        if(trim($opt["keyword"]) != ""){
            if(mb_strpos(trim($opt["keyword"]), '+')){
                
                $andKeyword = explode("+", $opt["keyword"]);
                
                foreach($andKeyword as $row){
                    $strWhere.= "and (title like '%".trim($row)."%' or context like '%".trim($row)."%') ";
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
                    $strWhere.= "(title like '%".trim($row)."%' or context like '%".trim($row)."%') ";
                    
                    $rowCnt++;
                }
                
            }else{
                $strWhere.= "and (title like '%".trim($opt["keyword"])."%' or context like '%".trim($opt["keyword"])."%') ";
            }
        }
        
        $sql = "select * ";
        $sql.= "from tb_contents ";
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
    
    public function contents_info($opt) {
        
        $strWhere = "where idx=".$opt["idx"]." ";
        
        $sql = "select * from tb_contents ";
        $sql.= $strWhere;
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    public function contents_save($opt){
        
        $this->db->trans_begin();  
        
        $session_id = getExist($this->session->userdata["user_id"], 'noname');
        
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
            return ["result"=>"error", "msg"=>$errorMsg];
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
            return ["result"=>"ok", "msg"=>$resultMsg, "idx"=>$rtn_idx];
        }    
        
        exit;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>