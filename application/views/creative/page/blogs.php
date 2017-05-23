       

        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <?php if($category_detail): ?>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Blogs</span>
                            <!-- <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $category_detail->title; ?></span> -->
                            <?php endif; ?>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $category_detail?$category_detail->title:'Blogs'; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="slogan">
            <div class="title wow fadeInUp" data-fz="bigger" >Những dự án đã và đang thực hiện cho đối tác & khách hàng của chúng tôi.</div>
            <div class="btns btn-list wow fadeInUp" >
                <a href="<?php echo base_url('tin-tuc'); ?>.html" class="btn btn-default <?php echo $category_detail?'':'active'; ?>">Tất Cả</a>
                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                <a href='<?php echo base_url('tin-tuc/'.$foo->alias); ?>.html' class="btn btn-default <?php echo $category_detail->id==$foo->id?'active':''; ?>"><?php echo $foo->title; ?></a></button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="blogs">
            <?php if($blogs): ?>
            <?php foreach ($blogs as $key => $foo) : ?>
            <div class="boxs">
                <div class="box-author">
                    <div class="nailthumb" >
                        <div class="nailthumb-figure-square">
                            <div class="nailthumb-container">
                                <img class="lazy" data-original="<?php echo get_image_url($users[$foo->author]->ause_picture);?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="author">by <?php echo $users[$foo->author]->ause_name; ?></div>
                </div>
                <div class="box-thumb">
                    <div class="nailthumb" >
                        <a 
                            href="<?php echo base_url('tin-tuc/'.$foo->alias); ?>.html" 
                            class="nailthumb-container wow zoomIn" >
                            <img class="lazy" data-original="<?php echo get_image_url($foo->data['image']); ?>"/>
                        </a>
                    </div>
                </div>
                <div class="box-text" >
                    <div>
                        <div class="post-at"><?php echo mdate("%d Tháng %m Năm %Y",strtotime($foo->created));?></div>
                        <div class="text-content">
                            <div class="cat"><?php echo $foo->ctitle; ?></div>
                            <div class="title wow slideInUp" data-fz="big"><?php echo $foo->title; ?></div>
                            <div class="desc text-justify wow slideInUp" data-fz="medium"><?php echo $foo->data['desc']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if($paging): ?>
            <div class="text-center">
            <?php echo  $paging; ?>
            </div>
            <?php endif; ?>
            <?php else: ?>
                <div class="no-data">Dữ liệu đang cập nhật</div>
            <?php endif; ?>
        </div>
        
        <div class="space-linex5 white-bg"></div>


