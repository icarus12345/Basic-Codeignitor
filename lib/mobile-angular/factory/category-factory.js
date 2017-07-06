function CategoryFactory(API,StorageService) {
    var scode;
    this.setScope = function(_scode){
        scope = _scode;
    }
    this.get_by_pid = function(pid,callback){
        var data = StorageService.get('category',pid);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/category/get_by_pid',
            data: {
                pid: pid
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('category',pid,res.data.data)
                callback(res.data.data);

            } else {
                var template = [
                    '<h3>Error !</h3/>',
                    '<div>'+res.data.message+'</div>'
                    ];
                $fancyModal.open({
                    template: template.join(''),
                    plain: true,
                    closeByEscape: false,
                    // controller: 'MainController'
                });
            }
        },function(res){
            console.log('GET LIST FAIL:',res)
        })
    }
    return this;
}