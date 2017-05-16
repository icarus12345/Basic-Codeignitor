$(function() {
    var result = $('#result');
    // Print a hash
    $.print = function(dict) {
        console.log(dict)
        return JSON.stringify(dict);
    }
    $(document)
        .route('/', function(request) {
            console.log('/: ' + $.print(request.params));
        }).route('settings/', function(request) {
            console.log('settings: ' + $.print(request.params));
        }).route('quit/', function(request) {
            console.log('quit: ' + $.print(request.params));
        }).route('book/:id/', function(request, id) {
            console.log('book ' + id + ': ' + $.print(request.params));
        }).route('book/:id/note/:noteId#[0-9]+#/', function(request, id, noteId) {
            console.log('book ' + id + ', note ' + noteId + ': ' + $.print(request.params));
        });
    // Bind hashchange event
    function hashchange(e, triggered) {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            var match = $.routeMatches(hash);
            if (match) {
                var template = $(match.route.template);
                if (template.length) {
                    var text = match.route.callback.apply(match.route.callback, match.args);
                    template.text(text);
                }
            }
        }
    }
    hashchange();
    $(window).bind('hashchange', hashchange);
})