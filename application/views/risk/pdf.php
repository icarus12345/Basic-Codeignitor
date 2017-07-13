<!DOCTYPE html>
<html>
    <head>
        <title>RISK</title>
        <style>
            @page {
                margin-top: 30mm;size: auto;
                odd-header-name: Risk_Header;
                even-header-name: Risk_Header;
                footer-name: Risk_Footer;
            }
            *{
                margin:0;padding:0;font-family:Arial;font-size:10pt;color:#000;
            }
            body{
                width:100%;font-family:Arial;font-size:10pt;margin:0;padding:0;
            }
            p{margin:0;padding:0;}
            .wrapper{width:180mm;margin:0 15mm;}
            .page{height:297mm;width:210mm;page-break-after:always;}
            hr{color:#ccc;background:#ccc;}
            #footer{width:180mm;margin:0 15mm;padding-bottom:3mm;}
            #footer table{width:100%;border-left: 1px solid #ccc;border-top: 1px solid #ccc;background:#eee;border-spacing:0;border-collapse: collapse;}
            #footer table td{width:25%;text-align:center;font-size:9pt;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}
            .title{color: #fff;padding: 1.2mm 4mm;background: #107bbf;border-radius: 1.5mm}
            .item{padding: 1.5mm}
            .container{
                padding-right: 15mm;
                padding-left: 15mm;
            }
            .chart-image{
                width: 50%;
                text-align: center;
                float: left;
            }
            .chart-image img{display: block;margin: auto}
            .series{
                float: left;
                width: 50%;
            }
            .header{
                width:180mm;
                margin: 0 15mm;
                padding-top:15mm;
            }
            .header .project-name{
                font-weight:bold;
                font-size:12pt;
                color: #107bbf;
                float: left;width: 50%;
            }
            .header .author{
                float: right;
                font-size: 12px;
                width: 40%;
                text-align: right;
            }
            .clear{
                clear: both; margin: 0pt; padding: 0pt; 
            }
            .lendgen-color{
                width: 4em;height: 8;
                float: left;
                margin-top: .5em;
            }
            .lendgen-colorbel{
                float: left;width: 260;
            }
        </style>
    </head>
   <body>
        <htmlpageheader name="Risk_Header">
            <div class="header">
                <div class="project-name">
                   <?php echo $info['title'] ?>
                </div>
                <p class="author">RISK - <?php echo date('Y M D') ?></p>
                <div class="clear"></div>
            </div>
        </htmlpageheader>
       <htmlpagefooter name="Risk_Footer">
           <hr />
           <div id="footer">{PAGENO}/{nbpg}</div>
       </htmlpagefooter>
        <div class="container">
           <h1>
               <?php echo $info['title'] ?>
           </h1>
           <p><?php echo $info['desc'] ?></p>
        </div>
        <?php 
        foreach ($items as $key => $value) {
            if($key%2 == 1 && count($items)>1){
                echo '<pagebreak>';
            }
        ?>
            
            <div class="container">
                <?php if($key > 0){ ?>
                <h3><?php echo $value['title'] ?></h3>
                <div><?php echo $value['desc'] ?></div>
                <?php } ?>
                <div style="">
                    <div class="chart-image">
                        <img  src="<?php echo $value['image'] ?>" width="320" height="320">
                    </div>
                    <div class="series">
                        <div class="legend">
                            <div class="lendgen-color" style="background: #99cc33"></div>
                            <div class="legend-label">Global</div>
                            <div class="clear"></div>
                        </div>
                        <div class="legend">
                            <div class="lendgen-color" style="background: #117bc0"></div>
                            <div class="legend-label">Goal</div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div>
                    <?php foreach ($value['items'] as $ckey => $cvalue) { ?>
                    <div style="padding-left: 10mm;">
                        <div style="margin-left:-10mm;float:left;width: 2em;height: 2em;border:1px solid #ccc;border-radius:50%;line-height: 2em;text-align: center;margin-top:0.5em"><?php echo $ckey+1; ?></div>
                        <div style="margin-left:-10mm;width: 160mm;">
                            <div style=""><?php echo $cvalue['title']; ?></div>
                            <div style="color:<?php echo $cvalue['score'] < 2.5?'red':$cvalue['score'] < 3.5?'':'green'; ?>"><?php echo $cvalue['comment']; ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php
        }
        ?>
    </body>
</html>