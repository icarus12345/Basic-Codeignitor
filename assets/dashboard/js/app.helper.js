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
    }
}