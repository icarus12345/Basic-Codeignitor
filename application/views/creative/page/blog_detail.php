        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Blogs</span>
                            <?php if($category_detail): ?>
                            <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $category_detail->title; ?></span>
                            <?php endif; ?>
                            <!-- <span data-wow-delay="0.5s" class="wow fadeInUp"><?php echo $blog_detail->title; ?></span> -->
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title"><?php echo $blog_detail?$blog_detail->title:'Blogs'; ?></div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="gray-box">
            <div class="container pull-top pull-bottom white-bg">
                <div class="blog-thumb cover" style="background-image:url(<?php echo get_image_url($blog_detail->data['cover']);?>)">
                    <span>February<br>16</span>
                </div>
                <div class="pull-top">
                    <img src="<?php echo get_image_url($blog_detail->data['cover']);?>" style="max-width:100%;margin:auto;display:block">
                </div>
                <div>
                    <h3 class="h3"><?php echo $blog_detail?$blog_detail->title:'Blogs'; ?></h3>
                    <div class="space-line"></div>
                    <?php if($category_detail): ?>
                    <div class="desc text-small">Catalogue : <a href="<?php echo base_url('tin-tuc/'.$category_detail->alias);?>.html" class="a"><i><?php echo $category_detail->title; ?></i></a></div>
                    <?php endif; ?>
                    <div class="space-line"></div>
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url('lib/ckeditor/contents.css'); ?>">
                    <div class="ckeditor">
                    <?php echo $blog_detail->longdata['content']; ?>
                    </div>
                    <?php if(!empty($blog_detail->data['tag'])):?>
                    <?php $tags = explode(",",$blog_detail->data['tag']); ?>
                    <div class="space-line"></div>
                    <div class="space-line"></div>
                    <div class="blog-tags">Tags : 
                    <?php foreach($tags as $tag): ?>
                    <span><?php echo $tag; ?></span>
                    <?php endforeach;?>
                    </div>
                    <?php endif;?>
                </div>
            <!-- </div>
        </div>
        <div class="white-bg">
            <div class="container pull-top pull-bottom -gray-box"> -->
                <div class="space-linex2"></div>
                <div class="comment-box">
                    <h4>Comments</h4>
                    <div>
                        <?php $this->load->view('creative/page/fb_comment'); ?>
                    </div>
                </div>

            </div>
        </div>