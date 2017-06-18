<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Account_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function create($params){
        $this->db->set('ac_created', 'NOW()', FALSE);
        $this->db->set('ac_status', 1);
        @$this->db->insert('auth_account',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function get_by_username($username=''){
        $query = $this->db
            ->where(array(
                'ac_username' => $username,
                ))
            ->get('auth_account');
        $row = $query->row();
        return $row;
    }
    function get_by_email($email=''){
        $query = $this->db
            ->where(array(
                'ac_email' => $email,
                ))
            ->get('auth_account');
        $row = $query->row();
        return $row;
    }
}

?>
