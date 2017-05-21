       

        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Dịch vụ</span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title">Dịch vụ</div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div data-wow-delay="1.2s" class="slogan wow fadeInUp">
            <div class="title" data-fz="bigger">Những dự án đã và đang thực hiện cho đối tác & khách hàng của chúng tôi.</div>
        </div>
        <div class="services">
            <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
            <div class="boxs">
                <div class="box-thumb">
                    <div class="nailthumb" >
                        <a href="<?php echo base_url('dich-vu/'.$foo->alias); ?>.html" class="nailthumb-container wow fadeInUp" data-wow-delay="0.5s">
                            <img class="lazy" data-original="<?php echo get_image_url($foo->data['cover']); ?>"/>
                        </a>
                    </div>
                </div>
                <div class="box-text" >
                    <div>
                        <div class="text-content">
                            <div class="box-title">
                                <div class="title wow fadeInUp" data-fz="big" data-wow-delay="0.5s"><span class="line-clamp-1"><?php echo $foo->title; ?></span></div>
                                <div class="sub-title wow fadeInUp"><?php echo $foo->data['subtitle']; ?></div>
                            </div>
                            <div class="desc wow fadeInUp" data-fz="medium" data-wow-delay="0.5s"><?php echo $foo->data['desc']; ?></div>
                            <ul class="wow fadeInUp" data-wow-delay="0.5s"><?php echo $foo->data['links']; ?></ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="space-linex5 white-bg"></div>


