//
// For this trivial demo we have just a unique AuthController
// for everything
//
app.controller('AuthController', function($rootScope, $scope) {
    // User agent displayed in home page
    $scope.userAgent = navigator.userAgent;

    // Needed for the loading screen
    $scope.$on('$routeChangeStart', function() {
        $scope.loading = true;
        console.log('$routeChangeStart')
    });

    $scope.$on('$routeChangeSuccess', function() {
        $scope.loading = false;
        console.log('$routeChangeSuccess')
    });

    $scope.$on('$destroy', function() {
        console.log('$destroy')
        $scope.loading = false;
    });
});