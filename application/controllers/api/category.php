<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class category extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/category_model");
        $this->table = 'tbl_category';
        $this->Core_Model = new Core_Model($this->table);
        $this->Setting_Model = new Core_Model('tbl_setting');
    }
    
    function index(){
        echo 'Welcome API';
    }
    public function title_check($str){
        if ($str == 'test')
        {
                $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }
    public $rules = array(
        'insert' => array(
                'title' => array(
                    'field'=>'title',
                    'label'=>'Title',
                    'rules'=>'trim|required|min_length[4]|max_length[255]|callback_title_check'
                    ),
                'alias' => array(
                    'field'=>'alias',
                    'label'=>'Alias',
                    'rules'=>'trim|required|min_length[4]|max_length[255]'
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
                'pid' => array(
                    'field'=>'pid',
                    'label'=>'Parent ID',
                    'rules'=>'trim|integer'
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
                    'label'=>'ID',
                    'rules'=>'trim|is_natural_no_zero|required'
                ),
                'pid' => array(
                    'field'=>'pid',
                    'label'=>'Parent ID',
                    'rules'=>'trim|integer'
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
            if(
                !empty($entry_setting->data['catetype']) &&
                $entry_setting->data['cateviewer'] == 'tree'
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
        }
        if(!empty($id)) {
            $entry_detail = $this->Core_Model->get($id);
            $this->load->vars(array(
                'entry_detail' => $entry_detail
                ));
            $output['data'] = $entry_detail;
        }
        $output['html'] = $this->load->view('dashboard/forms/category_detail',null,true);
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
    public function delete(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        if(!empty($id)) {
            $entry_detail = $this->Core_Model->get($id);
            if($entry_detail){

                $rs = $this->Core_Model->onDelete($id);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Deleted record on database.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Record faily to delete. Please check data input and try again.";
                }
            } else {
                $output["message"] = "Record does't exists.";
            }
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    public function onupdate(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $this->form_validation->set_rules($this->rules['update']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $data = $this->input->post('data');
            $id = $this->input->post('id');
            $pid = $this->input->post('pid');
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $alias = $this->input->post('alias');
            $params = array(
                'title' => $title,
                'alias' => $alias,
                'pid' => $pid,
                'type' => $type,
                'data' => serialize($data),
                );
            $rs = $this->Core_Model->onUpdate($id, $params);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Updated record to database.';
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
        $this->form_validation->set_rules($this->rules['insert']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $data = $this->input->post('data');
            $id = $this->input->post('id');
            $pid = $this->input->post('pid');
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $alias = $this->input->post('alias');
            $params = array(
                'title' => $title,
                'alias' => $alias,
                'type' => $type,
                'pid' => $pid,
                'data' => serialize($data),
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
    function updateBatch($aaData){
        if(!empty($aaData)) foreach ($aaData as $c){
            if($c->value!=$c->cat_value){
                $this->cate_model->onUpdate($c->cat_id,array('cat_value'=>$c->value));
            }
        }
    }
    function bind(){
        $type = $this->input->post('type');
        $this->category_model->table_config=array(
            "table"     =>"{$this->table}",
            "select"    =>"
                SELECT SQL_CALC_FOUND_ROWS 
                    {$this->table}.{$this->prefix}id,
                    {$this->table}.{$this->prefix}title,
                    {$this->table}.{$this->prefix}pid,
                    {$this->table}.{$this->prefix}created,
                    {$this->table}.{$this->prefix}modified,
                    {$this->table}.{$this->prefix}status
                ",
            "from"      =>" FROM `{$this->table}` ",
            "where"     =>!empty($type)?"WHERE `{$this->prefix}type` = '$type'":'',
            "order_by"  =>"ORDER BY `{$this->prefix}pid` ASC,`{$this->prefix}position` ASC",
            "columnmaps"=>array(
                
            ),
            "filterfields"=>array(

            )
        );
        $output = $this->category_model->jqxBinding();
        $output['rows']=$this->category_model->buildTreeArray($output['rows']);
        $this->updateBatch($output['rows']);
        $this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($output));
    }
}