

app.controller('ChartController', function(
    $rootScope, $scope, $route, $routeParams, $window, $location, $fancyModal,
    API, CategoryService, ProjectService, StorageService
    ) {
    console.log('ChartController',$routeParams);
    
    ProjectService.get($routeParams.projectId,function(data){
        $scope.projectData = data.info;
        CategoryService.set_answereds(data.answereds);
        // GET ANSWERS
        // SET ANSWERS
        // GET CATEGORY
        CategoryService.get($routeParams.categoryId,function(data){
            console.log(data,'data')
            $scope.category_info = data;
            $scope.chart_data = data.chart_data;
        })
    })

    $scope.series = ["Global", "Goal"];
    $scope.$on('chart-create', function (event, chart) {
        $scope.chartLegend = chart.generateLegend();
    });
    $scope.check_open_comment = function(cat,i){
        if(cat._actived_comment==undefined) cat._actived_comment = [true];
        if(cat._actived_comment[i]==undefined) cat._actived_comment[i] = false;
        return cat._actived_comment[i];
    }
    $scope.toggle_comment = function(cat,i){
        console.log('toggle_comment',cat,i)
        if(cat._actived_comment==undefined) cat._actived_comment = [true];
        if(cat._actived_comment[i]==undefined) cat._actived_comment[i] = false;
        cat._actived_comment[i] = !cat._actived_comment[i];
    }
});