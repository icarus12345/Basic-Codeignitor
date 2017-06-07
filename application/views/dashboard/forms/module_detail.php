<form name="detail-setting-frm" id="detail-setting-frm" target="integration_asynchronous" class="validation-frm">
    <input 
        type="hidden" 
        name="id" 
        value="<?php echo $entry_detail->id; ?>" 
        >
    <input 
        type="hidden" 
        name="alias" 
        value="<?php echo $entry_detail->alias; ?>" 
        id="detail-setting-alias">
    <input 
        type="hidden" 
        name="type" 
        value="<?php echo $type; ?>" >
    <div class="row half">
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Title :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        id="detail-setting-title"
                        name="title"
                        onblur="App.Helper.Alias(this)"
                        value="<?php echo $entry_detail->title; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Site :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[50]]" 
                        placeholder=""
                        id="detail-setting-site"
                        name="data[site]"
                        value="<?php echo $entry_detail->data['site']; ?>" >
                </div>
            </div>
        </div>
    </div>
    <div class="row half">
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Size :(*)</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="data[size]" 
                            class="form-control selectpicker"
                            data-putto="#frm-err-data-size"
                            data-live-search="true"
                            data-size="10"
                            >
                            <option value="">Open page inside</option>
                            <optgroup label="Open on Popup">
                                <option value="240" 
                                    <?php echo $entry_detail->data['size'] == '240'?'selected="1"':''; ?>
                                    >Small (240)</option>
                                <option value="320" 
                                    <?php echo $entry_detail->data['size'] == '320'?'selected="1"':''; ?>
                                    >Smaller (320)</option>
                                <option value="480" 
                                    <?php echo $entry_detail->data['size'] == '480'?'selected="1"':''; ?>
                                    >Normal (480)</option>
                                <option value="520" 
                                    <?php echo $entry_detail->data['size'] == '520'?'selected="1"':''; ?>
                                    >Big (520)</option>
                                <option value="640" 
                                    <?php echo $entry_detail->data['size'] == '640'?'selected="1"':''; ?>
                                    >Bigger (640)</option>
                                <option value="720" 
                                    <?php echo $entry_detail->data['size'] == '720'?'selected="1"':''; ?>
                                    >Verry big (720)</option>
                            </optgroup>
                            <!--
                            <?php if($setting_data): ?>
                            <?php foreach ($setting_data as $key => $foo): ?>
                                <option 
                                    <?php echo $foo->id == $item->data.id ? 'selected="1"' : ''; ?>
                                    value="<?php echo  $foo->id; ?>">
                                        <?php echo  $foo->title; ?>
                                </option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            -->
                        </select>
                    </div>
                    <div id="frm-err-data-size"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Storage at :(*)</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="data[storage]" 
                            class="form-control selectpicker validate[required]"
                            data-putto="#frm-err-data-storage"
                            >
                            <option value="tbl_data" <?php echo $entry_detail->data['storage'] == 'tbl_data'?'selected="1"':''; ?>>Storage 01</option>
                            <option value="tbl_data2" <?php echo $entry_detail->data['storage'] == 'tbl_data2'?'selected="1"':''; ?>>Storage 02</option>
                            <option value="tbl_data3" <?php echo $entry_detail->data['storage'] == 'tbl_data3'?'selected="1"':''; ?>>Storage 03</option>
                            <option value="tbl_data4" <?php echo $entry_detail->data['storage'] == 'tbl_data4'?'selected="1"':''; ?>>Storage 04</option>
                            <option value="tbl_setting" <?php echo $entry_detail->data['storage'] == 'tbl_setting'?'selected="1"':''; ?>>Storage Setting</option>
                        </select>
                    </div>
                    <div id="frm-err-data-storage"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 half">
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
                        <input 
                            type="checkbox" name="data[add]" 
                            <?php echo $entry_detail->data['add']=="true"?'checked':''; ?>
                            >
                        <span>Add</span>
                    </label>
                    <label class="chk">
                        <input 
                            type="checkbox" name="data[edit]"
                            <?php echo $entry_detail->data['edit']=="true"?'checked':''; ?>
                            >
                        <span>Edit</span>
                    </label>
                    <label class="chk">
                        <input 
                            type="checkbox" name="data[delete]"
                            <?php echo $entry_detail->data['delete']=="true"?'checked':''; ?>
                            >
                        <span>Delete</span>
                    </label>
                    <label class="chk">
                        <input 
                            type="checkbox" name="data[unique]"
                            <?php echo $entry_detail->data['unique']=="true"?'checked':''; ?>
                            >
                        <span>Unique</span>
                    </label>
                    <label class="chk">
                        <input 
                            type="checkbox" name="data[showthumb]"
                            <?php echo $entry_detail->data['showthumb']=="true"?'checked':''; ?>
                            >
                        <span>Show Thumb</span>
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
                        value="<?php echo $entry_detail->data['type']; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-4 half">
            <div class="pull-bottom">
                <div>Category Type :</div>
                <div class="control-group">
                    <input 
                        type="text" 
                        class="form-control validate[maxSize[50]]" 
                        placeholder="" name="data[catetype]" 
                        value="<?php echo $entry_detail->data['catetype']; ?>" >
                </div>
            </div>
        </div>
        <div class="col-xs-2 half">
            <div class="pull-bottom">
                <div>View :</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="data[cateviewer]" 
                            class="form-control selectpicker validate[required]"
                            data-putto="#frm-err-data-cateviewer"
                            >
                            <option value="list">List</option>
                            <option value="tree" 
                                <?php echo $entry_detail->data['cateviewer'] == 'tree'?'selected="1"':''; ?>
                                >Tree</option>
                        </select>
                    </div>
                    <div id="frm-err-data-cateviewer"></div>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs tabs-actions nav-tabs-up" role="tablist" id="tabs-for-group">
        <li role="presentation">
            <a href="JavaScript:void(0)" id="click-to-add-new-tab"><span class="icon-plus"></span> Add</a></a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content" id="tabcontents-for-group"></div>
</form>
<div style="display: none" id="column-detail-dialog">
    <form name="column-detail-frm" id="column-detail-frm" target="integration_asynchronous" class="validation-frm">
        <div class="row half">
            
            <div class="col-xs-6 half">
                <div class="pull-bottom">
                    <div>Field type :</div>
                    <div class="">
                        <select 
                            name="type" 
                            class="form-control selectpicker validate[required]"
                            >
                            <option value="string">String</option>
                            <option value="text">Text</option>
                            <option value="html">HTML</option>
                            <option value="image">Image</option>
                            <option value="radio">Radio</option>

                            <option value="checkbox">Checkbox</option>
                            <option value="multidropdown">Multi Dropdown</option>
                            <option value="dropdown">Dropdown</option>

                            <option value="catelist">List Category</option>
                            <option value="catetree">Tree Category</option>

                            <option value="list">List</option>
                            <option value="grid">Grid</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 half" -data-box="col">
                <div class="pull-bottom">
                    <div>Col :</div>
                    <div class="">
                        <input 
                            type="number" 
                            class="form-control validate[required,min[1],max[12]]" 
                            placeholder="" name="col" 
                            value="" >
                    </div>
                </div>
            </div>
            <div class="col-xs-3 half" -data-box="biz">
                <div class="pull-bottom">
                    <div>Biz :</div>
                    <div class="">
                        <div class="chks">
                            <label class="chk">
                                <input type="checkbox" name="biz">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 half">
                <div class="pull-bottom">
                    <div>Field name :(*)</div>
                    <div class="control-group">
                        <input 
                            type="text" 
                            class="form-control validate[required,maxSize[50]]" 
                            placeholder="" name="name" 
                            value="" >
                    </div>
                </div>
            </div>
            <div class="col-xs-6 half">
                <div class="pull-bottom">
                    <div>Display text :(*)</div>
                    <div class="control-group">
                        <input 
                            type="text" 
                            class="form-control validate[required,maxSize[50]]" 
                            placeholder="" name="title" 
                            value="" >
                    </div>
                </div>
            </div>
        </div>
        <div data-box="data" class="pull-bottom">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Display</th>
                        <th width="20">
                            <a href="JavaScript:App.Setting.ShowColumnDataItemDialog()" class="icon-plus"></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <fieldset data-box="valid">
            <legend>Validation</legend>
            <div class="pull-bottom">
                <div>Client validation :</div>
                <div class="control-group">
                    <input 
                        type="text" 
                        class="form-control " 
                        placeholder="" name="client" 
                        value="" >
                </div>
            </div>
            <div class="pull-bottom">
                <div>Server validation :</div>
                <div class="control-group">
                    <input 
                        type="text" 
                        class="form-control " 
                        placeholder="" name="server" 
                        value="" >
                </div>
            </div>
        </fieldset>
        <div class="pull-bottom" data-box="sid">
            <div>Setting Entry :</div>
            <div class="">
                <select 
                    name="sid" 
                    class="form-control selectpicker"
                    >
                    <option value="">[   Nothing   ]</option>
                    <?php foreach($setting_list as $foo): ?>
                    <option 
                        data-content="<?php echo $foo->title; ?> - <small><i><?php echo $foo->data['site']; ?></i></small>"
                        value="<?php echo $foo->id; ?>"
                        ><?php echo $foo->title; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
    </form>
</div>
<div style="display: none" id="column-data-item-dialog">
    <form 
        name="column-data-item-frm" 
        id="column-data-item-frm" 
        target="integration_asynchronous" 
        class="validation-frm">
        <div class="pull-bottom">
            <div>Value :</div>
            <div class="control-group">
                <input 
                    type="text" 
                    class="form-control " 
                    placeholder="" name="value" 
                    value="" >
            </div>
        </div>
        <div class="">
            <div>Display :</div>
            <div class="control-group">
                <input 
                    type="text" 
                    class="form-control " 
                    placeholder="" name="display" 
                    value="" >
            </div>
        </div>
    </form>
</div>