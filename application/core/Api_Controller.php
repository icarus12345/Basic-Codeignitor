<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api_Controller extends CI_Controller {
    public $assigns;
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->assigns = array();
        $this->checklogin();
        $this->table = 'tbl_data';
        $this->prefix = '';
        $this->colid = 'id';
        $this->load->model('api/Auth_Model');
    }

    function checklogin() {
        $user = $this->session->userdata('dasbboard_user');
        if (!$user) {
            $output = array(
                'text' => 'fail',
                'message' => 'Permission denied',
                'code' => -1,
                'data' => null
            );
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(403)
                ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            die;
        }
    }
}
