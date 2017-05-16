App.Helper = {
    Alias: function(elm,f,t) {
        f = f || 'title';
        t = t || 'alias';
        var fromElm = $(elm).parents('form').find('input[name="' + f + '"]');
        var toElm = $(elm).parents('form').find('input[name="' + t + '"]');
        var str = fromElm.val();
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc

        var from = "àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ·/_,:;";
        var to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd-/_,:;";
        //var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        //var to   = "aaaaeeeeiiiioooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

        $(toElm).val(str);
    },
};
App.QueryString = (function () {
  // This function is anonymous, is executed immediately and
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
        // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
        // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
      query_string[pair[0]] = arr;
        // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  } 
  return query_string;
}())
App.Helper.ImageUrl = function(url){
    // if(
    //     url.startsWith('//') ||
    //     url.startsWith('http')
    // ){
    //     return url;
    // }
    if(
        url.startsWith('/data/')
    ){
        url = url.replace(/\/data\//g, "\/data\/thumbs\/");
        return App.BaseUrl + url;
    }
    return url;
}
//////
//// CKEDITOR START
//

App.Editor = {}
App.Editor.addRedactorEditor = function(Element) {
    Element.redactor({
        //air: true,
        //wym: true,
        'buttons': ['html', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'alignment', '|', 'video', 'link', '|', 'fontcolor', 'backcolor']
        //plugins: ['advanced']
    });
}

App.Editor.addEditorFeature = function(ElementID, height) {
//    var instance = CKEDITOR.instances[ElementID];
//    if (instance) {
//        return;
//    }
    if(typeof height == 'undefined') height = 320
    try {
        CKEDITOR.config.startupFocus = false;
        CKEDITOR.replace(ElementID, {
            'height': height,
            'toolbar': [
                ['Source'], ['Preview', 'Templates'],
                ['Image', 'Youtube','Video'], ['Flash', 'Table'],
                ['HorizontalRule', 'Smiley', 'SpecialChar'], ['PageBreak', 'Iframe'],
                ['Bold', 'Italic'], ['Underline', 'Strike'],
                ['Subscript', 'Superscript'],
                ['NumberedList', 'BulletedList'], ['Outdent', 'Indent'],
                ['Blockquote', 'CreateDiv'],
                ['JustifyLeft', 'JustifyCenter'], ['JustifyRight', 'JustifyBlock'],
                ['BidiLtr', 'BidiRtl', 'Language'],
                ['Link', 'Unlink'],
                /*['Styles'], */
                ['Format'], ['Font'], ['FontSize'],
                ['TextColor', 'BGColor'],['RemoveFormat'],
                ['Maximize', 'ShowBlocks']
                
            ],
            'removePlugins': 'magicline'

        });
        CKEDITOR.instances[ElementID].on('change', function() { CKEDITOR.instances[ElementID].updateElement() });
    } catch (e) {
        toastr.error(e.message,'Error');
    }

}

App.Editor.addEditorBasic = function (ElementID, height) {
//    var instance = CKEDITOR.instances[ElementID];
//    if (instance) {
//        return;
//    }
    if(typeof height == 'undefined') height = 320
    try {
        CKEDITOR.config.startupFocus = false;
        CKEDITOR.replace(ElementID, {
            'height': height,
            'toolbar': [
                ['ShowBlocks', 'Image'],
                ['NumberedList', 'BulletedList'],['Outdent', 'Indent'],['Link', 'Unlink'],
                ['JustifyLeft', 'JustifyCenter'], ['JustifyRight', 'JustifyBlock'],
                ['Format'], ['TextColor', 'BGColor']
            ],
            'removePlugins': 'magicline'
        });
        CKEDITOR.instances[ElementID].on('change', function() { CKEDITOR.instances[ElementID].updateElement() });
    } catch (e) {
        toastr.error(e.message,'Error');
    }
}

App.Editor.removeEditor = function (EId) {
    var instance = CKEDITOR.instances[EId];
    if (instance) {
        //CKEDITOR.remove(instance);
        instance.destroy(true);
    }
    //CKEDITOR.replace(EId);
}
//////
//// END
//

//////
//// KCFINDER - START
//
App.KCFinder={}
App.KCFinder.BrowseServerCallBack = function (callback) {
    try {
        window.KCFinder = {};
        window.KCFinder.callBack = function(url) {
            window.KCFinder = null;
            callback(url);
            $('#kc-finder-popup .kc-finder-content').html('');
            $('#kc-finder-popup').hide();
        };
        
        if($('#kc-finder-popup').length==0){
            window.open(App.BaseUrl + 'lib/kcfinder/browse.php?lang=en', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=700, height=500'
            );;
        }else{
            $('#kc-finder-popup .kc-finder-content').html('<iframe name="kcfinder_iframe" src="'+App.BaseUrl + 'lib/kcfinder/browse.php?lang=en" style="width:100%;height:100%;position:absolute;top:0;left:0;border:0;margin:0;padding:0"/>')
            $('#kc-finder-popup').show();
        }
    } catch (e) {
        toastr.error(e.message,'Error');
    }
}

App.KCFinder.openKCFinderByPath = function (path, element) {
    if ($(element).length === 0) {
        addNotice("Input element is not exist.",'error');
        return;
    }
    try {
        window.KCFinder = {};
        window.KCFinder.callBack = function(url) {
            window.KCFinder = null;
            $(element).val(url);
            $('#kc-finder-popup .kc-finder-content').html('');
            $('#kc-finder-popup').hide();
        };
        
        if($('#kc-finder-popup').length==0){
            window.open(App.BaseUrl + 'lib/kcfinder/browse.php?lang=en&' + path, 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=700, height=500'
            );
        }else{
            $('#kc-finder-popup .kc-finder-content').html('<iframe name="kcfinder_iframe" src="'+App.BaseUrl + 'lib/kcfinder/browse.php?lang=en'+path+'" style="width:100%;height:100%;position:absolute;top:0;left:0;border:0;margin:0;padding:0"/>')
            $('#kc-finder-popup').show();
        }
    } catch (e) {
        toastr.error(e.message,'Error');
    }

}

App.KCFinder.openKCFinderMulti = function (callback) {
    window.KCFinder = {
        callBackMultiple: function(files) {
            window.KCFinder = null;
            callback(files);
            $('#kc-finder-popup .kc-finder-content').html('');
            $('#kc-finder-popup').hide();
        }
    };
    
    if($('#kc-finder-popup').length==0){
        window.open(App.BaseUrl + 'lib/kcfinder/browse.php?lang=en',
            'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }else{
        $('#kc-finder-popup .kc-finder-content').html('<iframe name="kcfinder_iframe" src="'+App.BaseUrl + 'lib/kcfinder/browse.php?lang=en" style="width:100%;height:100%;position:absolute;top:0;left:0;border:0;margin:0;padding:0"/>')
        $('#kc-finder-popup').show();
    }
}

App.KCFinder.openKCFinderMultiByPath = function (path, callback) {
    window.KCFinder = {
        callBackMultiple: function(files) {
            window.KCFinder = null;
            callback(files);
            $('#kc-finder-popup .kc-finder-content').html('');
            $('#kc-finder-popup').hide();
        }
    };
    
    if($('#kc-finder-popup').length==0){
        window.open(App.BaseUrl + 'lib/kcfinder/browse.php?lang=en&' + path,
            'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }else{
        $('#kc-finder-popup .kc-finder-content').html('<iframe name="kcfinder_iframe" src="'+App.BaseUrl + 'lib/kcfinder/browse.php?lang=en&' + path +'" style="width:100%;height:100%;position:absolute;top:0;left:0;border:0;margin:0;padding:0"/>')
        $('#kc-finder-popup').show();
    }
}
App.KCFinder.BrowseServer = function (elementid) {
    if ($(elementid).length === 0){
        toastr.error('Input element is not exist','Error');
        return;
    }
    var div = document.getElementById('kc-finder-popup');
    if ($("#kc-finder-dialog").length === 0) {
        $('body').append('<div id="kc-finder-dialog"><div style="padding-bottom:64.42%"></div></div>');
    }
    new App.Dialog({
        'message' : $('#kc-finder-dialog'),
        'title': '<h4>KCFinder <small>Image browser</small></h4>',
        'dialogClass':'',
        'width':'720px',
        'type':'notice',
        // 'hideclose':true,
        'closeOnEscape':false
    }).open();
    try {
        window.KCFinder = {};
        window.KCFinder.callBack = function(url) {
            window.KCFinder = null;
            $(elementid).val(url);
            $(elementid).focus();
            $('#kc-finder-dialog>div').html('');
            $('#kc-finder-dialog').dialog('close')
        };
        if($('#kc-finder-dialog').length==0){
            window.open(App.BaseUrl + 'lib/kcfinder/browse.php?lang=en&type=image', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=700, height=500'
            );
        }else{
            $('#kc-finder-dialog>div').html('<iframe name="kcfinder_iframe" src="'+App.BaseUrl + 'lib/kcfinder/browse.php?lang=en&type=image'+'" style="width:100%;height:100%;position:absolute;top:0;left:0;border:0;margin:0;padding:0"/>')
        }
    } catch (e) {
        toastr.error(e.message,'Error');
    }
}
//////
//// END
//