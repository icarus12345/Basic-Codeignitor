<?php 
$this->CI =& get_instance();
$this->load->view('dashboard/inc/meta');
?>
    <body class="full-page">
        <?php $this->load->view('dashboard/inc/header'); ?>
        <div class="container page-container">
            <?php $this->load->view('dashboard/inc/nav'); ?>
            <div class="page-content">
                <?php $this->load->view($path_view); ?>
            </div>
        </div>
        <?php $this->load->view('dashboard/inc/footer'); ?>
        
        
        