<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Project_Model");
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
                'app_id' => array(
                    'field'=>'app_id',
                    'label'=>'App ID',
                    'rules'=>'trim|required'
                ),
                        
                'app_secret' => array(
                    'field'=>'app_secret',
                    'label'=>'App Secret',
                    'rules'=>'trim|required'
                )
        )
    );

    function index(){
        echo 'Welcome API';
        $list = json_decode('{"id":"f5f7ee41d8766edb1a3a67da05f057ac","name":"Trading Spouses"},{"id":"631b550716c21bcb342fb18e129a3e8e","name":"Torchwood"},{"id":"39c0b25a55e3a405b322125c1f220d3f","name":"Top Design"},{"id":"bf62e98997138b1e9bebdfe51a52af9f","name":"Tom and Jerry"},{"id":"f0edf0f1a3017872c083da14bb4211e8","name":"Tom and Jerry Kids Show"},{"id":"eba3ebf72f89f57a3ec123a3d3048d85","name":"Til Death"},{"id":"bf4889ad3cc6f59c9046054c8beb5f1d","name":"Tim Gunns Guide to Style"},{"id":"36c8756de16467610a6634fd5b3cf18e","name":"The Black Donnellys"},{"id":"51820269b397f5d0b7aa26507b9776d0","name":"Secret Diary of a Call Girl"},{"id":"3d594614f445f6b00014e9b77730b833","name":"Friends"},{"id":"f681eda96fbfadbe01f903da7ccf07e1","name":"Free Ride"}]');
        foreach ($list as $key => $value) {
            # code...
            $params = array(
                'title' => $value->name,
                'uid' => $this->user->ac_id
                );
            $rs = $this->Project_Model->insert($params);
        }
    }

    

    function create(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $title = $this->input->post('title');
        $this->form_validation->set_rules($this->rules['create']);
        if ($this->form_validation->run() == FALSE) {
            $output['text'] = 'Fail.';
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            $params = array(
                'title' => $title,
                'uid' => $this->user->ac_id
                );
            $rs = $this->Project_Model->insert($params);
            if($rs){
                $code = 200;
                $output['code'] = 1;
                $output['text'] = 'Success.';
                $output['message'] = 'Created project success.';
                // $output['data'] = $rs;
            } else {
                $code = 200;
                $output['message'] = 'Can\'t create project.';
                $output['text'] = 'Fail.';
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    
}
