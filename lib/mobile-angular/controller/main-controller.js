//
// For this trivial demo we have just a unique MainController
// for everything
//
app.controller('MainController', function($rootScope, $scope, $http, API, Auth) {
    // User agent displayed in home page
    $scope.userAgent = navigator.userAgent;
    // Needed for the loading screen
    // $rootScope.loading = true;
    $scope.$on('$routeChangeStart', function() {
        // $rootScope.loading = true;
        console.log('$routeChangeStart')
    });

    $scope.$on('$routeChangeSuccess', function() {
        // $rootScope.loading = true;
        console.log('$routeChangeSuccess')
    });

    $scope.$on('$destroy', function() {
        console.log('$destroy')
        // $rootScope.loading = true;
    });
    API.request({
        url: BASE_URL + 'api/auth/get_client',
        data: {
        },
    },function(res){
        console.log('GET CLIENT SUCCESS:',res)
    },function(res){
        console.log('GET CLIENT FAIL:',res)

    })
});