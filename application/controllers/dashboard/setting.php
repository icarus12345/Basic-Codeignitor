<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setting extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/setting_model");
        $this->table = 'tbl_setting';
        $this->Core_Model = new Core_Model($this->table);
    }
    
    function index(){
        $this->render('dashboard/welcome',null);
    }
    
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
        $output['html'] = $this->load->view('dashboard/forms/setting_detail',null,true);
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
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
}
