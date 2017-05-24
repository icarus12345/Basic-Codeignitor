<div class="-modal-header pull-top pull-bottom">
    <h4>
        <?php echo $entry_setting->title; ?> <small><?php echo $entry_detail?'Edit':'Add'; ?></small>
    </h4>
</div>
<form name="entry-detail-frm" id="entry-detail-frm" target="integration_asynchronous" class="validation-frm">
    <input 
        type="hidden" 
        name="id" 
        value="<?php echo $entry_detail->id; ?>" 
        >
    <input 
        type="hidden" 
        name="alias" 
        value="<?php echo $entry_detail->alias; ?>" 
        >
<div class="-modal-body pull-top">
    <div class="row half">
        
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Category :(*)</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="category" 
                            class="form-control selectpicker "
                            data-putto="#frm-err-data-category"
                            data-live-search="true"
                            data-size="10"
                            >
                            <option value="">[Nothing Select]</option>
                            <?php foreach($categories as $c): ?>
                                <option 
                                    data-content="<span style='padding-left: <?php echo $c->level*20; ?>px;'><?php echo $c->title; ?></span>"
                                    <?php if ($c->id == $entry_detail->category){echo 'selected="1"';} ?>
                                    value="<?php echo $c->id; ?>"
                                    ><?php echo $c->title; ?></span></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="frm-err-data-category"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 half">
            <div class="pull-bottom">
                <div>Data type :</div>
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
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Title :(*)</div>
                <div class="control-group">
                    <input 
                        type="text"
                        class="form-control validate[required,minSize[4],maxSize[250]]" 
                        placeholder=""
                        name="title"
                        onblur="App.Helper.Alias(this)"
                        value="<?php echo $entry_detail->title; ?>" >
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="-modal-footer pull-top text-center">
    <button class="btn btn-outline-secondary" onclick="App.Setting.Duplicate()">Duplicate</button>
    <button class="btn btn-default" onclick="App.Setting.Save()">Save</button>
    <button class="btn btn-link" onclick="App.Setting.Back()">Back</button>
</div>