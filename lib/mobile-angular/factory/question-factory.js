function QuestionFactory(API,StorageService) {
    this.get_by_cid = function(param,callback){
        var data = StorageService.get('question',param.pid+'-'+param.cid);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/question/get_by_cid',
            data: {
                cid: param.cid,
                pid: param.pid,
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('question',param.pid+'-'+param.cid,res.data.data)
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
            console.log('FAIL:',res)
        })
    }
    this.answer_the_question = function(param,callback){
        
        API.request({
            url: BASE_URL + 'api/question/answer_the_question',
            data: param,
        },function(res){
            if(res.data.code == 1){
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
            console.log('FAIL:',res)
        })
    }
    return this;
}