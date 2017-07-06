function QuestionFactory(API,StorageService) {
    this.get_by_cid = function(cid,callback){
        var data = StorageService.get('question',cid);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/question/get_by_cid',
            data: {
                cid: cid
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('question',cid,res.data.data)
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