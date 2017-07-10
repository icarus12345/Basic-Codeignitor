

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
        })
    })
    // CategoryService.get_by_id({
    //     cid: $routeParams.categoryId,
    //     pid: $routeParams.projectId,
    // },function(data){
    //     $scope.category_info = data;
    // })

    $scope.labels =["Eating", "Drinking", "Sleeping"];
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
            circular: true,
            gridLines: {
                circular: true,
                fill:true,
                fillColor:'#ff0000',
                drawOnChartArea: true,
                color: "rgba(0, 0, 0, .1)",
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
    $scope.series = ["Series A", "Series B"];
    $scope.data = [
        // [2.5, 3.5, 4.5],
        // [2.5, 3  , 3  ],
        [3.5, 2.5  , 4.5  ],
        [3  , 4  , 5  ],
    ];
});