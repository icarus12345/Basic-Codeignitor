<?php 
$this->CI =& get_instance();
$this->load->view('dashboard/inc/meta');
?>
    <body class="full-page" style="padding:0">
        <!-- <?php $this->load->view('dashboard/inc/header'); ?> -->
        <!-- <div class="container page-container"> -->
            <?php // $this->load->view('dashboard/inc/nav'); ?>
            <!-- <div class="page-content"> -->
                <div class="flex fluid">
                    <div class="modal-overlay open"></div>
                    <div class="login-box secondary-box" >
                        <div class="modal-header">
                            <h4>Login <small>Authentication</small></h4>
                        </div>
                        <div class="modal-body" id="login-dialog">
                                <form name="login-frm" target="integration_asynchronous" class="validation-frm" onsubmit="return App.Auth.Login() || false;">
                                    <div class="pull-bottom">
                                        <div>User name :(*)</div>
                                        <div class="control-group">
                                            <input 
                                                type="text" 
                                                class="form-control validate[required,minSize[4],maxSize[50]]" 
                                                placeholder="User name" name="username" 
                                                value="" >
                                        </div>
                                    </div>
                                    <div class="">
                                        <div>Password :(*)</div>
                                        <div class="control-group">
                                            <input 
                                                type="password" 
                                                class="form-control validate[required,minSize[4],maxSize[50]]" 
                                                placeholder="Password" name="password" 
                                                value="" >
                                        </div>
                                    </div>
                                    <button type="submit" style="position:absolute;opacity:0"></button>
                                </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link">Forget password ?</button>
                            <button class="btn btn-outline-secondary" onclick="App.Auth.Login()">Login</button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        <!-- </div> -->
        <?php $this->load->view('dashboard/inc/footer'); ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#login-dialog .validation-frm').validationEngine({
                    'scroll': false,
                    'isPopup' : true,
                    validateNonVisibleFields:true
                });
            })

        </script>
        