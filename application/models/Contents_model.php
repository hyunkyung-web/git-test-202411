<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Contents_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function contents_list($opt) {
        
        $strWhere = "where idx > -1 ";
        
        if(trim($opt["contents_type"]!="")){
            $strWhere.= "and contents_type='".$opt["contents_type"]."' ";
        }
        
        if(trim($opt["keyword"]) != ""){
            if(mb_strpos(trim($opt["keyword"]), '+')){
                
                $andKeyword = explode("+", $opt["keyword"]);
                
                foreach($andKeyword as $row){
                    $strWhere.= "and (title like '%".trim($row)."%' or body_text like '%".trim($row)."%') ";
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
                    $strWhere.= "(title like '%".trim($row)."%' or body_text like '%".trim($row)."%') ";
                    
                    $rowCnt++;
                }
                
            }else{
                $strWhere.= "and (title like '%".trim($opt["keyword"])."%' or body_text like '%".trim($opt["keyword"])."%') ";
            }
        }
        
        $sql = "select * ";
        $sql.= "from tb_contents ";
        $sql.= $strWhere;
        $sql.= "order by idx desc";
        $listSql = "limit ?, ?";
        
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
            
            $sql = "insert into tb_contents (";
            $sql.= "contents_type, title, description, body_text, attach_file, wdate, wuser) values (";
            $sql.= "'".$opt["contents_type"]."', '".$opt["title"]."', '".$opt["description"]."', '".$opt["body_text"]."', '".$opt["attach_file"]."', ";
            $sql.= "now(), '".$session_id."') ";
            
            $data = $this->db->query($sql);
            $rtn_idx = $this->db->insert_id();
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_contents set ";            
            $sql.= "contents_type = '".$opt["contents_type"]."', ";
            $sql.= "title = '".$opt["title"]."', ";
            $sql.= "description = '".$opt["description"]."', ";
            $sql.= "body_text = '".$opt["body_text"]."', ";
            $sql.= "attach_file = '".$opt["attach_file"]."', ";            
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."' ";
            $sql.= "where idx=".$opt["idx"]." ";
           
            $data = $this->db->query($sql);
            $rtn_idx = $opt["idx"];
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update tb_contents set ";
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
    
    public function save_reply($opt){        
       
        $this->db->trans_begin();  
        
        if($opt["editMode"]=="N"){
            $sql = "insert into tb_contents_reply (contents_idx, member_id, member_nm, reply_text, wdate) values (";
            $sql.= "".$opt["contents_idx"].", ".$this->session->userdata["member_id"].", '".$this->session->userdata["member_nm"]."', ";
            $sql.= "'".$opt["reply_text"]."', now()) ";
            $data = $this->db->query($sql);
        }elseif($opt["editMode"]=="D"){
            $sql = "delete from tb_contents_reply ";
            $sql.= "where idx=".$opt["idx"];
            $data = $this->db->query($sql);
        }        
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();            
            return ["result"=>"ok", "msg"=>"ok"];
        }
        
        exit;
    }
    
    public function ajax_reply_like_list($opt){
        
        $strWhere = "where contents_idx=".$opt["contents_idx"]." ";
        
        $sql = "select * from tb_contents_reply ";
        $sql.= $strWhere;
        $sql.= "order by wdate asc ";
        $reply_list = $this->db->query($sql)->result_array();        
        $reply_cnt = $this->db->query($sql)->num_rows();
        
        $sql = "select * from tb_contents_like ";
        $sql.= $strWhere;
        $like_list = $this->db->query($sql)->result_array();
        $like_cnt = $this->db->query($sql)->num_rows();
        
        $sql = "select * from tb_contents_like ";
        $sql.= $strWhere;
        $sql.= "and member_id=".$this->session->userdata["member_id"]." ";        
        $my_like_cnt = $this->db->query($sql)->num_rows();
        
        return ["reply_list"=>$reply_list, "reply_cnt" => $reply_cnt, "like_list"=>$like_list, "like_cnt" => $like_cnt, "my_like_cnt"=>$my_like_cnt];
        exit;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>