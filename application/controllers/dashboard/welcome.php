<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class welcome extends Core_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        // $this->Core_Model = new Core_Model($this->table, $this->prefix, $this->colid);
        $this->render('dashboard/welcome',null);
    }
    
    
}
