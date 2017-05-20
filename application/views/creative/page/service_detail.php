       

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
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $category_detail->title; ?></span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $category_detail->title; ?></div>
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
        <div class="events">
            <?php if($services): ?>
            <?php foreach ($services as $key => $foo) : ?>
            <div class="boxs">
                <div class="box-thumb">
                    <div class="nailthumb" >
                        <a 
                            href="detail.html" 
                            class="nailthumb-container cover" 
                            data-anijs="if: scroll, on: window, do: fadeIn animated, before: scrollReveal" 
                        style="background-image:url(<?php echo get_image_url($foo->data['image']); ?>)"></a>
                    </div>
                </div>
                <div class="box-text" >
                    <div>
                        <div class="text-content">
                            <div class="box-number wow fadeInUp">
                                <?php echo sprintf("%02d", $key+1) ?>.
                            </div>
                            <div class="title wow fadeInUp"><?php echo $foo->title; ?></div>
                            <div 
                                class="desc -line-clamp-4" 
                                data-fz="medium" 
                                data-anijs="if: scroll, on: window, do: slideInUp animated, before: scrollReveal, after: removeAnim">
                                <?php echo $foo->data['desc']; ?>
                                </div>
                            <div class="hr-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">Dữ liệu đang cập nhật</div>
            <?php endif; ?>
        </div>
        <div class="yellow-box">
            <div>
                <div class="sub-title">TIẾP THEO LÀ GÌ ?</div>
                <div class="title" data-fz="big">BẠN ĐÃ SẴN SÀNG CHƯA ?</div>
                <div class="title" data-fz="big">CHÚNG TA HÃY BẮT ĐẦU CÔNG VIỆC</div>
            </div>
        </div>

        <div class="space-linex2 white-bg"></div>


