        <header id="navbar" class="navbar navbar-fixed-top" role="banner">
            <!-- Menu [ -->
            <div class="">
                <div class="navbar-header">
                    <a href="index.html" class="navbar-brand"></a>
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
                        <li class="active"><a href='home.html'>HOME</a></li>
                        <li><a href='about.html'>ABOUT</a></li>
                        <li>
                            <a href="service.html" -data-toggle="dropdown">SERVICE</a>
                            <ul class="dropdown-menu">
                                <?php if($service_category) foreach ($service_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('services/'.$foo->alias); ?>'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a href="event.html" -data-toggle="dropdown">EVENTS</a>
                            <ul class="dropdown-menu">
                                <?php if($event_category) foreach ($service_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('services/'.$foo->alias); ?>'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a href="project.html" -data-toggle="dropdown">PROJECT</a>
                            <ul class="dropdown-menu">
                                <?php if($project_category) foreach ($service_category as $key => $foo) : ?>
                                <li><a href='<?php echo base_url('projects/'.$foo->alias); ?>'><?php echo $foo->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a href='news.html'>NEWS</a></li>
                        <li><a href='recruitment.html'>TUYỂN DỤNG</a></li>
                        <li><a href='contact.html'>CONTACT</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Menu ] -->
        </header>