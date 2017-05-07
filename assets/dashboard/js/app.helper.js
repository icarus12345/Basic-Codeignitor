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
        addNotice(e.message,'error');
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
        addNotice(e.message,'error');
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