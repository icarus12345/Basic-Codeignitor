<form name="detail-setting-frm" id="detail-setting-frm" target="integration_asynchronous" class="validation-frm">
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
        <div class="col-xs-12 half">
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
        <?php if($entry_setting->data['cateviewer'] == 'tree'): ?>
        <div class="col-xs-12 half">
            <div class="pull-bottom">
                <div>Parent :(*)</div>
                <div class="control-group">
                    <div>
                        <select 
                            name="pid" 
                            class="form-control selectpicker "
                            data-putto="#frm-err-data-pid"
                            data-live-search="true"
                            data-size="10"
                            >
                            <option value="0">[Root]</option>
                            <?php $level=-1; ?>
                            <?php foreach($entry_setting->data['categories'] as $c): ?>
                                <?php 
                                if ($c->id == $entry_detail->id){
                                    $level = $c->level;
                                }
                                if ($level!=-1 and $c->level <= $level and $c->id != $entry_detail->id){
                                    $level = -1;
                                }
                                ?>
                                <option 
                                    data-content="<span style='padding-left: <?php echo $c->level*20 + 20; ?>px;'><?php echo $c->title; ?></span>"
                                    <?php if ($level!=-1 and $level < $c->level){ echo 'disabled=1';} ?>
                                    <?php if ($c->id == $entry_detail->id){ echo 'disabled=1';} ?>
                                    <?php if ($c->id == $entry_detail->pid){echo 'selected="1"';} ?>
                                    value="<?php echo $c->id; ?>"
                                    ><?php echo $c->title; ?></span></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="frm-err-data-pid"></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
                                        <option data-data="<span style='padding-left: <?php echo $c->level*20; ?>px;'><?php echo $c->title; ?></span>"><?php echo $c->title; ?></span></option>
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
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    
</form>
