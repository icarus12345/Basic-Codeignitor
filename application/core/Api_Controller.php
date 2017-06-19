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
        $this->valid_token();
        $this->load->model('api/Token_Model');
        $this->load->model('api/Client_Model');
        $this->load->model('api/Account_Model');

    }

    function valid_token() {
        $code = 403;
        $output = array(
            'text' => 'fail',
            'message' => 'Permission denied.',
            'code' => -1,
        );
        $app_id = $this->input->post('app_id');
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        $user = $this->session->userdata('api_user');
        $valid = false;
        if($user){
            $this->user = $user;
            // $u = $this->Account_Model->get_by_username($user->ac_username);
            // if($u->ac_token == $user->ac_token){
                $valid = true;
            // } else {
            //     $output['code'] = -201;
            //     $output['text'] = 'fail';
            //     $output['message'] = 'Have Another Device Access To Your Account';
            // }
        }
        if(!$valid){
            $this->output
                ->set_content_type('application/json')
                ->set_status_header($code)
                ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
                die;
        }
    }
}
