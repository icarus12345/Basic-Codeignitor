<?php
session_start();
error_reporting(1);
/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */

if (isset($_POST['file'])) {
    $R["result"] = -1;
    $R["message"] = ("This function to requires an administrative account.<br/>Please check your authority, and try again.");
    if (
            isset($_SESSION["auth"]["user"]) && 
            (
                $_SESSION["auth"]["user"]->ause_authority == 'Administrator' ||
                $_SESSION["auth"]["user"]->ause_authority == 'Admin' ||
                $_SESSION["auth"]["user"]->ause_authority == 'User'
            )
        ){
        $path = '../../../data/';
        $dir = $_POST['dir'];$file = $_POST['file'];
        if(!file_exists("$path$dir/$file") or !is_file("$path$dir/$file")){
            $R["result"] = -404;
            $R["message"] = "[$path$dir/$file]Image doest exists !";
        }else{
            $path_parts = pathinfo("$path$dir/$file");
            $file_name = $path_parts['filename'];
            $file_ext = $path_parts['extension'];
            $targ_w = (int)$_POST['w'];
            $targ_h = (int)$_POST['h'];
            $aspectRatio = $_POST['aspectRatio'];
            $jpeg_quality = 100;

            $src = "$path$dir/$file";
            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

            $time = date('Y-m-d-H-i-s');
            imagejpeg($dst_r, "{$path}{$dir}/{$file_name}_{$aspectRatio}_{$time}.{$file_ext}",$jpeg_quality);
            if (function_exists('chmod'))
                    @chmod("{$path}{$dir}/{$file_name}_{$aspectRatio}_{$time}.{$file_ext}", 0644);
            $R["result"] = 1;
            $R["message"] = 'CROP SUCCESS !';
            $R["path"] = "/data/{$dir}/{$file_name}_{$aspectRatio}_{$time}.{$file_ext}";
        }
    }
    echo json_encode($R);
    die;
}
$path = '../../../data/';
$dir = $_GET['dir'];$file = $_GET['file'];
if(!file_exists("$path$dir/$file") or !is_file("$path$dir/$file")){
    die('Image doest exists !');
}
// If not a POST request, display page below:
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>CMS - IMAGE EDITOR</title>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <link href='/libraries/ui/themes/base/jquery.ui.all.css' rel='stylesheet' type='text/css'>
        <link href="/libraries/cms/cpanel.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/libraries/cms/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="/libraries/ui/js/jquery-ui-1.9.2.custom.js"></script>
        <script type="text/javascript">
            $.widget.bridge('uitooltip', $.ui.tooltip);
            var base_url = '/';
        </script>
        <script type="text/javascript" src="/libraries/cms/cms.1109.js"></script>
        <script src="js/jquery.Jcrop.js"></script>
        <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
        <script type="text/javascript">

            $(function() {
                $('#cropbox').Jcrop({
                    //aspectRatio: 16/9,
                    onSelect: updateCoords
                });
                $('#aspectRatio').change(function(){
                    switch($(this).val()){
                        case '':
                            $('#cropbox').Jcrop({onSelect: updateCoords});
                            break;
                        case '1-1':
                            $('#cropbox').Jcrop({aspectRatio: 1,onSelect: updateCoords});
                            break;
                        case '4-3':
                            $('#cropbox').Jcrop({aspectRatio: 4/3,onSelect: updateCoords});
                            break;
                        case '16-9':
                            $('#cropbox').Jcrop({aspectRatio: 16/9,onSelect: updateCoords});
                            break;
                        case '21-9':
                            $('#cropbox').Jcrop({aspectRatio: 21/9,onSelect: updateCoords});
                            break;
                        case 'slider':
                            $('#cropbox').Jcrop({aspectRatio: 640/478,onSelect: updateCoords});
                            break;
                        case 'NEWS':
                            $('#cropbox').Jcrop({aspectRatio: 200/200,onSelect: updateCoords});
                            break;
                    }
                    
                });
            });

            function updateCoords(c)
            {
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
            }
            ;

            function checkCoords()
            {
                if (parseInt($('#w').val()))
                    return true;
                alert('Please select a crop region then press submit.');
                return false;
            }
            
            function cropimage(){
                var w = parseInt($('#w').val());
                if(!w){
                    ErrorMsg('Please select a crop region then press submit.');
                    return;
                }
                var Params = $('#crop-frm').serializeObject();
                console.log(Params);
                backend({
                    url: '/libraries/kcfinder/jcrop/crop.php',
                    data: Params,
                    callback: function(rsdata) {
                        if (rsdata.result < 0) {
                            ErrorMsg(rsdata.message);
                        } else {
                            NoticeMsg(rsdata.message +'<br/>Image path: '+rsdata.path+'<br/><img style="max-width:320px;max-height:320px;" src="'+rsdata.path+'"/>');
                        }
                    }
                }).call();
            }

        </script>
        <style type="text/css">
            body{background-color: #111;color: #ebebeb }
            select {
                border:0px solid #333;background: #222;color: #fff;
                padding: 4px 8px;border-radius: 2px;
            }
            button {
                border:0px solid #333;background: #222;color: #fff;
                padding: 4px 8px;border-radius: 2px;
            }

        </style>

    </head>
    <body>
        <div class="">
            <div>
                
                <form id="crop-frm" name="crop-frm" method="POST" onsubmit="return checkCoords();" target="integration_asynchronous">
                    <select id="aspectRatio" name="aspectRatio">
                        <option value="">auto</option>
                        <option value="1-1">1:1</option>
                        <option value="4-3">4:3</option>
                        <option value="16-9">16:9</option>
                        <option value="21-9">21:9</option>
                        <option value="slider">Slider</option>
                        <option value="NEWS">TIN TỨC</option>
                    </select>
                    <input type="hidden" id="x" name="x" value="0"/>
                    <input type="hidden" id="y" name="y"  value="0"/>
                    <input type="hidden" id="w" name="w"  value="0"/>
                    <input type="hidden" id="h" name="h"  value="0"/>
                    <input type="hidden" id="dir" name="dir" value="<?php echo $dir ?>" />
                    <input type="hidden" id="file" name="file" value="<?php echo $file ?>" />
                    <button type="button" onclick="cropimage()" id="crop" value="crop" name="crop" >Crop Image</button>
                </form>
            </div>
            <!-- This is the image we're attaching Jcrop to -->
            <img src="/data/<?php echo $dir ?>/<?php echo $file ?>"id="cropbox" />
            <!-- This is the form that our event handler fills -->
            

        </div>
        <iframe id="integration_asynchronous" name="integration_asynchronous"
        style="width: 0;height: 0;border: 0;position: absolute"></iframe>

    </body>

</html>