var jssorHomeSliderInit = function() {
    if($('#home-jssor').length==0)return;
    var strHtml = $('#home-jssor').html()
    var jssorSlider,StartIndex = 0;
    var captionTransitions = {};
    captionTransitions["O"] = [{b:100,d:1,o:.5}];
    captionTransitions["T100"] = [{b:-1,d:1,y:0,x:0,o:-1},{b:1,d:300,x:0,y:100,o:1}];
    captionTransitions["LR720"] = [{b:-1,d:1,y:0,x:0,o:-1,e:{o:0}},{b:400,d:400,y:0,x:720,o:1}];
    captionTransitions["B400"] = [{b:-1,d:1,y:0,x:0,o:-1},{b:800,d:300,y:-400,x:0,o:1}];
    function init(){
        var w = $(window).width();
        var h = $(window).height();
        if(jssorSlider){
            StartIndex = jssorSlider.$CurrentIndex();
        }
        $('#home-jssor').html(strHtml);
        $('.home-jssor,.home-jssor [data-u="slides"]').css({
            width: w,
            height: h,
        })
        var homeJssorOptions = {
            $StartIndex: StartIndex<0?0:StartIndex,
            $AutoPlay: true,
            $SlideDuration: 1000,
            $SlideEasing: $Jease$.$OutQuint,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                $SpacingX: 10,                                  //[Optional] Horizontal space between each item in pixel, default value is 0
                $SpacingY: 10,                                  //[Optional] Vertical space between each item in pixel, default value is 0
                $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
            },

            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssorTransitions(w,h),
                $TransitionsOrder: 0,
                $ShowLink: true
            },
            $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $CaptionTransitions: captionTransitions,
                $PlayInMode: 1,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
                // $Breaks: [
                //     [{d:2000,b:4000}],
                //     [{d:5000,b:5000}],
                //     [{d:2000,b:21000}],
                //     [{d:10000,b:5000}]
                // ],
                // $Controls: [{r:0},{r:0},{r:0},{r:20},{r:20},{r:20},{r:20},{r:100},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100,e:2400},{r:100}]
            },

        };

        jssorSlider = new $JssorSlider$("home-jssor", homeJssorOptions);
        
    }
    // init();
    /*responsive code begin*/
    /*you can remove responsive code if you don't want the slider scales while window resizing*/
    function ScaleSlider() {
        init();
    //     var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
    //     if (refSize) {
    //         refSize = Math.min(refSize, 1920);
    //         jssor_1_slider.$ScaleWidth(refSize);
    //     }
    //     else {
    //         window.setTimeout(ScaleSlider, 30);
    //     }
    }
    ScaleSlider();
    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
    /*responsive code end*/

};