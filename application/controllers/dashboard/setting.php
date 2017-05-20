<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends Core_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->render('dashboard/setting',null);
    }
}
