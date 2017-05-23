<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->Setting_Model = new Core_Model('tbl_module');
    }
    
    function index(){
        // $this->Core_Model = new Core_Model($this->table, $this->prefix, $this->colid);
        $this->render('dashboard/main',null);
    }
    function load_setting($sid){
        $entry_setting = $this->Setting_Model->get($sid);
        if($entry_setting) $settings[$entry_setting->id] = $entry_setting;
        if($entry_setting->data['columns'])
        foreach ($entry_setting->data['columns'] as $key => $column) {
            if($column['type'] == 'catetree'){
                $cat_type = $column['name'];
                $cate_data = $this->Category_Model->get_by_type($cat_type);
                $entry_setting->data['columns'][$key]['categories'] = $this->Category_Model
                    ->buildTreeArray($cate_data);
            } else if($column['type'] == 'catelist'){
                $cat_type = $column['name'];
                $cate_data = $this->Category_Model->get_by_type($cat_type);
                $entry_setting->data['columns'][$key]['categories'] = $cate_data;
            } else if($column['type'] == 'list') {
                $setting = $this->Setting_Model->get($column['sid']);
                if($setting) $settings[$setting->id] = $setting;
            }
        }

         $this->load->vars(array(
            'settings' => $settings,
            'sid'=>$sid
        ));
        
    }
    function view($sid){
        $this->load_setting($sid);
        $this->index();
    }
    function detail($sid,$id){
        $this->load_setting($sid);
        $this->render('dashboard/detail',array('id'=>$id));
    }
}
