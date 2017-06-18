<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Core_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/Auth_Model");
        $this->load->model("dashboard/User_Model");
    }
    
    function index(){
        echo 'Welcome API';
    }
    public $rules = array(
        'insert' => array(
                'params[ause_username]' => array(
                    'field'=>'params[ause_username]',
                    'label'=>'Username',
                    'rules'=>'trim|required'
                    ),
                        
                'params[ause_email]' => array(
                    'field'=>'params[ause_email]',
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
                'params[ause_username]' => array(
                    'field'=>'params[ause_username]',
                    'label'=>'Username',
                    'rules'=>'trim|required'
                    ),
                        
                'params[ause_email]' => array(
                    'field'=>'params[ause_email]',
                    'label'=>'Email',
                    'rules'=>'trim|valid_email|required',
                    'errors' => array (
                        'required' => 'Error Message rule "required" for field email',
                        'trim' => 'Error message for rule "trim" for field email',
                        'valid_email' => 'Error message for rule "valid_email" for field email'
                    )
                ),
        ),
        'updatemyaccount' => array(
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
    public function myaccount(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $output['html'] = $this->load->view('dashboard/auth/myaccount',null,true);
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
        $ause_id = $this->input->post('ause_id');
        $user = $this->session->userdata('dasbboard_user');
        if(!empty($ause_id)) {
            $user_detail = $this->User_Model->get($ause_id);
            if($user_detail){
                if($user_detail->ause_position > $user->ause_position){
                    $this->load->vars(array(
                        'user_detail' => $user_detail
                        ));
                    $output['data'] = $user_detail;
                    $output['html'] = $this->load->view('dashboard/auth/user_detail',null,true);
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Requires an administrative account. Please check your authority, and try again.";
                }
            } else {
                $output["code"] = -1;
                $output["message"] = "User does't exists.";
            }
        } else {
            $output['html'] = $this->load->view('dashboard/auth/user_detail',null,true);
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    function updatemyaccount(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $this->form_validation->set_rules($this->rules['updatemyaccount']);
        $user = $this->session->userdata('dasbboard_user');
        $username = $user->ause_username;
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $avatar = $this->input->post('avatar');
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
                if(!empty($password) && $user->ause_password != md5($username . $oldpassword . $user->ause_secretkey)) {
                        $output['message'] = 'Current password does\'t macth !';
                } else {
                    $params = array(
                        'ause_name'=>$name,
                        'ause_email'=>$email,
                        'ause_picture'=>$avatar,
                        // 'ause_password'=> md5($username . $password . $user->ause_secretkey),
                        );
                    if(!empty($password)){
                        $params['ause_password'] = md5($username . $password . $user->ause_secretkey);
                    }
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

    function bind(){
        $this->User_Model->table_config=array(
            "table"     =>"auth_users",
            "select"    =>"
                SELECT SQL_CALC_FOUND_ROWS ause_id,ause_name,ause_email,ause_username,ause_created,ause_modified,ause_status
                ",
            "from"      => "FROM auth_users",
            "where"     => 'WHERE ause_deleted is null',
            "order_by"  => "",
            "columnmaps"=>array(
                
            ),
            "filterfields"=>array(

            )
        );
        $output = $this->User_Model->jqxBinding();
        $this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($output));
    }

    function commit(){
        $ause_id = $this->input->post('ause_id');
        if(!empty($ause_id)) $this->onupdate();
        else $this->oncreate();
    }

    public function onupdate(){
        $output = array(
            'text' => 'This function to requires an administrative account. Please check your authority, and try again.',
            'code' => -1,
            'data' => null
        );
        $user = $this->session->userdata('dasbboard_user');
        $ause_id = $this->input->post('ause_id');
        

        $params = $this->input->post('params');
        $ause_name = $this->input->post('ause_name');
        $ause_username = $this->input->post('ause_username');
        $ause_email = $this->input->post('ause_email');
        $ause_password = $this->input->post('ause_password');
        $ause_picture = $this->input->post('ause_picture');
        $ause_authority = $this->input->post('ause_authority');


        $this->form_validation->set_rules($this->rules['update']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {
            $user_detail = $this->User_Model->get($ause_id);
            if($user_detail){
                if($user_detail->ause_position > $user->ause_position){
                    // $params = array();
                    // if(isset($ause_name)) $params['ause_name'] = $ause_name;
                    // if(isset($ause_username)) $params['ause_username'] = $ause_username;
                    // if(isset($ause_email)) $params['ause_email'] = $ause_email;
                    // if(isset($ause_password)) $params['ause_password'] = $ause_password;
                    // if(isset($ause_picture)) $params['ause_picture'] = $ause_picture;
                    // if(isset($ause_authority)) $params['ause_authority'] = $ause_authority;
                    if(!empty($params["ause_password"])){
                        $params["ause_password"]=md5($user_detail->ause_username.$params["ause_password"].$user_detail->ause_secretkey);
                    } else {
                        unset($params["ause_password"]);
                    }
                    // $params['ause_status'] = 1;

                    
                    $rs = $this->User_Model->onUpdate($ause_id,$params);
                    if ($rs === true) {
                        $output["code"] = 1;
                        $output["text"] = 'ok';
                        $output["message"] = 'Register record to database.';
                    } else {
                        $output["code"] = -1;
                        $output["message"] = "Record faily to insert. Please check data input and try again.";
                    }
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Requires an administrative account. Please check your authority, and try again.";
                }
            } else {
                $output["code"] = -1;
                $output["message"] = "User does't exists.";
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function oncreate(){
        $output = array(
            'text' => 'This function to requires an administrative account. Please check your authority, and try again.',
            'code' => -1,
            'data' => null
        );
        $user = $this->session->userdata('dasbboard_user');

        $params = $this->input->post('params');
        $ause_name = $this->input->post('ause_name');
        $ause_username = $this->input->post('ause_username');
        $ause_email = $this->input->post('ause_email');
        $ause_password = $this->input->post('ause_password');
        $ause_picture = $this->input->post('ause_picture');
        $ause_authority = $this->input->post('ause_authority');


        $this->form_validation->set_rules($this->rules['insert']);
        if ($this->form_validation->run() == FALSE) {
            $output['validation'] = validation_errors_array();
            $output['message'] = validation_errors();
            // $output['code'] = -1;
        } else {

            // $params = array();
            // if(isset($ause_name)) $params['ause_name'] = $ause_name;
            // if(isset($ause_username)) $params['ause_username'] = $ause_username;
            // if(isset($ause_email)) $params['ause_email'] = $ause_email;
            // if(isset($ause_password)) $params['ause_password'] = $ause_password;
            // if(isset($ause_picture)) $params['ause_picture'] = $ause_picture;
            // if(isset($ause_authority)) $params['ause_authority'] = $ause_authority;

            $params["ause_key"] = random_string('alnum', 8);
            $params["ause_salt"] = random_string('alnum', 8);
            $params["ause_secretkey"] = random_string('alnum', 32);
            $params["ause_password"]=md5($params["ause_username"].$params["ause_password"].$params["ause_secretkey"]);
            $params["ause_position"]=$user->ause_position+1;
            $params['ause_status'] = 1;

            
            $rs = $this->User_Model->onInsert($params);
            if ($rs === true) {
                $output["code"] = 1;
                $output["text"] = 'ok';
                $output["message"] = 'Register success.';
            } else {
                $output["code"] = -1;
                $output["message"] = "Record faily to register account. Please check data input and try again.";
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    function delete(){
        $output = array(
            'text' => 'This function to requires an administrative account. Please check your authority, and try again.',
            'code' => -1,
            'data' => null
        );
        $user = $this->session->userdata('dasbboard_user');
        $ause_id = $this->input->post('ause_id');
        

        
        
            $user_detail = $this->User_Model->get($ause_id);
        if($user_detail){
            if($user_detail->ause_position > $user->ause_position){
                $params = array();
                $params['ause_deleted'] = date('Y-m-d H:i:s');

                
                $rs = $this->User_Model->onUpdate($ause_id,$params);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Deleted success.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Record faily to delete. Please check data input and try again.";
                }
            } else {
                $output["code"] = -1;
                $output["message"] = "Requires an administrative account. Please check your authority, and try again.";
            }
        } else {
            $output["code"] = -1;
            $output["message"] = "User does't exists.";
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}
