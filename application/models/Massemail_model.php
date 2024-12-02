<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Massemail_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function list($opt) {        
        
        $sql = "select * from tb_mass_email ";
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
    
    public function open($idx) {
        
        $sql = "select * from tb_mass_email where idx=".$idx;
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    
    public function save($opt) {
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        
        if ($opt["editMode"] == "N" ){
            $sql = " insert into tb_mass_email (template_nm, mail_type, mail_subject, mail_body, wuser, wdate) values ( ";
            $sql.= " '".$opt["template_nm"]."', ";
            $sql.= " '".$opt["mail_type"]."', ";
            $sql.= " '".$opt["mail_subject"]."', ";
            $sql.= " '".$opt["mail_body"]."', ";
            $sql.= " '".$session_id."', ";
            $sql.= " now() ) ";
            $data = $this->db->query($sql);
        }

        elseif ($opt["editMode"] == "U" ) {
            $sql = "update tb_mass_email set ";
            $sql.= "template_nm = '".$opt["template_nm"]."', ";
            $sql.= "mail_type = '".$opt["mail_type"]."', ";
            $sql.= "mail_subject = '".$opt["mail_subject"]."', ";
            $sql.= "utm_campaign = '".$opt["utm_campaign"]."', ";
            $sql.= "mail_body = '".addslashes($opt["mail_body"])."', ";
            $sql.= "uuser = '".$session_id."', ";
            $sql.= "udate = now() ";
            $sql.= "where idx=".$opt["idx"]."";            
            $data = $this->db->query($sql);
        }
        elseif ($opt["editMode"] == "D" ) {
            $sql = "delete from tb_mass_email where idx=".$opt["idx"];
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
            return ["result"=>"ok", "msg"=>$opt["editMode"]=="D" ? "delete ok" : "save ok"];
        }
        exit;
    }
    
    public function report($idx) {
        
        $sql = "select x.template_idx, x.send_cnt, x.open_cnt, y.utm_cnt, x.utm_campaign ";
        $sql.= "from (";
        $sql.= "    select a.*, b.utm_campaign ";
        $sql.= "    from ( ";
        $sql.= "        select template_idx, count(0) as send_cnt, sum(case when open_dt is not null then 1 else 0 end) as open_cnt ";
        $sql.= "        from tb_mass_email_log ";
        $sql.= "        group by template_idx ";
        $sql.= "    ) as a left outer join ";
        $sql.= "    tb_mass_email b on a.template_idx=b.idx ";
        $sql.= ") x left outer join ";
        $sql.= "( ";
        $sql.= "    select utm_campaign, sum(case when utm_email is not null then 1 else 0 end) as utm_cnt ";
        $sql.= "    from ( ";
        $sql.= "        select utm_campaign, utm_email, count(0) from sample_utm_log where utm_campaign <> '' and utm_email <> '' group by utm_campaign, utm_email ";
        $sql.= "    ) a ";
        $sql.= "    group by utm_campaign ";
        $sql.= ") y on x.utm_campaign=y.utm_campaign ";
        $sql.= "where x.template_idx=".$idx." ";
        $sql.= "group by x.template_idx ";
        $zipge = $this->db->query($sql)->result_array();
        
        $sql = "select x.*, y.utm_dt ";
        $sql.= "from ( ";
        $sql.= "    select a.template_idx, a.to_user, a.send_dt, a.open_dt, b.utm_campaign ";
        $sql.= "    from ( ";
        $sql.= "        select * ";
        $sql.= "        from tb_mass_email_log ";
        $sql.= "        where template_idx=".$idx." ";
        $sql.= "    ) as a left outer join ";
        $sql.= "    tb_mass_email b on a.template_idx=b.idx ";
        $sql.= ") x left outer join ";
        $sql.= "(select utm_campaign, utm_email, min(wdate) as utm_dt from sample_utm_log group by utm_campaign, utm_email) y on x.utm_campaign=y.utm_campaign and x.to_user=y.utm_email ";
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return ['zipge'=>$zipge, 'list'=>$list, 'listCount'=>$listCount];
        exit;
    }
    
    public function addressbook() {
        
        $sql = "select * from tb_address_book ";
        $sql.= "order by user_nm asc ";
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return ['list'=>$list, 'listCount'=>$listCount];
        exit;
    }
    
    public function read_mail($mail_seq){
        $sql = "update tb_mass_email_log set open_dt=now() ";
        $sql.= "where mail_seq='".$mail_seq."' ";
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>"open ok"];
        }
    }
    
    public function save_email_log($opt){
        
        $this->db->trans_begin();
        
        $session_id = getExist($this->session->userdata["user_id"], "none");
        $session_nm = getExist($this->session->userdata["user_nm"], "noname");
        
        $sql = "insert into tb_mass_email_log (";
        $sql.= "mail_type, mail_seq, mail_subject, mail_body, result, to_user, template_idx, send_dt) values (";
        $sql.= "'".$opt["mail_type"]."', '".$opt["mail_seq"]."', '".$opt["mail_subject"]."', '".addslashes($opt["mail_body"])."', '".$opt["result"]."', '".$opt["to_user"]."', ";
        $sql.= "".$opt["template_idx"].", now() )";      
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