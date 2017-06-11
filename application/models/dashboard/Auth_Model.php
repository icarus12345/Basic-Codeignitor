<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Auth_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function getuser($_username){
        $query=$this->db
                ->where("ause_username",$_username)
                ->or_where("ause_email",$_username)
                ->get("auth_users");
        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        return $query->row();
    }
    function onUpdate($id, $params) {
        $this->db->set('ause_modified', 'NOW()', FALSE);
        $this->db->where('ause_id', $id);
        @$this->db->update('auth_users', $params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function getprivileges($_userid){
        $query=$this->db
                ->select("`apri_id`,`apri_name`,`apri_key`,`apri_position`,`aupr_permission`")
                ->from("auth_user_privilege")
                ->join("auth_privileges","aupr_privilege=apri_id")
                ->where(array(
                    "`aupr_user`"=>$_userid,
                    "`apri_status`"=>"true"
                ))
                ->get();
        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $rs = $query->result();
        return $rs;
    }
    function get_all(){
        $query=$this->db
            ->select("ause_name,ause_id,ause_email,ause_picture")
            ->get("auth_users");
        $data = array();
        foreach ($query->result() as $key => $row) {
            $data[$row->ause_id] = $row;
        }
        return $data;
    }
}

?>
