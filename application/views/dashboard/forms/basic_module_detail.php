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
    <input  type="hidden"  name="data[size]" value="">
    <input  type="hidden"  name="data[storage]" value="">
    <input  type="hidden"  name="data[add]" value="">
    <input  type="hidden"  name="data[edit]" value="">
    <input  type="hidden"  name="data[delete]" value="">
    <input  type="hidden"  name="data[unique]" value="">
    <input  type="hidden"  name="data[type]" value="">
    <input  type="hidden"  name="data[catetype]" value="">
    <input  type="hidden"  name="data[cateviewer]" value="">

    <div>
        <ul id="sortable" class="sortable "></ul>
        <div class="clearfix"></div>
    </div>
    <div class="add-sortable-item">
        <span class="icon-plus"></span> Add
    </div>
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