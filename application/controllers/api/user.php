<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/Auth_Model");
    }
    
    function index(){
        echo 'Welcome API';
    }
    public $rules = array(
        'insert' => array(
                'username' => array(
                    'field'=>'username',
                    'label'=>'Username',
                    'rules'=>'trim|required'
                    ),
                        
                'email' => array(
                    'field'=>'email',
                    'label'=>'Email',
                    'rules'=>'trim|valid_email|required',
                    'errors' => array (
                        'required' => 'Error Message rule "required" for field email',
                        'trim' => 'Error message for rule "trim" for field email',
                        'valid_email' => 'Error message for rule "valid_email" for field email'
                    )
                ),
        ),
        'update' => array(
                'name' => array(
                    'field'=>'name',
                    'label'=>'Username',
                    'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
                        
                'email' => array(
                    'field'=>'email',
                    'label'=>'Email',
                    'rules'=>'trim|valid_email|required',
                    'errors' => array (
                        'required' => 'Error Message rule "required" for field email',
                        'trim' => 'Error message for rule "trim" for field email',
                        'valid_email' => 'Error message for rule "valid_email" for field email'
                    )
                ),
                'password' => array(
                    'field'=>'password',
                    'label'=>'Password',
                    'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
                'oldpassword' => array(
                    'field'=>'oldpassword',
                    'label'=>'Current Password',
                    'rules'=>'trim|required|min_length[4]|max_length[255]'
                ),
        )                    
    );
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
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    public function detail(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $output['html'] = $this->load->view('dashboard/auth/user_detail',null,true);
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    function update(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $this->form_validation->set_rules($this->rules['update']);
        $user = $this->session->userdata('dasbboard_user');
        $username = $user->ause_username;
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $oldpassword = $this->input->post('oldpassword');
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $user = $this->Auth_Model->getuser($username);
            if (!$user) {
                $output['message'] = 'User does\'t exists !';
            } else {
                if ($user->ause_password != md5($username . $password . $user->ause_secretkey)) {
                    $output['message'] = 'Current password does\'t macth !';
                }else{
                    $params = array(
                        'ause_name'=>$name,
                        'ause_email'=>$email,
                        'ause_password'=> md5($username . $password . $user->ause_secretkey),
                        );
                    $rs = $this->Auth_Model->onUpdate($user->ause_id, $params);
                    if ($rs === true) {
                        $output["code"] = 1;
                        $output["text"] = 'ok';
                        $output["message"] = 'Updated success.';
                    } else {
                        $output["code"] = -1;
                        $output["message"] = "Update failed . Please check data input and try again.";
                    }
                }
            }
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}
