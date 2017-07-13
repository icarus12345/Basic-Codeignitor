

app.controller('ProjectController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService
    ) {
    console.log('ProjectController',$routeParams);
    $scope.view_chart = function(cate){
        $location.path( '/project/' + $scope.projectData.id + '/chart/' + cate.id );
    }
    $scope.go = function(cate){
            console.log(cate)
        if(cate.items && cate.items.length>0){
            $location.path( '/project/' + $scope.projectData.id + '/cat/' + cate.id );
        }else if(cate.questions && cate.questions.length>0){
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
        $scope.projectData = data.info;
        CategoryService.set_answereds(data.answereds);
        // GET ANSWERS
        // SET ANSWERS
        // GET CATEGORY
        CategoryService.get($routeParams.categoryId,function(data){
            $scope.category_info = data;
        })
    })
    
});