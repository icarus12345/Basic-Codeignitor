function Category(opt){
    this.id = opt.id || 0;
    this.title = opt.title || '';
    this.desc = opt.desc || '';
    this.pid = opt.pid || undefined;
    this.count_answered = function(){
        if(this.questions){
            return this.questions
                .reduce(function(sum, q) {
                return sum + (q.answered>0?1:0); 
            }, 0)
        } else if(this.items){
            return this.items.reduce(function(sum, c) {
                return sum + c.count_answered(); 
            }, 0)
        } else {
            return 0;
        }
    }
    this.count_question = function(){
        if(this.questions){
            return this.questions.length;
        } else if(this.items){
            return this.items.reduce(function(sum, c) { 
                return sum + c.count_question();  
            }, 0)
        } else {
            return 0;
        }
    }
    this.process = function(){
        var count_answered = this.count_answered();
        var count_question = this.count_question();
        if(!count_question) return 0;
        return count_answered/count_question;
    }
}
function CategoryFactory(API,StorageService, $fancyModal) {
    var me = this;
    this.get_by_id = function(param,callback){
        var data = StorageService.get('category',param.cid);
        if(data) 
            if(typeof callback == 'function') callback(data)
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
                if(typeof callback == 'function') callback(res.data.data);

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

    this.get_list_category = function(callback){
        var data = StorageService.get('list_category','');
        if(data) {
            me.build(data);
            if(typeof callback == 'function') callback(data)
        }else
        API.request({
            url: BASE_URL + 'api/category/get_list',
            data: {
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('list_category','',res.data.data)
                me.build(res.data.data);
                if(typeof callback == 'function') callback(res.data.data)
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
    this.build = function(data){
        this._categories = {
            0: new Category({})
        };
        var items = data.items;
        var questions = data.questions;
        this.questions = {}
        for(var i = 0; i<items.length;i++){
            this._categories[items[i].id] = new Category(items[i]);
        }
        for(var i = 0; i<questions.length;i++){
            var q = questions[i];
            this.questions[q.id] = q;
            var c = q.category;
            var cat = this._categories[c];
            if(!cat.questions) cat.questions = [];
                cat.questions.push(q);
        }
        for(var c in this._categories){
            var cat = this._categories[c];
            var pcat = this._categories[cat.pid];
            if(pcat){
                cat.parent = pcat;
                if(!pcat.items) pcat.items = [];
                pcat.items.push(cat);
            }
        }
        this.set_answereds(this.answereds);
    }
    this.set_answereds = function (answereds){
        if(answereds) this.answereds = answereds;
        if(this._categories){
            // build

            for(var i = 0;i<this.answereds.length;i++){
                var ans = this.answereds[i];
                var qid = ans.qid;
                this.questions[qid].answered = ans.ans;
                // this.questions[qid].answers[answered].answered = true;
            }
        }
    }
    this._get = function(id,callback){

    }
    this.get = function(id, callback){
        if(!this._categories){
            this.get_list_category(function(){
                var data = me._categories[id];
                if(typeof callback == 'function') callback(data);
            })
        } else {
            var data = this._categories[id];
            if(typeof callback == 'function') callback(data);
        }
    }
    return this;
}