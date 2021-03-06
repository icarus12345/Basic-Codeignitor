<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
    // POST is actually in json format, do an internal translation
    $_POST += json_decode(file_get_contents('php://input'), true);
}
class Api_Controller extends CI_Controller {
    public $assigns;
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->assigns = array();
        $this->load->model('api/Token_Model');
        $this->load->model('api/Client_Model');
        $this->load->model('api/Account_Model');
        $this->valid_token();
        $this->_code = 200;
        $this->_output = array(
            'text' => 'fail',
            'message' => 'Bad request.',
            'code' => -1,
        );
    }

    function display(){
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($this->_code)
            ->set_output(json_encode($this->_output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
            die;
    }

    function valid_token() {
        $app_id = $this->input->post('app_id');
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        $tok = $this->Token_Model->get_by_token($token);
        $valid = false;
        if($tok){
            $valid = true;
            $user = $this->session->userdata('api_user');
            if(!$user){

                $user = $this->Account_Model->get_by_id($tok->token_app_id);
                $this->session->set_userdata('api_user', $user);
            }
            $this->user = $user;
        }
        if(!$valid){
            // $this->_code = 403;
            // $this->_output['message'] = 'Permission denied.';
            // $this->display();
        }
    }
}
