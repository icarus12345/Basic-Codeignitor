<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
    // POST is actually in json format, do an internal translation
    $_POST += json_decode(file_get_contents('php://input'), true);
}
class Auth extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("api/Token_Model");
        $this->load->model("api/Client_Model");
        $this->load->model("api/Account_Model");
    }

    public $rules = array(
        'login' => array(
                'username' => array(
                    'field'=>'username',
                    'label'=>'Username',
                    'rules'=>'trim|required|alpha_numeric|min_length[4]|max_length[50]'
                    ),
                'password' => array(
                    'field'=>'password',
                    'label'=>'Password',
                    'rules'=>'trim|required|min_length[4]|max_length[50]'
                    ),
        ),
        'register' => array(
                'username' => array(
                    'field'=>'username',
                    'label'=>'Username',
                    'rules'=>'trim|required|alpha_numeric|min_length[4]|max_length[50]|is_unique[auth_account.ac_username]'
                    ),
                'email' => array(
                    'field'=>'email',
                    'label'=>'Email',
                    'rules'=>'trim|valid_email|required|is_unique[auth_account.ac_email]',
                    'errors' => array (
                        'required' => 'Error Message rule "required" for field email',
                        'trim' => 'Error message for rule "trim" for field email',
                        'valid_email' => 'Error message for rule "valid_email" for field email'
                    )
                ),
                'first_name' => array(
                    'field'=>'first_name',
                    'label'=>'Fist name',
                    'rules'=>'trim|required|min_length[2]|max_length[50]'
                    ),
                'last_name' => array(
                    'field'=>'last_name',
                    'label'=>'Last name',
                    'rules'=>'trim|required|min_length[2]|max_length[50]'
                    ),
                'password' => array(
                    'field'=>'password',
                    'label'=>'Password',
                    'rules'=>'trim|required|min_length[4]|max_length[50]'
                    ),
        ),
        'get_token' => array(
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
    }

    function get_token(){
        $code = 200;
        $output = array(
            'text' => 'Access Denied.',
            'code' => -1,
        );
        $app_id = $this->input->post('app_id');
        $app_secret = $this->input->post('app_secret');
        $this->form_validation->set_rules($this->rules['get_token']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            $client = $this->Client_Model->get($app_id,$app_secret);
            if($client) {
                $token = $this->Token_Model->create($client->app_id);
                if($token){
                    $code = 200;
                    $output['code'] = 1;
                    $output['text'] = 'Success';
                    $data = array(
                        'token' => $token->token_id,
                        'expried' => $token->token_expried,
                        );
                    $output['data'] = $data;
                } else {
                    $code = 403;
                    $output['message'] = 'Fail to generator token.';
                }
            } else {
                $code = 403;
                $output['message'] = 'Client does\' exists.';
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            // ->_display();
    }

    function get_client(){
        $code = 403;
        $output = array(
            'text' => 'fail',
            'message' => 'Access Denied.',
            'code' => -1,
        );
        $app_id = $this->input->post('app_id');
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        $tok = $this->Token_Model->get($app_id,$token);
        if($tok){
            $code = 200;
            // $output['code'] = -201;
            // $output['message'] = 'Have Another Device Access To Your Account';
            $output['data'] = $tok;
        } else {
            $code = 403;
            $output['message'] = 'Token invalid.';
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function register(){
        $code = 403;
        $output = array(
            'text' => 'Access Denied.',
            'code' => -1,
        );
        $app_id = $this->input->post('app_id');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $first = $this->input->post('first_name');
        $last = $this->input->post('last_name');
        $password = $this->input->post('password');
        // $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        $this->form_validation->set_rules($this->rules['register']);
        if ($this->form_validation->run() == FALSE) {
            $code = 200;
            $output['text'] = 'Fail.';
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            // $tok = $this->Token_Model->get($app_id,$token);
            // if($tok){
                $params = array(
                    'ac_username' => $username,
                    'ac_email' => $email,
                    'ac_password' => md5($password),
                    'ac_first_name' => $first,
                    'ac_last_name' => $last,
                    );
                $rs = $this->Account_Model->create($params);
                if($rs){
                    $user = $this->Account_Model->get_by_username($username);
                    $code = 200;
                    $output['code'] = 1;
                    $output['text'] = 'Success.';
                    $output['data'] = $user;
                } else {
                    $code = 200;
                    $output['text'] = 'Can\'t register account.';
                    $output['text'] = 'Fail.';
                }
            // } else {
                // $code = 403;
                // $output['message'] = 'Token invalid.';
            // }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function login(){
        $code = 403;
        $output = array(
            'text' => 'fail',
            'message' => 'Access Denied.',
            'code' => -1,
        );
        $app_id = $this->input->post('app_id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        // $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        $this->form_validation->set_rules($this->rules['login']);
        if ($this->form_validation->run() == FALSE) {
            $code = 200;
            $output['text'] = 'Fail.';
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
        } else {
            // $tok = $this->Token_Model->get($app_id,$token);
            // if($tok){
                
                    $code = 200;
                    $user = $this->Account_Model->get_by_username($username);
                    if($user){
                        if($user->ac_password == md5($password)){
                            if($user->ac_status==1){
                                unset($user->ac_password);
                                // $output['code'] = 1;
                                // $output['text'] = 'Success.';
                                $tok = $this->Token_Model->create($user->ac_id);
                                if($tok){
                                    $output['code'] = 1;
                                    $output['text'] = 'Success';
                                    $token = array(
                                        'token' => $tok->token_id,
                                        'expried' => $tok->token_expried,
                                        );
                                    $output['data'] = array(
                                        'user_info' => $user,
                                        // 'token_info' => $token,
                                        'token' => $tok->token_id,
                                        'app_id' => $user->ac_id,
                                        );
                                    $this->Account_Model->update($user->ac_id,array(
                                        'ac_token' => $tok->token_id,
                                        'ac_last_login' => date('Y-m-d H:i:s')
                                        ));
                                    $user->ac_token = $tok->token_id;
                                } else {
                                    $output['message'] = 'Fail to generator token.';
                                }
                                $this->session->set_userdata('api_user', $user);
                            } else {
                                $output['message'] = 'Your account have been deleted.';
                            }
                        } else {
                            $output['message'] = 'Login failed password did not match that for the login provided.';
                            
                        }
                    } else {
                        $output['text'] = 'User does\'t exists.';
                    }
                
            // } else {
                // $code = 403;
                // $output['message'] = 'Token invalid.';
            // }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function get_user_info(){
        $code = 200;
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => $data
        );
        $user = $this->session->userdata('api_user');
        if($user){
            // $u = $this->Account_Model->get_by_username($user->ac_username);
            // if($u->ac_token == $user->ac_token){
                // $tok = $this->Token_Model->create($user->ac_id);
                $data = array(
                    'user_info' => $user,
                    // 'token_info' => $token,
                    'token' => $user->ac_token,
                    'app_id' => $user->ac_id,
                    );
                $output['data'] = $data;
            // } else {
                // $output['code'] = -201;
                // $output['text'] = 'fail';
                // $output['message'] = 'Have Another Device Access To Your Account';
            // }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
