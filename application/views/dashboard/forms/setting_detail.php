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
        <?php if(!$entry_detail) : ?>
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
                        name="data[type]" 
                        class="form-control selectpicker validate[required]"
                        >
                        <option value="string" <?php echo $entry_detail->data['type'] == "string"?'selected=1':'' ?>>String</option>
                        <option value="text" <?php echo $entry_detail->data['type'] == "text"?'selected=1':'' ?>>Text</option>
                        <option value="html" <?php echo $entry_detail->data['type'] == "html"?'selected=1':'' ?>>HTML</option>
                        <option value="image" <?php echo $entry_detail->data['type'] == "image"?'selected=1':'' ?>>Image</option>
                        <option value="radio" <?php echo $entry_detail->data['type'] == "radio"?'selected=1':'' ?>>Radio</option>

                        <option value="checkbox" <?php echo $entry_detail->data['type'] == "checkbox"?'selected=1':'' ?>>Checkbox</option>
                        <option value="multidropdown" <?php echo $entry_detail->data['type'] == "multidropdown"?'selected=1':'' ?>>Multi Dropdown</option>
                        <option value="dropdown" <?php echo $entry_detail->data['type'] == "dropdown"?'selected=1':'' ?>>Dropdown</option>

                        <option value="catelist" <?php echo $entry_detail->data['type'] == "catelist"?'selected=1':'' ?>>List Category</option>
                        <option value="catetree" <?php echo $entry_detail->data['type'] == "catetree"?'selected=1':'' ?>>Tree Category</option>

                        <option value="list" <?php echo $entry_detail->data['type'] == "list"?'selected=1':'' ?>>List</option>
                        <option value="grid" <?php echo $entry_detail->data['type'] == "grid"?'selected=1':'' ?>>Grid</option>
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
    <?php endif; ?>
        <?php if($entry_detail) : ?>
            
            <?php if ($entry_detail->data['type'] == 'string'): ?>
                
                <div class="col-xs-12 half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div>
                                <input 
                                    type="text"
                                    class="form-control " 
                                    data-putto="#frm-err-data-value"
                                    name="data[value]"
                                    value="<?php echo $entry_detail->data['value']; ?>" >
                            </div>
                            <div id="frm-err-data-value"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'text'): ?>
                <div class="col-xs-12 half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div>
                                <textarea 
                                    type="text"
                                    class="form-control " 
                                    data-putto="#frm-err-data-value"
                                    name="data[value]"
                                    ><?php echo $entry_detail->data['value']; ?></textarea>
                            </div>
                            <div id="frm-err-data-value"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'html'): ?>
                <div class="col-xs-12 half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div>
                                <textarea 
                                    type="text" row="4" 
                                    id="value"
                                    data-editor=1
                                    class="form-control " 
                                    data-putto="#frm-err-data-value"
                                    name="data[value]"
                                    ><?php echo $entry_detail->data['value']; ?></textarea>
                            </div>
                            <div id="frm-err-data-value"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'image'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div class="input-append">
                                <input type="text" 
                                    class="form-control " 
                                    data-putto="#frm-err-data-value"
                                    name="data[value]"
                                    id="value"
                                    value="<?php echo $entry_detail->data['value']; ?>"
                                    >
                                <span class="add-on" onclick="App.KCFinder.BrowseServer('#value')">
                                    <i class="fa fa-image"></i>
                                </span>
                            </div>
                            <div id="frm-err-data-value"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'multidropdown'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="<?php echo $name; ?>" 
                                    class="form-control selectpicker <?php echo $column['client']; ?>"
                                    data-putto="#frm-err-<?php echo $id; ?>"
                                    -data-live-search="true"
                                    multiple=1
                                    data-size="10"
                                    >
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if (in_array($c['value'],$value)){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-<?php echo $id; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'dropdown'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="<?php echo $name; ?>" 
                                    class="form-control selectpicker <?php echo $column['client']; ?>"
                                    data-putto="#frm-err-<?php echo $id; ?>"
                                    -data-live-search="true"
                                    data-size="10"
                                    >
                                    <option value="">Nothing Selected</option>
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if ($c['value'] == $value){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-<?php echo $id; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($entry_detail->data['type'] == 'list'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $entry_detail->title; ?> :</div>
                        
                        <div>
                            <ul id="<?php echo $id; ?>" class="sortable" data-column="<?php echo $column['name']; ?>" data-sid="<?php echo $column['sid']; ?>"></ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="add-sortable-item" data-column="<?php echo $column['name']; ?>" data-sid="<?php echo $column['sid']; ?>">
                            <span class="icon-plus"></span> Add
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</form>
<div class="-modal-footer pull-top text-center">
    <button class="btn btn-outline-secondary" onclick="App.Setting.Duplicate()">Duplicate</button>
    <button class="btn btn-default" onclick="App.Setting.Save()">Save</button>
    <button class="btn btn-link" onclick="App.Setting.Back()">Back</button>
</div>