var App = {};
App.pendingOn = function(){
    
}
App.pendingOff = function(){

}
App.ShowLogin = function(){
    if ($("#login-dialog").length === 0) {
        $('body').append('<div id="login-dialog"></div>');
    }
    new App.Dialog({
        'message' : $('#login-dialog'),
        'title': '<h4>Login <small>Authentication</small></h4>',
        'dialogClass':'',
        'width':'320px',
        'type':'notice',
        'hideclose':true,
        'closeOnEscape':false,
        'buttons' : [{
            'text': 'Login',
            'class': 'ui-btn btn-info btn',
            'click': function() {
                
            }
        },{
            'text': 'Cancel',
            'class': 'ui-btn btn',
            'click': function() {
                $(this).dialog("close");
            }
        }]
    }).open();
    $('#login-dialog .validation-frm').validationEngine({
        'scroll': false,
        'isPopup' : true,
        validateNonVisibleFields:true
    });
}
App.Dialog = function (option) {
    var me = this;
    this.option = {
        'modal': true,
        'closeOnEscape': true,
        'type': "notice", //notice,error,question,custom
        'title': null,
        'message': "",
        'uidialog': null,
        'hideclose': false,
        'autoOpen': false,
        'minwidth': '320px',
        'width': 'auto',
        'height': 'auto',
        'dialogClass': '',
        'onload': null,
        'onclose': null,
        'onopen': null,
        'callback': null,
        'buttons': null
    };
    if (option) {
        $.each(option, function(index, value) {
            me.option[index] = value;
        });
    }
    me.option.title = "<div class='ui-" + me.option.type + "'>" + (me.option.title === null ? "Notice Message !" : me.option.title) + "</div>";
    if (me.option.message === null || me.option.message === undefined) {
        
    } else if (typeof(me.option.message) === "object") {
        me.option.uidialog = me.option.message;
    } else {
        if (me.option.uidialog == null) {
            var node = 1;
            var $div = $('.ui-dialog-' + node);
            while ($div.length > 0 && !$div.is(":hidden")) {
                node++;
                $div = $('.ui-dialog-' + node);
            }
            if ($div.length === 0) {
                me.option.uidialog = $('<div/>', {
                    'class': 'ui-dialog-' + node
                }).appendTo($('body'));
            }else me.option.uidialog = $div;
        }
        if (typeof(me.option.message) === "string") {
            if(!me.option.buttons)
            me.option.buttons = {
                Close: function() {
                    $(this).dialog("destroy");
                }
            };
            me.option.uidialog.html('<div style="max-width:320px">' + me.option.message + '</div>');
        } else {
            //me.option.uidialog = $("#bckdialog");
            me.option.uidialog.html("Unkown this message !");
        }
    }
    var dialog = me.option.uidialog.dialog({
        'modal': me.option.modal,
        'autoOpen': me.option.autoOpen,
        'minwidth': me.option.minwidth,
        'dialogClass': me.option.dialogClass + ' ' + me.option.type,
        'resizable': false,
        'width': me.option.width,
        'title': me.option.title,
        'closeOnEscape': me.option.closeOnEscape,
        /*hide                : "explode",*/
        'buttons': me.option.buttons,
        'open': function(event, ui) {
            if (me.option.onopen && typeof(me.option.onopen) === "function") {
                try {
                    me.option.onopen();
                } catch (e) {}
            }
            $(event.target).dialog('widget')
                .css({
                    // 'position': 'fixed'
                })
                .position({
                    'my': 'center',
                    'at': 'center',
                    'of': window
                });
        },
        'close': function(event, ui) {
            if (me.option.onclose && typeof(me.option.onclose) === "function") {
                try {
                    me.option.onclose();
                } catch (e) {}
            }
        },
        'create': function(event, ui) {
            if (me.option.hideclose === true) {
                $(this).closest(".ui-dialog")
                    .find(".ui-dialog-titlebar-close")
                    .hide();
            }
            if (me.option.oncreate && typeof(me.option.oncreate) === "function") {
                try {
                    me.option.oncreate(event, ui);
                } catch (e) {}
            }
        }
    });
    return {
        'open': function() {
            me.option.uidialog.dialog('open');
        },
        'close': function() {
            me.option.uidialog.dialog('close');
        }
    };
}
App.Request = function (opt) {
    var option = {
        'url': null,
        'data': null,
        'datatype': "json",
        'before': null,
        'after': null,
        'done': null
    };
    if (opt)
        $.each(opt, function(index, value) {
            option[index] = value;
        });
    jQuery.ajax({
        type: "POST",
        //cache:false,
        //timeout:10000,
        data: option.data,
        dataType: option.datatype,
        url: option.url,
        success: function(data_result) {
            if (typeof(option.done) === 'function')
                option.done(data_result);
            if (typeof(option.after) === 'function')
                option.after();
            else {
                App.pendingOff();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            if (typeof(option.after) === 'function')
                option.after();
            else {
                App.pendingOff();
            }
            toastr.error('Sorry. Your request could not be completed. Please check your input data and try again.','Error');
        }
    });
    return {
        done: function(fn) {
            option.done = fn;
        }
    };
}
App.Confirm = function(title, message, callback) {
    if ($("#confirm-dialog").length === 0) {
        $('body').append('<div id="confirm-dialog">'+message+'</div>');
    }
    $('#confirm-dialog').html(message);
    new App.Dialog({
        'message' : $('#confirm-dialog'),
        'title': title,
                'width':'320px',
        'type':'confirm',
        'buttons' : [{
            'text': 'OK',
            'class': 'btn btn-ui',
            'click': function() {
                if(typeof callback == 'function') callback();
                $(this).dialog("close");
            }
        }, {
            'text': 'Cancel',
            'class': 'btn btn-ui',
            'click': function() {
                $(this).dialog("close");
            }
        }]
    }).open();
}
App.Auth = {
    Login: function(){
        var frm = $(document['login-frm']);
        if( frm.validationEngine('validate') === false){
            toastr.warning('Please complete input data.','Warning');
            return;
        }
        new App.Request({
            url: App.BaseUrl + 'api/auth/login',
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
            url: App.BaseUrl + 'api/auth/logout',
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
            url: App.BaseUrl + 'api/user/create',
            data: frm.serializeObject(),
        }).done(function(res){
            if(res.code < 0){
                toastr.warning(res.message,'Warning');
            }
        })
    }
}
App.InitForm = function(frm){
    frm.validationEngine({
        'scroll': false,
        'isPopup' : true,
        validateNonVisibleFields:true
    });
    frm.find('.selectpicker').selectpicker();
    
    if(frm.find('textarea[data-editor]').length>0){
        frm.find('textarea[data-editor]').each(function(){
                // addEditorBasic($(this).attr('id'),160);
                App.Editor.addEditorFeature($(this).attr('id'),200);
        })
        
    }
}
$(document).ready(function(){
    $('#navigation li>a').click(function(){
        if(!$(this).parent().hasClass('open')){
            $(this).parent().parent().find('>li.open').removeClass('open')
        }
        $(this).parent().toggleClass('open');
    });
    $('li[data-actived]').addClass('active open')
    $('li[data-actived]').parents('li').addClass('active open')
})