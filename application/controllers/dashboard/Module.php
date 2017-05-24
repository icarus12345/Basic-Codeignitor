<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Module extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->Module_Model = new Core_Model('tbl_module');
    }
    
    function index(){
        $this->render('dashboard/module',null);
    }

    
}
