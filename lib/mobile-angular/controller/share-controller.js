

app.controller('ShareController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal, 
    $mdDialog,
    API, CategoryService, ProjectService, StorageService, QuestionService
    ) {
    console.log('ShareController',$routeParams);
    
    $scope.cid = $routeParams.categoryId;
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data.info;
        
    })

    $scope.showAlert = function(ev) {
        // Appending dialog to document.body to cover sidenav in docs app
        // Modal dialogs should fully cover application
        // to prevent interaction outside of dialog
        $mdDialog.show(
            $mdDialog.alert()
                // .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('This is an alert title')
                .textContent('You can specify some description text in here.')
                .ariaLabel('Alert Dialog Demo')
                .ok('Got it!')
                .targetEvent(ev)
        );
    };
})