$(document).ready(function(){
    App.Module = (function(){
        var URI = {
            binding : App.BaseUrl + 'dashboardapi/module/bind',
            detail  : App.BaseUrl + 'dashboardapi/module/detail',
            commit  : App.BaseUrl + 'dashboardapi/module/commit',
            delete  : App.BaseUrl + 'dashboardapi/module/delete',
        };
        var gridElm = $('#jqxGrid');
        var theme = 'metro';
        var datafields = [
            {name: 'id', type: 'int'},
            {name: 'title'},
            {name: 'site'},
            {name: 'status' , type: 'bool'},
            {name: 'created' , type: 'date'},
            {name: 'modified' , type: 'date'},
            {name: 'lock' , type: 'bool'},
        ];
        var columns = [
            {
                text: '', dataField: 'id', width: 52, filterable: false, sortable: true,editable: false,
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    var str = "";
                    if (value && value > 0) {
                        try {
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            "onclick=\"App.Module.ShowDetailDialog(" + value + ");\" "+ 
                            "title='Edit :" + value + "'><i class=\"fa fa-pencil-square\"></i></a>\
                            ";
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            "onclick=\"App.Module.Delete(" + value + ","+row+");\" "+ 
                            "title='Delete :" + value + "'><i class=\"fa fa-trash-o\"></i></a>\
                            ";
                        } catch (e) {
                        }
                    }
                    return str;
                }
            },{
                text: 'Id'    , dataField: 'id2' , displayfield:'id',cellsalign: 'right', 
                width: 60, columntype: 'numberinput', filtertype: 'number',
                filterable: false, sortable: false,editable: false,hidden:true
            },{
                text: 'Title', dataField: 'title', minWidth: 180, sortable: true,
                columntype: 'textbox', filtertype: 'textbox', filtercondition: 'CONTAINS'
                
            },{
                text: 'Site', dataField: 'site', minWidth: 180, sortable: false,
                columntype: 'textbox', filterable:false,hidden: true
                
            },{
                text: 'Status'    , dataField: 'status' , cellsalign: 'center',
                width: 44, columntype: 'checkbox', threestatecheckbox: false, filtertype: 'bool',
                filterable: true, sortable: true,editable: true
            },{
                text: 'Created' , dataField: 'created', width: 120, cellsalign: 'right',
                filterable: true, columntype: 'datetimeinput', filtertype: 'range', cellsformat: 'yyyy-MM-dd HH:mm:ss',
                sortable: true,editable: false
            },{
                text: 'Modifield' , dataField: 'modified', width: 120, cellsalign: 'right',
                filterable: true, columntype: 'datetimeinput', filtertype: 'range', cellsformat: 'yyyy-MM-dd HH:mm:ss',
                sortable: true,editable: false, hidden: true
            }
        ];

        

        // var colSrc = [];
        // for(var i=0;i<this._columns.length;i++){
        //     if(this._columns[i].text!='')
        //     colSrc[i] = {
        //         label: this._columns[i].text,
        //         value: this._columns[i].dataField,
        //         checked: this._columns[i].hidden!=true?true:false
        //     }
        // }
        // $("#jqxListBoxSetting").jqxListBox({
        //     width: '100%', height: '200px',
        //     source: colSrc,
        //     checkboxes: true, 
        //     theme : me.theme
        // }).on('checkChange', function (event) {
        //     if (event.args.checked) {
        //         $(me.jqxgrid).jqxGrid('showcolumn', event.args.value);
        //     }
        //     else {
        //         $(me.jqxgrid).jqxGrid('hidecolumn', event.args.value);
        //     }
        // });
        function createGrid(){
            var source = {
                datatype    : "json",
                type        : "POST",
                datafields  : datafields,
                url         : URI.binding,
                id          :'id',
                root        : 'rows',
                filter: function() {
                    $(gridElm).jqxGrid('updatebounddata', 'filter');
                },
                sort: function() {
                    $(gridElm).jqxGrid('updatebounddata');
                }
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                formatData: function (data) {
                    data.type = App.Module.type;
                    data.table = 'tbl_setting';
                    return data;
                },
                loadError: function(xhr, status, error) {
                    toastr.error("<b>Status</b>:" + xhr.status + "<br/><b>ThrownError</b>:" + error + "<br/>",'Error');
                }
            });
            var h = $(window).height() - 12*2 - 90 - 46 - 30;
            $(gridElm).jqxGrid({
                width               : '100%', //
                //autoheight:true,
                rowsheight:28,
                height              : Math.max(240, h),
                source              : dataAdapter,
                theme               : theme,
                columns             : columns,
                selectionmode       : 'singlecell',
                filterable          : true,
                autoshowfiltericon  : true,
                showfilterrow       : true,
                sortable            : false,
                virtualmode         : false,
                groupable           : true,
                groups              : [],
                showgroupsheader    : false,
                editable            : true,
                editmode            : 'dblclick',
                pageable            : true,
                pagesize            : 100,
                pagesizeoptions     : [20,100, 200, 500, 1000],
                rendergridrows      : function(){ 
                    return me.dataAdapter.records; 
                },
                ready: function(){
                    // pendingOff();
                },
                handlekeyboardnavigation: function(event)
                {
                    var key = event.charCode ? event.charCode : event.keyCode ? event.keyCode : 0;
                    if (key == 27) {
                        me.cancel=true;
                    }
                },
            }).on("bindingcomplete", function (event) {
                $(gridElm).jqxGrid('addgroup', 'site');
                $(gridElm).jqxGrid('expandallgroups');
            })
        }
        var dialog;
        var columnDialog;
        var editingItem,groupNo;
        function addGroup(data){
            groupNo++;
            var groupname =  'New Group';
            if(data) groupname = data.name;
            var liElm = $([
                '<li role="presentation" class="" data-id="'+groupNo+'">',
                    '<a href="#tab-for-group-'+groupNo+'" aria-controls="tab-for-group-'+groupNo+'" role="tab" data-toggle="tab">'+groupname+'</a>',
                    '<div class="modal-action">',
                        '<div class="dropdown pull-right">',
                            '<a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>',
                            '<ul class="dropdown-menu"  style="min-width:80px">',
                                '<li data-action="rename"><a href="#"><span class="fa fa-pencil-square-o"></span> Rename</a></li>',
                                '<li data-action="remove"><a href="#"><span class="fa fa-trash-o"></span> Remove</a></li>',
                                '<li role="separator" class="divider"></li>',
                                '<li><a href="#"><span class="icon-question"></span> Help</a></li>',
                            '</ul>',
                        '</div>',
                    '</div>',
                '</li>',
                ].join(''))
            $('#click-to-add-new-tab').parent().before(liElm);
            var divElm = $([
                '<div role="tabpanel" class="tab-pane" id="tab-for-group-'+groupNo+'" data-id="'+groupNo+'">',
                    '<div class="">',
                        '<ul class="sortable "></ul>',
                        '<div class="clearfix"></div>',
                    '</div>',
                    '<div class="add-sortable-item">',
                        '<span class="icon-plus"></span> Add',
                    '</div>',
                '</div>'
                ].join(''))
            $('#tabcontents-for-group').append(divElm)
            var sortableElm = divElm.find('.sortable')

            // Add column item
            function addColumnItem(c){
                var li = $('<li/>')
                    .addClass('col-xs-'+ (c.col||'12') + (!!+c.biz?' biz':''))
                    .html('<div><span>'+c.title+'</span></div>')
                    .data('cdata',c)
                sortableElm.append(li)
                li.find('>div').append([
                    '<div class="dropdown pull-right">',
                        '<a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>',
                        '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">',
                            '<li><a data-action="edit" href="JavaScript:"><span class="fa fa-pencil"></span> Edit</a></li>',
                            '<li><a data-action="delete" href="JavaScript:"><span class="fa fa-trash-o"></span> Delete</a></li>',
                        '</ul>',
                    '</div>'
                    ].join(''))
                li.find('a[data-action="edit"]').click(function(){
                    editingItem = li;
                    var dataRecord = li.data('cdata')
                    console.log(dataRecord,'dataRecord')
                    var frm = $('#column-detail-frm');
                    console.log('dataRecord.biz',dataRecord.biz,!!+dataRecord.biz)
                    frm.find('input[name="name"]').val(dataRecord.name);
                    frm.find('input[name="title"]').val(dataRecord.title);
                    frm.find('select[name="type"]').val(dataRecord.type).change();
                    frm.find('select[name="sid"]').val(dataRecord.sid||'').change();
                    frm.find('input[name="client"]').val(dataRecord.client);
                    frm.find('input[name="server"]').val(dataRecord.server);
                    frm.find('input[name="biz"]').prop('checked', !!+dataRecord.biz);
                    frm.find('input[name="col"]').val(dataRecord.col || '12');
                    frm.find('select[name="type"]').selectpicker('refresh');
                    frm.find('select[name="sid"]').selectpicker('refresh');
                    if(dataRecord.data){
                        var html = dataRecord.data.map(function(item){
                                return [
                                '<tr>',
                                    '<td data-field="value">',
                                        item.value,
                                    '</td>',
                                    '<td data-field="display">',
                                        item.display,
                                    '</td>',
                                    '<td>',
                                        '<a href="JavaScript:" onclick="$(this).parents(\'tr\').remove()" class="icon-close"></span>',
                                    '</td>',
                                '</tr>'
                                ].join('');
                            }).join('')
                        //.join('');
                        frm.find('div[data-box="data"] table tbody').html(html)
                    }else{
                        frm.find('[data-box="data"] table tbody').html('')
                    }
                    App.Module.ShowColumnDetailDialog({
                        addColumnItem: addColumnItem,
                        divElm:divElm
                    })
                })
                li.find('a[data-action="delete"]').click(function(){
                    li.remove();
                })
            }
            if(data) data.data.map(addColumnItem)

            // Events
            liElm.find('li[data-action="rename"]').click(function(){
                if ($("#rename-tab-dialog").length === 0) {
                    $('body').append(
                        ['<div id="rename-tab-dialog">',
                            '<div class="pull-top">',
                                '<div class="control-group">',
                                    '<input id="input-for-tab-name" type="text" class="form-control">',
                                '</div>',
                            '</div>',
                        '</div>'].join(''));
                }
                var renameDialog = new App.Dialog({
                    'modal': true,
                    'message' : $('#rename-tab-dialog'),
                    'title': '<h4>Rename tab</h4>',
                    'dialogClass':'',
                    'width':'320px',
                    'type':'notice',
                    'hideclose':true,
                    'closeOnEscape':false,
                    'onopen': function(){
                        $('#input-for-tab-name').val(liElm.find('>a').html())
                    },
                    'buttons' : [{
                        'text': 'Done',
                        'class': 'ui-btn btn',
                        'click': function(){
                            var _name = $('#input-for-tab-name').val();
                            liElm.find('>a').html(_name);
                            $(this).dialog("close");
                        }
                    },{
                        'text': 'Cancel',
                        'class': 'btn btn-link',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                })
                renameDialog.open();
            })
            liElm.find('li[data-action="remove"]').click(function(){
                liElm.remove();
                divElm.remove();
                if($('#tabs-for-group>li').length>1){
                    $('#tabs-for-group>li:first-child>a').click();
                }
            })

            sortableElm.sortable({
              placeholder: "placeholder",
              start: function(e, ui){
                console.log(ui)
                ui.placeholder.addClass(ui.item.attr('class'))
              }
            });

            divElm.find('.add-sortable-item').click(function(){
                editingItem = null;
                // show the popup window.
                var frm = $('#column-detail-frm');
                frm.find('input[name="name"]').val('');
                frm.find('input[name="title"]').val('');
                frm.find('select[name="type"]').val('string').change();
                frm.find('select[name="sid"]').val('').change();
                frm.find('input[name="client"]').val('');
                frm.find('input[name="server"]').val('');
                frm.find('input[name="col"]').val('12');
                frm.find('input[name="biz"]').prop('checked', false);
                frm.find('select[name="type"]').selectpicker('refresh');
                frm.find('select[name="sid"]').selectpicker('refresh');
                frm.find('[data-box="data"] table tbody').empty();
                App.Module.ShowColumnDetailDialog({
                    addColumnItem: addColumnItem,
                    divElm:divElm
                })
            })

            if(!data) liElm.find('>a').click();
        }
        function initGroup(groups,columns){
            var data = groups.map(function(g){
                var cls = [];
                for(var i = 0;i<g.length;i++){
                    if(columns.length>0){
                        cls.push(columns.shift());
                    }
                }
                return {
                    name:g.name,
                    data: cls
                }
            })
            groupNo = 0;
            data.map(function(g,i){
                addGroup(g)
            })

            $('#click-to-add-new-tab').click(function(){
                addGroup()
            })
            if($('#tabs-for-group>li').length>1){
                $('#tabs-for-group>li:first-child>a').click();
            }
        }
        return {
            Grid: function(){
                createGrid();
            },
            Refresh: function() {
                $(gridElm).jqxGrid('updatebounddata');
            },
            Duplicate: function(){
                var frm = $('#detail-setting-frm');
                frm.find('input[name="id"]').val('');
                frm.find('input[name="title"]').val(frm.find('input[name="title"]').val() + '(copy)');
                frm.find('input[name="alias"]').val(frm.find('input[name="alias"]').val() + '-copy');
                frm.find('input[name="id"]').val('');
                App.Module.Save();
            },
            Delete: function(id,row){
                // toastr.warning('This function to requires an administrative account.<br/>Please check your authority, and try again.','Warning');
                var _data = $(gridElm).jqxGrid('getrowdata', row);
                if(_data.lock == 1){
                    toastr.warning('You can not delete this Item.','Warning');
                    return; 
                }
                var itemName = _data.title;
                App.Confirm(
                    'Delete item ?',
                    'Do you want delete "'+itemName+'".<br/>These items will be permanently deleted and cannot be recovered. Are you sure ?',
                    function(){
                        new App.Request({
                            'url': URI.delete,
                            'data': {
                                'id': id
                            },
                        }).done(function(res) {
                            if (res.code < 0) {
                                toastr.error(res.message,'Error');
                            } else {
                                toastr.success(res.message,'Success');
                                App.Module.Refresh();
                            }
                        })
                    }
                );
            },
            Save: function(){
                var frm = $('#detail-setting-frm');
                if( frm.validationEngine('validate') === false){
                    toastr.warning('Please complete input data.','Warning');
                    return;
                }
                
                var data = $('#detail-setting-frm').serializeObject();
                var groups = $('#tabcontents-for-group>.tab-pane').get().map(function(g,i){
                    var gname = $('#tabs-for-group>li:eq("'+i+'")>a').text();
                    var glength = $(g).find('.sortable>li').get().length; 
                    return {
                        name: gname,
                        length: glength
                    }
                })
                var columns = $('#tabcontents-for-group>.tab-pane .sortable>li').get().map(function(c){
                    var cdata = $(c).data('cdata');
                    // cdata.biz = +!!cdata.biz;
                    if(
                        !(
                            cdata.type == 'multidropdown' || 
                            cdata.type == 'dropdown' ||
                            cdata.type == 'radio'
                        )
                        ){
                        delete cdata.data;
                    }
                    if(
                        cdata.type == 'grid' || 
                        // cdata.type == 'checkbox' ||
                        cdata.type == 'list'
                        ){
                        delete cdata.client;
                        delete cdata.client;
                    }
                    if(
                        !(
                            cdata.type == 'grid' || 
                            cdata.type == 'list'
                        )
                        ){
                        delete cdata.sid;
                    }
                    return cdata;
                })
                data.data.groups = groups;
                data.data.columns = columns;
                data.data.add = !!data.data.add;
                data.data.edit = !!data.data.edit;
                data.data.delete = !!data.data.delete;
                data.data.unique = !!data.data.unique;
                data.data.showthumb = !!data.data.showthumb;
                console.log('Data:',data);
                // return;

                new App.Request({
                    url: URI.commit,
                    data: data,
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        $('#detail-setting-dialog').dialog("close");
                        App.Module.Refresh();
                    }
                })
            },
            ShowDetailDialog: function(id){
                if ($("#detail-setting-dialog").length === 0) {
                    $('body').append('<div id="detail-setting-dialog"></div>');
                }

                $('#detail-setting-dialog').html('<div class="loading"><span>Loading...</span></div>')
                dialog = new App.Dialog({
                    'modal': true,
                    'message' : $('#detail-setting-dialog'),
                    'title': '<h4>Add <small>Function setting</small></h4>',
                    'dialogClass':'',
                    'width':'560px',
                    'type':'notice',
                    'hideclose':true,
                    'closeOnEscape':false,
                    'oncreate': function(event, ui){
                        var toolbar = [
                            '<div class="modal-action">',
                                '<div class="dropdown pull-right">',
                                    '<a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>',
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">',
                                        '<li><a href="#"><span class="icon-settings"></span> Setting</a></li>',
                                        '<li role="separator" class="divider"></li>',
                                        '<li><a href="#"><span class="icon-question"></span> Help</a></li>',
                                    '</ul>',
                                '</div>',
                            '</div>'
                        ].join('')
                        $(event.target).dialog('widget')
                            .find('.ui-widget-header')
                            .append(toolbar)
                    },
                    'buttons' : [{
                        'text': 'Duplicate',
                        'class': 'ui-btn btn ' + (id?'':'hidden'),
                        'click': App.Module.Duplicate
                    },{
                        'text': 'Done',
                        'class': 'ui-btn btn',
                        'click': App.Module.Save
                    },{
                        'text': 'Cancel',
                        'class': 'btn btn-link',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                })

                dialog.open();
                $('#column-detail-dialog').remove();
                $('#column-data-item-dialog').remove();
                new App.Request({
                    url: URI.detail,
                    // datatype: 'html',
                    data: {
                        id: id || null,
                        type: App.Module.type,
                        basic_module: App.Module.basic_module
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                        dialog.close();
                    } else {
                        $('#detail-setting-dialog').html(res.html);
                        
                        
                        App.InitForm($('#detail-setting-frm'));

                        var frm = $('#column-detail-frm');
                        var groups = [];
                        var columns = [];
                        var defaultSeo = {"name":"Seo","data":[{"type":"string","col":"12","name":"stitle","title":"Title","client":"validate[maxSize[120]]","server":"","biz":0},{"type":"text","col":"12","name":"sdesc","title":"Description","client":"validate[maxSize[250]]","server":"","biz":0},{"type":"image","col":"12","name":"simage","title":"Image","client":"","server":"","biz":0},{"type":"text","col":"12","name":"skeywords","title":"Keywords","client":"validate[maxSize[120]]","server":"","biz":0}]}
                        if(
                            res.data && 
                            res.data.data && 
                            res.data.data.columns && 
                            res.data.data.groups
                            ){
                            columns = res.data.data.columns;
                            groups = res.data.data.groups;
                        } else if(
                            res.data && 
                            res.data.data && 
                            res.data.data.columns
                            ){
                            groups = [{
                                name: 'Information',
                                length: res.data.data.columns.length
                            },{
                                name: 'Seo',
                                length: defaultSeo.data.length
                            }];
                            columns = res.data.data.columns;
                            columns.push(defaultSeo.data[0])
                            columns.push(defaultSeo.data[1])
                            columns.push(defaultSeo.data[2])
                            columns.push(defaultSeo.data[3])
                        } else {
                            groups = [{
                                name: 'Information',
                                length: 0
                            },{
                                name: 'Seo',
                                length: defaultSeo.data.length
                            }]
                            columns = defaultSeo.data;
                        }
                        

                        initGroup(groups,columns);
                        App.InitForm(frm);
                        columnDialog = null;
                        frm.find('select[name="type"]').change(function(){
                            var type = this.value;
                            frm.find('[data-box]').hide();
                            switch(type) {
                                case 'multidropdown':
                                case 'dropdown':
                                case 'radio':
                                    frm.find('[data-box="data"]').show();
                            }
                            switch(type) {
                                case 'string':
                                case 'catelist':
                                case 'catetree':
                                case 'text':
                                case 'html':
                                case 'image':
                                    frm.find('[data-box="valid"]').show();
                            }
                            switch(type) {
                                case 'list':
                                case 'grid':
                                    frm.find('[data-box="sid"]').show();
                                    console.log('sid',type)

                            }
                        })
                        dialog.close();
                        dialog.open();
                    }
                })
            },
            ShowColumnDetailDialog: function(opt){
                columnDialog = new App.Dialog({
                    'modal': true,
                    'message' : $('#column-detail-dialog'),
                    'title': '<h4>Field <small>Setting Field</small></h4>',
                    'dialogClass':'',
                    'width':'420px',
                    'type':'notice',
                    'hideclose':true,
                    'closeOnEscape':false,
                    'oncreate': function(event, ui){
                        var toolbar = [
                            '<div class="modal-action">',
                                '<div class="dropdown pull-right">',
                                    '<a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>',
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">',
                                        '<li><a href="#"><span class="icon-settings"></span> Setting</a></li>',
                                        '<li role="separator" class="divider"></li>',
                                        '<li><a href="#"><span class="icon-question"></span> Help</a></li>',
                                    '</ul>',
                                '</div>',
                            '</div>'
                        ].join('')
                        $(event.target).dialog('widget')
                            .find('.ui-widget-header')
                            .append(toolbar)
                    },
                    'buttons' : [{
                        'text': 'Done',
                        'class': 'ui-btn btn',
                        'click': function() {
                            var frm = $('#column-detail-frm');
                            if( frm.validationEngine('validate') === false){
                                toastr.warning('Please complete input data.','Warning');
                                return;
                            }
                            var data = $('#column-detail-frm').serializeObject();
                            data.biz = +!!data.biz
                            console.log(data.biz,'data.biz')
                            data.data = frm.find('[data-box="data"] table tbody tr')
                                .get()
                                .map(function(tr){
                                    return {
                                        display: $(tr).find('td[data-field="display"]').html(),
                                        value: $(tr).find('td[data-field="value"]').html(),
                                    }
                                });
                            console.log('CData:',data);
                            if (editingItem) {
                                editingItem.data('cdata',data);
                                editingItem.attr('class', '');
                                editingItem.addClass('col-xs-'+ (data.col||'12') + (!!+data.biz?' biz':''));
                                editingItem.find('>div>span').html(data.title)
                            }else{
                                opt.addColumnItem(data)
                                opt.divElm.find('.sortable').sortable('refresh');
                            }
                            $(this).dialog("close");
                        }
                    },{
                        'text': 'Cancel',
                        'class': 'ui-btn btn',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                })
                columnDialog.open();
                
            },
            ShowColumnDataItemDialog: function(){
                new App.Dialog({
                    'modal': true,
                    'message' : $('#column-data-item-dialog'),
                    'title': '<h4>Item <small>add item</small></h4>',
                    'dialogClass':'',
                    'width':'240px',
                    'type':'notice',
                    'hideclose':true,
                    'closeOnEscape':false,
                    'oncreate': function(event, ui){
                        var toolbar = [
                            '<div class="modal-action">',
                                '<div class="dropdown pull-right">',
                                    '<a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>',
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">',
                                        '<li><a href="#"><span class="icon-settings"></span> Setting</a></li>',
                                        '<li role="separator" class="divider"></li>',
                                        '<li><a href="#"><span class="icon-question"></span> Help</a></li>',
                                    '</ul>',
                                '</div>',
                            '</div>'
                        ].join('')
                        $(event.target).dialog('widget')
                            .find('.ui-widget-header')
                            .append(toolbar)
                    },
                    'buttons' : [{
                        'text': 'Done',
                        'class': 'ui-btn btn',
                        'click': function() {
                            var frm = $('#column-detail-frm');
                            var data = $('#column-data-item-frm').serializeObject();
                            frm.find('[data-box="data"] table tbody').append(
                                 [
                                    '<tr>',
                                        '<td data-field="value">',
                                        data.value,
                                        '</td>',
                                        '<td data-field="display">',
                                        data.display,
                                        '</td>',
                                        '<td>',
                                        '<a href="JavaScript:" onclick="$(this).parents(\'tr\').remove()" class="icon-close"></span>',
                                        '</td>',
                                    'r>'
                                ].join('')  
                            );
                            $('#column-data-item-frm')[0].reset()
                            $(this).dialog("close");
                        }
                    },{
                        'text': 'Cancel',
                        'class': 'ui-btn btn',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                }).open();
                
            }
        }
    }())
})