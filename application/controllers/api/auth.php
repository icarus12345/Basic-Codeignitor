<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class auth extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/auth_model");
    }
    
    function index(){
        echo 'Welcome API';
    }
    
    function logout(){
        $this->session->sess_destroy();
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    function login(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $code = 1;
        $username = $this->input->get_post('username');
        $password = $this->input->get_post('password');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
        // $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else if ($this->session->userdata('dasbboard_user')) {
            $output['code'] = 1;
            $output['message'] = 'You already signed in on Dashboard System.';
            $output['text'] = 'ok';
        } else {

            $nlogin = (int)$this->session->userdata('nlogin');
            $this->session->set_userdata('nlogin', ++$nlogin);
            $user = $this->auth_model->getuser($username);
            if (!$user) {
                $output['message'] = 'Username or Password don\'t match.';
            } else {
                if ($user->ause_password != md5($username . $password . $user->ause_secretkey)) {
                    $name = $user->ause_name;
                    $output['code'] = -906;
                    $output['message'] = "Login failed for user '$name'.";
                }elseif ($user->ause_delete !== null) {
                    $output['code'] = -901;
                    $output['message'] = "Valid login but user have been deleted.";
                }elseif ($user->ause_status === "true") {
                    unset($user->ause_password);
                    unset($user->ause_salt);
                    unset($user->ause_secretkey);
                    
                    $authoritys = explode(',', $user->ause_authority);
                    $this->fileverify($authoritys);

                    $this->session->set_userdata('dasbboard_user', $user);

                    $output['code'] = 1;
                    $output['text'] = 'ok';
                    $output['data'] = $user;
                    $output['nlogin'] = $nlogin;
                    $this->session->set_userdata('nlogin', 0);
                } else {
                    $output['code'] = -902;
                    $output['message'] = "Valid login but user is not active.";
                }
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    private function fileverify($authoritys) {
        unset($_SESSION['KCFINDER']);
        if (
                !!array_intersect(array('Administrator', 'Admin', 'User'), $authoritys)
        ) {
            $_SESSION['KCFINDER']['disabled'] = false;
            $_SESSION['KCFINDER']['uploadURL'] = ('/data');
            $_SESSION['KCFINDER']['uploadDir'] = BASEPATH.'../data';
            $files = array(
                'upload' => true,
                'delete' => true,
                'copy' => true,
                'move' => true,
                'rename' => true,
                'edit' => true,
            );
            $dirs = array(
                'create' => true,
                'delete' => true,
                'rename' => true
            );
        } elseif (
                !!array_intersect(array('View'), $authoritys)
        ) {
            $_SESSION['KCFINDER']['uploadURL'] = ('/data'); //base_url("data");
            $_SESSION['KCFINDER']['uploadDir'] = BASEPATH.'../data';
            $_SESSION['KCFINDER']['disabled'] = false;
            $files = array(
                'upload' => false,
                'delete' => false,
                'copy' => false,
                'move' => false,
                'rename' => false,
                'edit' => false,
            );
            $dirs = array(
                'create' => false,
                'delete' => false,
                'rename' => false
            );
        } else {
            $_SESSION['KCFINDER']['uploadURL'] = ('/data'); //base_url("data");
            $_SESSION['KCFINDER']['uploadDir'] = BASEPATH.'../data';
            $_SESSION['KCFINDER']['disabled'] = true;

            $files = array(
                'upload' => false,
                'delete' => false,
                'copy' => false,
                'move' => false,
                'rename' => false
            );
            $dirs = array(
                'create' => false,
                'delete' => false,
                'rename' => false
            );
        }
        $_SESSION['KCFINDER']['access'] = array(
            'files' => $files,
            'dirs' => $dirs
        );
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
                'id' => array(
                    'field'=>'id',
                    'label'=>'ID',
                    'rules'=>'trim|is_natural_no_zero|required'
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
}
