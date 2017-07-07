<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Question_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function get_by_cid($cid=0){
        $query=$this->db
            ->where("category", $cid)
            ->where("status", '1')
            ->get('tbl_data2');

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $data = unserialize($entrys[$key]->data);
            unset($entrys[$key]->data);
            $entrys[$key]->answers = $data['answers'];
        }
        return $entrys;
    }
    
}

?>
