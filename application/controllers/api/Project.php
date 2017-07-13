<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Project_Model");
        $this->load->model("api/Answer_Model");
    }

    public $rules = array(
        'create' => array(
                'title' => array(
                    'field'=>'title',
                    'label'=>'Project Name',
                    'rules'=>'trim|required|min_length[2]|max_length[50]|is_unique[tbl_project.title]'
                    ),
                'desc' => array(
                    'field'=>'desc',
                    'label'=>'Description',
                    'rules'=>'trim|max_length[255]'
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

    function gets(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $perpage = 20;
        $page = $this->input->post('page');
        $perpage = $this->input->post('perpage');
        if($page<=0) $page = 1;
        if($perpage<=0) $perpage = 10;
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $rs = $this->Project_Model->get_list($this->user->ac_id,$page,$perpage);
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get list project success.';
            $output['data'] = $rs;
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function create(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $this->form_validation->set_rules($this->rules['create']);
        if ($this->form_validation->run() == FALSE) {
            $output['text'] = 'Fail.';
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            $params = array(
                'title' => $title,
                'desc' => $desc,
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

    function get(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $id = $this->input->post('id');
        $uid = $this->user->ac_id;
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $project = $this->Project_Model->get($id);
            $answereds = $this->Answer_Model->get_by_uid_pid($uid,$id);
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get list project success.';
            $output['data'] = array(
                'info' => $project,
                'answereds' => $answereds,
                );
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    function export(){
        $this->load->library('mpdf/mpdf');
        $mpdf = new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

        $items = $this->input->post('items');
        $info = $this->input->post('info');
        $this->load->vars(array(
            'items' => $items,
            'info' => $info,
        ));
        $html = $this->load->view('risk/pdf',null,true);

        $mpdf->WriteHTML($html);
        $pdffile = APPPATH . "../data/image/test.pdf";
        $mpdf->Output($pdffile,'F');

        $this->_code = 200;
        $this->_output['text'] = 'Success.';
        $this->_output['code'] = 1;
        $this->_output['message'] = 'Export success.';
        $this->display();
    }
}
