function AuthFactory($rootScope, $http, SharedState, $fancyModal, API) {
    var Auth = this;
    $rootScope.AppData = $rootScope.AppData || {};
    this.UserInfo = undefined;
    (function getUserInfo(){
        API.__request({
            url: BASE_URL + 'api/auth/get_user_info',
            data: {
            },
            showerror: false
        },function(res){
            console.log('GET USERINFO SUCCESS:',res)
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
            }else if(res.data.code==1 && res.data.data){
                Auth.UserInfo = res.data.data.user_info;
                API.token = res.data.data.token;
                APP_ID = res.data.data.app_id;
                API.runQueue();
            } else {
                SharedState.turnOn('IsShowLogin');
            }
        },function(res){
            console.log('GET USERINFO FAIL:',res)
            SharedState.turnOn('IsShowLogin');
        });
        
    }())
    $rootScope.doAuthRegister = function(){
        console.log($rootScope.auth_reg_info)
        API.__request({
            url: BASE_URL + 'api/auth/register',
            data: $rootScope.auth_reg_info,
        },function(res){
            if(res.data.code == 1){
                console.log('Register Success:',res)
                SharedState.turnOff('IsShowRegister');
                SharedState.turnOn('IsShowLogin');
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
            console.log('Register Fail:',res)
        });
    }
    $rootScope.doAuthLogin = function(){
        console.log($rootScope.auth_singin_info)
        API.__request({
            url: BASE_URL + 'api/auth/login',
            data: $rootScope.auth_singin_info,
        },function(res){
            if(res.data.code == 1){
                console.log('Login Success:',res);
                Auth.UserInfo = res.data.data.user_info;
                API.token = res.data.data.token;
                APP_ID = res.data.data.app_id;
                SharedState.turnOff('IsShowLogin');
                API.runQueue();
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
            console.log('Login Fail:',res)
        });
    }
    $rootScope.auth_singin_info = {
        username:'',
        password:'',

    }
    $rootScope.auth_reg_info = {
        email:'',
        username:'',
        password:'',
        confirm_password:'',
        first_name:'',
        last_name:'',

    }
    console.log('AuthFactory')
    $rootScope.Auth = Auth;
    return Auth;
}
