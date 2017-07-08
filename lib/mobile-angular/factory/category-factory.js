function CategoryFactory(API,StorageService) {
    var scode;
    this.setScope = function(_scode){
        scope = _scode;
    }
    this.get_by_id = function(param,callback){
        var data = StorageService.get('category',param.cid);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/category/get_by_id',
            data: {
                id: param.cid,
                pid: param.pid,
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('category',param.cid,res.data.data)
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
    this.clear_category = function(){
        for(var key in sessionStorage){
            if(key.indexOf('category')===0){
                delete(sessionStorage[key])
            }
        }
    }
    return this;
}