<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Utm_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function save_utm_log($opt){
        
        
        $this->db->trans_begin();  
        
        $sql = "INSERT INTO sample_utm_log ";
        $sql.= "(utm_source, utm_medium, utm_campaign, utm_uid, utm_email, ";
        $sql.= "page_title, page_url, log_ip, device_info, device_model, ";
        $sql.= "device_type, mail_seq, cate_1, cate_2, cate_3, cate_4, cate_5, wdate) VALUES (";
        $sql.= "'".$opt["utm_source"]."', '".$opt["utm_medium"]."', '".$opt["utm_campaign"]."', '".$opt["utm_uid"]."', '".$opt["utm_email"]."', ";
        $sql.= "'".$opt["page_title"]."', '".$opt["page_url"]."', '".$opt["log_ip"]."', '".$opt["device_info"]."', '".$opt["device_model"]."', ";
        $sql.= "'".$opt["device_type"]."', '".$opt["mail_seq"]."', '".$opt["cate_1"]."', '".$opt["cate_2"]."', '".$opt["cate_3"]."', ";
        $sql.= "'".$opt["cate_4"]."', '".$opt["cate_5"]."', now() )";
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            $resultMsg = "save log complete";
            return ["result"=>"ok", "msg"=>$resultMsg];
        }    
        
        exit;
        
    }
    
    public function list($opt){
        
        $strWhere = "where idx > 0 ";
        
        if($opt["sch_dt1"] != '' && $opt["sch_dt2"] != ''){
            $strWhere.= "and (date_format(wdate, '%Y-%m-%d') between '".$opt["sch_dt1"]."' and '".$opt["sch_dt2"]."') ";
        } 
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (utm_source like '%".$opt["keyword"]."%' or utm_medium like '%".$opt["keyword"]."%' or utm_campaign like '%".$opt["keyword"]."%' or ";
            $strWhere.= "utm_uid like '%".$opt["keyword"]."%' or utm_email like '%".$opt["keyword"]."%' or page_url like '%".$opt["keyword"]."%' or ";
            $strWhere.= "cate_1 like '%".$opt["keyword"]."%' or cate_2 like '%".$opt["keyword"]."%' or cate_3 like '%".$opt["keyword"]."%' or ";
            $strWhere.= "cate_4 like '%".$opt["keyword"]."%' or cate_5 like '%".$opt["keyword"]."%') ";
        }
              
        $sql = "select * from sample_utm_log ";
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
    
    
    public function dashboard($opt){
        
        $groupWhere = "";
        $selectItem = "";
        
        $strWhere = "where idx > 0 ";
        
        if($opt["sch_dt1"] != '' && $opt["sch_dt2"] != ''){
            $strWhere.= "and (date_format(wdate, '%Y-%m-%d') between '".$opt["sch_dt1"]."' and '".$opt["sch_dt2"]."') ";
        }
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (utm_source like '%".$opt["keyword"]."%' or utm_medium like '%".$opt["keyword"]."%' or utm_campaign like '%".$opt["keyword"]."%' or ";
            $strWhere.= "utm_uid like '%".$opt["keyword"]."%' or utm_email like '%".$opt["keyword"]."%' or page_url like '%".$opt["keyword"]."%' or ";
            $strWhere.= "cate_1 like '%".$opt["keyword"]."%' or cate_2 like '%".$opt["keyword"]."%' or cate_3 like '%".$opt["keyword"]."%' or ";
            $strWhere.= "cate_4 like '%".$opt["keyword"]."%' or cate_5 like '%".$opt["keyword"]."%') ";
        }        
        
        if(trim($opt["groupby_item"]) != ""){
            $groupWhere.= "group by ".$opt["groupby_item"]." ";
            $selectItem.= $opt["groupby_item"].', count(0) as item_cnt ';
        } else {
            $selectItem = "* ";
        }
        
        $sql = "select date_format(wdate, '%Y-%m-%d') as log_dt, count(0) as item_cnt ";
        $sql.= "from (";
        $sql.= "select * from sample_utm_log ";
        $sql.= $strWhere;
        $sql.= ") as x ";
        $sql.= "group by date_format(wdate, '%Y-%m-%d')";
        $dayList = $this->db->query($sql)->result_array();
        
        $sql = "select utm_medium, count(0) as item_cnt ";
        $sql.= "from (";
        $sql.= "select * from sample_utm_log ";
        $sql.= $strWhere;
        $sql.= ") as x ";
        $sql.= "group by utm_medium";
        $mediumList = $this->db->query($sql)->result_array();
        
        $sql = "select device_type, count(0) as item_cnt ";
        $sql.= "from (";
        $sql.= "select * from sample_utm_log ";
        $sql.= $strWhere;
        $sql.= ") as x ";
        $sql.= "group by device_type";
        $deviceList = $this->db->query($sql)->result_array();
        
        $sql = "select ".$selectItem;
        $sql.= "from (";
        $sql.= "select * from sample_utm_log ";
        $sql.= $strWhere;
        $sql.= ") as x ";
        $sql.= $groupWhere;
        
        $groupList = $this->db->query($sql)->result_array();
        
        return array('groupList'=>$groupList, 'dayList'=>$dayList, 'mediumList'=>$mediumList, 'deviceList'=>$deviceList);
        exit;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>