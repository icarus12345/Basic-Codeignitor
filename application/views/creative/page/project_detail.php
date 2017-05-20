       

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
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $project_detail->title; ?></span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $project_detail->title; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-linex2 white-bg"></div>
        <div class="detail-box">
                <div class="box-thumb">
                    <div class="nailthumb" >
                        <div class="nailthumb-container cover" style="background-image:url(<?php echo get_image_url($project_detail->data['image']); ?>)" data-anijs="if: scroll, on: window, do: zoomIn animated, before: scrollReveal">
                        </div>
                    </div>
                </div>
                <div class="box-text" >
                    <div class="hea">
                        <div class="title" data-fz="big" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim"><?php echo $project_detail->title; ?></div>
                        <div class="au">CHI TIẾT DỰ ÁN</div>
                    </div>
                    <div class="desc scrollbar" data-fz="medium" data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">
                        <?php if($project_detail->longdata['content']): ?>
                        <?php echo $project_detail->longdata['content']; ?>
                        <?php else: ?>
                            <div class="no-data">Dữ liệu đang cập nhật</div>
                        <?php endif; ?>
                    </div>
                    <div class="foo">
                        <div class="au">TÁC GIẢ</div>
                        <div class="tg">CREATIVE DESIGN STUDIO</div>
                        <button class="btn btn-dark" data-toggle="modal" data-target="#regisModal">ĐĂNG KÝ MUA</button>
                    </div>
                </div>
        </div>
        <div class="space-linex2 white-bg"></div>
        <div class="release-box">
            <div class="slogan" style="background:transparent" data-anijs="if: scroll, on: window, do: rollIn animated, before: scrollReveal">
                <div class="title" data-fz="bigger" >-- GỢI Ý CÁC DỰ ÁN KHÁC --</div>
                <div class="desc" data-fz="medium">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
            </div>
            <?php if($related_projects): ?>
            <div class="release-slider">
                <div class="owl-carousel" id="owl-release">
                    
                    <?php foreach ($related_projects as $key => $foo) : ?>
                    <div class="item box">
                        <div class="nailthumb">
                            <div class="nailthumb-figure-64">
                            <div class="nailthumb-container cover" style="background-image:url(<?php echo get_image_url($foo->data['image']); ?>)"/></div>
                            <div class="nailthumb-mark">
                                <div>
                                    <div class="title"><?php echo $foo->title; ?></div>
                                    <div class="author text-justify"><?php echo $foo->data['desc']; ?></div>
                                    <div class="socials">
                                        <a href="#"><span class="fa fa-facebook"></span></a>
                                        <a href="#"><span class="fa fa-twitter"></span></a>
                                        <a href="#"><span class="fa fa-google"></span></a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
                <div class="no-data">Dữ liệu đang cập nhật</div>
            <?php endif; ?>
            <div class="space-linex2"></div>
        </div>
        <div class="space-linex5 white-bg"></div>
        <?php $this->load->view('creative/page/register_event'); ?>
