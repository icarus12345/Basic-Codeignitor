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
            'title' => array(
                'field'=>'title',
                'label'=>'Title',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'alias' => array(
                'field'=>'alias',
                'label'=>'Alias',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|min_length[4]|max_length[50]'
                ),
            'type' => array(
                'field'=>'type',
                'label'=>'TypeKey',
                'rules'=>'trim|max_length[50]',
                'errors' => array (
                    // 'required' => 'Error Message rule "required" for field Type',
                    // 'trim' => 'Error message for rule "trim" for field email',
                )
            ),
        ),
        'update' => array(
            'title' => array(
                'field'=>'title',
                'label'=>'Title',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'alias' => array(
                'field'=>'alias',
                'label'=>'Alias',
                'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|min_length[4]|max_length[50]'
                ),
            'type' => array(
                'field'=>'type',
                'label'=>'TypeKey',
                'rules'=>'trim|max_length[50]',
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
    public function create(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $this->form_validation->set_rules($this->rules['insert']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $data = $this->input->post('data');
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $type = $this->input->post('type');
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    
}
