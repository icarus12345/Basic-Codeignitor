<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Client_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get($app_id='',$app_secret=''){
        $query = $this->db
            ->where(array(
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                ))
            ->get('auth_client');
        $row = $query->row();
        return $row;
    }
}

?>
