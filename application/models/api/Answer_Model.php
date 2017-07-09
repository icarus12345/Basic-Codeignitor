<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Answer_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function get_by_uid_pid_cid($uid,$pid,$cid){
        $query=$this->db
            ->select('tbl_answer.*')
            ->from('tbl_answer')
            ->join('tbl_data2','tbl_answer.qid = tbl_data2.id','left')
            ->where("uid", $uid)
            ->where("pid", $pid)
            ->where("status", '1')
            ->where("category", $cid)
            ->get();

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $entrys = $query->result();
        return $entrys;
    }
    function get_by_uid_pid($uid,$pid){
        $query=$this->db
            ->select('tbl_answer.*')
            ->from('tbl_answer')
            ->join('tbl_data2','tbl_answer.qid = tbl_data2.id','left')
            ->where("uid", $uid)
            ->where("pid", $pid)
            ->where("status", '1')
            ->get();

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $entrys = $query->result();
        return $entrys;
    }
    function get_answer($uid,$pid,$qid){
        $query=$this->db
            ->where("uid", $uid)
            ->where("pid", $pid)
            ->where("qid", $qid)
            ->get('tbl_answer');

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $row = $query->row();
        return $row;
    }
    function insert($params){
        $this->db->set('created', 'NOW()', FALSE);
        @$this->db->insert('tbl_answer',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function update($id,$params){
        $this->db->set('modified', 'NOW()', FALSE);
        @$this->db
            ->where('id',$id)
            ->update('tbl_answer',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
}

?>
