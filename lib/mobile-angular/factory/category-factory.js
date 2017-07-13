function Category(opt){
    var me = this;
    this.id = opt.id || 0;
    this.title = opt.title || '';
    this.desc = opt.desc || '';
    this.lower = opt.lower || '';
    this.medium = opt.medium || '';
    this.higher = opt.higher || '';
    this.pid = opt.pid || undefined;
    var arrayColors = [
        "153, 204, 51",
        "17, 123, 192",
        "247, 70, 74",
        "255, 127, 14",
        "44, 160, 44",
        "148, 159, 177",
        "255, 214, 0"
    ];
    var colors = [ '#99cc33', '#117bc0', '#f7464a', '#ff7f0e', '#2ca02c', '#949FB1', '#FFD600'];
    var chart_options = {
        layout: {
            padding: {
                left: 14,
                right: 14,
                top: 14,
                bottom: 14
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
                circular: true,
                backgroundColor: '#BBB',
                borderColor: '#AAA',
                fontColor: '#333',
                radius: 12,
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
    this.toggle_serie = function (i){
        console.log('Toggle')
        if(this.chart_info.dataset_override[i].display!== false){
            this.chart_info.dataset_override[i].display= false;

            this.chart_info.dataset_override[i].backgroundColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].borderColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].fillColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].strokeColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].pointColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].pointHighlightStroke = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].pointBorderColor = 'rgba(0,0,0,0)';
            this.chart_info.dataset_override[i].pointBackgroundColor = 'rgba(0,0,0,0)';
        } else {
            this.chart_info.dataset_override[i].display= true;
            delete(this.chart_info.dataset_override[i].backgroundColor)
            delete(this.chart_info.dataset_override[i].borderColor)
            delete(this.chart_info.dataset_override[i].fillColor)
            delete(this.chart_info.dataset_override[i].strokeColor)
            delete(this.chart_info.dataset_override[i].pointColor)
            delete(this.chart_info.dataset_override[i].pointHighlightStroke)
            delete(this.chart_info.dataset_override[i].pointBorderColor)
            delete(this.chart_info.dataset_override[i].pointBackgroundColor)
        }
        // if(this.chart_info.colors[i] == colors[i]){
        //     this.chart_info.colors[i] = 'rgba(0,0,0,0)';
        // } else {
        //     this.chart_info.colors[i] = colors[i]
        // }
    }
    this.init = function(){
        this.score = 0;
        this.sum_score=0;
        this.sum_global_score=0;
        this.count_question=0;
        this.count_answered=0;
        this.process=0;
        this.level = this.level||0;
        if(this.questions){
            // Count Questions
            this.count_question = this.questions.length;

            // Count Answereds
            this.count_answered = this.questions
                .reduce(function(sum, q) {
                return sum + (q.answered>=0?1:0); 
            }, 0);

            // Sum Score
            this.sum_score = this.questions
                .reduce(function(sum, q) {
                    var score = 0;
                    q.comment = 'You have not completed this section';
                    if(q.answered == 0){
                        score = 2.5;
                        q.comment = q.lower || 'No data to display';
                    }
                    if(q.answered == 1){
                        score = 3.5;
                        q.comment = q.medium || 'No data to display';
                    }
                    if(q.answered == 2){
                        score = 4.5;
                        q.comment = q.higher || 'No data to display';
                    }
                return sum + score; 
            }, 0);

            // Sum Score
            this.sum_global_score = this.questions
                .reduce(function(sum, q) {
                    var score = 0;
                    if(q.global == 0) score = 2.5;
                    if(q.global == 1) score = 3.5;
                    if(q.global == 2) score = 4.5;
                return sum + score; 
            }, 0)
            if(this.count_answered>0)
                this.score = this.sum_score/this.count_answered;
            if(this.count_question>0)
                this.global_score = this.sum_global_score/this.count_question;
            // Chart Data
            var _goalData = [];
            var _globalData = [];
            var _labels = [];
            for(var i in this.questions){
                var q = this.questions[i];
                var score = 0;
                if(q.answered == 0) score = 2.5;
                if(q.answered == 1) score = 3.5;
                if(q.answered == 2) score = 4.5;
                var global_score = 3;
                if(q.global == 0) global_score = 2.5;
                if(q.global == 1) global_score = 3.5;
                if(q.global == 2) global_score = 4.5;
                _labels.push(+i+1);
                _goalData.push(score);
                _globalData.push(global_score);
            }
            this.chart_info = {
                options: chart_options,
                colors : colors,
                labels: _labels,
                data:[_globalData,_goalData],
                dataset_override:[
                    {
                    },
                    {
                    }
                ]
            };
        }else if(this.items){
            // Build Data
            for(var c in this.items){
                this.items[c].level = this.level+1;
                this.items[c].init();
            }

            // Count Questions
            this.count_question = this.items.reduce(function(sum, c) { 
                return sum + c.count_question;  
            }, 0);

            // Count Answereds
            this.count_answered = this.items.reduce(function(sum, c) {
                return sum + c.count_answered; 
            }, 0);

            // Sum Score
            this.sum_score = this.items.reduce(function(sum, c) {
                return sum + c.sum_score; 
            }, 0);

            // Sum Score
            this.sum_global_score = this.items.reduce(function(sum, c) {
                return sum + c.sum_global_score; 
            }, 0);

            if(this.count_answered>0)
                this.score = this.sum_score/this.count_answered;
            if(this.count_question>0)
                this.global_score = this.sum_global_score/this.count_question;
            this.comment = 'You have not completed this section';
            if(this.score < 2.5){
                this.comment = this.lower || 'No data to display';
            } else if(this.score < 3.5){
                this.comment = this.medium || 'No data to display';
            } else {
                this.comment = this.higher || 'No data to display';
            }
            // Chart Data
            var items = this.items;
            var _goalData = [];
            var _globalData = [];
            var _labels = [];
            for(var i in items){
                _labels.push(+i+1);
                _goalData.push(items[i].score);
                _globalData.push(items[i].global_score);
            }
            this.chart_info = {
                options: chart_options,
                colors : colors,
                labels: _labels,
                data:[_globalData,_goalData],
                dataset_override:[
                    {
                    },
                    {
                    }
                ]
            };
        }else{
            var _goalData = [];
            var _globalData = [];
            var _labels = [];
            this.chart_info = {
                options: chart_options,
                colors : colors,
                labels: _labels,
                data:[_globalData,_goalData],
                dataset_override:[
                    {
                    },
                    {
                    }
                ]
            };
        }
        // Process bar
        if(this.count_question>0){
            this.process = this.count_answered/this.count_question;
        }
    }
    this._get_image = function(){
        var datasets = [];
        for(var i in this.chart_info.data){
            var rgb = arrayColors[i];
            datasets.push({
                'label': '',
                'data': this.chart_info.data[i],
                // 'fill': "false",
                // 'backgroundColor': "rgba(0,0,0,0)",
                'borderColor': "rgba(" + rgb + ",1)",
                'pointBackgroundColor': "rgba(" + rgb + ",1)",
                'pointHoverBackgroundColor': "rgba(" + rgb + ",0.8)",
                'pointBorderColor': "#fff",
                'pointHoverBorderColor': "rgba(" + rgb + ",1)",
            })
        }
        var config = {
            type: 'radar',
            data: {
                labels: this.chart_info.labels,
                datasets: datasets
            },
            options: chart_options
        };
        var div = document.createElement('div');
        div.style.position='absolute';
        div.style.width='100%';
        document.body.appendChild(div)
        var canvas = document.createElement('canvas');
        div.appendChild(canvas)
        var radachart = new Chart(canvas, config);
        var url = canvas.toDataURL();
        document.body.removeChild(div);
        return url;
    }
    this._get_info = function(){
        var items;
        if(this.items){
            items = this.items.map(function(c){
                return {
                    title: c.title,
                    comment: c.comment,
                    score: c.score,
                }
            })
        }else if(this.questions){
            items = this.questions.map(function(q){
                return {
                    title: q.title,
                    comment: q.comment,
                    score: q.score,
                }
            })
        }
        return {
            level: this.level,
            title: this.title,
            desc: this.desc,
            comment: this.comment,
            score: this.score,
            image: this._get_image(),
            items: items
        }
    }
    this.get_infos = function(){
        var data = [];
        data.push(this._get_info());
        if(this.items){
            this.items.map(function(c){
                var sdata = c.get_infos();
                for(var i in sdata){
                    data.push(sdata[i]);
                }
            })
        }
        return data;
    }
}
function CategoryFactory(API,StorageService, $fancyModal) {
    var me = this;
    this.get_by_id = function(param,callback){
        var data = StorageService.get('category',param.cid);
        if(data) 
            if(typeof callback == 'function') callback(data)
        else
        API.request({
            url: BASE_URL + 'api/category/get_by_id',
            data: {
                id: param.cid,
                pid: param.pid,
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('category',param.cid,res.data.data)
                if(typeof callback == 'function') callback(res.data.data);

            } else {
                var template = [
                    '<h3>Error !</h3/>',
                    '<div>'+res.data.message+'</div>'
                    ];
                $fancyModal.open({
                    template: template.join(''),
                    plain: true,
                    closeByEscape: false,
                    // controller: 'MainController'
                });
            }
        },function(res){
            console.log('GET LIST FAIL:',res)
        })
    }
    this.clear_category = function(){
        for(var key in sessionStorage){
            if(key.indexOf('category')===0){
                delete(sessionStorage[key])
            }
        }
    }

    this.get_list_category = function(callback){
        var data = StorageService.get('list_category','');
        if(data) {
            me.build(data);
            if(typeof callback == 'function') callback(data)
        }else
        API.request({
            url: BASE_URL + 'api/category/get_list',
            data: {
            },
        },function(res){
            if(res.data.code == 1){
                StorageService.set('list_category','',res.data.data)
                me.build(res.data.data);
                if(typeof callback == 'function') callback(res.data.data)
            } else {
                var template = [
                    '<h3>Error !</h3/>',
                    '<div>'+res.data.message+'</div>'
                    ];
                $fancyModal.open({
                    template: template.join(''),
                    plain: true,
                    closeByEscape: false,
                    // controller: 'MainController'
                });
            }
        },function(res){
            console.log('GET LIST FAIL:',res)
        })
    }
    this.build = function(data){
        this._categories = {
            0: new Category({})
        };
        var items = data.items;
        var questions = data.questions;
        this.questions = {}
        for(var i = 0; i<items.length;i++){
            this._categories[items[i].id] = new Category(items[i]);
        }
        for(var i = 0; i<questions.length;i++){
            var q = questions[i];
            this.questions[q.id] = q;
            var c = q.category;
            var cat = this._categories[c];
            if(!cat.questions) cat.questions = [];
                cat.questions.push(q);
        }
        for(var c in this._categories){
            var cat = this._categories[c];
            var pcat = this._categories[cat.pid];
            if(pcat){
                cat.parent = pcat;
                if(!pcat.items) pcat.items = [];
                pcat.items.push(cat);
            }
        }
        this.set_answereds(this.answereds);
        this._categories[0].init();
    }
    this.clear_answered = function(){
        for(var q in this.questions){
            delete this.questions[q].answered;
        }
    }
    this.set_answereds = function (answereds){
        if(answereds) this.answereds = answereds;
        if(this._categories){
            // build
            this.clear_answered();
            for(var i = 0;i<this.answereds.length;i++){
                var ans = this.answereds[i];
                var qid = ans.qid;
                this.questions[qid].answered = ans.ans;
                // this.questions[qid].answers[answered].answered = true;
            }
        }
    }
    this._get = function(id,callback){

    }
    this.get = function(id, callback){
        if(!this._categories){
            this.get_list_category(function(){
                var data = me._categories[id];
                if(typeof callback == 'function') callback(data);
            })
        } else {
            var data = this._categories[id];
            if(typeof callback == 'function') callback(data);
        }
    }
    this.export = function(p){
        var items = this._categories[0].get_infos()
        if(items.length>0){
            items[0].title = p.title;
            items[0].desc = p.desc;
        }
        API.request({
            url: BASE_URL + 'api/project/export',
            data: {
                info: p,
                items: items
            },
        },function(res){
            if(res.data.code == 1){
                
            } else {
                var template = [
                    '<h3>Error !</h3/>',
                    '<div>'+res.data.message+'</div>'
                    ];
                $fancyModal.open({
                    template: template.join(''),
                    plain: true,
                    closeByEscape: false,
                    // controller: 'MainController'
                });
            }
        },function(res){
            console.log('Export FAIL:',res)
        })
    }
    return this;
}