$(document).ready(function(){
    App.Setting = (function(){

        var bindingUrl = App.BaseUrl + '/api/common/bind';
        var gridElm = $('#jqxGrid');
        var theme = 'metro';
        var datafields = [
            {name: 'id', type: 'int'},
            {name: 'title'},
            {name: 'status' , type: 'bool'},
            {name: 'created' , type: 'date'},
            {name: 'modified' , type: 'date'},
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
                            "onclick=\"myApp.editItem(" + value + ");\" "+ 
                            "title='Edit :" + value + "'><i class=\"fa fa-pencil-square\"></i></a>\
                            ";
                            str += "<a href='JavaScript:void(0)'"+
                            "style='padding: 5px; float: left;margin-top: 2px;' " +
                            "onclick=\"myApp.removeItem(" + value + ","+row+");\" "+ 
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
                url         : bindingUrl,
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
                    data.type = '';
                    data.table = 'tbl_setting';
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
        var dialog;
        return {
            Grid: function(){
                createGrid();
            },
            Refresh: function() {
                $(gridElm).jqxGrid('updatebounddata');
            },
            Add: function(){
                if ($("#add-setting-dialog").length === 0) {
                    $('body').append('<div id="add-setting-dialog"></div>');
                }
                $('#add-setting-dialog').html('<div class="loading"><span>Loading...</span></div>')
                dialog = dialog || new App.Dialog({
                    'modal': false,
                    'message' : $('#add-setting-dialog'),
                    'title': '<h4>Add <small>Function setting</small></h4>',
                    'dialogClass':'',
                    'width':'640px',
                    'type':'notice',
                    'hideclose':true,
                    'closeOnEscape':false,
                    'buttons' : [{
                        'text': 'Done',
                        'class': 'ui-btn btn',
                        'click': function() {
                            
                        }
                    },{
                        'text': 'Cancel',
                        'class': 'ui-btn btn',
                        'click': function() {
                            $(this).dialog("close");
                        }
                    }]
                })

                dialog.open();

                new App.Request({
                    url: App.BaseUrl + 'dashboard/setting/detail',
                    datatype: 'html',
                    data: {},
                }).done(function(res){
                    $('#add-setting-dialog').html(res);
                    dialog.close();
                    dialog.open();
                    App.InitForm($('#add-setting-frm'))
                })
            }
        }
    }())
    App.Setting.Grid();
})