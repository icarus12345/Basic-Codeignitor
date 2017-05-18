<?php 
$this->CI =& get_instance();
?>
<!-- <div class=" fluid"> -->
    <div class="modal-body">
        <!-- <h3 class="page-title">
            Dashboard <small><?php echo $settings[$sid]->title; ?></small>
        </h3> -->
        <div class="page-bar">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li>
                    <a href="#"><?php echo $settings[$sid]->title; ?></a>
                </li>
            </ul>
        </div>

        <div class="-secondary-box" id="entry-detail">
            <div class="modal-header">
                <h4>
                    <?php echo $settings[$sid]->title; ?> <small>Add/Edit</small>
                </h4>
            </div>
        </div>
    </div>
<!-- </div> -->
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            App.Common.onlysave = 1;
            App.Common.sid = '<?php echo $sid; ?>';
            App.Common.settings = <?php echo json_encode($settings); ?>;
            App.Common.settings[App.Common.sid].data.size = '';
            App.Common.ShowDetailDialog('<?php echo $id; ?>')
        }, 300)
    })
</script>