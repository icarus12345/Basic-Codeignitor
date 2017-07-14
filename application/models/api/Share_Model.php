<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Share_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function get_by_pid_email($pid,$email){
        $query=$this->db
            ->from('tbl_shared')
            ->where("pid", $pid)
            ->where("email", $email)
            ->get();

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $row = $query->row();
        return $row;
    }
    function get_by_pid($pid){
        $query=$this->db
            ->from('tbl_shared')
            ->where("pid", $pid)
            ->get();

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $entrys = $query->result();
        return $entrys;
    }
    function insert($params){
        $this->db->set('created', 'NOW()', FALSE);
        @$this->db->insert('tbl_shared',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function update($id,$params){
        $this->db->set('modified', 'NOW()', FALSE);
        @$this->db
            ->where('id',$id)
            ->update('tbl_shared',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
}

?>
