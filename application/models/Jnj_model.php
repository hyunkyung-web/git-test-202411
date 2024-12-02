<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Jnj_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function read_info($opt){
        
        $sql = "select * from tb_consent_list ";
        $sql.= "where usr_name='".$opt["usr_name"]."' and usr_phone='".$opt["usr_phone"]."' and usr_email='".$opt["usr_email"]."' ";
        
        $listCount = $this->db->query($sql)->num_rows();    
        $list = $this->db->query($sql)->result_array();
        
        return ["cnt"=>$listCount, "list"=>$list];        
        exit;
    }
    
    public function delete_info($opt){
        
        foreach($opt as $idx){
            $sql = "delete from tb_consent_list ";
            $sql.= "where idx=".$idx." ";
            $this->db->query($sql);
        }
        
        return ["result"=>"ok"];
        exit;
    }
    
    public function optin_list($opt){
        
        $strWhere = "where idx>0 ";
        
        if(trim($opt["keyword"])!=""){
            $arr_keyword = explode(' ', $opt["keyword"]);
            foreach($arr_keyword as $str){
                $strWhere.= "and (usr_name like '%".$str."%' or usr_phone like '%".$str."%' or usr_email like '%".$str."%' or office_nm like '%".$str."%' or office_address like '%".$str."%' )";
            }
        }
        
        if(trim($opt["info_type"])!=""){
            $strWhere.="and (info_type='".$opt["info_type"]."') ";
        }        
        
        $sql = "select *, (case info_type when 'owner' then '대표' else '약사' end) as info_type_nm from tb_consent_list ";
        $sql.= $strWhere;
        $listSql = "order by idx desc limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
               
        return ["listCount"=>$listCount, "list"=>$list];
        exit;
    }
    
    public function save_form($opt){
        
        $this->db->trans_begin();      
        
        $sql = "insert into tb_consent_list (";
        $sql.= "info_type,usr_name, usr_phone, usr_email, office_nm, office_zip, office_address, sign_img, agree_1, agree_2, agree_3, agree_4, rep_name, log_device, device_info, wdate) values (";
        $sql.= "'".$opt["info_type"]."','".$opt["usr_name"]."','".$opt["usr_phone"]."','".$opt["usr_email"]."', ";
        $sql.= "'".$opt["office_nm"]."','".$opt["office_zip"]."','".$opt["office_address"]."','".$opt["sign_img"]."', ";
        $sql.= "'".$opt["agree_1"]."','".$opt["agree_2"]."','".$opt["agree_3"]."','".$opt["agree_4"]."', ";
        $sql.= "'".$opt["rep_name"]."','".$opt["log_device"]."','".$opt["device_info"]."', now()) ";
        
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