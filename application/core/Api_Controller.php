<?php
class Api_Controller extends CI_Controller {
    public $assigns;
    public $layout = 'main';
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->assigns = array();
        $this->checklogin();
        $this->table = 'tbl_data';
        $this->prefix = '';
        $this->colid = 'id';
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
                ->set_status_header(200)
                ->set_output(json_encode($output,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            die;
        }
    }

    function bind(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        if(!empty($this->input->get_post('table'))){
            $this->table = $this->input->get_post('table');
        }
        $type = $this->input->get_post('type');
        $this->Core_Model = new Core_Model($this->table);
        $this->Core_Model->table_config=array(
            "table"     =>"{$this->table}",
            "select"    =>"
                SELECT SQL_CALC_FOUND_ROWS 
                    {$this->table}.{$this->prefix}id,
                    {$this->table}.{$this->prefix}title,
                    {$this->table}.{$this->prefix}created,
                    {$this->table}.{$this->prefix}modified,
                    {$this->table}.{$this->prefix}status
                ",
            "from"      =>"
                FROM `{$this->table}` 
            ",
            "where"     =>"WHERE `{$this->prefix}type` = '$type'",
            "order_by"  =>"ORDER BY `{$this->prefix}created` DESC",
            "columnmaps"=>array(
                
            ),
            "filterfields"=>array(

            )
        );
        $output = $this->Core_Model->jqxBinding();
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}

// include 'FE_Controller.php';
// include 'CP_Controller.php';
