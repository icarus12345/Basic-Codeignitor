<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/Category_Model");
        $this->table = 'tbl_category';
        $this->Core_Model = new Core_Model($this->table);
        $this->Setting_Model = new Core_Model('tbl_module');
    }
    
    function index(){
        echo 'Welcome API';
    }
    public $rules = array(
        'unique' => array(
            'title' => array(
                'field'=>'title',
                'label'=>'Title',
                'rules'=>'callback_title_check'
            ),
        ),
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
                    'rules'=>'trim|max_length[255]'
                    ),
                'alias' => array(
                    'field'=>'alias',
                    'label'=>'Alias',
                    'rules'=>'trim|max_length[255]'
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
    public function title_check($str){
        $alias = $this->input->post('alias');
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $row = $this->Core_Model
            ->set_type($type)
            ->get_by_alias($alias);
        if($row && $row->id!=$id){
            $this->form_validation->set_message('title_check', 'The {field} field are already inserted');
            return FALSE;
        }
        return TRUE;
    }
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
                $cate_data = $this->Category_Model->get_by_type($cat_type);
                $entry_setting->data['categories'] = $this->Category_Model
                    ->buildTreeArray($cate_data);
            }
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
        // if($entry_setting->data['unique'] == 'true'){
            $this->form_validation->set_rules($this->rules['unique']);
        // }
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $params = array();
            $id = $this->input->post('id');
            $pid = $this->input->post('pid');
            if(isset($pid)) $params['pid'] = $pid;
            $title = $this->input->post('title');
            if(isset($title)) $params['title'] = $title;
            $alias = $this->input->post('alias');
            if(isset($alias)) $params['alias'] = $alias;
            $type = $this->input->post('type');
            if(isset($type)) $params['type'] = $type;
            $status = $this->input->post('status');
            if(isset($status)) $params['status'] = $status;
            $data = $this->input->post('data');
            if(isset($data)) $params['data'] = serialize($data);
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
        // if($entry_setting->data['unique'] == 'true'){
                $this->form_validation->set_rules($this->rules['unique']);
        // }
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
                'status' => 1,
                'pid' => $pid,
                'data' => serialize($data),
                );
            
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
        $this->Category_Model->table_config=array(
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
            "order_by"  =>"ORDER BY `{$this->prefix}pid` ASC,`{$this->prefix}sorting` DESC",
            "columnmaps"=>array(
                
            ),
            "filterfields"=>array(

            )
        );
        $output = $this->Category_Model->jqxBinding();
        $output['rows']=$this->Category_Model->buildTreeArray($output['rows']);
        $this->updateBatch($output['rows']);
        $this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($output));
    }

    public function sendlatest(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $entry_detail = $this->Category_Model->get($id);
        if($entry_detail){
            
            $rs = $this->Category_Model->onSendLatest($id);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Success.';
            } else {
                $output["code"] = -1;
                $output["message"] = "Entry faily to update. Please check data input and try again.";
            }
        }else{
            $output["message"] = 'Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function sendoldest(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $entry_detail = $this->Category_Model->get($id);
        if($entry_detail){
            
            $rs = $this->Category_Model->onSendOldest($id);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Success.';
            } else {
                $output["code"] = -1;
                $output["message"] = "Entry faily to update. Please check data input and try again.";
            }
        }else{
            $output["message"] = 'Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}