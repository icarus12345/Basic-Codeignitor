<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Question_Model");
    }

    public $rules = array(
        'create' => array(
                'title' => array(
                    'field'=>'title',
                    'label'=>'Project Name',
                    'rules'=>'trim|required|min_length[2]|max_length[50]|is_unique[tbl_project.title]'
                    ),
        ),
        'update' => array(
                'title' => array(
                    'field'=>'title',
                    'label'=>'Project Name',
                    'rules'=>'trim|required|min_length[2]|max_length[50]'
                    ),
        ),
        'get_list' => array(
                
        )
    );

    function index(){
        echo 'Welcome API';
    }

    function get_by_cid(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $cid = $this->input->post('cid');
        if($cid<=0) $cid = 0;
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $rs = $this->Question_Model->get_by_cid($cid);
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get list question success.';
            $output['data'] = $rs;
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
