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
app.controller('MainController', function(
    $rootScope, $scope, $http, $route, API, Auth, SharedState, $fancyModal, 
    MainService, ProjectService, CategoryService
    ) {
    SharedState.initialize($scope, 'modalAddProject');
    // User agent displayed in home page
    $scope.userAgent = navigator.userAgent;
    // Needed for the loading screen
    // $rootScope.loading = true;
    $scope.$on('$routeChangeStart', function() {
        // $rootScope.loading = true;
    });

    $scope.$on('$routeChangeSuccess', function(event, current, previous) {
        // $rootScope.loading = true;
    });

    $scope.$on('$destroy', function() {
        $rootScope.activedView = undefined;
        // $rootScope.loading = true;
    });
    
    $scope.loadMore = function(){
        if($rootScope.__frontPage!='home') return;
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
        title : '',
        desc: ''
    }
    $scope.onCreateProject = function(){
        console.log($scope.addProjectInfo)
        API.__request({
            url: BASE_URL + 'api/project/create',
            data: $scope.addProjectInfo,
        },function(res){
            if(res.data.code == 1){
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
    $scope.listProject = MainService.listProject;
    $scope.showmenu = function(){
        console.log(event.changedTouches[event.changedTouches.length - 1])
    }

    
    $scope.export_pdf = function(id){
        ProjectService.get(id,function(p){
            CategoryService.set_answereds(p.answereds);
            CategoryService.get(0,function(c){
                console.log(c)
                // setTimeout(function(){
                    CategoryService.export(p.info)
                // },1000)
            })
        })
    }
});