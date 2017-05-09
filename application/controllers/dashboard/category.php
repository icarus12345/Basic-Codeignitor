<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class category extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/category_model");
    }
    
    function index(){
        $this->render('dashboard/category',null);
    }

    function view($sid = 0){
        $this->Setting_Model = new Core_Model('tbl_setting');
        $entry_setting = $this->Setting_Model->get($sid);
        if($entry_setting->data['columns'])
        foreach ($entry_setting->data['columns'] as $key => $column) {
            if($column['type'] == 'catetree'){
                $cat_type = $column['name'];
                $cate_data = $this->category_model->get_by_type($cat_type);
                $entry_setting->data['columns'][$key]['categories'] = $this->category_model
                    ->buildTreeArray($cate_data);
            } else if($column['type'] == 'catelist'){
                $cat_type = $column['name'];
                $cate_data = $this->category_model->get_by_type($cat_type);
                $entry_setting->data['columns'][$key]['categories'] = $cate_data;
            }
        }
        $this->load->vars(array(
            'entry_setting' => $entry_setting
        ));
        $this->index();
    }
    function vtree($sid = 0){
        
    }
    function vlist($sid = 0){

    }
}