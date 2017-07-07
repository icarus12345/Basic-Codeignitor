

app.controller('QuestionController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService, QuestionService
    ) {
    console.log('QuestionController',$routeParams);
    
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data;
    })
    QuestionService.get_by_cid({
        pid: $routeParams.projectId,
        cid: $routeParams.categoryId,
    }, function(data){
        $scope.question_info = data;
    })
    $scope.answer_the_question = function(quest,ans){
        var ansIndex = quest.answers.indexOf(ans);
        QuestionService.answer_the_question({
            pid: $routeParams.projectId,
            cid: $routeParams.categoryId,
            qid: quest.id,
            ans: ansIndex
        },function(data){
            for(var i =0;i<quest.answers.length;i++){
                quest.answers[i].selected = false;
            }
            ans.selected = true;
            StorageService.set('question',$routeParams.projectId+'-'+$routeParams.categoryId, $scope.question_info);
            CategoryService.clear_category();
        })
    }
});