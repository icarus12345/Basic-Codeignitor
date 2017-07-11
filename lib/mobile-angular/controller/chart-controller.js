

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
            console.log(data,'^^^^')
            $scope.chart_data = data.chart_data;
            // var chartData = [];
            // var globalData = [];
            // for(var i in data.items){
            //     var sum = data.items[i].sum_score();
            //     var sum_global = data.items[i].sum_global_score();
            //     var num_global = data.items[i].count_question();
            //     var num = data.items[i].count_answered();
            //     var global_score = 0;
            //     var score = 0;
            //     if(num>0) score = sum/num;
            //     if(num_global>0) global_score = sum_global/num_global;
            //     chartData.push(score)
            //     globalData.push(global_score)
            // }
            // $scope.data = [globalData,chartData];
        })
    })
    // CategoryService.get_by_id({
    //     cid: $routeParams.categoryId,
    //     pid: $routeParams.projectId,
    // },function(data){
    //     $scope.category_info = data;
    // })

    $scope.chartColors = [ '#99cc33', '#117bc0', '#f7464a', '#ff7f0e', '#2ca02c', '#949FB1', '#FFD600'];
    $scope.chartOptions = {
        layout: {
            padding: {
                left: 10,
                right: 10,
                top: 10,
                bottom: 10
            }
        },
        animation: false,
        backgroundColor: '',
        fill:false,
        line:{
            lineTension:0
        },
        startAngle: 0,
        legend:{
            display: false,
            fullWidth: true,
            position:'top',
            labels:{
                align: 'start',
                // generateLabels: function(chart){
                //     chart.legend.afterFit = function () {
                //       var width = this.width; // guess you can play with this value to achieve needed layout
                //       this.lineWidths = this.lineWidths.map(function(){return width;});

                //     };
                // }
            }
        },  
        scale: {
            pointLabels:{
                display:true,
                // fontColor: '#000000',
                fontSize: 12
            },
            gridLines: {
                display:true,
                circular: true,
                fill:true,
                fillColor:[
                    "rgba(0, 0, 0, 0)",
                    "rgba(0, 0, 0, 0)",
                    '#FFF',
                    '#DDD',
                    '#BBB',
                    ],
                drawOnChartArea: true,
                color: [
                    "rgba(0, 0, 0, 0)",
                    "rgba(0, 0, 0, 0)",
                    "rgba(0, 0, 0, .1)",
                    "rgba(0, 0, 0, .1)",
                    "rgba(0, 0, 0, .1)",
                    ],
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
    $scope.$on('chart-create', function (event, chart) {
        $scope.chartLegend = chart.generateLegend();
    });
});