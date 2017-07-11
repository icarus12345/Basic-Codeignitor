

app.controller('QuestionController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService, QuestionService
    ) {
    console.log('QuestionController',$routeParams);
    
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data.info;
        CategoryService.set_answereds(data.answereds);
        // GET ANSWERS
        // SET ANSWERS
        // GET CATEGORY
        CategoryService.get($routeParams.categoryId,function(data){
            $scope.category_info = data;
            console.log(data)
        })
    })
    $scope.answer_the_question = function(quest,ans){
        var ansIndex = quest.answers.indexOf(ans);
        console.log(quest,ans,ansIndex)
        if(quest.answered==ansIndex) return;
        QuestionService.answer_the_question({
            pid: $routeParams.projectId,
            cid: $routeParams.categoryId,
            qid: quest.id,
            ans: ansIndex
        },function(data){
            quest.answered = ansIndex;
            // Clear and reload answered
            // ProjectService.clear($routeParams.projectId)
            CategoryService._categories[0].init();
        })
    }
});