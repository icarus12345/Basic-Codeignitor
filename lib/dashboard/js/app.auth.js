App.Auth = {
    Login: function(){
        var frm = $(document['login-frm']);
        if( frm.validationEngine('validate') === false){
            toastr.warning('Please complete input data.','Warning');
            return;
        }
        new App.Request({
            url: App.BaseUrl + 'dashboardapi/auth/login',
            data: frm.serializeObject(),
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            } else {
                location.reload();
            }
        })
    },
    Logout: function(){
        new App.Request({
            url: App.BaseUrl + 'dashboardapi/auth/logout',
            data: {},
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            } else {
                location.reload();
            }
        })
    },
    Create: function(){
        var frm = $(document['login-frm']);
        if( frm.validationEngine('validate') === false){
            toastr.warning('Please complete input data.','Warning');
            return;
        }
        new App.Request({
            url: App.BaseUrl + 'dashboardapi/user/create',
            data: frm.serializeObject(),
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            }
        })
    },
    Detail: function(){
        if ($("#myaccount-dialog").length === 0) {
            $('body').append('<div id="myaccount-dialog"></div>');
        }

        $('#myaccount-dialog').html('<div class="loading"><span>Loading...</span></div>')
        var dialog = new App.Dialog({
            'modal': true,
            'message' : $('#myaccount-dialog'),
            'title': '<h4>Account information !</h4>',
            'dialogClass':'',
            'width': 380,
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
                'text': 'Update',
                'class': 'ui-btn btn',
                'click': App.Auth.Save
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
            url: App.BaseUrl + 'dashboardapi/user/myaccount',
            // datatype: 'html',
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            } else {
                $('#myaccount-dialog').html(res.html);
                dialog.close();
                dialog.open();
                App.InitForm($('#myaccount-frm'));
                
            }
        })
    },
    Save: function(){
        var frm = $('#myaccount-frm');
        if( frm.validationEngine('validate') === false){
            toastr.warning('Please complete input data.','Warning');
            return;
        }
        
        var data = $('#myaccount-frm').serializeObject();
        
        new App.Request({
            url: App.BaseUrl + 'dashboardapi/user/updatemyaccount',
            data: data,
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            } else {
                toastr.success(res.message,'Success');
                $('#myaccount-dialog').dialog("close");
            }
        })
    }
}