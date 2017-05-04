$(document).ready(function(){
    App.Common = (function(){
        var gridElm;
        var URI = {
            binding : App.BaseUrl + 'api/common/bind',
            detail  : App.BaseUrl + 'api/common/detail',
            commit  : App.BaseUrl + 'api/common/commit',
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
                            "onclick=\"App.Common.ShowDetail(" + value + ");\" "+ 
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
                    data.type = App.Common.entry_setting.data.type || '';
                    data.table = App.Common.entry_setting.data.storage;
                    return data;
                },
                loadError: function(xhr, status, error) {
                    toastr.error("<b>Status</b>:" + xhr.status + "<br/><b>ThrownError</b>:" + error + "<br/>",'Error');
                }
            });
            $(gridElm).jqxGrid({
                width               : '100%', //
                //autoheight:true,
                rowsheight:28,
                height              : '400px',
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
        }

        return {
            Grid: function(){
                createGrid();
            },
            Refresh: function() {
                $(gridElm).jqxGrid('updatebounddata');
            },
            Back: function(){
                if(!!App.Common.entry_setting.data.size){
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
                
                new App.Request({
                    url: URI.commit,
                    data: data,
                }).done(function(res){
                    if(res.code < 0){
                        toastr.warning(res.message,'Warning');
                    } else {
                        toastr.success(res.message,'Success');
                        if(!!App.Common.entry_setting.data.size){
                            $('#entry-detail').dialog("close");
                        } else {
                            $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>').hide();
                            $('#entrys-list').show();
                        }
                        App.Common.Refresh();
                    }
                })
            },
            ShowDetail: function(id){
                if(!!App.Common.entry_setting.data.size){
                    if ($("#entry-detail").length === 0) {
                        $('body').append('<div id="entry-detail"></div>');
                    }

                    $('#entry-detail').html('<div class="loading"><span>Loading...</span></div>')
                    dialog = new App.Dialog({
                        'modal': true,
                        'message' : $('#entry-detail'),
                        'title': '<h4>Add <small>'+App.Common.entry_setting.title+'</small></h4>',
                        'dialogClass':'',
                        'width': App.Common.entry_setting.data.size,
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
                        if(!!App.Common.entry_setting.data.size){
                            dialog.close();
                            dialog.open();
                        }

                        App.InitForm($('#entry-detail-frm'));
                        
                    }
                })
            },
        }
    }())
})