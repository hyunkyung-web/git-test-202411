<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Event_model extends CI_Model {
    
    public function __construct() {
        $this->load->database(); 
    }
    
    public function event_save($opt){
        
        
        $this->db->trans_begin();  
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        
        if($opt["editMode"] == "N") {
            
            $sql = "insert into tb_event_list (";
            $sql.= "event_nm, event_date, event_time, event_run_time, event_city, event_place, ";
            $sql.= "biz_cd, biz_nm, brand_1, brand_2, brand_3, pm_1, pm_2, pm_3, auth_phone, ";
            $sql.= "meeting_type, meeting_id, meeting_pw, meeting_url, chairman, speaker, agenda, ";
            $sql.= "noti_txt_email, noti_txt_info, review_cd, save_tel, pass_key, wdate, wuser, wuser_nm, event_status) values (";
            $sql.= "'".$opt["event_nm"]."', '".$opt["event_date"]."', '".$opt["event_time"]."', ".$opt["event_run_time"].", '".$opt["event_city"]."', '".$opt["event_place"]."', ";
            $sql.= "'".$opt["biz_cd"]."', '".$opt["biz_nm"]."', '".$opt["brand_1"]."', '".$opt["brand_2"]."', '".$opt["brand_3"]."', '".$opt["pm_1"]."', '".$opt["pm_2"]."', '".$opt["pm_3"]."', '".$opt["auth_phone"]."', ";
            $sql.= "'".$opt["meeting_type"]."', '".$opt["meeting_id"]."', '".$opt["meeting_pw"]."', '".$opt["meeting_url"]."', '".$opt["chairman"]."', '".$opt["speaker"]."', '".$opt["agenda"]."', ";
            $sql.= "'".$opt["noti_txt_email"]."', '".$opt["noti_txt_info"]."', '".$opt["review_cd"]."', '".$opt["save_tel"]."', '".$opt["pass_key"]."', now(), '".$session_id."', '".$session_nm."', '".$opt["event_status"]."') ";
            $data = $this->db->query($sql);            
            $rtn_idx = $this->db->insert_id();
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_event_list set ";            
            $sql.= "event_nm = '".$opt["event_nm"]."', ";
            $sql.= "event_date = '".$opt["event_date"]."', ";
            $sql.= "event_time = '".$opt["event_time"]."', ";
            $sql.= "event_run_time = ".$opt["event_run_time"].", ";
            $sql.= "event_city = '".$opt["event_city"]."', ";
            $sql.= "event_place = '".$opt["event_place"]."', ";
            $sql.= "biz_cd = '".$opt["biz_cd"]."', ";
            $sql.= "biz_nm = '".$opt["biz_nm"]."', ";
            $sql.= "brand_1 = '".$opt["brand_1"]."', ";
            $sql.= "brand_2 = '".$opt["brand_2"]."', ";
            $sql.= "brand_3 = '".$opt["brand_3"]."', ";
            $sql.= "pm_1 = '".$opt["pm_1"]."', ";
            $sql.= "pm_2 = '".$opt["pm_2"]."', ";
            $sql.= "pm_3 = '".$opt["pm_3"]."', ";
            $sql.= "auth_phone = '".$opt["auth_phone"]."', ";
            $sql.= "meeting_type = '".$opt["meeting_type"]."', ";
            $sql.= "meeting_id = '".$opt["meeting_id"]."', ";
            $sql.= "meeting_pw = '".$opt["meeting_pw"]."', ";
            $sql.= "meeting_url = '".$opt["meeting_url"]."', ";
            $sql.= "pass_key = '".$opt["pass_key"]."', ";
            $sql.= "chairman = '".$opt["chairman"]."', ";
            $sql.= "speaker = '".$opt["speaker"]."', ";
            $sql.= "agenda = '".$opt["agenda"]."', ";
            $sql.= "noti_txt_email = '".$opt["noti_txt_email"]."', ";
            $sql.= "noti_txt_info = '".$opt["noti_txt_info"]."', ";
            $sql.= "review_cd = '".$opt["review_cd"]."', ";
            $sql.= "save_tel = '".$opt["save_tel"]."', ";
            $sql.= "event_status = '".$opt["event_status"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."', ";
            $sql.= "uuser_nm = '".$session_id."' ";
            $sql.= "where event_idx=".$opt["event_idx"]." ";
            $data = $this->db->query($sql);
            $rtn_idx = $opt["event_idx"];
            
        } elseif($opt["editMode"]=="D"){
            $sql = "update tb_event_list set ";
            $sql.= "delete_flag = 'Y', ";
            $sql.= "event_status = 'close', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$session_id."', ";
            $sql.= "uuser_nm = '".$session_id."' ";
            $sql.= "where event_idx=".$opt["event_idx"]." ";
            $data = $this->db->query($sql);
            $rtn_idx = $opt["event_idx"];
        }
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            switch ($opt["editMode"]) {
                case "N":
                    $resultMsg = "new_ok";
                    break;
                case "U":
                    $resultMsg = "update_ok";
                    break;
                case "D":
                    $resultMsg = "delete_ok";
                    break;
            }
            return ["result"=>"ok", "msg"=>$resultMsg, "rtn_idx"=>$rtn_idx];
        }    
        
        exit;
        
    }
    
    public function event_img_update($opt){
        
        $this->db->trans_begin();
        $session_id = $this->session->userdata["user_id"];
        
        $sql = "update tb_event_list set ";
        $sql.= "thumbnail='".$opt["img_path"]."', ";
        $sql.= "sms_img_path='".$opt["sms_img_path"]."', ";
        $sql.= "udate = now(), ";
        $sql.= "uuser = '$session_id' ";
        $sql.= "where event_idx=".$opt["event_idx"]." ";        
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();            
            return ["result"=>"ok", "msg"=>"update ok"];
        }
        exit;
    }
    
    public function event_list($opt) {
        
        $strWhere = "where (delete_flag is null or delete_flag <> 'Y') ";
        
        if($opt["s_date"] != '' && $opt["e_date"] != ''){
            $strWhere.= "and (date(event_date) between '".$opt["s_date"]."' and '".$opt["e_date"]."') ";
        }        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (event_nm like '%".$opt["keyword"]."%' or biz_nm like '%".$opt["keyword"]."%' ";
            $strWhere.= "or brand_1 like '%".$opt["keyword"]."%' or brand_2 like '%".$opt["keyword"]."%' or brand_3 like '%".$opt["keyword"]."%' ";
            $strWhere.= "or pm_1 like '%".$opt["keyword"]."%' or pm_2 like '%".$opt["keyword"]."%' or pm_3 like '%".$opt["keyword"]."%') ";
        }
        if($opt["event_status"] != ''){
            $strWhere.= "and event_status='".$opt["event_status"]."' ";
        }
        
        $sql = "select *, (case event_status when 'ready' then '준비' when 'action' then '방송' when 'close' then '마감' end) as status ";
        $sql.= "from tb_event_list ";
        $sql.= $strWhere;
        $sql.= "order by event_idx desc ";
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
    
    public function main_event_list($opt) {
        
        $strWhere = "where (delete_flag is null or delete_flag <> 'Y') ";        
        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (event_nm like '%".$opt["keyword"]."%' or biz_nm like '%".$opt["keyword"]."%' ";
            $strWhere.= "or brand_1 like '%".$opt["keyword"]."%' or brand_2 like '%".$opt["keyword"]."%' or brand_3 like '%".$opt["keyword"]."%' ";            
        }
        

        
        //event_status: ready, action, close
        if($opt["event_status"] != ''){
            if($opt["event_status"]=="today"){
                $strWhere.= "and event_status <> 'close' and (date(event_date)='".date('Y-m-d')."') "; 
            } else {
                $strWhere.= "and event_status='".$opt["event_status"]."' ";
            }
        }
        
        $sql = "select *, (case event_status when 'ready' then '준비' when 'action' then '방송' when 'close' then '마감' end) as status ";
        $sql.= "from tb_event_list ";
        $sql.= $strWhere;
        $sql.= "order by event_idx desc ";
        
        $listCount = $this->db->query($sql)->num_rows();
        $list = $this->db->query($sql)->result_array();
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function cbo_event_list($status="all") {
        
        if($status=="all"){
            $strWhere = "where (delete_flag is null or delete_flag <> 'Y') ";
        } elseif($status=="not_close"){
            $strWhere = "where event_status <> 'close' and (delete_flag is null or delete_flag <> 'Y') ";
        }
        
        $sql = "select *, (case event_status when 'ready' then '준비' when 'action' then '방송' when 'close' then '마감' end) as status_nm, ";
        $sql.= "(case event_status when 'ready' then '#e3ffd7' when 'action' then '#ffe800' when 'close' then '#aaa' end) as status_color ";
        $sql.= "from tb_event_list ";
        $sql.= $strWhere;
        $listSql = "order by event_idx desc";
        $list = $this->db->query($sql.$listSql)->result_array();
        
        return $list;
        exit;
    }
    
    public function event_open($opt) {
        
        $strWhere = "where event_idx=".$opt["event_idx"]." ";
        
        $sql = "select * from tb_event_list ";
        $sql.= $strWhere;
        $sql.= "order by event_date, event_time limit 0, 1";
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    public function event_log_list($opt) {
        
        $strWhere = "where idx > 0  ";
        
        if($opt["event_idx"] != ""){
            $strWhere.= "and a.event_idx='".$opt["event_idx"]."' ";
        }        
        if($opt["s_date"] != '' && $opt["e_date"] != ''){
            $strWhere.= "and (date(a.wdate) between '".$opt["s_date"]."' and '".$opt["e_date"]."') ";
        }
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (a.user_id like '%".$opt["keyword"]."%' or a.ref_1 like '%".$opt["keyword"]."%' ";
            $strWhere.= "or a.ref_2 like '%".$opt["keyword"]."%' or a.inflow_cd like '%".$opt["keyword"]."%') ";
        }
        
        $sql = "select a.*, b.event_nm, b.biz_nm from tb_event_log a ";
        $sql.= "left outer join tb_event_list b on a.event_idx=b.event_idx ";
        $sql.= $strWhere;
        $sql.= "order by a.wdate desc, a.idx desc ";
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
    
    
    public function event_log_zipge($opt) {
        
        $strWhere = "where a.idx > 0  ";
        
        
        if($opt["event_idx"] != ""){
            $strWhere.= "and a.event_idx='".$opt["event_idx"]."' ";
        }
        if($opt["s_date"] != '' && $opt["e_date"] != ''){
            $strWhere.= "and (date(a.wdate) between '".$opt["s_date"]."' and '".$opt["e_date"]."') ";
        }
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (a.user_id like '%".$opt["keyword"]."%' or a.ref_1 like '%".$opt["keyword"]."%' ";
            $strWhere.= "or a.ref_2 like '%".$opt["keyword"]."%' or a.inflow_cd like '%".$opt["keyword"]."%') ";
        }
        
        //로그리스트
        if($opt["report_type"]=="0"){
            $sql = "select a.*, b.event_nm, b.biz_nm, c.user_nm, c.biz_nm, c.biz_dept, c.mobile ";
            $sql.= "from tb_event_log a ";
            $sql.= "left outer join tb_event_list b on a.event_idx=b.event_idx ";
            $sql.= "left outer join tb_pre_application c on a.event_idx=c.event_idx and a.ref_1=c.email ";
            $sql.= $strWhere;
            $sql.= "order by a.wdate desc, a.idx desc ";
            $listSql = "limit ?, ?";
        }
        //참여현황 집계
        elseif($opt["report_type"]=="1"){
            $sql = "select x.*, y.user_nm, y.biz_nm, y.biz_dept, y.mobile ";            
            $sql.= "from (";
            $sql.= "    select a.event_idx, a.log_seq, b.event_nm, a.user_id, a.inflow_cd, a.ref_1, a.ref_2, a.log_page, max(a.log_device) as log_device,";
            $sql.= "    min(case when a.log_type='in' then a.wdate end) as in_time, ";
            $sql.= "    max(case when a.log_type='out' then a.wdate end) as out_time, max(a.idx) as idx, ";
            $sql.= "    timestampdiff(minute, min(case when a.log_type='in' then a.wdate end), max(case when a.log_type='out' then a.wdate end)) as playing_time, ";
            $sql.= "    timestampdiff(minute, max(case when a.log_type='out' then a.wdate end), now()) as now_gap ";            
            $sql.= "    from tb_event_log a ";
            $sql.= "    left outer join tb_event_list b on a.event_idx=b.event_idx ";            
            $sql.=      $strWhere;
            $sql.= "    group by a.event_idx, a.log_seq, a.user_id, a.inflow_cd, a.ref_1, a.ref_2, a.log_page ";
            $sql.= ") x ";
            $sql.= "left outer join tb_pre_application y on x.event_idx=y.event_idx and x.ref_1=y.email and y.delete_yn is null ";
            $sql.= "order by x.idx desc, x.user_id, x.log_seq ";
            $listSql = "limit ?, ?";           
        }
        //실시간 접속자 현황
        elseif($opt["report_type"]=="2"){
            $sql = "select x.*, y.user_nm, y.biz_nm, y.biz_dept, y.mobile ";
            $sql.= "from (";
            $sql.= "    select a.event_idx, a.log_seq, b.event_nm, a.user_id, a.inflow_cd, a.ref_1, a.ref_2, a.log_page, max(a.log_device) as log_device,";
            $sql.= "    min(case when a.log_type='in' then a.wdate end) as in_time, ";
            $sql.= "    max(case when a.log_type='out' then a.wdate end) as out_time, max(a.idx) as idx, ";
            $sql.= "    timestampdiff(minute, min(case when a.log_type='in' then a.wdate end), max(case when a.log_type='out' then a.wdate end)) as playing_time, ";
            $sql.= "    timestampdiff(minute, max(case when a.log_type='out' then a.wdate end), now()) as now_gap ";            
            $sql.= "    from tb_event_log a ";
            $sql.= "    left outer join tb_event_list b on a.event_idx=b.event_idx ";            
            $sql.=      $strWhere;
            $sql.= "    group by a.event_idx, a.log_seq, a.user_id, a.inflow_cd, a.ref_1, a.ref_2, a.log_page ";
            $sql.= "    having now_gap=0 ";
            $sql.= ") x ";
            $sql.= "left outer join tb_pre_application y on x.event_idx=y.event_idx and x.ref_1=y.email and y.delete_yn is null ";
            $sql.= "order by x.idx desc, x.user_id, x.log_seq ";
            $listSql = "limit ?, ? ";
        }
        
        $listCount = $this->db->query($sql)->num_rows();            
        
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        }else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function event_save_log($opt){
        
        $this->db->trans_begin();
        
        $session_id = isset($this->session->userdata["user_id"]) ? $this->session->userdata["user_id"] : '';
//         $session_id = isset($this->session->userdata["user_id"]) ? $this->session->userdata["user_id"] : $_SERVER['HTTP_X_FORWARDED_FOR'];
        $listCount = 0;
        
        $strWhere = "where log_seq='".$opt["log_seq"]."' and event_idx=".$opt["event_idx"]." and user_id='".$session_id."' and log_page='".$opt["log_page"]."' ";
        $strWhere.= "and log_type='".$opt["log_type"]."' and ref_1='".$opt["ref_1"]."' and ref_2='".$opt["ref_2"]."' ";
        
        $bsql = "select * from tb_event_log ";
        $bsql.= $strWhere;
        $listCount = $this->db->query($bsql)->num_rows();
        
        //같은 세션의 접근기록이 없는 경우 신규로 로그저장
        if($listCount==0){
            $sql = "insert into tb_event_log (";
            $sql.= "log_seq, event_idx, user_id, log_page, log_type, inflow_cd, ref_1, ref_2, wdate, log_ip, log_device, device_info) values (";
            $sql.= "'".$opt["log_seq"]."', ".$opt["event_idx"].", '".$session_id."', '".$opt["log_page"]."','".$opt["log_type"]."', '".$opt["inflow_cd"]."', ";
            $sql.= "'".$opt["ref_1"]."', '".$opt["ref_2"]."', now(), '".$opt["log_ip"]."', '".$opt["log_device"]."', '".$opt["device_info"]."' )";
            $data = $this->db->query($sql);
            
            if($opt["log_type"] == "in"){
                $sql = "insert into tb_event_log (";
                $sql.= "log_seq, event_idx, user_id, log_page, log_type, inflow_cd, ref_1, ref_2, wdate, log_ip, log_device, device_info) values (";
                $sql.= "'".$opt["log_seq"]."', ".$opt["event_idx"].", '".$session_id."', '".$opt["log_page"]."','out', '".$opt["inflow_cd"]."', ";
                $sql.= "'".$opt["ref_1"]."', '".$opt["ref_2"]."', now(), '".$opt["log_ip"]."', '".$opt["log_device"]."', '".$opt["device_info"]."' )";
                $data = $this->db->query($sql);                
            }
            
        } else {
            //같은 세션에서 로그가 존재하고 입장로그가 아닌 퇴장로그를 기록하는 경우에만 업데이트. 새로고침 발생에 따른 입장로그는 업데이트 하지 않는다. 최초입장 시간을 남겨두기 위함            
            if($opt["log_type"] == "out") {
                $sql = "update tb_event_log set wdate=now() ";
                $sql.= $strWhere;
                $data = $this->db->query($sql);
            } else {
                $data = true;
            }            
        }
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();            
            return ["result"=>"log_save_ok", "msg"=>"log save ok"];
        }
        
        exit;
    }
    
    public function event_qna_list($opt) {
        
        $strWhere = "where (event_idx = ".$opt["event_idx"].") ";
        
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (event_idx = ".$opt["keyword"].") ";
        }
        
        $sql = "select * from tb_qna_list ";
        $sql.= $strWhere;
        $sql.= "order by show_yn desc, reply_ok asc, idx asc ";
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
    
    
    public function get_qna_list($opt) {
        
        $strWhere = "where event_idx=".$opt["event_idx"]." and (reply_ok is null or reply_ok <> 'Y') and  show_yn='Y' ";
        
        $sql = "select * from tb_qna_list ";
        $sql.= $strWhere;
        $sql.= "order by idx desc limit 0, 1";
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    public function save_qna($opt){               
        
        $this->db->trans_begin();

        $session_id = isset($this->session->userdata["user_id"]) ? $this->session->userdata["user_id"] : $opt["ref_1"];
        

        $sql = "insert into tb_qna_list (";
        $sql.= "event_idx, question, show_yn, reply_ok, wdate, wuser) values (";
        $sql.= "".$opt["event_idx"].", '".$opt["question"]."', 'N', 'N', now(), '".$session_id."' )";       

        $data = $this->db->query($sql);        
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"save ok", "msg"=>"save ok"];
        }
        
        exit;
    }
    
    public function update_qna($opt){
        
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        
        if($opt["editMode"]=="show"){
            $asql = "update tb_qna_list set show_yn='N', reply_ok='Y' where event_idx=".$opt["event_idx"]." and show_yn='Y' and reply_ok='N' ";
            $adata = $this->db->query($asql);
            
            $bsql = "update tb_qna_list set show_yn='N' where event_idx=".$opt["event_idx"];
            $bdata = $this->db->query($bsql);
        }
        if($opt["editMode"]=="delete"){
            $sql = "delete from tb_qna_list ";
            $sql.= "where idx=".$opt["idx"]." ";            
        }else {
            $sql = "update tb_qna_list set ";
            $sql.= "answer='".$opt["answer"]."', ";
            $sql.= "show_yn='".$opt["show_yn"]."', ";
            $sql.= "reply_ok='".$opt["reply_ok"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser='".$session_id."' ";
            $sql.= "where idx=".$opt["idx"]." ";            
        }
        
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>$opt["editMode"]." ok"];
        }
        
        exit;
    }
    
    public function faq_list($opt) {
        
        $strWhere = "where idx > 0 ";
        if(trim($opt["keyword"]) != ""){
            $strWhere.= "and (biz_nm like '%".$opt["keyword"]."%' or email like '%".$opt["keyword"]."%' or user_nm like '%".$opt["keyword"]."%')  ";
        }
        
        $sql = "select * from tb_faq_list ";
        $sql.= $strWhere;
        $sql.= "order by idx desc ";
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
    
    public function faq_open($opt) {        
        
        $strWhere = "where idx=".$opt["idx"]." ";
        
        $sql = "select * from tb_faq_list ";
        $sql.= $strWhere;        
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    
    
//     대기실-문의사항
    public function save_faq($opt){
        
        $this->db->trans_begin();
        
        $conn_ip = getRealClientIp();
        
        if($opt["editMode"] == "N"){
            $sql = "insert into tb_faq_list (";
            $sql.= "event_idx, user_nm, biz_nm, email, question, log_ip, wdate) values (";
            $sql.= "".$opt["event_idx"].", '".$opt["user_nm"]."', '".$opt["biz_nm"]."', '".$opt["email"]."', '".$opt["question"]."', '".$conn_ip."', now() )";
            $data = $this->db->query($sql);
            
            $msg = "문의내용이 등록되었습니다. 이메일로 연락 드리겠습니다.";
            
        } elseif($opt["editMode"]=="U"){
            $sql = "update tb_faq_list set ";
            $sql.= "answer = '".$opt["answer"]."', ";
            $sql.= "udate = now(), ";
            $sql.= "uuser = '".$this->session->userdata["user_id"]."', ";
            $sql.= "uuser_nm = '".$this->session->userdata["user_nm"]."' ";
            $sql.= "where idx =".$opt["idx"]." ";
            $data = $this->db->query($sql);
            
            $msg = "답변을 등록했습니다.";
        }
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();            
            return ["result"=>"ok", "msg"=>$msg];
        }
        
        exit;
    }
//     관리자-문의사항 답변
    public function update_faq($opt){
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        
        $sql = "update tb_faq_list set ";
        $sql.= "answer='".$opt["answer"]."', ";
        $sql.= "udate = now(), ";
        $sql.= "uuser='".$session_id."', ";
        $sql.= "uuser_nm='".$session_nm."' ";
        $sql.= "where idx=".$opt["idx"]." ";
        
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
    
    public function application_list($opt) {
        
        $strWhere = "where idx > 0 ";
        $strWhere.=" and event_idx = ".$opt["event_idx"]." ";
        
        $deleteFlag = isset($opt["chkDelete"]) ? $opt["chkDelete"] : "N";
        
        if ($deleteFlag == "Y"){
            $strWhere .= "and delete_yn = 'Y' ";
        } else {
            $strWhere .= "and delete_yn is null ";
        }
        
        if(isset($opt["keyword"]) != ""){
            $strWhere.= "and (user_nm like '%".trim($opt["keyword"])."%' or email like '%".trim($opt["keyword"])."%' or mobile like '%".trim($opt["keyword"])."%' or biz_nm like '%".trim($opt["keyword"])."%') ";
        }
        
        $sql = "select * from tb_pre_application ";
        $sql.= $strWhere;
        $sql.= "order by idx desc ";
        $listSql = "limit ?, ?";
        
        $listCount = $this->db->query($sql)->num_rows();
        if(isset($opt["start"])){
            $list = $this->db->query($sql.$listSql, [$opt["start"], $opt["end"]])->result_array();
        } else {
            $list = $this->db->query($sql)->result_array();
        }
        
        return ["list"=>$list, "listCount" => $listCount];
        exit;
    }
    
    public function save_application($opt){
        
        $this->db->trans_begin();
//         $rtn_idx = $opt["event_idx"];
        $conn_ip = getRealClientIp();
        
        if($opt["editMode"]=="N"){
            $bsql = "select * from tb_pre_application ";
            $bsql.= "where delete_yn is null and event_idx=".$opt["event_idx"]." and email='".$opt["email"]."' ";
            $listCount = $this->db->query($bsql)->num_rows();
            
            $mobileDevice = array("iPhone", "iPod", "IEMobile", "Mobile", "lgtelecom", "PPC", "BlackBerry", "Android", "SM-", "SCH-", "SPH-", "LG-", "CANU", "IM-" ,"EV-","Nokia");
            $userDevice = "PC";
            
            for ($i=0; $i <= count($mobileDevice)-1; $i++ ) {
                if ( strrpos($_SERVER['HTTP_USER_AGENT'], $mobileDevice[$i]) > -1 ) {
                    $userDevice = "MOBILE";
                }
            }
            
            if($listCount>0){
                $sql = "update tb_pre_application set ";
                $sql.= "user_nm='".$opt["user_nm"]."', ";
                $sql.= "biz_nm='".$opt["biz_nm"]."', ";
                $sql.= "biz_dept='".$opt["biz_dept"]."', ";
                $sql.= "mobile='".$opt["mobile"]."', ";
                $sql.= "log_ip='".$conn_ip."', ";
                $sql.= "device_info='".$_SERVER['HTTP_USER_AGENT']."', ";
                $sql.= "device_type='".$userDevice."', ";
                $sql.= "udate=now() ";
                $sql.= "where event_idx=".$opt["event_idx"]." and email='".$opt["email"]."' ";
            } else {
                $sql = "insert into tb_pre_application (";
                $sql.= "event_idx, user_nm, email, biz_nm, biz_dept, mobile, log_ip, device_info, device_type, wdate) values (";
                $sql.= "".$opt["event_idx"].", '".$opt["user_nm"]."', '".$opt["email"]."', '".$opt["biz_nm"]."', ";
                $sql.= "'".$opt["biz_dept"]."', '".$opt["mobile"]."', '".$conn_ip."', '".$_SERVER['HTTP_USER_AGENT']."', '".$userDevice."', now())";
//                 $rtn_idx = $this->db->insert_id();
            }
        } elseif($opt["editMode"]=="D"){
            $sql = "delete from tb_pre_application where event_idx=".$opt["event_idx"]." and upload_num='".$opt["upload_num"]."' ";
        }
                    
        $data = $this->db->query($sql);
        
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            if($opt["editMode"]=="N"){
                return ["result"=>"ok", "msg"=>"save ok"];
            } elseif($opt["editMode"]=="D"){
                return ["result"=>"ok", "msg"=>"delete ok"];
            }            
        }
        
        exit;
    }
    
    public function chk_application($opt) {
        
        $strWhere = "where delete_yn is NULL and event_idx=".$opt["event_idx"]." and email='".$opt["email"]."' ";
        
        $sql = "select * from tb_pre_application ";
        $sql.= $strWhere;
        $sql.= "order by idx desc limit 0, 1";
        
        $list = $this->db->query($sql)->result_array();
        
        return $list;
        exit;
    }
    
    public function update_application($opt){
        
        $sql = "update tb_pre_application set ";
        $sql.= "user_nm='".$opt["user_nm"]."', ";
        $sql.= "biz_nm='".$opt["biz_nm"]."', ";
        $sql.= "biz_dept='".$opt["biz_dept"]."', ";
        $sql.= "email='".$opt["email"]."', ";
        $sql.= "mobile='".preg_replace('/[^0-9]*/s', '', $opt["mobile"])."', ";
        $sql.= "udate=now() ";
        $sql.= "where idx=".$opt["idx"];
        
        $data = $this->db->query($sql);
        
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>"update ok"];        
        }
        
        exit;
        
    }
    
    public function save_application_excel($sheetData, $eventIdx){
        
        $this->db->trans_begin();
        
        $session_id = $this->session->userdata["user_id"];
        $session_nm = $this->session->userdata["user_nm"];
        $rowNum = 1;
        
        foreach($sheetData as $row){
            if($rowNum > 2){
                //0:이름, 1:병원명, 2:소속, 3:이메일, 4:연락처, 5:업로드번호
                $preSql = "select * from tb_pre_application where event_idx=".$eventIdx." and user_nm='".$row[0]."' and email='".$row[3]."' ";
                $chkData = $this->db->query($preSql)->num_rows();
                
                if($chkData > 0){
                    $sql = "delete from tb_pre_application where event_idx=".$eventIdx." and user_nm='".$row[0]."' and email='".$row[3]."' ";
                    $this->db->query($sql);
                }
                
                $sql = "insert into tb_pre_application (";
                $sql.= "user_nm, biz_nm, biz_dept, email, mobile, upload_num, event_idx, wdate, wuser, wuser_nm) values (";
                $sql.= "'".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[3]."', '".preg_replace('/[^0-9]*/s', '', $row[4])."', '".$row[5]."', ".$eventIdx.", ";
                $sql.= "now(), '".$session_id."', '".$session_nm."')";
                $data = $this->db->query($sql);
                
                if (!$data) {
                    $errorMsg = $this->db->error();
                    $this->db->trans_rollback();
                    return ["result"=>"db_error", "msg"=>$errorMsg];
                } 
            }
            
            $rowNum++;
        }
        
        $this->db->trans_commit();
        return ["result"=>"ok", "msg"=>"업로드 완료"];
        
        exit;
    }
    
    public function delete_application($opt){
        
        $this->db->trans_begin();
        $chkIdx = $opt["chkIdx"];
        $strWhere = "where idx in (".implode(',', $chkIdx).") ";        
        
        if($opt["editMode"]=="delete"){
            $sql = "update tb_pre_application set delete_yn = 'Y' ";
        } elseif($opt["editMode"]=="restore"){
            $sql = "update tb_pre_application set delete_yn = NULL ";
        }
        $sql.= $strWhere;
        $data = $this->db->query($sql);
        
        if (!$data) {
            $errorMsg = $this->db->error();
            $this->db->trans_rollback();
            return ["result"=>"db_error", "msg"=>$errorMsg];
        } else {
            $this->db->trans_commit();
            return ["result"=>"ok", "msg"=>$opt["editMode"]." ok"];
        }
        
        exit;
    }
    
    public function save_email_log($opt){
        
        $this->db->trans_begin();
        
        $session_id = getExist($this->session->userdata["user_id"], "none");
        $session_nm = getExist($this->session->userdata["user_nm"], "noname");
        
        $sql = "insert into tb_email_log (";
        $sql.= "email_type, event_idx, to_email, subject, mail_body, result, wuser, wuser_nm, wdate) values (";
        $sql.= "'".$opt["mail_type"]."', ".$opt["event_idx"].", '".$opt["to_email"]."', '".$opt["subject"]."', '".$opt["mail_body"]."', '".$opt["result"]."', ";
        $sql.= "'".$session_id."', '".$session_nm."', now() )";     
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
    
    public function save_sms_log($opt){
        
        $this->db->trans_begin();
        
        $session_id = getExist($this->session->userdata["user_id"], "none");
        $session_nm = getExist($this->session->userdata["user_nm"], "noname");
        
        $sql = "insert into tb_sms_log (";
        $sql.= "sms_type, event_idx, to_mobile, subject, mail_body, result, remain_cnt, wuser, wuser_nm, wdate) values (";
        $sql.= "'".$opt["sms_type"]."', ".$opt["event_idx"].", '".$opt["to_mobile"]."', '".$opt["subject"]."', '".$opt["mail_body"]."', ";
        $sql.= "'".$opt["result"]."', ".$opt["remain_cnt"].", '".$session_id."', '".$session_nm."', now() )";
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
    
    public function get_authkey_sms($opt){
        
        $strWhere = "where udate is null and event_idx=".$opt["event_idx"]." and auth_phone='".$opt["auth_phone"]."' and date_format(wdate, '%Y-%m-%d')='".date('Y-m-d')."' ";
        
        $sql = "select wdate from tb_auth_sms ";
        $sql.= $strWhere;
        $sql.= "order by idx desc limit 0, 1";
        $list = $this->db->query($sql)->result_array();
        
        if(count($list)==0){
            return "ok";  
        } else {
            return(time()-strtotime($list[0]["wdate"]));
        }
        exit;
    }

    public function send_authkey_sms($opt){
        
        $this->db->trans_begin();
        
        $sql = "insert into tb_auth_sms (event_idx, auth_phone, auth_key, wdate) values (";
        $sql.= $opt["event_idx"].", '".$opt["auth_phone"]."', '".$opt["auth_key"]."', now() )";
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
    
    public function valid_auth_key($opt){        
        
        $strWhere = "where udate is null and event_idx=".$opt["event_idx"]." and auth_phone='".$opt["auth_phone"]."' and auth_key='".$opt["auth_key"]."' and date_format(wdate, '%Y-%m-%d')='".date('Y-m-d')."' ";
        
        $sql = "select * from tb_auth_sms ";
        $sql.= $strWhere;        
        $dataCnt = $this->db->query($sql)->num_rows();
       
        if($dataCnt==1){            
            $exeSql = "update tb_auth_sms set udate=now() ";
            $exeSql.= $strWhere;
            $this->db->query($exeSql);
            return ["result"=>"ok", "msg"=>"valid key"];
        } else {
            return ["result"=>"no", "msg"=>"invalid key"];
        }
        
        exit;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>