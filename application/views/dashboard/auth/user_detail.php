<?php 
$CI =& get_instance();
?>
<form name="user-detail-frm" id="user-detail-frm" target="integration_asynchronous" class="validation-frm">
    <input 
        type="hidden" 
        name="ause_id" 
        id="ause_id" 
        value="<?php echo $user_detail->ause_id; ?>" 
        >
    <div class="row half">
        <div class="col-xs-6 half">
            <div class="">
                <div>Authority :(*)</div>
                <div class="control-group">
                    <select 
                        name="ause_authority" 
                        class="form-control selectpicker "
                        data-putto="#frm-err-data-authority"
                        data-live-search="true"
                        data-size="10"
                        >
                        <option value="">Nothing Selected</option>
                        <option value="Admin" <?php echo $user_detail->ause_authority=='Admin'?'selected=1':'' ; ?>>Admin</option>
                        <option value="User" <?php echo $user_detail->ause_authority=='User'?'selected=1':'' ; ?>>User</option>
                        <option value="View" <?php echo $user_detail->ause_authority=='View'?'selected=1':'' ; ?>>View</option>
                    </select>
                </div>
                <div id="frm-err-data-authority"></div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="">
                <div>Status :(*)</div>
                <div class="control-group">
                    <select 
                        name="ause_status" 
                        class="form-control selectpicker "
                        data-putto="#frm-err-data-status"
                        data-live-search="true"
                        data-size="10"
                        >
                        <option value="0" <?php echo $user_detail->ause_status=='0'?'selected=1':'' ; ?>>Block</option>
                        <option value="1" <?php echo $user_detail->ause_status=='1'?'selected=1':'' ; ?>>Actived</option>
                    </select>
                </div>
                <div id="frm-err-data-status"></div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Display :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="ause_name"
                        value="<?php echo $user_detail->ause_name ; ?>" >
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Username :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="ause_username"
                        value="<?php echo $user_detail->ause_username ; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>New Password :(*)</div>
                <div class="control-group">
                    <input 
                        type="password" id="ause_password"
                        class="form-control validate[minSize[4],maxSize[50]]" 
                        placeholder=""
                        name="ause_password"
                        value="" >
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="">
                <div>Confirm Password :(*)</div>
                <div class="control-group">
                    <input 
                        type="password"
                        class="form-control validate[equals[ause_password]]" 
                        placeholder=""
                        name="confirmpassword"
                        value="" >
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
                        name="ause_email"
                        value="<?php echo $user_detail->ause_email ; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Avatar :(*)</div>
                <div class="control-group">
                    <div class="input-append">
                        <input type="text" 
                            class="form-control" 
                            data-putto="#frm-err-ause_picture"
                            name="ause_picture"
                            id="ause_picture"
                            value="<?php echo $user_detail->ause_picture ; ?>"
                            >
                        <span class="add-on" onclick="App.KCFinder.BrowseServer('#ause_picture')">
                            <i class="fa fa-image"></i>
                        </span>
                    </div>
                    <div id="frm-err-ause_picture"></div>
                </div>
            </div>
        </div>
    </div>
</form>