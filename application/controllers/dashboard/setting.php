<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setting extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/setting_model");
    }
    
    function index(){
        $this->render('dashboard/welcome',null);
    }
    
    function detail(){
        $setting_data = $this->setting_model->get_common();
        $this->load->vars(array(
            'setting_data' => $setting_data
            ));
        $this->load->view('dashboard/forms/setting_detail');
    }
    
}
