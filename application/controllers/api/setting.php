<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setting extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/category_model");
        $this->table = 'tbl_setting';
        $this->Core_Model = new Core_Model($this->table);
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
                    'label'=>'ID',
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
        if(!empty($id)) {
            $entry_detail = $this->Core_Model->get($id);
            $this->load->vars(array(
                'entry_detail' => $entry_detail
                ));
            $output['data'] = $entry_detail;
        }
        $setting_list = $this->Core_Model
            ->select('id,title,data')
            ->gets();
        $this->load->vars(array(
            'setting_list' => $setting_list
            ));

        $output['html'] = $this->load->view('dashboard/forms/setting_detail',null,true);
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
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $alias = $this->input->post('alias');
            $params = array(
                'title' => $title,
                'alias' => $alias,
                // 'type' => $type,
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
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $alias = $this->input->post('alias');
            $params = array(
                'title' => $title,
                'alias' => $alias,
                // 'type' => $type,
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
    function bind(){
        $type = $this->input->post('type');
        $this->Core_Model->table_config=array(
            "table"     =>"{$this->table}",
            "select"    =>"
                SELECT SQL_CALC_FOUND_ROWS 
                    {$this->table}.{$this->prefix}id,
                    {$this->table}.{$this->prefix}title,
                    {$this->table}.{$this->prefix}created,
                    {$this->table}.{$this->prefix}modified,
                    {$this->table}.{$this->prefix}status,
                    {$this->table}.{$this->prefix}data
                ",
            "from"      =>" FROM `{$this->table}` ",
            "where"     =>!empty($type)?"WHERE `{$this->prefix}type` = '$type'":'',
            "order_by"  =>"ORDER BY `{$this->prefix}created` ASC",
            "columnmaps"=>array(
                
            ),
            "filterfields"=>array(

            )
        );
        $output = $this->Core_Model->jqxBinding();
        foreach ($output['rows'] as $key => $value) {
            $data = unserialize($value->data);
            unset($output['rows'][$key]->data);
            $output['rows'][$key]->title = $output['rows'][$key]->title . ' - <small><i>' . $data['site'] .'</i></small>';
        }
        $this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($output));
    }
}