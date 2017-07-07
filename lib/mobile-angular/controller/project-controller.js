

app.controller('ProjectController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService
    ) {
    console.log('ProjectController',$routeParams);
    $scope.go = function(cate){
            console.log(cate)
        if(+cate.child_num>0){
            $location.path( '/project/' + $scope.projectData.id + '/cat/' + cate.id );
        }else if(+cate.quest_num>0){
            $location.path( '/project/' + $scope.projectData.id + '/quest/' + cate.id );
        }else{
            var template = [
                '<h3>Warning !</h3/>',
                '<div>Don\'t have questions to display.</div>'
                ].join('');
            $fancyModal.open({
                template: template,
                plain: true,
                closeByEscape: false,
                // controller: 'MainController'
            });
        }
    }
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data;
    })
    CategoryService.get_by_id({
        cid: $routeParams.categoryId,
        pid: $routeParams.projectId,
    },function(data){
        $scope.category_info = data;
    })
});