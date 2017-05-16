<?php 
$this->CI =& get_instance();
?>
<html lang="en">
    <head>
        <title>Creative</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width; initial-scale=1.0, minimum-scale=1.0, user-scalable=no" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>lib/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>lib/bootstrap/css/hover.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>lib/bootstrap/css/font-awesome.min.css?t=1">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>lib/scrollreveal/animate.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>lib/fullpage/jquery.fullPage.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/creative/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/creative/css/font-size.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/creative/css/button.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/creative/css/home.css"/>



        <script type="text/javascript" src="<?php echo base_url() ?>lib/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/owl-carousel/owl.carousel.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/jquery.nailthumb.1.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/jquery.lazyload.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/wow.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/fullpage/jquery.fullPage.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/creative/js/main.js"></script>
        <!--[if IE]>
            <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
        <![endif]-->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="full-page">
        
        
        <?php $this->load->view('creative/inc/head'); ?>
        <span class="slider-nav prev">
            <span class="arrow"></span>
            <span class="number">
                <span class="left"></span>
                <span class="middle"></span>
                <span class="right"></span>
            </span>
        </span>
        <span class="slider-nav next">
            <span class="arrow"></span>
            <span class="number">
                <span class="left">2</span>
                <span class="middle"></span>
                <span class="right"></span>
            </span>
        </span>
        <div id="fullpage">
        <?php foreach ($slider as $key => $foo) : ?>
        

            <div class="section" data-index="<?php echo $key ?>">
                <div class="section-image">
                    <div data-pos="tl"><div><div style="background-image:url('<?php echo get_image_url($foo->data['image']); ?>')" class="cover slider-bg"></div></div></div>
                    <div data-pos="tr"><div><div style="background-image:url('<?php echo get_image_url($foo->data['image']); ?>')" class="cover slider-bg"></div></div></div>
                    <div data-pos="bl"><div><div style="background-image:url('<?php echo get_image_url($foo->data['image']); ?>')" class="cover slider-bg"></div></div></div>
                    <div data-pos="br"><div><div style="background-image:url('<?php echo get_image_url($foo->data['image']); ?>')" class="cover slider-bg"></div></div></div>
                </div>
                <div class="slider-cap">
                    <div class="cap1">
                        <div class="capitalize text-animation">
                            <?php echo $foo->data['subtitle']; ?>
                        </div>
                    </div>
                    <h2 class="delay-1 text-animation-2"><?php echo $foo->title; ?></h2>
                    <a class="btn-white text-animation-2 delay-2" href="<?php echo $foo->data['url']; ?>">
                        Xem Thêm
                    </a>
                </div>
                
            </div>
        <?php endforeach; ?>
        </div>
        <?php $this->load->view('creative/inc/foot'); ?>
