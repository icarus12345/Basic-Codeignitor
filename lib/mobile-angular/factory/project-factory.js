function Project(opt){
    this.id = opt.id;
    this.items = [];
}

function ProjectFactory(API,StorageService, StorageService, $fancyModal) {
    this.clear = function(id){
        for(var key in sessionStorage){
            if(key.indexOf('project-'+(id||''))===0){
                delete(sessionStorage[key])
            }
        }
    }
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