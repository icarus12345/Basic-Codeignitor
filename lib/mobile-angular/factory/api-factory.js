function APIFactory($rootScope,$http,SharedState, $fancyModal, StorageService) {
    var API = this;
    SharedState.initialize($rootScope, 'IsShowLogin');
    SharedState.initialize($rootScope, 'IsShowRegister');
    // SharedState.turnOn('IsShowRegister');
    // console.log(Auth)
    API.token = StorageService.get('token','');
    $rootScope.loading = $rootScope.loading||0;
    this.getToken = function(callback){
        $rootScope.loading++;
        console.log('++',$rootScope.loading);
        $http({
            url: BASE_URL + 'api/auth/get_token',
            method:'POST',
            data: {
                app_id: APP_ID,
                app_secret: APP_SECRET,
            },
            // withCredentials: true,
            headers: {
                // 'X-CSRF-Token': 'AAABBBCCCDDD',
                'Content-Type': 'application/json',
                // 'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'

            },
            // transformRequest: function(obj) {
            //     var str = [];
            //     for(var p in obj)
            //     str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            //     return str.join("&");
            // },
            
        }).then(function(res){
            console.log(res,'GET TOKEN SUCCESS');
            if(res.data.code == 1 && res.data.data){
                API.token = res.data.data.token;
                if(typeof callback == 'function'){
                    callback();
                }
            }
            $rootScope.loading--;
            console.log('--',$rootScope.loading);
        },function(res){
            console.log(res,'GET TOKEN FAIL');
            var template = [
                '<h3>Error !</h3/>',
                '<div>Stretch and squeeze your browser window to see both mobile and desktop versions.</div>'
                ].join('');
            $fancyModal.open({
                template: template,
                plain: true,
                closeByEscape: false,
                // controller: 'MainController'
            });
            $rootScope.loading--;
            console.log('--',$rootScope.loading);
        });
    }
    function __request(opt,successFun,failFun){
        $rootScope.loading++;
        console.log('++',$rootScope.loading);
        opt.data.app_id = APP_ID;
        $http({
            url: opt.url,
            method:opt.method || 'POST',
            data: opt.data,
            // withCredentials: true,
            headers: {
                'X-CSRF-Token': API.token || '',
                'Content-Type': 'application/json',
                // 'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'

            },
            // transformRequest: function(obj) {
            //     var str = [];
            //     for(var p in obj)
            //     str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            //     return str.join("&");
            // },
            
        }).then(function(res){
            if(res.data.code==-201){
                SharedState.turnOn('IsShowLogin');
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
            }else{
                if(typeof successFun == 'function') successFun(res);
            }
            setTimeout(function(){
                $rootScope.loading--;
                console.log('--',$rootScope.loading);
            }, 500)
        },function(res){
            if(opt.showerror!==false){
                var template = [
                    '<h3>Error !</h3/>',
                    '<div>Server are busy.</div>'
                    ];
                switch(res.status){
                    case 404:
                        template[1] = '404 Page Not Found.';
                        break;
                    case 403:
                        template[1] = '403 Permission denied.';
                        break;
                    case 500:
                        template[1] = '500 (Internal Server Error).';
                        break;
                }
                $fancyModal.open({
                    template: template.join(''),
                    plain: true,
                    closeByEscape: false,
                    // controller: 'MainController'
                });
            }
            if(typeof failFun == 'function') failFun(res);
            setTimeout(function(){
                $rootScope.loading--;
                console.log('--',$rootScope.loading);
            }, 500)
        });
    }
    this.__request = __request;
    this.__queue = [];
    this.runQueue = function(){
        console.log('CALL QUEUE')
        for(var i = 0; i<this.__queue.length;i++){
            __request(this.__queue[i].opt,this.__queue[i].successFun,this.__queue[i].failFun);
        }
        this.__queue = [];
    }
    this.request = function(opt,successFun,failFun){
        if(API.token){
            __request(opt,successFun,failFun);
        } else {
            // getToken
            // API.getToken(function(){
                // __request(opt,successFun,failFun);
            // })
            API.__queue.push({
                opt:opt,
                successFun:successFun,
                failFun:failFun,
            })
        }
    }
    console.log('APIFactory')
    $rootScope.API = API;
    return API;
}