<?php if(empty($entry_setting->data['size'])) : ?>
<div class="modal-header">
    <h4>
        <?php echo $entry_setting->title; ?> <small><?php echo $entry_detail?'Edit':'Add'; ?></small>
    </h4>
</div>
<?php endif; ?>

<div class="modal-body">
<form name="entry-detail-frm" id="entry-detail-frm" target="integration_asynchronous" class="validation-frm">
    <input 
        type="hidden" 
        name="id" 
        value="<?php echo $entry_detail->id; ?>" 
        >
    <input 
        type="hidden" 
        name="type" 
        value="<?php echo $entry_setting->data['type']; ?>" 
        >
    <input 
        type="hidden" 
        name="alias" 
        value="<?php echo $entry_detail->alias; ?>" 
        id="detail-setting-alias">
    <div class="row half">
        <div class="col-xs-<?php echo empty($entry_setting->data['catetype'])?'12':'6'; ?> half">
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
        <?php //if($entry_setting->data['cateviewer'] == 'tree'): ?>
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
                            <?php foreach($entry_setting->data['categories'] as $c): ?>
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
        <?php //endif; ?>
        <?php if($entry_setting->data['columns']) foreach($entry_setting->data['columns'] as $column): ?>
            <?php if ($column['type'] == 'catetree'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="data[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    data-live-search="true"
                                    data-size="10"
                                    >
                                    <option value="">Nothing Selected</option>
                                    <?php foreach($column['categories'] as $c): ?>
                                        <option 
                                            data-data="<span style='padding-left: <?php echo $c->level*20; ?>px;'><?php echo $c->title; ?></span>"
                                            <?php if ($c->id == $entry_detail->data[$column['name']]){echo 'selected="1"';} ?>
                                            ><?php echo $c->title; ?></span></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'string'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <input 
                                    type="text"
                                    class="form-control <?php echo $column['client']; ?>" 
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    name="data[<?php echo $column['name']; ?>]"
                                    value="<?php echo $entry_detail->data[$column['name']]; ?>" >
                            </div>
                            <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'text'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <textarea 
                                    type="text"
                                    class="form-control <?php echo $column['client']; ?>" 
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    name="data[<?php echo $column['name']; ?>]"
                                    ><?php echo $entry_detail->data[$column['name']]; ?></textarea>
                            </div>
                            <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'image'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="input-append">
                            <input type="text" 
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                name="data[<?php echo $column['name']; ?>]"
                                id="data-<?php echo $column['name']; ?>"
                                value="<?php echo $entry_detail->data[$column['name']]; ?>"
                                >
                            <span class="add-on" onclick="App.KCFinder.BrowseServer('#data-<?php echo $column['name']; ?>')">
                                <i class="fa fa-image"></i>
                            </span>
                        </div>
                        <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'checklist'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="data[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    -data-live-search="true"
                                    multiple=1
                                    data-size="10"
                                    >
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if ($c['value'] == $entry_detail->data[$column['name']]){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'list'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="data[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    -data-live-search="true"
                                    data-size="10"
                                    >
                                    <option value="">Nothing Selected</option>
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if ($c['value'] == $entry_detail->data[$column['name']]){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if($entry_setting->data['bigcolumns']) foreach($entry_setting->data['bigcolumns'] as $column): ?>
            <?php if ($column['type'] == 'catetree'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="longdata[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                    data-live-search="true"
                                    data-size="10"
                                    >
                                    <option value="">Nothing Selected</option>
                                    <?php foreach($column['categories'] as $c): ?>
                                        <option 
                                            data-data="<span style='padding-left: <?php echo $c->level*20; ?>px;'><?php echo $c->title; ?></span>"
                                            <?php if ($c->id == $entry_detail->longdata[$column['name']]){echo 'selected="1"';} ?>
                                            ><?php echo $c->title; ?></span></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'string'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <input 
                                    type="text"
                                    class="form-control <?php echo $column['client']; ?>" 
                                    data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                    name="longdata[<?php echo $column['name']; ?>]"
                                    value="<?php echo $entry_detail->longdata[$column['name']]; ?>" >
                            </div>
                            <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'text'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <textarea 
                                    type="text"
                                    class="form-control <?php echo $column['client']; ?>" 
                                    data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                    name="longdata[<?php echo $column['name']; ?>]"
                                    ><?php echo $entry_detail->longdata[$column['name']]; ?></textarea>
                            </div>
                            <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'image'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="input-append">
                            <input type="text" 
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                name="longdata[<?php echo $column['name']; ?>]"
                                id="longdata-<?php echo $column['name']; ?>"
                                value="<?php echo $entry_detail->longdata[$column['name']]; ?>"
                                >
                            <span class="add-on" onclick="App.KCFinder.BrowseServer('#longdata-<?php echo $column['name']; ?>')">
                                <i class="fa fa-image"></i>
                            </span>
                        </div>
                        <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'checklist'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="longdata[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                    -data-live-search="true"
                                    multiple=1
                                    data-size="10"
                                    >
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if ($c['value'] == $entry_detail->longdata[$column['name']]){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php elseif ($column['type'] == 'list'): ?>
                <div class="col-xs-<?php echo $column['col']; ?> half">
                    <div class="pull-bottom">
                        <div><?php echo $column['title']; ?> :(*)</div>
                        <div class="control-group">
                            <div>
                                <select 
                                    name="longdata[<?php echo $column['name']; ?>]" 
                                    class="form-control selectpicker "
                                    data-putto="#frm-err-longdata-<?php echo $column['name']; ?>"
                                    -data-live-search="true"
                                    data-size="10"
                                    >
                                    <option value="">Nothing Selected</option>
                                    <?php foreach($column['data'] as $c): ?>
                                        <option value="<?php echo $c['value']; ?>"
                                            <?php if ($c['value'] == $entry_detail->longdata[$column['name']]){echo 'selected="1"';} ?>
                                            >
                                            <?php echo $c['display']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="frm-err-longdata-<?php echo $column['name']; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    
</form>
</div>

<?php if(empty($entry_setting->data['size'])) : ?>
<div class="modal-footer">
    <?php if($entry_detail) : ?>
    <button class="btn btn-outline-secondary" onclick="App.Common.Duplicate()">Duplicate</button>
    <?php endif; ?>
    <button class="btn btn-ui" onclick="App.Common.Save()">Save</button>
    <button class="btn btn-link" onclick="App.Common.Back()">Back</button>
</div>
<?php endif; ?>