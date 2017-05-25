<!-- Menu [ -->
<nav id="navigation" class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
    <ul >
        <li class="sidebar-search-wrapper">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form action="extra_search.html" class="sidebar-search" method="post">
                <!-- <a class="remove" href="javascript:;"><i class="icon-close"></i></a> -->
                <div class="input-group">
                    <input class="form-control" placeholder="Search..." type="text"> <span class="input-group-btn"><a class="btn submit" href="javascript:;"><i class="icon-magnifier"></i></a></span>
                </div>
            </form><!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li class="heading">
            <h3 class="text-uppercase">Dashboard</h3>
        </li>
        <?php if($dashboard_menus) foreach ($dashboard_menus as $m) : ?>
        <li>
            <?php if(!empty($m->children)) :?>
            <a href="#">
                <i class="<?php echo !empty($m->data['icon'])?$m->data['icon']:'icon-home'; ?>"></i> <span class="title"><?php echo $m->title; ?></span> 
                <span class="arrow"></span>
            </a>
            <ul>
            <?php foreach ($m->children as $sm) : ?>
                <li>
                    <?php if(!empty($sm->children)) :?>
                    <a href="#"><i class="<?php echo !empty($sm->data['icon'])?$sm->data['icon']:'fa fa-th-list'; ?>"></i> <span class="title"><?php echo $sm->title; ?></span> <span class="arrow"></span></a>
                    <ul>
                    <?php foreach ($sm->children as $ssm) : ?>
                        <li>
                            <a href="<?php echo !empty($ssm->data['link'])? get_url($ssm->data['link']):'#';?>">
                                <i class="<?php echo !empty($ssm->data['icon'])?$ssm->data['icon']:'icon-folder'; ?>"></i> <span class="title"><?php echo $ssm->title; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <a href="<?php echo !empty($sm->data['link'])? get_url($sm->data['link']):'#';?>">
                        <i class="<?php echo !empty($sm->data['icon'])?$sm->data['icon']:'icon-folder'; ?>"></i> <span class="title"><?php echo $sm->title; ?></span>
                    </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <a href="<?php echo !empty($m->data['link'])? get_url($m->data['link']):'#';?>">
                <i class="<?php echo !empty($m->data['icon'])?$m->data['icon']:'icon-home'; ?>"></i> <span class="title"><?php echo $m->title; ?></span>
            </a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        
        <li class="heading">
            <h3 class="uppercase">More</h3>
        </li>
        <li>
            <a href="javascript:;"><i class="icon-puzzle"></i> <span class="title">Feature</span> <span class="arrow"></span></a>
            <ul class="sub-menu">
                <li>
                    <a href="index.html"><i class="icon-user"></i> User Option</a>
                </li>
                <li>
                    <a href="<?php echo base_url('dashboard/category/view/4'); ?>"><i class="fa fa-sitemap"></i> Dashboard Menu</a>
                </li>
                <li>
                    <a href="<?php echo base_url('dashboard/setting'); ?>"><i class="fa fa-sliders"></i> Dashboard Module</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
