<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Category_Model");
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

    function get_by_id(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $id = $this->input->post('id');
        $pid = $this->input->post('pid');
        $uid = $this->user->ac_id;
        if($id<=0) $id = 0;
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $items = $this->Category_Model->get_by_pid($id);
            $answers = $this->Category_Model->get_answer_number($uid,$pid);
            foreach ($items as $key => $value) {
                foreach ($answers as $akey => $avalue) {
                    if($value->id == $avalue->id){
                        $items[$key]->answered_num = $avalue->answered_num;
                        break;
                    }
                }
            }
            $data = array(
                'items'=>$items,
                'answers'=>$answers,
                );
            if($id>0){
                $cat = $this->Category_Model->get_by_id($id);
                if($cat){
                    $data['id'] = $cat->id;
                    $data['title'] = $cat->title;
                    $data['desc'] = $cat->data['desc'];
                }
            }
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get list category success.';
            $output['data'] = $data;
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function get(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $id = $this->input->post('id');
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $rs = $this->Project_Model->get($id);
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get category success.';
            $output['data'] = $rs;
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
