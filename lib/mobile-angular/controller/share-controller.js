

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
    $scope.share_info = {
        pid: $routeParams.projectId,
        email: '',
        mode: 0
    }
    $scope.doShare = function(ev) {
        API.request({
            url: BASE_URL + 'api/project/share',
            data: $scope.share_info,
        },function(res){
            if(res.data.code == 1){
                
            } else {
                $mdDialog.show(
                    $mdDialog.alert()
                        // .parent(angular.element(document.querySelector('#popupContainer')))
                        .clickOutsideToClose(true)
                        .title('Error !')
                        .textContent(res.data.message)
                        .ariaLabel('Alert Dialog')
                        .ok('OK')
                        .targetEvent(ev)
                );
            }
        },function(res){
            $mdDialog.show(
                $mdDialog.alert()
                    // .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('Error !')
                    .textContent('Can\'t share.')
                    .ariaLabel('Alert Dialog')
                    .ok('OK')
                    .targetEvent(ev)
            );
        })
        
    };
})