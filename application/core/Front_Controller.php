<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Front_Controller extends CI_Controller {
    public $assigns;
    public $layout = 'main';
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->assigns = array();
        $this->load->model('front/front_model');
        $this->load->model('front/category_model');
        $this->model= new front_model('tbl_data');
        
        $this->assigns['service_category'] = $this->category_model
            ->set_type('services')
            ->desc()
            ->gets();
        $this->assigns['project_category'] = $this->category_model
            ->set_type('projects')
            ->desc()
            ->gets();
        $this->assigns['event_category'] = $this->category_model
            ->set_type('events')
            ->desc()
            ->gets();
    }
    
    function render($path_view = '',$data = array()){
        $this->load->vars(array(
            'path_view' => $path_view
            ));
        $this->load->vars($this->assigns);
        $this->load->vars($data);
        $this->load->view("creative/{$this->layout}",null);
    }
    
    

    

}