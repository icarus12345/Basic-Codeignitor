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
        $showthumb = $this->input->get_post('showthumb');
        $this->Core_Model = new Core_Model($this->table);
        $this->Core_Model->table_config=array(
            "table"     => "{$this->table}",
            "select"    => "
                SELECT SQL_CALC_FOUND_ROWS 
                    {$this->table}.{$this->prefix}id,
                    {$this->table}.{$this->prefix}title,
                    {$this->table}.{$this->prefix}created,
                    {$this->table}.{$this->prefix}category,
                    {$this->table}.{$this->prefix}sorting,
                    tbl_category.title as cattitle,
                    {$this->table}.{$this->prefix}modified,
                    {$this->table}.{$this->prefix}status,
                    {$this->table}.{$this->prefix}data
                ",
            "from"      => "
                FROM `{$this->table}` 
                LEFT JOIN tbl_category ON(tbl_category.id = {$this->table}.category)
            ",
            "where"     => !empty($type)?"WHERE {$this->table}.`{$this->prefix}type` = '$type'":'',
            "order_by"  => "ORDER BY {$this->table}.`{$this->prefix}sorting` DESC",
            "columnmaps"=>array(
                'cattitle'=>'tbl_category.title'
            ),
            "filterfields"=>array(
            )
        );
        $output = $this->Core_Model->jqxBinding();
        foreach ($output['rows'] as $key => $value) {
            $output['rows'][$key]->data = unserialize($output['rows'][$key]->data);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}

// include 'CP_Controller.php';
