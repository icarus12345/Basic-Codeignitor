<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends Front_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $this->layout='home';
        $slider = $this->model
            ->set_type('slider')
            ->desc()
            ->gets();
        $this->assigns['slider'] = $slider;
        $this->render(null,null);
    }
    public function about(){
        $this->layout='main';
        $this->assigns['abouts'] = $this->model->get('15');
        $this->assigns['staffs'] = $this->model
            ->set_type('staff')
            ->gets();
        $this->render('creative/page/about',null);
    }
    public function services(){
        $this->layout='main';
        // $this->assigns['abouts'] = $this->model->get('15');
        // $this->assigns['staffs'] = $this->model
        //     ->set_type('staff')
        //     ->gets();
        $this->render('creative/page/services',null);
    }

}
