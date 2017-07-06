function ProjectFactory(API,StorageService) {
    this.get = function(id,callback){
        var data = StorageService.get('project',id);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/project/get',
            data: {
                id: id
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('project',id,res.data.data)
                callback(res.data.data)
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
    this.gets = function(callback){

    }
    return this;
}