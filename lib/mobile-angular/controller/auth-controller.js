//
// For this trivial demo we have just a unique AuthController
// for everything
//
app.controller('AuthController', function($rootScope, $scope, API) {
    // User agent displayed in home page
    $scope.userAgent = navigator.userAgent;
    // $rootScope.loading = true;
    // Needed for the loading screen
    $scope.$on('$routeChangeStart', function() {
        console.log('$routeChangeStart')
    });

    $scope.$on('$routeChangeSuccess', function() {
        console.log('$routeChangeSuccess')
    });

    $scope.$on('$destroy', function() {
        console.log('$destroy')
    });
    // $rootScope.loading = true;
    API.request({
        url: BASE_URL + 'api/auth/get_client',
        data: {
            app_id: APP_ID
        },
    },function(res){
        // $rootScope.loading = false;
        console.log('GET CLIENT SUCCESS2:',res)
    },function(res){
        // $rootScope.loading = false;
        console.log('GET CLIENT FAIL2:',res)

    })
});