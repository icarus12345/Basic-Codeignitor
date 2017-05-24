<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/Category_Model");
    }
    
    function index(){
        $this->view('');
    }

    function view($type = ''){
        $this->assigns['type'] = $type;
        $this->render('dashboard/type',null);
    }
}