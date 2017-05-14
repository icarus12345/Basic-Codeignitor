<?php 
$CI =& get_instance();
?>
<form name="user-detail-frm" id="user-detail-frm" target="integration_asynchronous" class="validation-frm">
    <div class="row half">
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Display :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="name"
                        value="<?php echo $CI->session->userdata('dasbboard_user')->ause_name ; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Email :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,custom[email]]" 
                        placeholder=""
                        name="email"
                        value="<?php echo $CI->session->userdata('dasbboard_user')->ause_email ; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Current Password :(*)</div>
                <div class="control-group">
                    <input 
                        type="password"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="oldpassword"
                        value="" >
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>New Password :(*)</div>
                <div class="control-group">
                    <input 
                        type="password" id="password"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="password"
                        value="" >
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="">
                <div>Confirm Password :(*)</div>
                <div class="control-group">
                    <input 
                        type="password"
                        class="form-control validate[required,equals[password]]" 
                        placeholder=""
                        name="confirmpassword"
                        value="" >
                </div>
            </div>
        </div>
    </div>
</form>