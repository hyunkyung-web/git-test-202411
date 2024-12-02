<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Survey_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function survey_read($opt) {
        
        $strWhere = "where survey_idx=".$opt["survey_idx"]." ";
        
        $sql = "select * from tb_survey_question ";
        $sql.= $strWhere;
        $listSql = "order by seq ";
        
        $list = $this->db->query($sql.$listSql)->result_array();
        $listCount = $this->db->query($sql)->num_rows();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function question_read_single($opt) {
        
//         $strWhere = "where a.survey_idx=".$opt["survey_idx"]."  ";
        $strWhere = "where a.survey_idx=".$opt["survey_idx"]." and a.seq=".$opt["question_seq"]." ";
        
        $sql = "select a.idx as question_idx, a.seq as question_seq, a.txt_question, a.question_type, b.idx as answer_idx, b.seq as answer_seq, b.answer_value ";
        $sql.= "from tb_survey_question a ";
        $sql.= "left outer join tb_survey_answer b on a.idx=b.question_idx ";
        $sql.= $strWhere;
        $listSql = "order by a.seq, b.seq ";
        
        $list = $this->db->query($sql.$listSql)->result_array();
        $listCount = $this->db->query($sql)->num_rows();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function question_read($opt) {
        
        $strWhere = "where a.survey_idx=".$opt["survey_idx"]."  ";
        //         $strWhere = "where survey_idx=".$opt["survey_idx"]." and idx=".$opt["question_idx"]." ";
        
        $sql = "select a.idx as question_idx, a.seq as question_seq, a.txt_question, a.question_type, b.idx as answer_idx, b.seq as answer_seq, b.answer_value ";
        $sql.= "from tb_survey_question a ";
        $sql.= "left outer join tb_survey_answer b on a.idx=b.question_idx ";
        $sql.= $strWhere;
        $listSql = "order by a.seq, b.seq ";
                
        $list = $this->db->query($sql.$listSql)->result_array();
        $listCount = $this->db->query($sql)->num_rows();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function result_zipge($opt) {
        
        $a_where = "where question_idx=".$opt["question_idx"]." ";
        $b_where = "where survey_idx=".$opt["survey_idx"]." and question_idx=".$opt["question_idx"]." ";
     
        $sql = "select a.answer_value, b.vote_cnt, c.txt_question ";
        $sql.= "from ( ";
        $sql.= "select * from tb_survey_answer ";
        $sql.= $a_where;
        $sql.= ") a left outer join ("; 
        $sql.= "select answer_idx, count(answer_idx) as vote_cnt ";
        $sql.= "from tb_survey_result ";
        $sql.= $b_where;
        $sql.= "group by answer_idx) b on a.idx=b.answer_idx ";
        $sql.= "left outer join tb_survey_question as c on a.question_idx=c.idx ";
        
        $list = $this->db->query($sql)->result_array();
        
        return ["list"=>$list];
        exit;
    }

    public function data_save($opt){
        
        $this->db->trans_begin();
        
        $arr_question = $opt["question"];
        $arr_answer = $opt["answer"];
        
        foreach($arr_question as $key=>$value){
            $sql = "insert into tb_survey_result (survey_idx, question_idx, answer_idx, log_device, device_info, wdate) values (";
            $sql.= "".$opt["survey_idx"].", ".$value.", ".$arr_answer[$key].", '".$opt["log_device"]."', '".$opt["device_info"]."', now() )" ;
            $data = $this->db->query($sql);
            
            if (!$data) {
                $errorMsg = $this->db->error();
                $this->db->trans_rollback();
                return ["result"=>"db_error", "msg"=>$errorMsg];
                exit;
            }
        }  
        
        $this->db->trans_commit();
        
        $resultMsg = "ok";
        
        return ["result"=>"ok", "msg"=>$resultMsg];
        exit;
        
        
    }

    
//     public function question_read($opt) {
        
//         $strWhere = "where survey_idx=".$opt["survey_idx"]."  ";
// //         $strWhere = "where survey_idx=".$opt["survey_idx"]." and idx=".$opt["question_idx"]." ";
        
//         $sql = "select * from tb_survey_question ";
//         $sql.= $strWhere;
//         $listSql = "order by seq ";
        
//         $list = $this->db->query($sql.$listSql)->result_array();
//         $listCount = $this->db->query($sql)->num_rows();
        
//         return ["list"=>$list, "listCount" => $listCount];
//         exit;
//     }
    
    public function answer_read($opt) {
        
        $strWhere = "where survey_idx=".$opt["survey_dx"]." ";
//         $strWhere = "where question_idx=".$opt["question_idx"]." ";

        
        $sql = "select * from tb_survey_answer ";
        $sql.= $strWhere;
        $listSql = "order by question_idx, seq ";
        
        $list = $this->db->query($sql.$listSql)->result_array();
        $listCount = $this->db->query($sql)->num_rows();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
        
    
    
    
}

?>