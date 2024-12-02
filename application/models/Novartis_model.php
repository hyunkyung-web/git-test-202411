<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Novartis_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function save_survey($opt){
        
        $this->db->trans_begin();
        
        for($i=0; $i<count($opt["survey_q"]); $i++){
            $sql = "insert into tb_survey_202410 (survey_q, survey_a, usr_id, wdate) values (";
            $sql.= "'".$opt["survey_q"][$i]."', '".$opt["survey_a"][$i]."', '".$opt["usr_id"]."', now() )";
            
            $data = $this->db->query($sql);
        }        
        //         echo $sql;
        //         exit;
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>"설문에 참여해주셔서 감사합니다."];
        }
        
        exit;
    }
    
    public function survey_list() {
        
        $sql = "select * from tb_survey_202410 ";        
        $listSql = "order by wdate desc, survey_q asc ";
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql.$listSql)->result_array();
        
        
        return array('list'=>$list, 'listCount'=>$listCount);
        exit;
    }
    
    
    
    public function save_qna($opt){
        
        $this->db->trans_begin();        

        $sql = "insert into zz_novartis_qna (";
        $sql.= "hcp_name, hcp_biznm, hcp_telno, hcp_email, qna_text, wdate) values (";
        $sql.= "'".$opt["hcp_name"]."','".$opt["hcp_biznm"]."','".$opt["hcp_telno"]."' ";
        $sql.= ",'".$opt["hcp_email"]."','".$opt["qna_text"]."', now()) ";
        
//         echo $sql;
//         exit;

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