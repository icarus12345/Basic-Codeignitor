<?php if(empty($entry_setting->data['size'])) : ?>
<div class="-modal-header pull-top pull-bottom">
    <h4>
        <?php echo $entry_setting->title; ?> <small><?php echo $entry_detail?'Edit':'Add'; ?></small>
    </h4>
</div>

<div class="-modal-body pull-top">
<?php endif; ?>
<?php
    function _addField($column,$entry_detail){
        // global $entry_detail;

        $value = $entry_detail->data[$column['name']];
        $name = 'data['.$column['name'].']';
        $id = 'data-'.$column['name'];
        if($column['biz'] == '1'):
            $value = $entry_detail->longdata[$column['name']];
            $name = 'longdata['.$column['name'].']';
        endif; 
        if ($column['type'] == 'catetree'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div>
                            <select 
                                name="<?php echo $name; ?>" 
                                class="form-control selectpicker "
                                data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                data-live-search="true"
                                data-size="10"
                                >
                                <option value="">Nothing Selected</option>
                                <?php foreach($column['categories'] as $c): ?>
                                    <option 
                                        data-data="<span style='padding-left: <?php echo $c->level*20; ?>px;'><?php echo $c->title; ?></span>"
                                        <?php if ($c->id == $value){echo 'selected="1"';} ?>
                                        ><?php echo $c->title; ?></span></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'radio'): ?>
            
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div class="rdbs">
                            <?php foreach($column['data'] as $c): ?>
                            <label class="rdb">
                                <input 
                                    type="radio" 
                                    class="<?php echo $column['client']; ?>"
                                    data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                    name="<?php echo $name; ?>" 
                                    <?php if ($c['value'] == $value){echo 'checked="1"';} ?>
                                    value="<?php echo $c['value']; ?>"
                                    >
                                <span><?php echo $c['display']; ?></span>
                            </label>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                        </div>
                        <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'checkbox'): ?>
            
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="chks">
                        <label class="chk">
                            <input 
                                type="checkbox" 
                                name="<?php echo $name; ?>" 
                                <?php if ($value){echo 'checked="1"';} ?>
                                value="1"
                                >
                            <span>&nbsp;</span>
                        </label>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'string'): ?>
            
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div>
                            <input 
                                type="text"
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                name="<?php echo $name; ?>"
                                value="<?php echo $value; ?>" >
                        </div>
                        <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'text'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div>
                            <textarea 
                                type="text"
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-data-<?php echo $column['name']; ?>"
                                name="<?php echo $name; ?>"
                                ><?php echo $value; ?></textarea>
                        </div>
                        <div id="frm-err-data-<?php echo $column['name']; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'html'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div>
                            <textarea 
                                type="text" row="4" 
                                id="<?php echo $id; ?>"
                                data-editor=1
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-<?php echo $column['biz']?'long':'';?>data-<?php echo $column['name']; ?>"
                                name="<?php echo $name; ?>"
                                ><?php echo $value; ?></textarea>
                        </div>
                        <div id="frm-err-<?php echo $id; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'image'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    <div class="control-group">
                        <div class="input-append">
                            <input type="text" 
                                class="form-control <?php echo $column['client']; ?>" 
                                data-putto="#frm-err-<?php echo $id; ?>"
                                name="<?php echo $name; ?>"
                                id="<?php echo $id; ?>"
                                value="<?php echo $value; ?>"
                                >
                            <span class="add-on" onclick="App.KCFinder.BrowseServer('#<?php echo $id; ?>')">
                                <i class="fa fa-image"></i>
                            </span>
                        </div>
                        <div id="frm-err-<?php echo $id; ?>"></div>
                    </div>
                </div>
            </div>
        <?php elseif ($column['type'] == 'multidropdown'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
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
        <?php elseif ($column['type'] == 'dropdown'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
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
        <?php elseif ($column['type'] == 'list'): ?>
            <div class="col-xs-<?php echo $column['col']; ?> half">
                <div class="pull-bottom">
                    <div><?php echo $column['title']; ?> :</div>
                    
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
    <?php
    }
?>
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
    <?php if($entry_setting->data['groups']): ?>
    <ul class="nav nav-tabs" role="tablist" <?php if(count($entry_setting->data['groups'])<=1) echo 'style="display:none"'; ?>>
        <?php 
        $num = 0;
        foreach ($entry_setting->data['groups'] as $key => $g) :
            ?>
        <li role="presentation" class="<?php echo $key==0?'active':''; ?>">
            <a href="#entry-tab-<?php echo $key; ?>" aria-controls="entry-info-tab" role="tab" data-toggle="tab">
            <?php echo $g['name']; ?>
            </a>
        </li>
        <?php
        $entry_setting->data['groups'][$key]['data'] = array();
        for($i=0;$i<$g['length'];$i++){
            $entry_setting->data['groups'][$key]['data'][] = $entry_setting->data['columns'][$num++];
        }
        endforeach;
        ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach ($entry_setting->data['groups'] as $key => $g) : ?>
        <div role="tabpanel" class="tab-pane <?php echo $key==0?'active':''; ?>" id="entry-tab-<?php echo $key; ?>">
            <div class="row half pull-top">
            <?php if($key==0) : ?>
                <div class="col-xs-<?php echo empty($entry_setting->data['catetype'])?'12':'6'; ?> half">
                    <div class="pull-bottom">
                        <div>Title :(*)</div>
                        <div class="control-group">
                            <input 
                                type="text"
                                class="form-control validate[required,minSize[4],maxSize[250]]" 
                                placeholder=""
                                id="detail-setting-title"
                                name="title"
                                onblur="App.Helper.Alias(this)"
                                value="<?php echo $entry_detail->title; ?>" >
                        </div>
                    </div>
                </div>
                <?php if(!empty($entry_setting->data['categories'])): ?>
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
                <?php endif; ?>
            <?php endif; ?>
            <?php 
            foreach($g['data'] as $i => $column): 
                _addField($column,$entry_detail);
            endforeach;
            ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    
            <div class="row half info-box pull-top">
                <div class="col-xs-<?php echo empty($entry_setting->data['catetype'])?'12':'6'; ?> half">
                    <div class="pull-bottom">
                        <div>Title :(*)</div>
                        <div class="control-group">
                            <input 
                                type="text"
                                class="form-control validate[required,minSize[4],maxSize[250]]" 
                                placeholder=""
                                id="detail-setting-title"
                                name="title"
                                onblur="App.Helper.Alias(this)"
                                value="<?php echo $entry_detail->title; ?>" >
                        </div>
                    </div>
                </div>
                <?php if(!empty($entry_setting->data['categories'])): ?>
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
                <?php endif; ?>
                <?php 
                if($entry_setting->data['columns']):

                foreach($entry_setting->data['columns'] as $i => $column): 
                _addField($column,$entry_detail);
                endforeach; 
                endif;
                ?>
            </div>
    <?php endif; ?>
</form>
<?php if($entry_detail): ?>
<div class="pre">
Author:<?php echo $users[$entry_detail->author]->ause_name; ?><br/>
Created: <?php echo $entry_detail->created; ?><br/>
Modified: <?php echo $entry_detail->modified; ?>
</div>
<?php endif; ?>
<?php if(empty($entry_setting->data['size'])) : ?>
</div>

<div class="-modal-footer pull-top text-center">
    <?php if($entry_detail && !$onlysave) : ?>
    <button class="btn btn-outline-secondary" onclick="App.Common.Duplicate()">Duplicate</button>
    <?php endif; ?>
    <?php if(!$onlysave) : ?>
    <button class="btn btn-default" onclick="App.Common.Save()">Save</button>
    <button class="btn btn-link" onclick="App.Common.Back()">Back</button>
    <?php else: ?>
    <button class="btn btn-block" onclick="App.Common.Save(true)">Save</button>
    <?php endif; ?>
</div>
<?php endif; ?>