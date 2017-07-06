

app.controller('QuestionController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService, QuestionService
    ) {
    console.log('QuestionController',$routeParams);
    
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data;
    })
    QuestionService.get_by_cid($scope.cid,function(data){
        $scope.listQuestion = data;
    })
    $scope.answer_the_question = function(quest,ans){
        console.log(quest,ans)
        for(var i =0;i<quest.data.answers.length;i++){
            quest.data.answers[i].selected = false;
        }
        ans.selected = true;
    }
});