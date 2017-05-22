
        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Dự Án</span>
                            <?php if($category_detail): ?>
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $category_detail->title; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $category_detail?$category_detail->title:'Dự Án'; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="slogan">
            <div class="title wow zoomInDown" data-fz="bigger" >Những dự án đã và đang thực hiện cho đối tác & khách hàng của chúng tôi.</div>
            <div class="btns btn-list wow zoomInDown" >
                <a href="<?php echo base_url('du-an'); ?>.html" class="btn btn-default <?php echo $category_detail?'':'active'; ?>">Tất Cả</a>
                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                <a href='<?php echo base_url('du-an/'.$foo->alias); ?>.html' class="btn btn-default <?php echo $category_detail->id==$foo->id?'active':''; ?>"><?php echo $foo->title; ?></a></button>
                <?php endforeach; ?>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/masonry.js"></script>

        <div id="container" class="boxs">
            <?php if($projects): ?>
            <?php foreach ($projects as $key => $foo) : ?>
            <div class="box size<?php echo $foo->data['display']; ?>">
                <div class="nailthumb">
                    <div class="nailthumb-container">
                        <img class="lazy" data-original="<?php echo get_image_url($foo->data['thumb']); ?>"/>
                    </div>
                    <a href="<?php echo base_url('du-an/'.$foo->alias); ?>.html" class="nailthumb-mark">
                        <div>
                            <div class="title"><?php echo $foo->title; ?></div>
                            <div class="author text-justify"><?php echo $foo->data['desc']; ?></div>
                            <div class="socials">
                                <span href="#"><span class="fa fa-facebook"></span></span>
                                <span href="#"><span class="fa fa-twitter"></span></span>
                                <span href="#"><span class="fa fa-google"></span></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">Dữ liệu đang cập nhật</div>
            <?php endif; ?>
        </div>
        <div class="space-linex5 white-bg"></div>


