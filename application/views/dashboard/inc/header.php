<?php 
$CI =& get_instance();
?>
<div class="page-header">
    <div class="container">
        <a href="/" class="navbar-brand a">
            CPanel 1109
        </a>
        <div class="dropdown-user dropdown">
            <a href="#" class="" data-toggle="dropdown">
                <div class="avatar-circle"></div>
                <span><?php echo $CI->session->userdata('dasbboard_user')->ause_name ; ?></span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default pull-right">
                <li>
                    <a href="JavaScript:App.Auth.Detail()">
                    <i class="icon-user"></i> My Profile </a>
                </li>
                <li>
                    <a href="JavaScript:toastr.warning('Function is updatting...','Warning');">
                    <i class="icon-calendar"></i> My Calendar </a>
                </li>
                <li>
                    <a href="JavaScript:toastr.warning('Function is updatting...','Warning');">
                    <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">0</span>
                    </a>
                </li>
                <li>
                    <a href="JavaScript:toastr.warning('Function is updatting...','Warning');">
                    <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">0</span>
                    </a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="JavaScript:toastr.warning('Function is updatting...','Warning');"><i class="icon-lock"></i> Lock Screen </a>
                </li>
                <li>
                    <a href="JavaScript:App.Auth.Logout()"><i class="icon-key"></i> Log Out </a>
                </li>
            </ul>
        </div>
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navigation">
            <span>
                <span class="icon-bar line-1"></span>
                <span class="icon-bar line-2"></span>
                <span class="icon-bar line-3"></span>
            </span>
        </button>
    </div>
</div>