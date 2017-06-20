//
// For this trivial demo we have just a unique MainController
// for everything
//
app.factory('MainService', function() {
    var MainService = this;
    this.page = 1;
    this.perpage = 15;
    this.isLoadMore = true;
    return MainService;
});
app.controller('MainController', function($rootScope, $scope, $http, API, Auth, SharedState, $fancyModal, MainService) {
    SharedState.initialize($scope, 'modalAddProject');
    // User agent displayed in home page
    $scope.userAgent = navigator.userAgent;
    // Needed for the loading screen
    // $rootScope.loading = true;
    $scope.$on('$routeChangeStart', function() {
        // $rootScope.loading = true;
        console.log('$routeChangeStart')
    });

    $scope.$on('$routeChangeSuccess', function() {
        // $rootScope.loading = true;
        console.log('$routeChangeSuccess')
    });

    $scope.$on('$destroy', function() {
        console.log('$destroy')
        // $rootScope.loading = true;
    });
    
    $scope.loadMore = function(){
        if(!MainService.isLoadMore) return;
        MainService.page++;
        $scope.getList();
    }
    $scope.getList = function(){
        API.request({
            url: BASE_URL + 'api/project/gets',
            data: {
                page: MainService.page,
                perpage: MainService.perpage
            },
        },function(res){
            if(res.data.code == 1){
                console.log('GET LIST SUCCESS:',res)
                for(var i in res.data.data){
                    MainService.listProject.push(res.data.data[i])
                }
                if(!res.data.data || res.data.data.length==0){
                    MainService.isLoadMore = false;
                }
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
    
    $scope.addProjectInfo = {
        title : ''
    }
    $scope.onCreateProject = function(){
        console.log($scope.addProjectInfo)
        API.__request({
            url: BASE_URL + 'api/project/create',
            data: $scope.addProjectInfo,
        },function(res){
            if(res.data.code == 1){
                console.log('Create Project Success:',res)
                SharedState.turnOff('modalAddProject');
                $scope.addProjectInfo.title='';
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
            console.log('Create Project Fail:',res)
        });
    }

    MainService.listProject = MainService.listProject || $scope.getList() || [];
    $scope.listProject = MainService.listProject
});