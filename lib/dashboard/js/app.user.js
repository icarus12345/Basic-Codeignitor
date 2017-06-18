$(document).ready(function(){
    App.User = (function(){
        var me= {}
        var gridElm;
        var URI = {
            binding : App.BaseUrl + 'dashboardapi/user/bind',
            detail  : App.BaseUrl + 'dashboardapi/user/detail',
            commit  : App.BaseUrl + 'dashboardapi/user/commit',
            update  : App.BaseUrl + 'dashboardapi/user/update',
            delete  : App.BaseUrl + 'dashboardapi/user/delete'
        };
        var theme = 'metro';
        me.bindingEntry = function(){
            me.datafields = [
                {name: 'ause_id', type: 'int'},
                {name: 'ause_name'},
                {name: 'ause_username'},
                {name: 'ause_email'},
                {name: 'ause_status' , type: 'bool'},
                {name: 'ause_created' , type: 'date'},
                {name: 'ause_modified' , type: 'date'}
            ];
            
            

            me.source = {
                datatype    : "json",
                type        : "POST",
                datafields  : me.datafields,
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
            me.dataAdapter = new $.jqx.dataAdapter(me.source, {
                formatData: function (data) {
                    return data;
                },
                loadError: function(xhr, status, error) {
                    toastr.error("<b>Status</b>:" + xhr.status + "<br/><b>ThrownError</b>:" + error + "<br/>",'Error');
                }
            });
            me.columns = [{
                text: '', dataField: 'ause_id', width: 52, filterable: false, sortable: true,editable: false,
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    var str = "";
                    if (value && value > 0) {
                        try {
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            'data-toggle="dropdown" data-target="#common-menu"'+
                            " "+ 
                            "title='Edit :" + value + "'><i class=\"icon-options-vertical\"></i></a>\
                            ";
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            "onclick=\"App.User.ShowDetailDialog(" + value + ");\" "+ 
                            "title='Edit :" + value + "'><i class=\"fa fa-pencil\"></i></a>\
                            ";
                            // str += "<a href='JavaScript:void(0)'"+
                            // "style='padding: 5px; float: left;margin-top: 2px;' " +
                            // "onclick=\"App.User.Delete(" + value + ","+row+");\" "+ 
                            // "title='Delete :" + value + "'><i class=\"fa fa-trash-o\"></i></a>\
                            // ";
                        } catch (e) {
                        }
                    }
                    return str;
                }
            },{
                text: 'Id'    , dataField: 'id2' , displayfield:'ause_id',cellsalign: 'right', 
                width: 60, columntype: 'numberinput', filtertype: 'number',
                filterable: false, sortable: false,editable: false,hidden:true
            },{
                text: 'Name', dataField: 'ause_name', minWidth: 180, sortable: true,
                columntype: 'textbox', filtertype: 'textbox', filtercondition: 'CONTAINS',
            },{
                text: 'Email', dataField: 'ause_email', minWidth: 180, sortable: true,
                columntype: 'textbox', filtertype: 'textbox', filtercondition: 'CONTAINS',
            },{
                text: 'Status'    , dataField: 'status' , cellsalign: 'center',
                width: 44, columntype: 'checkbox', threestatecheckbox: false, filtertype: 'bool',
                filterable: true, sortable: true,editable: true, hidden: false
            },{
                text: 'Created' , dataField: 'ause_created', width: 120, cellsalign: 'right',
                filterable: true, columntype: 'datetimeinput', filtertype: 'range', cellsformat: 'yyyy-MM-dd HH:mm:ss',
                sortable: true,editable: false
            },{
                text: 'Modifield' , dataField: 'ause_modified', width: 120, cellsalign: 'right',
                filterable: true, columntype: 'datetimeinput', filtertype: 'range', cellsformat: 'yyyy-MM-dd HH:mm:ss',
                sortable: true,editable: false, hidden: true
            }];
            
            init();
        }
        
        function init(){
            $('#entry-detail').hide();
            gridElm = $('#jqxGrid');
            
            var h = $(window).height() - 12*2 - 90 - 46 - 30;
            $(gridElm).jqxGrid({
                width               : '100%', //
                //autoheight:true,
                rowsheight:28,
                height              : Math.max(240, h),
                source              : me.dataAdapter,
                theme               : theme,
                columns             : me.columns,
                selectionmode       : 'singlecell',
                filterable          : true,
                autoshowfiltericon  : true,
                showfilterrow       : true,
                sortable            : false,
                virtualmode         : false,
                // groupable           : true,
                // groups              : [],
                // showgroupsheader    : false,
                editable            : false,
                // editmode            : 'dblclick',
                // pageable            : true,
                // pagesize            : 100,
                // pagesizeoptions     : [20,100, 200, 500, 1000],
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
            $('body').append('<ul id="common-menu" class="dropdown-menu">\
                <li><a data-action="add" href="#"><i class="fa fa-plus"></i> Add new Record</a></li>\
                <li><a data-action="edit" href="#"><i class="fa fa-pencil"></i> Edit Selected Row</a></li>\
                <li><a data-action="delete" href="#"><i class="fa fa-trash-o"></i> Delete Selected Row</a></li>\
                <li role="separator" class="divider"></li>\
                <li><a data-action="status" href="#"><i class="fa fa-toggle-off"></i> Invisible</a></li>\
            </ul>')
            $('#common-menu').on('contextmenu',function(){
                event.preventDefault();
                event.stopPropagation();
                return false;
            });
            $('#common-menu a').click(function(){
                var action = $(this).data('action');
                var cell = $(gridElm).jqxGrid('getselectedcell');
                var rowIndex = cell.rowindex;
                if(rowIndex>=0){
                    var rowData = $(gridElm).jqxGrid('getrowdata', rowIndex);
                    console.log(rowData)
                    switch(action){
                        case 'add':
                            App.User.ShowDetailDialog();
                            break;
                        case 'edit':
                            App.User.ShowDetailDialog(rowData.ause_id);
                            break;
                        case 'delete':
                            App.User.Delete(rowData.ause_id,rowIndex);
                            break;
                        case 'status':
                            App.User.onCommit(
                                   {status: rowData.ause_status=='1'?'false':'true'}, rowData.ause_id, App.User.Refresh
                                );
                            console.log(rowData.ause_id)
                            break;
                        case 'statuson':
                            App.User.onCommit(
                                   {status: 'true'}, rowData.ause_id, App.User.Refresh
                                );
                            console.log(rowData.ause_id)
                            break;
                        case 'statusoff':
                            App.User.onCommit(
                                   {status: 'false'}, rowData.ause_id, App.User.Refresh
                                );
                            break;
                        case 'sendlatest':
                            App.User.SendLatest(rowData.ause_id);
                            break;
                        case 'sendoldest':
                            App.User.SendOldest(rowData.ause_id);
                            break;
                    }
                    console.log(action)
                }
            })

            $(gridElm).bind('cellbeginedit', function (event) {
                me.cancel = false;
            })
            $(gridElm).on('contextmenu',function(){
                event.preventDefault();
                event.stopPropagation();
                
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
                var rowData = $(gridElm).jqxGrid('getrowdata', rowIndex);
                var openContextMenu = false;
                if(event.args.rightclick) openContextMenu = true;
                if($.jqx.mobile.isTouchDevice() && event.args.originalEvent.type=='touchend' && event.args.datafield=='id') 
                    openContextMenu = true;
                if(rowIndex>=0){
                    $(gridElm).jqxGrid('selectcell', rowIndex,event.args.datafield);
                    var dataRow = $(gridElm).jqxGrid('getrowdata', rowIndex);
                    $('#common-menu a').removeAttr('disabled')
                    // if(App.User.settings[App.User.sid].data.add != 'true'){
                        // $('#common-menu a[data-action="add"]').attr('disabled','1')
                    // }
                    // if(App.User.settings[App.User.sid].data.edit != 'true'){
                        // $('#common-menu a[data-action="edit"]').attr('disabled','1')
                        // $('#common-menu a[data-action="status"]').attr('disabled','1')
                        // $('#common-menu a[data-action="delete"]').attr('disabled','1')
                    // }
                    // if(App.User.settings[App.User.sid].data.delete != 'true'){
                        // $('#common-menu a[data-action="delete"]').attr('disabled','1')
                    // }
                    if(rowData.status==1){
                        $('#common-menu a[data-action="status"]').html('<i class="fa fa-toggle-off"></i> Invisible')
                    } else {
                        $('#common-menu a[data-action="status"]').html('<i class="fa fa-toggle-on"></i> Visible')
                    }

                    var scrollTop = $(window).scrollTop();
                    var scrollLeft = $(window).scrollLeft();
                    var menuWidth = $('#common-menu').width();
                    var menuHeight = $('#common-menu').height();
                    var clientX = (event.args.originalEvent.clientX) + scrollLeft,
                    clientY = (event.args.originalEvent.clientY) + scrollTop;
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
                    $('#common-menu').css({
                            position:'fixed',
                            top:y+'px',
                            left:x+'px',
                        })
                    if (openContextMenu) {
                        setTimeout(function(){
                            $('#common-menu').addClass('open')
                        },100)
                        // event.stopPropagation();
                        // event.preventDefault();
                        event.preventDefault();
                        event.stopPropagation();
                        return false;
                    }else{
                        
                    }
                }
            })
        }
        var Lists = {};
        var Grids = {};
        return {
            onCommit: function(data,id,callback){
                new App.Request({
                    url: URI.update,
                    data: {
                        id: id,
                        data: data
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        if(typeof callback == 'function') callback()
                    }
                })
            },
            Grid: function(){
                me.bindingEntry();
            },
            Refresh: function() {
                $(gridElm).jqxGrid('updatebounddata');
            },
            Back: function(){
                    $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').hide();
                    $('#entrys-list').show();
            },
            Delete: function(id,row){
                // toastr.warning('This function to requires an administrative account.<br/>Please check your authority, and try again.','Warning');
                var _data = $(gridElm).jqxGrid('getrowdata', row);
                if(_data.lock == 1){
                    toastr.warning('You can not delete this Item.','Warning');
                    return; 
                }
                console.log(_data,row)
                var itemName = _data.ause_name;
                App.Confirm(
                    'Delete item ?',
                    'Do you want delete "'+itemName+'".<br/>These items will be permanently deleted and cannot be recovered. Are you sure ?',
                    function(){
                        new App.Request({
                            'url': URI.delete,
                            'data': {
                                'ause_id': id
                            },
                        }).done(function(res) {
                            if (res.code < 0) {
                                toastr.error(res.message,'Error');
                            } else {
                                toastr.success(res.message,'Success');
                                App.User.Refresh();
                            }
                        })
                    }
                );
            },
            Save: function(only){
                var frm = $('#user-detail-frm');
                if( frm.validationEngine('validate') === false){
                    toastr.warning('Please complete input data.','Warning');
                    return;
                }
                
                var params = $('#user-detail-frm').serializeObject();

                // console.log(data);return;
                delete(params.confirmpassword)
                new App.Request({
                    url: URI.commit,
                    data: {
                        ause_id: $('#ause_id').val(),
                        params: params
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>')
                        dialog.close();
                        App.User.Refresh();
                    }
                })
            },
            ShowDetailDialog: function(id){

                $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').show();
                // $('#entrys-list').hide();
                dialog = new App.Dialog({
                    'modal': true,
                    'message' : $('#entry-detail'),
                    'title': '<h4>User <small>add</small></h4>',
                    'dialogClass':'',
                    'width':'480px',
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
                        'click': App.User.Save
                    },{
                        'text': 'Cancel',
                        'class': 'btn btn-link',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                })
                dialog.open();
                new App.Request({
                    url: URI.detail,
                    // datatype: 'html',
                    data: {
                        ause_id: id || null
                    },
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                        dialog.close();
                    } else {
                        $('#entry-detail').html(res.html);

                        App.InitForm($('#user-detail-frm'));
                        dialog.close();
                        dialog.open();
                        if(res.data)
                        $('#entry-detail').dialog('widget')
                            .find('.ui-widget-header')
                            .find('h4')
                            .html(res.data.ause_name + '<small>edit</small>')
                        
                    }
                })
            }
        }
    }())
})