        <header id="navbar" class="navbar navbar-fixed-top" role="banner">
            <!-- Menu [ -->
            <div class="">
                <div class="navbar-header">
                    <a href="<?php echo base_url(''); ?>" class="navbar-brand"></a>
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navigation">
                        <span>
                            <span class="icon-bar line-1"></span>
                            <span class="icon-bar line-2"></span>
                            <span class="icon-bar line-3"></span>
                        </span>
                    </button>
                    <div class="navbar-search-lang">
                        <div class="navbar-langs">
                            <span>Language: </span>
                            <div class="lang-control">
                                <a href="#" data-toggle="dropdown">Tiếng Việt <span class="fa fa-angle-down"></span></a>
                                <ul class="dropdown-menu invert">
                                    <li><a href='#'>Tiếng Việt</a></li>
                                    <li><a href='#'>English</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="navbar-search">
                            <!-- <input class="navbar-search-input"> -->
                            <button class="navbar-search-button"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </div>
                <nav id="navigation" class="navbar-collapse bs-navbar-collapse collapse" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href='home.html'>Trang Chủ</a></li>
                        <li><a href='<?php echo base_url('ve-chung-toi'); ?>.html'>Về Chúng Tôi</a></li>
                        <li>
                            <a href="<?php echo base_url('dich-vu'); ?>.html" -data-toggle="dropdown">Dịch Vụ</a>
                            <ul class="dropdown-menu">
                                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('dich-vu/'.$foo->alias); ?>.html'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url('su-kien'); ?>.html" -data-toggle="dropdown">Trò Chơi - Sự Kiện</a>
                            <ul class="dropdown-menu">
                                <?php if($event_category) foreach ($event_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('su-kien/'.$foo->alias); ?>'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url('du-an'); ?>.html" -data-toggle="dropdown">PROJECT</a>
                            <ul class="dropdown-menu">
                                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('du-an/'.$foo->alias); ?>'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a href='<?php echo base_url('tin-tuc'); ?>.html'>NEWS</a></li>
                        <li><a href='<?php echo base_url('tuyen-dung'); ?>.html'>TUYỂN DỤNG</a></li>
                        <li><a href='<?php echo base_url('lien-he'); ?>.html'>CONTACT</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Menu ] -->
        </header>