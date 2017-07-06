
app.factory('CategoryService', function(API,StorageService) {
    var CategoryService = this;
    var storage = {}
    var scode;
    this.setScope = function(_scode){
        scope = _scode;
    }
    this.get_by_pid = function(pid,callback){
        var data = StorageService.get('category',pid);
        if(data) 
            callback(data)
        else
        API.request({
            url: BASE_URL + 'api/category/get_by_pid',
            data: {
                pid: pid
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('category',pid,res.data.data)
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
    return CategoryService;
});
app.factory('ProjectService', function(API,StorageService) {
    var ProjectService = this;
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
    return ProjectService;
});
app.controller('ProjectController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, 
    API, CategoryService, ProjectService,StorageService
    ) {
    console.log('ProjectController',$routeParams);
    $scope.go = function(path){
        $location.path( path );
    }
    $scope.getProject = function(){
        API.request({
            url: BASE_URL + 'api/project/get',
            data: {
                id: $routeParams.projectId
            },
        },function(res){
            if(res.data.code == 1){
                $scope.projectData = res.data.data
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
    $scope.pid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data;
    })
    CategoryService.get_by_pid($scope.pid,function(data){
        $scope.listCategory = data;
        $scope.contentHeight = $window.innerHeight - 51 - 41*(data.length||0)
    })
});