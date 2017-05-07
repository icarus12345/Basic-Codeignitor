<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class common extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/auth_model");
        $this->Setting_Model = new Core_Model('tbl_setting');
        $this->load->model("dashboard/category_model");
    }
    
    function index(){
        echo 'Welcome API';
    }
    public $rules = array(
        'insert' => array(
            'data[title]' => array(
                'field'=>'data[title]',
                'label'=>'Title',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[alias]' => array(
                'field'=>'data[alias]',
                'label'=>'Alias',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|min_length[4]|max_length[50]'
                ),
            'data[category]' => array(
                'field'=>'data[category]',
                'label'=>'Category',
                'rules'=>'trim|integer'
                ),
            'sid' => array(
                'field'=>'sid',
                'label'=>'Setting Entry',
                'rules'=>'trim|required|is_natural_no_zero',
                'errors' => array (
                    // 'required' => 'Error Message rule "required" for field Type',
                    // 'trim' => 'Error message for rule "trim" for field email',
                )
            ),
        ),
        'update' => array(
            'data[title]' => array(
                'field'=>'data[title]',
                'label'=>'Title',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[alias]' => array(
                'field'=>'data[alias]',
                'label'=>'Alias',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|min_length[4]|max_length[50]'
                ),
            'data[category]' => array(
                'field'=>'data[category]',
                'label'=>'Category',
                'rules'=>'trim|integer'
                ),
            'sid' => array(
                'field'=>'sid',
                'label'=>'Setting Entry',
                'rules'=>'trim|required|is_natural_no_zero',
                'errors' => array (
                    // 'required' => 'Error Message rule "required" for field Type',
                    // 'trim' => 'Error message for rule "trim" for field email',
                )
            ),
            'id' => array(
                'field'=>'id',
                'label'=>'Id',
                'rules'=>'trim|is_natural_no_zero|required'
            ),
        )
    );
    function detail(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        if(!empty($sid)) {
            $entry_setting = $this->Setting_Model->get($sid);
            if($entry_setting){
                if(
                    !empty($entry_setting->data['catetype']) &&
                    (
                        $entry_setting->data['cateviewer'] == 'tree' ||
                        $entry_setting->data['cateviewer'] == 'list'
                    )
                    ){
                    $cat_type = $entry_setting->data['catetype'];
                    $cate_data = $this->category_model->get_by_type($cat_type);
                    $entry_setting->data['categories'] = $this->category_model
                        ->buildTreeArray($cate_data);
                }
                if(!empty($entry_setting->data['columns'])) foreach ($entry_setting->data['columns'] as $key => $column) {
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
                $storage = $entry_setting->data['storage'];
                if(!empty($storage)){
                    if(!empty($id)) {
                        $this->Core_Model = new Core_Model($storage);
                        $entry_detail = $this->Core_Model->get($id);
                        $this->load->vars(array(
                            'entry_detail' => $entry_detail
                            ));
                        $output['data'] = $entry_detail;
                    }
                    $output['html'] = $this->load->view('dashboard/forms/common_detail',null,true);
                } else {
                    $output['text'] = 'fail';
                    $output['code'] = -1;
                    $output['message'] = 'Storage does\'t exitst.';
                }
            } else {
                $output['text'] = 'fail';
                $output['code'] = -1;
                $output['message'] = 'Setting does\'t exitst.';
            }
        }
        ;
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    function subdetail(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $data = $this->input->post('data');
        $sid = $this->input->post('sid');
        if(!empty($sid)) {
            $entry_setting = $this->Setting_Model->get($sid);
            if($entry_setting){
                if(
                    !empty($entry_setting->data['catetype']) &&
                    (
                        $entry_setting->data['cateviewer'] == 'tree' ||
                        $entry_setting->data['cateviewer'] == 'list'
                    )
                    ){
                    $cat_type = $entry_setting->data['catetype'];
                    $cate_data = $this->category_model->get_by_type($cat_type);
                    $entry_setting->data['categories'] = $this->category_model
                        ->buildTreeArray($cate_data);
                }
                if(!empty($entry_setting->data['columns'])) foreach ($entry_setting->data['columns'] as $key => $column) {
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
                $storage = $entry_setting->data['storage'];
                if(!empty($storage)){
                    if(!empty($data)) {
                        $this->load->vars(array(
                            'entry_detail' => (object)$data
                            ));
                        $output['data'] = $data;
                    }
                    $output['html'] = $this->load->view('dashboard/forms/subcommon_detail',null,true);
                } else {
                    $output['text'] = 'fail';
                    $output['code'] = -1;
                    $output['message'] = 'Storage does\'t exitst.';
                }
            } else {
                $output['text'] = 'fail';
                $output['code'] = -1;
                $output['message'] = 'Setting does\'t exitst.';
            }
        }
        ;
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    function commit(){
        $id = $this->input->post('id');
        if(!empty($id)) $this->onupdate();
        else $this->oncreate();
    }

    public function onupdate(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $sid = $this->input->post('sid');
        $entry_setting = $this->Setting_Model->get($sid);
        if($entry_setting){
            if($entry_setting->data['columns']) foreach ($entry_setting->data['columns'] as $key => $column) {
                if(!empty($column['server'])){
                    $field = 'data[data]['.$column['name'].']';
                    if($column['biz'] == '1'){
                        $field = 'data[longdata]['.$column['name'].']';
                    }
                    $label = $column['title'];
                    $rule = $column['server'];
                    $this->form_validation->set_rules($field,$label,$rule);
                }
            }
        } else {

        }

        $this->form_validation->set_rules($this->rules['insert']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {

            $data = $this->input->post('data[data]');
            $longdata = $this->input->post('data[longdata]');
            $id = $this->input->post('id');
            $title = $this->input->post('data[title]');
            $type = $this->input->post('data[type]');
            $alias = $this->input->post('data[alias]');
            $category = $this->input->post('data[category]');

            $table = $entry_setting->data['storage'];
            $params = array(
                'category' => $category,
                'title' => $title,
                'alias' => $alias,
                'type' => $type,
                'pid' => $pid,
                'data' => serialize($data),
                'longdata' => serialize($longdata),
                );
            $this->Core_Model = new Core_Model($this->table);
            $rs = $this->Core_Model->onUpdate($id, $params);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Register record to database.';
            } else {
                $output["code"] = -1;
                $output["message"] = "Record faily to insert. Please check data input and try again.";
            }
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function oncreate(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $sid = $this->input->post('sid');
        $entry_setting = $this->Setting_Model->get($sid);
        if($entry_setting){
            if($entry_setting->data['columns']) foreach ($entry_setting->data['columns'] as $key => $column) {
                if(!empty($column['server'])){
                    $field = 'data[data]['.$column['name'].']';
                    if($column['biz'] == '1'){
                        $field = 'data[longdata]['.$column['name'].']';
                    }
                    $label = $column['title'];
                    $rule = $column['server'];
                    $this->form_validation->set_rules($field,$label,$rule);
                }
            }
        } else {

        }

        $this->form_validation->set_rules($this->rules['insert']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {

            $data = $this->input->post('data[data]');
            $longdata = $this->input->post('data[longdata]');
            $id = $this->input->post('id');
            $title = $this->input->post('data[title]');
            $type = $this->input->post('data[type]');
            $alias = $this->input->post('data[alias]');

            $table = $entry_setting->data['storage'];
            $params = array(
                'title' => $title,
                'alias' => $alias,
                'type' => $type,
                'pid' => $pid,
                'data' => serialize($data),
                'longdata' => serialize($longdata),
                );
            $this->Core_Model = new Core_Model($this->table);
            $rs = $this->Core_Model->onInsert($params);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Register record to database.';
            } else {
                $output["code"] = -1;
                $output["message"] = "Record faily to insert. Please check data input and try again.";
            }
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    
}
