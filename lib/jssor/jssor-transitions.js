var jssorTransitions = function(w,h){
    var maxcols = Math.min(8,Math.floor(Math.max(w,h)/100));
    var cols = maxcols; rows = Math.round(h/(w/maxcols));
    if(rows>maxcols){
        rows = maxcols;
        cols = Math.round(w/(h/maxcols));
    }
    console.log(maxcols,cols,rows)
    return [
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:1.3,$Top:2.5}},
        {$Duration:1500,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.1,0.9],$Top:[0.1,0.9]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.1,0.9],$Top:[0.1,0.9]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseLinear},$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Assembly:260,$Round:{$Left:0.8,$Top:2.5}},
        {$Duration:1200,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:0.8}},
        {$Duration:1200,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump},$Assembly:260,$Outside:true,$Round:{$Left:0.8,$Top:0.8}},
        {$Duration:1200,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseSwing},$Assembly:260,$Round:{$Left:0.8,$Top:0.8}},
        {$Duration:1200,x:0.3,y:-0.3,$Delay:20,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.2,0.8],$Top:[0.2,0.8]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInJump,$Top:$JssorEasing$.$EaseInJump,$Clip:$JssorEasing$.$EaseSwing},$Assembly:260,$Round:{$Left:0.8,$Top:0.8}},
        {$Duration:1800,x:1,$Delay:30,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Clip:$JssorEasing$.$EaseInOutQuad},$Assembly:260,$Outside:true,$Round:{$Top:0.8}},
        {$Duration:1800,x:1,$Delay:30,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Left:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Clip:$JssorEasing$.$EaseInOutQuad},$Assembly:260,$Round:{$Top:0.8}},
        {$Duration:1000,$Delay:30,$Cols:cols,$Rows:rows,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:$JssorEasing$.$EaseOutQuad,$Assembly:2049},
        {$Duration:800,$Delay:300,$Cols:cols,$Rows:rows,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:$JssorEasing$.$EaseOutQuad},
        {$Duration:800,$Delay:300,$Cols:cols,$Rows:rows,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationRectangleCross,$Easing:$JssorEasing$.$EaseOutQuad},
        {$Duration:800,$Delay:200,$Cols:cols,$Rows:rows,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationCircle,$Assembly:2049},
        {$Duration:1200,y:-1,$Cols:cols,$Rows:rows,$Clip:15,$During:{$Top:[0.5,0.5],$Clip:[0,0.5]},$Formation:$JssorSlideshowFormations$.$FormationStraight,$ChessMode:{$Column:12},$ScaleClip:0.5},
        {$Duration:1000,$Delay:30,$Cols:cols,$Rows:rows,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:$JssorEasing$.$EaseInQuad,$Assembly:2050},
        {$Duration:1000,$Cols:3,$Rows:2,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:$JssorEasing$.$EaseInBounce},
        {$Duration:500,$Delay:30,$Cols:cols,$Rows:rows,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Easing:$JssorEasing$.$EaseInQuad},
        {$Duration:800,$Delay:300,$Cols:cols,$Rows:rows,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:$JssorEasing$.$EaseInQuad},
        {$Duration:800,$Delay:300,$Cols:cols,$Rows:rows,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationRectangleCross,$Easing:$JssorEasing$.$EaseInQuad},
        {$Duration:600,x:1,y:-1,$Delay:50,$Cols:cols,$Rows:rows,$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
        {$Duration:600,x:-1,y:1,$Delay:50,$Cols:cols,$Rows:rows,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},

        {$Duration:700,$Opacity:2,$Brother:{$Duration:1000,$Opacity:2}},
        {$Duration:1500,x:0.5,$Cols:2,$ChessMode:{$Column:3},$Easing:{$Left:$JssorEasing$.$EaseInOutCubic},$Opacity:2,$Brother:{$Duration:1500,$Opacity:2}},

















    ];
}