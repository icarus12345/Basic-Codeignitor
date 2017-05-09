$(document).ready(function(){
    App.Common = (function(){
        var me= {}
        var gridElm;
        var URI = {
            binding : App.BaseUrl + 'api/common/bind',
            detail  : App.BaseUrl + 'api/common/detail',
            subdetail  : App.BaseUrl + 'api/common/subdetail',
            commit  : App.BaseUrl + 'api/common/commit',
            update  : App.BaseUrl + 'api/common/update',
            delete  : App.BaseUrl + 'api/common/delete',
        };
        var theme = 'metro';
        var datafields = [
            {name: 'id', type: 'int'},
            {name: 'title'},
            {name: 'level'},
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
                            "onclick=\"App.Common.ShowDetailDialog(" + value + ");\" "+ 
                            "title='Edit :" + value + "'><i class=\"fa fa-pencil-square\"></i></a>\
                            ";
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            "onclick=\"App.Common.Delete(" + value + ","+row+");\" "+ 
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
                columntype: 'textbox', filtertype: 'textbox', filtercondition: 'CONTAINS',
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    var dataRow = $(gridElm).jqxGrid('getrowdata', row);
                    var str = '<div style="overflow: hidden; text-overflow: ellipsis; padding-bottom: 4px; text-align: left; margin-right: 2px; margin-left: 4px; padding-top: 4px;">';
                    str+='<span style="padding-left:'+dataRow.level*20+'px;">'+value+'</span>';
                    //str+=dataRow.Display;
                    str+='</div>';
                    return str;
                }
                
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
        var editingItem;
        function addItem(column, sid, data){
            var li = $('<li/>')
                .addClass('col-xs-12')
                .html('<div><span>'+data.title+'</span></div>')
                .data('cdata',data)
            $( '#data-' + column ).append(li)
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
                var cdata = li.data('cdata');
                editingItem = li;
                App.Common.ShowSubDetailDialog(column,sid,cdata);
            })
            li.find('a[data-action="delete"]').click(function(){
                li.remove();
            })
        }
        function createGrid(){
            $('#entry-detail').hide();
            gridElm = $('#jqxGrid');
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
                    data.type = App.Common.settings[App.Common.sid].data.type || '';
                    data.table = App.Common.settings[App.Common.sid].data.storage;
                    return data;
                },
                loadError: function(xhr, status, error) {
                    toastr.error("<b>Status</b>:" + xhr.status + "<br/><b>ThrownError</b>:" + error + "<br/>",'Error');
                }
            });
            var w = $(window).height() - 12*2 - 120 - 46 - 30;
            $(gridElm).jqxGrid({
                width               : '100%', //
                //autoheight:true,
                rowsheight:28,
                height              : Math.max(240, w),
                source              : dataAdapter,
                theme               : theme,
                columns             : columns,
                selectionmode       : 'singlecell',
                filterable          : true,
                autoshowfiltericon  : true,
                showfilterrow       : true,
                sortable            : false,
                virtualmode         : false,
                // groupable            : true,
                // groups              : ['author_name','topic_title'],
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
            })
            $('body').append('<div id="jqxMenu" class="jqx-contextMenu">\
                                <ul>\
                                    <li data-action="add" id="jqxAddAction"><i class="fa fa-plus"></i> Add new Record</li>\
                                    <li data-action="edit" id="jqxEditAction"><i class="fa fa-pencil-square"></i> Edit Selected Row</li>\
                                    <li data-action="status" id="jqxStatusAction">\
                                        <i class="fa fa-toggle-off"></i> Status\
                                        <ul>\
                                            <li data-action="statuson" id="jqxStatusActionOn"><i class="fa fa-check-square-o"></i> Enable</li>\
                                            <li data-action="statusoff" id="jqxStatusActionOff"><i class="fa fa-square-o"></i> Disable</li>\
                                        </ul>\
                                    </li>\
                                    <li data-action="delete" id="jqxDeleteAction"><i class="fa fa-trash-o"></i> Delete Selected Row</li>\
                                    <li data-action="view" id="jqxViewAction"><i class="fa fa-eye"></i> View Selected Row</li>\
                                    <li data-action="chart" id="jqxChartAction"><i class="fa fa-line-chart"></i> Chart</li>\
                                </ul>\
                            </div>')
            me.contextMenu = $("#jqxMenu").jqxMenu({ 
                width: 200, 
                height: 'auto', 
                autoOpenPopup: false, 
                mode: 'popup',
                theme: theme,
                animationShowDuration:0,
                animationHideDuration:0,
                animationShowDelay:0,
                animationHideDelay:0
            }).on('itemclick', function (event) {
                var $args = $(args);
                // var rowIndex = $(gridElm).jqxGrid('getselectedrowindex');
                var cell = $(gridElm).jqxGrid('getselectedcell');
                var rowIndex = cell.rowindex;
                if(rowIndex>=0){
                    var rowData = $(gridElm).jqxGrid('getrowdata', rowIndex);
                    if(rowData){
                        var action = $args.data('action');
                        var entryId = rowData.id;
                        if(action == 'add'){
                            me.addItem();
                        }else if(action == 'edit'){
                            me.editItem(entryId);
                        }else if(action == 'delete'){
                            me.removeItem(entryId,rowIndex);
                        }else if(action == 'status'){
                        }else if(action == 'statuson'){
                            // me.onCommit(me.entryCommitUri,{[{$frefix}]status: 'true'}, entryId, me.onRefresh);
                        }else if(action == 'statusoff'){
                            // me.onCommit(me.entryCommitUri,{[{$frefix}]status: 'false'}, entryId, me.onRefresh);
                        }else if(action == 'chart'){
                            // var chart_title = "Chart of "+rowData.[{$frefix}]title;
                            // myChart.openWeekChart('_product',entryId,'[{date('Y-m-d')}]','View',chart_title);
                        }else{
                            addNotice("Function is updating !",'warning');
                        }
                    }
                }
            });

            $(gridElm).bind('cellbeginedit', function (event) {
                me.cancel = false;
            }).bind('cellendedit', function (event) {
                if(me.cancel) return;
                try{
                    var args = event.args;
                    var _column = args.datafield, 
                        _row = args.rowindex, 
                        _value = args.value;
                    var _data = $(gridElm).jqxGrid('getrowdata', _row);
                    var _id = _data.id;
                    if (_id == undefined || _id == "") {
                        return;
                    }
                    var updateCell = function(){
                        me.onRefresh();
                    };
                    switch (_column) {
                        case 'title':
                            if (_value != _data.title && _value!='')
                                // me.onCommit(
                                //     me.entryCommitUri,
                                //     {title: _value},
                                //     _id
                                // );
                            break;
                        
                        case 'status':
                            if (_value)
                                App.Common.onCommit(
                                   {status: '1'}, _id
                                );
                            else
                                App.Common.onCommit(
                                   {status: '0'}, _id
                                );
                            break;
                        default:
                            toastr.warning("Column editable is dont support !",'Warning');
                            console.log(_value)
                    }
                } catch (e) {
                    toastr.error(e.message, 'Error');
                }
            }).on('contextmenu',function(){
                return false;
            }).on('cellclick', function (event) {

                var getTouches = function (e) {
                    if (e.originalEvent) {
                        if (e.originalEvent.touches && e.originalEvent.touches.length) {
                            return e.originalEvent.touches;
                        } else if (e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
                            return e.originalEvent.changedTouches;
                        }
                    }
                    if (!e.touches) {
                        e.touches = new Array();
                        e.touches[0] = e.originalEvent;
                    }
                    return e.touches;
                };
                var rowIndex = event.args.rowindex;
                var openContextMenu = false;
                if(event.args.rightclick) openContextMenu = true;
                if($.jqx.mobile.isTouchDevice() && event.args.originalEvent.type=='touchend' && event.args.datafield=='[{$frefix}]id') 
                    openContextMenu = true;
                if(rowIndex>=0){
                    if (openContextMenu) {
                        $(gridElm).jqxGrid('selectcell', rowIndex,event.args.datafield);
                        var scrollTop = $(window).scrollTop();
                        var scrollLeft = $(window).scrollLeft();
                        var menuWidth = me.contextMenu.width();
                        var menuHeight = me.contextMenu.height();
                        var clientX = (event.args.originalEvent.clientX) + scrollLeft,
                        clientY = (event.args.originalEvent.clientY) + scrollTop;
                        //touchstart
                        if(event.args.originalEvent.type=='touchend'){
                            var touches = getTouches(event.args.originalEvent);
                            var touch = touches[0];
                            clientX = touch.pageX;
                            clientY = touch.pageY;
                        }
                        var x = parseInt(clientX);
                        var y = parseInt(clientY);
                        var windowWidth = $(window).width() + scrollLeft;
                        var windowHeight = $(window).height() + scrollTop;
                        if( x + menuWidth > windowWidth){
                            x = windowWidth - menuWidth -4;
                        }
                        if( y + menuHeight > windowHeight){
                            y = windowHeight - menuHeight -4;
                        }
                        if(event.args.originalEvent.type=='touchend'){
                            setTimeout(function(){
                                me.contextMenu.jqxMenu('open', x, y);
                            },500);
                        }else{
                            me.contextMenu.jqxMenu('open', x, y);
                        }
                        var dataRow = $(gridElm).jqxGrid('getrowdata', rowIndex);
                        
                        event.stopPropagation();
                        event.preventDefault();
                    }
                }
                return false;
            })

            
        }
        var Lists = {};
        var Grids = {};
        return {
            onCommit: function(data,id){
                new App.Request({
                    url: URI.update,
                    data: {
                        id: id,
                        sid: App.Common.sid,
                        data: data
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        
                    }
                })
            },
            Grid: function(){
                createGrid();
            },
            CreateList: function(data){
                var frm = $('#entry-detail-frm');
                frm.find('.add-sortable-item').click(function(){
                    editingItem = null;
                    var column = $(this).data('column');
                    var sid = $(this).data('sid');
                    App.Common.ShowSubDetailDialog(column,sid);
                });

                frm.find('.sortable').each(function(){
                    var column = $(this).data('column');
                    var sid = $(this).data('sid');
                    console.log(data.longdata[column])
                    data.longdata[column].map(function(cdata){
                        addItem(column,sid,cdata)
                    })
                    $(this).sortable({
                        placeholder: "placeholder",
                        start: function(e, ui){
                            console.log(ui)
                            ui.placeholder.addClass(ui.item.attr('class'))
                        }
                    });
                });

            },
            Refresh: function() {
                $(gridElm).jqxGrid('updatebounddata');
            },
            Back: function(){
                if(!!App.Common.settings[App.Common.sid].data.size){
                    $('#entry-detail').dialog("close");
                } else {
                    $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').hide();
                    $('#entrys-list').show();
                }
            },
            Duplicate: function(){
                var frm = $('#entry-detail-frm');
                frm.find('input[name="id"]').val('');
                frm.find('input[name="title"]').val(frm.find('input[name="title"]').val() + '(copy)');
                frm.find('input[name="alias"]').val(frm.find('input[name="alias"]').val() + '-copy');
                frm.find('input[name="id"]').val('');
                App.Common.Save();
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
                                App.Common.Refresh();
                            }
                        })
                    }
                );
            },
            Save: function(){
                var frm = $('#entry-detail-frm');
                if( frm.validationEngine('validate') === false){
                    toastr.warning('Please complete input data.','Warning');
                    return;
                }
                
                var data = $('#entry-detail-frm').serializeObject();

                data.longdata = {};
                frm.find('.sortable').each(function(){
                    var column = $(this).data('column');
                    var subData = $(this).find('>li').get().map(function(li){
                        return $(li).data('cdata');
                    })
                    data.longdata[column] = subData;
                })
                // console.log(data);return;
                new App.Request({
                    url: URI.commit,
                    data: {
                        id: data.id,
                        sid: App.Common.sid || null,
                        data: data
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        if(!!App.Common.settings[App.Common.sid].data.size){
                            $('#entry-detail').dialog("close");
                        } else {
                            $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').hide();
                            $('#entrys-list').show();
                        }
                        App.Common.Refresh();
                    }
                })
            },
            ShowDetailDialog: function(id){
                if(!!App.Common.settings[App.Common.sid].data.size){
                    if ($("#entry-detail").length === 0) {
                        $('body').append('<div id="entry-detail"></div>');
                    }

                    $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>')
                    dialog = new App.Dialog({
                        'modal': true,
                        'message' : $('#entry-detail'),
                        'title': '<h4>Add <small>'+App.Common.settings[App.Common.sid].title+'</small></h4>',
                        'dialogClass':'',
                        'width': App.Common.settings[App.Common.sid].data.size,
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
                            'click': App.Common.Duplicate
                        },{
                            'text': 'Done',
                            'class': 'ui-btn btn',
                            'click': App.Common.Save
                        },{
                            'text': 'Cancel',
                            'class': 'btn btn-link',
                            'click': function() {
                                $(this).dialog("close");
                            }
                        }]
                    })

                    dialog.open();
                } else {
                    $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').show();
                    $('#entrys-list').hide();
                }

                new App.Request({
                    url: URI.detail,
                    // datatype: 'html',
                    data: {
                        id: id || null,
                        sid: App.Common.sid || null
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        $('#entry-detail').html(res.html);

                        App.InitForm($('#entry-detail-frm'));
                        App.Common.CreateList(res.data);
                        if(!!App.Common.settings[App.Common.sid].data.size){
                            dialog.close();
                            dialog.open();
                        }
                        
                    }
                })
            },
            ShowSubDetailDialog: function(column,sid,data){
                if ($("#sub-entry-detail").length === 0) {
                    $('body').append('<div id="sub-entry-detail"></div>');
                }

                $('#sub-entry-detail').html('<div class="loading"><span>Loading...</span></div>');
                var subdialog = new App.Dialog({
                    'modal': true,
                    'message' : $('#sub-entry-detail'),
                    'title': '<h4>Add <small>'+App.Common.settings[sid].title+'</small></h4>',
                    'dialogClass':'',
                    'width': App.Common.settings[sid].data.size || 640,
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
                        'click': function(){
                            var frm = $('#subentry-detail-frm');
                            if( frm.validationEngine('validate') === false){
                                toastr.warning('Please complete input data.','Warning');
                                return;
                            }
                            var data = $('#subentry-detail-frm').serializeObject();
                            if (editingItem) {
                                editingItem.data('cdata',data);
                                editingItem.find('>div>span').html(data.title)
                            } else {
                                addItem(column,sid,data);
                            }
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
                subdialog.open();
                new App.Request({
                    url: URI.subdetail,
                    // datatype: 'html',
                    data: {
                        sid: sid,
                        data: data || null
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        $('#sub-entry-detail').html(res.html);

                        App.InitForm($('#subentry-detail-frm'));
                        subdialog.close();
                        subdialog.open();
                        
                    }
                })
            }
        }
    }())
})