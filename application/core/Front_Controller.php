<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Front_Controller extends CI_Controller {
    public $assigns;
    public $layout = 'main';
    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->assigns = array();
        $this->load->library('pagination');
        $this->load->model('front/Front_Model');
        $this->load->model('dashboard/Auth_Model');
        $this->load->model('front/Category_Model');
        $this->model= new Front_Model('tbl_data');
        $this->load->model('front/Setting_Model');
        $this->assigns['settings'] = $this->Setting_Model
            ->set_type('creative')
            ->get_list();
        $this->assigns['service_category'] = $this->Category_Model
            ->set_type('services')
            ->desc()
            ->gets();
        $this->assigns['project_category'] = $this->Category_Model
            ->set_type('projects')
            ->desc()
            ->gets();
        $this->assigns['event_category'] = $this->Category_Model
            ->set_type('events')
            ->desc()
            ->gets();
        $this->assigns['users'] = $this->Auth_Model
            ->get_all();
    }
    
    function render($path_view = '',$data = array()){
        $this->load->vars(array(
            'path_view' => $path_view
            ));
        $this->load->vars($this->assigns);
        $this->load->vars($data);
        $this->load->view("creative/{$this->layout}",null);
    }
    
    function paging($page=1,$perpage=10,$function=''){
        $query = $this->db->query('SELECT FOUND_ROWS() AS `found_rows`;');
        $tmp = $query->row_array();
        $total_rows = $tmp['found_rows'];
        $config['is_ajax_paging'] = $this->input->is_ajax_request();
        $config['paging_function'] = $function;
        $config['base_url'] = $function;
        $config['first_url'] = "";
        $config['suffix'] = '.html';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $perpage;
        $config['cur_page'] = $page;
        $config['num_links'] = 3;
        $config['use_page_numbers'] = true;
        // $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '«';
        // $config['first_link'] = false;
        $config['first_tag_open'] = '<li class="page first">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '»';
        // $config['last_link'] = false;
        $config['last_tag_open'] = '<li class="page last">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-arrow-right"></i>';
        $config['next_tag_open'] = '<li class="page prev">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-arrow-left"></i>';
        $config['prev_tag_open'] = '<li class="page next">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="JavaScript:">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function get_seo_tags($item = null){
        $this->assigns['seo'] = array();
        if(!empty($item)){
            $this->assigns['seo']['title'] = $item->title;
        }
        if(!empty($item) && !empty($item->data['stitle'])){
            $this->assigns['seo']['desc'] = $item->data['stitle'];
        }
        if(!empty($item) && !empty($item->data['desc'])){
            $this->assigns['seo']['desc'] = $item->data['desc'];
        }
        if(!empty($item) && !empty($item->data['sdesc'])){
            $this->assigns['seo']['desc'] = $item->data['sdesc'];
        }
        if(!empty($item) && !empty($item->data['cover'])){
            $this->assigns['seo']['image'] = $item->data['cover'];
        }
        if(!empty($item) && !empty($item->data['image'])){
            $this->assigns['seo']['image'] = $item->data['image'];
        }
        if(!empty($item) && !empty($item->data['simage'])){
            $this->assigns['seo']['image'] = $item->data['simage'];
        }
        if(!empty($item) && !empty($item->data['skeyword'])){
            $this->assigns['seo']['keywords'] = $item->data['skeywords'];
        }
    }

}