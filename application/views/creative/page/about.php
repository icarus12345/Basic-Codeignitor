        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/jssor/jssor.slider-22.2.16.min.js"></script>
        <script src="<?php echo base_url() ?>lib/jssor/jssor-transitions.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/creative/js/about-jssor.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/creative/css/jssor-theme.css"/>
        


        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $abouts->title; ?></span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $abouts->title; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div data-wow-delay="0.2s" class="slogan wow zoomInDown">
            <div class="title" data-fz="bigger"><?php echo $abouts->data['slogan']; ?></div>
            <div class="btns btn-list">
                <button class="btn btn-dark">XEM THÀNH VIÊN</button>
                <button class="btn btn-dark">XEM CÔNG VIỆC</button>
            </div>
        </div>
        <?php foreach ($abouts->longdata['boxs'] as $key => $foo) : ?>
        <div class="boxs <?php echo $key%2==0?'invert':'' ?>">
            <div class="box-thumb">
                <div class="nailthumb" >
                    <div class="nailthumb-container wow zoomIn" data-wow-delay="0.5s">
                        <img class="lazy" data-original="<?php echo get_image_url($foo['image']) ?>"/>
                    </div>
                </div>
            </div>
            <div class="box-text" >
                <div>
                    <div class="text-content">
                        <div class="title wow slideInUp" data-fz="big" data-wow-delay="0.5s"><?php echo $foo['title']; ?></div>
                        <div class="desc wow fadeInUp text-justify" data-fz="medium" data-wow-delay="0.5s"><?php echo $foo['desc']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div class=" service-list">
            <div class="container">
                <div class="row">
                    <div class="slogan wow rollIn">
                        <div class="title" data-fz="bigger" >-- Công việc của chúng tôi --</div>
                        <div class="desc" data-fz="medium">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                    </div>
                    <div class="jobs cls">
                        <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                        <div class="col-xs-6 col-sm-4 service-item">
                            <div class="wow fadeInLeft">
                                <div class="service-icon"></div>
                                    <div class="title">
                                        <span class="line-clamp-1"><?php echo $foo->title; ?></span>
                                    </div>
                                <div class="desc">
                                        <span class="line-clamp-f-2"><?php echo $foo->data['desc']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="staff-box cls">
            <div class="slider wow rollIn">

                    <div class="slider-title text-border" data-fz='big'>-- ĐỘI NGŨ CỦA CHÚNG TÔI</div>
                <div id="tab-jssor" style="position:relative;margin:0 auto;top:0px;left:0px;width:960px;height:400px;overflow:hidden;visibility:hidden;">
                    <!-- Loading Screen -->
                    <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
                        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                        <div style="position:absolute;display:block;background:url('/theme/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                    </div>
                    <div data-u="slides" class="slider-content" style="cursor:default;position:relative;top:0px;left:0px;width:600px;height:300px;overflow:hidden;">
                        <?php if($staffs) foreach ($staffs as $key => $foo) : ?>
                        <div>
                            <div data-u="image" >
                                <div class="slider-image cover" style="background-image:url('<?php echo get_image_url($foo->data['cover']) ?>')"></div>
                                <!-- <div class="slider-info"></div> -->
                            </div>
                            <div data-u="thumb" style="">
                                <div class="thumb-image cover" style="background-image:url('<?php echo get_image_url($foo->data['image']) ?>')"></div>
                                <div class="thumb-mask">
                                    <span class="bor1"></span>
                                    <span class="bor2"></span>
                                    <div class="title"><?php echo $foo->title; ?></div>
                                    <div class="desc"><?php echo $foo->data['position']; ?></div>
                                    <div class="socials">
                                        <a href="<?php echo $foo->data['fb']; ?>"><span class="fa fa-facebook"></span></a>
                                        <a href="<?php echo $foo->data['tw']; ?>"><span class="fa fa-twitter"></span></a>
                                        <a href="<?php echo $foo->data['gg']; ?>"><span class="fa fa-google"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Thumbnail Navigator -->
                    <div data-u="thumbnavigator" class="jssor-thumb" style="position:absolute;left:0px;bottom:0px;width:960px;height:180px;" data-autocenter="2">
                        <!-- Thumbnail Item Skin Begin -->
                        <div data-u="slides" style="cursor: default;">
                            <div data-u="prototype" class="p">
                                <div data-u="thumbnailtemplate" class="t"></div>
                            </div>
                        </div>
                        <!-- Thumbnail Item Skin End -->
                    </div>
                    <!-- Bullet Navigator -->
                    <div data-u="navigator" class="jssorb-buttlet" style="bottom:16px;right:16px;" data-autocenter="1">
                        <!-- bullet navigator item prototype -->
                        <div data-u="prototype" style="width:16px;height:16px;">
                            <!-- <div data-u="numbertemplate"></div> -->
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                jssorTabSliderInit()
                </script>
            </div>
            <div class="info wow fadeInUp">
                <?php if($staffs) foreach ($staffs as $key => $foo) : ?>
                <?php 
                    $skills = $foo->longdata['skills'];
                ?>
                <div>
                    <div class="box-center">
                        <div class="title text-center text-thin" data-fz="big" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">-- KỸ NĂNG --</div>
                        <?php if($skills) foreach ($skills as $skey => $sfoo) : ?>
                        <div class="desc skill-box a1" data-fz="" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">
                            <div data-fz="medium"><?php echo $sfoo['title']; ?></div>
                            <div class="skill">
                                <div class="a11" style="width:<?php echo $sfoo['process']; ?>%" data-anijs="if: animationend, on:.a1, do: slideInLeft animated, after: removeAnim"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="customer-box boxs invert">
            <div class="box-thumb">
                <div class="nailthumb" >
                    <div class="nailthumb-container has-mask" data-anijs="if: scroll, on: window, do: fadeIn animated, before: scrollReveal">
                        <img class="lazy" data-original="<?php echo base_url() ?>assets/creative/images/5.jpg"/>
                    </div>
                    <div class="text-content">
                        <div class="title" data-fz="big" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">-- KHACH HANG HAI LONG --</div>
                        <div class="desc" data-fz="medium" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                    </div>
                </div>
            </div>
            <div class="box-text">
                <div>
                    <div class="customer-slider">
                        <div class="owl-carousel" id="owl-partner">
                            <div class="item">
                                <div class="nailthumb">
                                    <div class="nailthumb-figure-64">
                                        <a href="JavaScript:void(0)" class="nailthumb-container">
                                            <img class="lazy" src="<?php echo base_url() ?>assets/creative/images/property_investment_03.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="nailthumb">
                                    <div class="nailthumb-figure-64">
                                        <a href="JavaScript:void(0)" class="nailthumb-container">
                                            <img class="lazy" src="<?php echo base_url() ?>assets/creative/images/property_investment_04.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="nailthumb">
                                    <div class="nailthumb-figure-64">
                                        <a href="JavaScript:void(0)" class="nailthumb-container">
                                            <img class="lazy" src="<?php echo base_url() ?>assets/creative/images/property_investment_05.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="nailthumb">
                                    <div class="nailthumb-figure-64">
                                        <a href="JavaScript:void(0)" class="nailthumb-container">
                                            <img class="lazy" src="<?php echo base_url() ?>assets/creative/images/property_investment_06.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="nailthumb">
                                    <div class="nailthumb-figure-64">
                                        <a href="JavaScript:void(0)" class="nailthumb-container">
                                            <img class="lazy" src="<?php echo base_url() ?>assets/creative/images/property_investment_07.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-linex5 white-bg"></div>


