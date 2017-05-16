<?php 
$this->CI =& get_instance();
$this->load->view('creative/inc/meta');
?>
    <body>
        <?php $this->load->view('creative/inc/head'); ?>
        <?php if($path_view) $this->load->view($path_view); ?>
        
        <script src="<?php echo base_url() ?>lib/scrollreveal/anijs.js"></script>
        <script src="<?php echo base_url() ?>lib/scrollreveal/anijs-helper-scrollreveal.js"></script>
        <?php $this->load->view('creative/inc/foot'); ?>
