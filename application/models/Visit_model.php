<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Visit_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function reservation_list($opt) {
        
        $strWhere = "where idx > 0 ";
        $strWhere.= " and (hcp_email = '".$opt["hcp_email"]."') ";
        $strWhere.= " and (req_dt between '".$opt["sch_dt_1"]."' and '".$opt["sch_dt_2"]."' )";
        
        $sql = "select * from tb_visit_reservation ";
        $sql.= $strWhere;
        $listSql = "order by req_dt ";
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql.$listSql)->result_array();
        return array('list'=>$list, 'listCount'=>$listCount);
        exit;
    }
    
    
    public function reservation_save($opt) {
        
        $this->db->trans_begin();
        
        $deviceType = $_SERVER['HTTP_USER_AGENT'];        
        
        //방문요청 등록
        if ($opt["editMode"] == "N" ){
            $sql = " insert into tb_visit_reservation (hcp_email, hcp_nm, req_dt, req_time, req_desc, rep_email, doc_id, biz_cd, agent_info, wdate) values ( ";
            $sql.= " '".$opt["hcp_email"]."', ";
            $sql.= " '".$opt["hcp_nm"]."', ";
            $sql.= " '".$opt["req_dt"]."', ";
            $sql.= " '".$opt["req_time"]."',";
            $sql.= " '".$opt["req_desc"]."', ";
            $sql.= " '".$opt["rep_email"]."', ";
            $sql.= " '".$opt["doc_id"]."', ";
            $sql.= " '".$opt["biz_cd"]."', ";
            $sql.= " '".$deviceType."',";
            $sql.= " now() ) ";
            
            $data = $this->db->query($sql);
            
            $rtnIdxNo = $this->db->insert_id();
        }
        
        //메일발송 후 발송 플래그 처리
        else if ($opt["editMode"] == "U" ) {
            $sql = "update tb_visit_reservation set ";
            $sql.= "send_result = '".$opt["send_result"]."' ";
            $sql.= "where idx=".$opt["idx_no"]."";
            $data = $this->db->query($sql);
            
            $rtnIdxNo = $opt["idx_no"];
        }
        
        if (!$data) {
            $errorMsg = $this->db->_error_message();
            $errorNum = $this->db->_error_number();
            $rtnError = $errorMsg.'[error code:'.$errorNum.']';
            $this->db->trans_rollback();
            return (array("result"=>"DB_ERROR", "msg"=>$rtnError));
        } else {
            $this->db->trans_commit();
            return array("result"=>"ok", "msg"=>"ok", "rtnIdxNo"=>$rtnIdxNo);
        }
        exit;
    }
    
    public function admin_list($opt) {
        
        
        
        $strWhere = "where (req_dt between '".$opt["s_date"]."' and '".$opt["e_date"]."') ";
        
        if($opt["keyword"] != '' ){
            $strWhere.= "and (hcp_nm like '%".$opt["keyword"]."%' or hcp_email like '%".$opt["keyword"]."%' or rep_email like '%".$opt["keyword"]."%' or biz_cd like '%".$opt["keyword"]."%' ) ";
        }
        
        $sql = "select * from tb_visit_reservation ";
        $sql.= $strWhere;
        $sql.= "order by req_dt desc ";
        $listSql = "limit ?, ? ";
        
        $listCount = $this->db->query($sql)->num_rows();        
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        } else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return array('list'=>$list, 'listCount'=>$listCount);
        exit;
    }
    
    public function record_visit_log($opt) {
        
        $this->db->trans_begin();
        
        $deviceType = $_SERVER['HTTP_USER_AGENT'];
        
        $sql = " insert into tb_visit_log (hcp_email, hcp_nm, rep_email, doc_id, biz_cd, device_info, wdate) values ( ";
        $sql.= " '".$opt["hcp_email"]."', ";
        $sql.= " '".$opt["hcp_nm"]."', ";
        $sql.= " '".$opt["rep_email"]."', ";
        $sql.= " '".$opt["doc_id"]."',";
        $sql.= " '".$opt["biz_cd"]."', ";
        $sql.= " '".$deviceType."',";
        $sql.= " now() ) ";

        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->_error_message();
            $errorNum = $this->db->_error_number();
            $rtnError = $errorMsg.'[error code:'.$errorNum.']';
            $this->db->trans_rollback();
            return (array("result"=>"fail", "msg"=>$rtnError));
        } else {
            $this->db->trans_commit();
            return array("result"=>"ok", "msg"=>"ok");
        }
        exit;
    }
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>