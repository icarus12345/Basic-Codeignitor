

app.controller('ShareController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService, QuestionService
    ) {
    console.log('ShareController',$routeParams);
    
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data.info;
        
    })
})