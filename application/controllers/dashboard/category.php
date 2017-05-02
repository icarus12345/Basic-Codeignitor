<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class category extends Core_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->render('dashboard/category',null);
    }

    function view($sid = 0){
        $this->Setting_Model = new Core_Model('tbl_setting');
        $this->load->vars(array(
            'setting_detail' => $this->Setting_Model->get($sid)
        ));
        $this->index();
    }
}