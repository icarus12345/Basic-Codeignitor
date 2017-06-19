<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Project_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function insert($params){
        $this->db->set('created', 'NOW()', FALSE);
        $this->db->set('status', 1);
        @$this->db->insert('tbl_project',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    

    function update($id,$params){
        $this->db->set('modified', 'NOW()', FALSE);
        @$this->db
            ->where('id',$id)
            ->update('tbl_project',$params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }

    function get_list($uid){
        $query = $this->db
            ->where(array(
                'uid' => $uid
                ))
            ->get('tbl_project');
        $result = $query->result();
        return $result;
    }
}

?>
