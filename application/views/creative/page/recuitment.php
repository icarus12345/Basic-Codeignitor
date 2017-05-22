       

        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Tuyển Dụng</span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title">Tuyển Dụng</div>
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
                <a href="<?php echo base_url('du-an'); ?>.html" class="btn btn-default <?php echo $category_detail?'':'active'; ?>">Tất Cả</a>
                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                <a href='<?php echo base_url('du-an/'.$foo->alias); ?>.html' class="btn btn-default <?php echo $category_detail->id==$foo->id?'active':''; ?>"><?php echo $foo->title; ?></a></button>
                <?php endforeach; ?>
            </div>
        </div>
        
        
        <div class="space-linex3 white-bg"></div>
            <div class="box-title">
                <div class="title wow fadeInUp" data-fz="big" data-wow-delay="0.5s"><span class="line-clamp-1">GỬI HỒ SƠ CỦA BẠN</span></div>
                <div class="sub-title">Phá bỏ mọi giới hạn đam mê </div>
            </div>
            <form name="contactForm" id="contactForm" target="integration_asynchronous">
                <div>
                    <div class="row half pull-top">
                        <div class="col-xs-6 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <input 
                                    name="contact_name" data-fz="medium"
                                    class="form-control light validate[required,minSize[4],maxSize[255]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Họ và Tên">
                                <!-- <label>Họ và tên</label> -->
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                        <div class="col-xs-6 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Số điện thoại</div> -->
                                <input 
                                    name="contact_phone" data-fz="medium"
                                    class="form-control light validate[required,minSize[7],maxSize[12]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Số Điện thoại">
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-6 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Email</div> -->
                                <input 
                                    name="contact_email" value="" data-fz="medium"
                                    class="form-control light validate[required,custom[email],maxSize[100]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Email">
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                        <div class="col-xs-6 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Địa chỉ</div> -->
                                <input 
                                    name="contact_data" data-fz="medium"
                                    class="form-control light validate[required,minSize[10],maxSize[255]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Địa chỉ">
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-4 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <select class="form-control light selectpicker" data-fz="medium">
                                    <option>Chọn thành phố</option>
                                </select>
                                <!-- <label>Họ và tên</label> -->
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                        <div class="col-xs-4 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Số điện thoại</div> -->
                                <select class="form-control light selectpicker" data-fz="medium">
                                    <option>Chọn thành phố</option>
                                </select>
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                        <div class="col-xs-4 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Số điện thoại</div> -->
                                <select class="form-control light selectpicker" data-fz="medium">
                                    <option>Chọn thành phố</option>
                                </select>
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-12 half pull-bottom">
                            <input 
                                    name="contact_data" data-fz="medium"
                                    class="form-control light validate[required,minSize[10],maxSize[255]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="CMND">
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-12 half pull-bottom">
                            <input 
                                    name="contact_data" data-fz="medium"
                                    class="form-control light validate[required,minSize[10],maxSize[255]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Số Năm Kinh Nghiệm">
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-12 half pull-bottom">
                            <input 
                                    name="contact_data" data-fz="medium"
                                    class="form-control light validate[required,minSize[10],maxSize[255]]" 
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Giới Tính">
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-12 half pull-bottom">
                            <div class="upload">
                                <button class="btn btn-default">Tải Hồ Sơ</button>
                                <span data-fz="medium">Lorem Ipsum is simply dummy text of the printing and typesetting industry</span>
                            </div>
                        </div>
                    </div>
                    <div class="row half">
                        <div class="col-xs-12 half pull-bottom">
                            <!-- <div class="input-group"> -->
                                <!-- <div>Nội dung</div> -->
                                <textarea 
                                    name="contact_message" 
                                    rows="8" data-fz="medium"
                                    class="form-control light validate[required,minSize[10],maxSize[4000]]"
                                    data-prompt-position="topLeft:0,20"
                                    placeholder="Mô tả đôi nét về bản thân"></textarea>
                            <!-- </div> -->
                            <!-- <div class="space-line"></div> -->
                        </div>
                    </div>
                    <div class="" data-fz="medium" style="color:red">* Lorem Ipsum is simply dummy text of the printing and typesetting industry</div>
                    <input type="hidden" name="contact_type" value="Contact us">
                    <div style="height:50px" class="text-right pull-top">
                        <button class="btn btn-dark">GỬI HỒ SƠ</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="space-linex3 white-bg"></div>


