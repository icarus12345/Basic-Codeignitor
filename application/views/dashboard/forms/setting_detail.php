<form name="add-setting-frm" id="add-setting-frm" target="integration_asynchronous" class="validation-frm">
    <div class="pull-bottom">
        <div>Title :(*)</div>
        <div class="control-group">
            <input 
                type="text" 
                class="form-control validate[required,minSize[4],maxSize[50]]" 
                placeholder="" name="title" 
                value="" >
        </div>
    </div>
    <div class="row half">
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Setting Type :(*)</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="data[id]" 
                            class="form-control selectpicker validate[required]"
                            data-putto="#frm-err-data-id"
                            data-live-search="true"
                            data-size="10"
                            >
                            <option value="-1">Nothing Selected</option>
                            <?php if($setting_data): ?>
                            <?php foreach ($setting_data as $key => $foo): ?>
                                <option 
                                    <?php echo $foo->id == $item->data.id ? 'selected="1"' : ''; ?>
                                    value="<?php echo  $foo->id; ?>">
                                        <?php echo  $foo->title; ?>
                                </option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div id="frm-err-data-id"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Functions :</div>
                <div class="chks">
                    <!-- <select 
                        name="data[add]" 
                        class="form-control selectpicker validate[required]"
                        >
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select> -->
                    <label class="chk">
                        <input type="checkbox" name="data[add]">
                        <span>Add</span>
                    </label>
                    <label class="chk">
                        <input type="checkbox" name="data[edit]">
                        <span>Edit</span>
                    </label>
                    <label class="chk">
                        <input type="checkbox" name="data[delete]">
                        <span>Delete</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row half">
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Type :(*)</div>
                <div class="control-group">
                    <input 
                        type="text" 
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder="" name="data[type]" 
                        value="" >
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Category Type :</div>
                <div class="control-group">
                    <input 
                        type="text" 
                        class="form-control validate[maxSize[50]]" 
                        placeholder="" name="data[catetype]" 
                        value="" >
                </div>
            </div>
        </div>
    </div>
</form>