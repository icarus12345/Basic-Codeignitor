var jssorTabSliderInit = function() {
    if($('#tab-jssor').length==0)return;
    var strHtml = $('#tab-jssor').html()
    var jssorSlider,StartIndex = 0;
    var captionTransitions = {};
    captionTransitions["O"] = [{b:100,d:1,o:.5}];
    captionTransitions["T100"] = [{b:-1,d:1,y:0,x:0,o:-1},{b:1,d:300,x:0,y:100,o:1}];
    captionTransitions["LR720"] = [{b:-1,d:1,y:0,x:0,o:-1,e:{o:0}},{b:400,d:400,y:0,x:720,o:1}];
    captionTransitions["B400"] = [{b:-1,d:1,y:0,x:0,o:-1},{b:800,d:300,y:-400,x:0,o:1}];
    var SwipeStartEventHandler = function(index){
        console.log('SwipeStartEventHandler',index)
    }
    var SwipeEndEventHandler = function(index,a,b,c){
        if (Math.floor(index) == index) {
            // console.log(jssorSlider)
            // $("img.lazy").lazyload({
            //    load: function() {
            //        $(this).removeClass('lazy');
            //        $(this.parentNode).nailthumb();
            //    }
            // });
        }
    }
    var ParkEventHandler = function(index){
        console.log('ParkEventHandler',index)
        $('.staff-box>.info>div').removeClass('actived');
        $('.staff-box>.info>div:eq('+index+')').addClass('actived');
    }
    var SlideEndEventHandler = function(index){
        console.log('SlideEndEventHandler', index)
    }
    var StateChangeEventHandler = function(index){
        console.log('StateChangeEventHandler', index)
    }
    function init(){
        var w = 1920;
        var h = w/2;//$(window).height();
        if(jssorSlider){
            StartIndex = jssorSlider.$CurrentIndex();
        }
        $('#tab-jssor').html(strHtml)
            .css({
                width: w/2,
                height: w/4,
            })
        $('#tab-jssor .slider-content,#tab-jssor .slider-content>div').css({
            width: w/2,
            height: w/4,
        })
        var thumbWidth = (w/2-40)/3;
        var thumbHeight = thumbWidth/2;
        console.log(thumbWidth,'thumbWidth')
        console.log(thumbHeight,'thumbHeight')
        thumbWidth = 280;
        thumbHeight = 140;
        // $('#tab-jssor .thumb-image').css({
        //     width: thumbWidth,
        //     height: thumbWidth/2,
        // })
        // $('#tab-jssor div[data-u="thumbnavigator"]').css({
        //     width: w/2,
        //     height: thumbHeight,
        // })
        
        var tabJssorOptions = {
            $StartIndex: StartIndex<0?0:StartIndex,
            $AutoPlay: false,
            $SlideDuration: 1000,
            $Idle: 5000,
            $LazyLoading: true,
            $SlideEasing: $Jease$.$OutQuint,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssorTransitions(w,h),
                $TransitionsOrder: 0,
                $ShowLink: true
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            },
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 3,
                $SpacingX: 20,
                $Align: thumbWidth + 20,
                $AutoCenter: 1,
                $Orientation: 1
            }

        };

        jssorSlider = new $JssorSlider$("tab-jssor", tabJssorOptions);
        // jssorSlider.$On($JssorSlider$.$EVT_SWIPE_START, SwipeStartEventHandler);
        jssorSlider.$On($JssorSlider$.$EVT_SWIPE_END, SwipeEndEventHandler);
        jssorSlider.$On($JssorSlider$.$EVT_PARK, ParkEventHandler);
        // jssorSlider.$On($JssorSlider$.$EVT_SLIDESHOW_END, SlideEndEventHandler);
        // jssorSlider.$On($JssorSlider$.$EVT_STATE_CHANGE, StateChangeEventHandler);
    }
    // init();
    /*responsive code begin*/
    /*you can remove responsive code if you don't want the slider scales while window resizing*/
        init();
    function ScaleSlider() {
        var refSize = jssorSlider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 1920);
            jssorSlider.$ScaleWidth(refSize);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    ScaleSlider();
    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
    /*responsive code end*/

};