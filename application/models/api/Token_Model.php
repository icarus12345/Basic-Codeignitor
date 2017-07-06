<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Token_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function create($app_id='',$time = 7200){
        $this->delete_expried_token();
        $token = random_string('alnum', 32);
        $this->db->set('token_app_id', $app_id);
        $this->db->set('token_id', $token);
        $this->db->set('token_created', 'NOW()', FALSE);
        $this->db->set('token_expried', "NOW() + INTERVAL {$time} SECOND", FALSE);
        @$this->db->insert('auth_token');
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return $this->get($app_id,$token);
        return false;
    }

    function get($app_id='',$token=''){
        $query = $this->db
            ->where(array(
                'token_app_id' => $app_id,
                'token_id' => $token,
                ))
            ->get('auth_token');
        $row = $query->row();
        return $row;
    }
    function get_by_token($token){
        $query = $this->db
            ->where(array(
                'token_id' => $token,
                ))
            ->get('auth_token');
        $row = $query->row();
        return $row;
    }
    function delete_expried_token(){
        @$this->db
            ->where('token_expried <','NOW()',FALSE)
            ->delete('auth_token');
    }
}

?>
