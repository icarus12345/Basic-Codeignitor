       

        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Sự Kiện</span>
                            <?php if($category_detail): ?>
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $category_detail->title; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $category_detail?$category_detail->title:'Sự Kiện'; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div data-wow-delay="1.2s" class="slogan wow fadeInUp">
            <div class="title" data-fz="bigger" style="max-width:1100px">Chúng tôi tạo ra những trò chơi để thu hút người dùng tham gia vào các chương trình khuyến mãi của khách hàng tích cực hơn.</div>
        </div>
        <div class="events">
            <?php if($events): ?>
            <?php foreach ($events as $key => $foo) : ?>
            <div class="boxs">
                <div class="box-thumb">
                    <div class="nailthumb" >
                        <a 
                            href="<?php echo base_url('su-kien/'.$foo->alias); ?>.html" 
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
                            <div class="btns">
                            <a class="btn btn-dark" href="<?php echo base_url('su-kien/'.$foo->alias); ?>.html">XEM THÊM</a>
                            <button class="btn btn-dark" data-toggle="modal" data-target="#regisModal">ĐĂNG KÝ MUA</button>
                            </div>
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


        <?php $this->load->view('creative/page/register_event'); ?>