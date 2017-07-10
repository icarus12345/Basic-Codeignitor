

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
            $scope.category_info = data;
            var chartData = [];
            for(var i in data.items){
                var sum = data.items[i].sum_score();
                var num = data.items[i].count_answered();
                var score = 0;
                if(num>0) score = sum/num;
                chartData.push(score)
            }
            $scope.data = [[3.5,3.5,2.7],chartData,];
        })
    })
    // CategoryService.get_by_id({
    //     cid: $routeParams.categoryId,
    //     pid: $routeParams.projectId,
    // },function(data){
    //     $scope.category_info = data;
    // })

    $scope.labels =["", "", ""];
    $scope.chartColors = [ '#99cc33', '#117bc0', '#f7464a', '#ff7f0e', '#2ca02c', '#949FB1', '#FFD600'];
    $scope.chartOptions = {
        animation: false,
        backgroundColor: '',
        fill:false,
        line:{lineTension:0},
        startAngle: 0,
        legend:{
           display: true
        },  
        scale: {
            gridLines: {
                display:false,
                circular: true,
                // fill:true,
                // fillColor:'#ff0000',
                drawOnChartArea: false,
                color: "rgba(0, 0, 0, 0)",
            },  
            
            scaleLabel:{
                display:false
            },
            type: 'radialLinear',
            ticks: {
                display: false,
                stepSize: 1,
                maxTicksLimit: 5,
                suggestedMax:5,
                // suggestedMin:0,
                max:5,
                beginAtZero: true
            }
        }
    };
    $scope.series = ["Global", "Goal"];
    
});