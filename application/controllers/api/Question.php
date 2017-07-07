<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends Api_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Question_Model");
        $this->load->model("api/Project_Model");
        $this->load->model("api/Category_Model");
        $this->load->model("api/Answer_Model");
    }

    public $rules = array(
        'create' => array(
                'pid' => array(
                    'field'=>'pid',
                    'label'=>'Project',
                    'rules'=>'trim|required'
                    ),
                'qid' => array(
                    'field'=>'qid',
                    'label'=>'Question',
                    'rules'=>'trim|required'
                    ),
                'ans' => array(
                    'field'=>'ans',
                    'label'=>'Answer',
                    'rules'=>'trim|required'
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
        $pid = $this->input->post('pid');
        $uid = $this->user->ac_id;
        if($cid<=0) $cid = 0;
        // $this->form_validation->set_rules($this->rules['get_list']);
        // if ($this->form_validation->run() == FALSE) {
        //     $output['text'] = 'Fail.';
        //     $output['validation'] = validation_errors_array();
        //     $output['message'] = validation_errors();
        // } else {
            $items = $this->Question_Model->get_by_cid($cid);
            $answers = $this->Answer_Model->get_by_uid_pid_cid($uid,$pid,$cid);
            foreach ($items as $key => $value) {
                foreach ($answers as $akey => $avalue) {
                    if($avalue->qid == $value->id){
                        $items[$key]->answers[$avalue->ans]['selected'] = 1;
                        break;
                    }
                }
            }
            $data = array(
                'items' => $items
                );
            if($cid>0){
                $cat = $this->Category_Model->get_by_id($cid);
                if($cat){
                    $data['id'] = $cat->id;
                    $data['title'] = $cat->title;
                    $data['desc'] = $cat->data['desc'];
                }
            }
            $output['q'] = $this->db->last_query();
            $output['code'] = 1;
            $output['text'] = 'Success.';
            $output['message'] = 'Get list question success.';
            $output['data'] = $data;
        // }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    function answer_the_question(){
        $code = 200;
        $output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
        $qid = $this->input->post('qid');
        $pid = $this->input->post('pid');
        $ans = $this->input->post('ans');
        $uid = $this->user->ac_id;
        $this->form_validation->set_rules($this->rules['create']);
        if ($this->form_validation->run() == FALSE) {
            $output['text'] = 'Fail.';
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            $answer = $this->Answer_Model->get_answer($uid,$pid,$qid);
            if($answer){
                $params = array(
                    'qid' => $qid,
                    'uid' => $uid,
                    'pid' => $pid,
                    'ans' => $ans,
                    );
                $rs = $this->Answer_Model->update($answer->id,$params);
            }else{
                $params = array(
                    'qid' => $qid,
                    'uid' => $uid,
                    'pid' => $pid,
                    'ans' => $ans,
                    );
                $rs = $this->Answer_Model->insert($params);
            }
            if($rs){
                $code = 200;
                $output['code'] = 1;
                $output['text'] = 'Success.';
                $output['message'] = 'Answer the question success.';
                // $output['data'] = $rs;
            } else {
                $code = 200;
                $output['message'] = 'Answer the question fail.';
                $output['text'] = 'Fail.';
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
