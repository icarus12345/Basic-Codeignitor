<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/User_Model");
    }
    
    function index(){
        $this->render('dashboard/user',null);
    }
}