<?php 
$this->CI =& get_instance();
?>
<div class=" fluid">
    <div class="modal-body">
        <h3 class="page-title">
            Dashboard <small>Content</small>
        </h3>
        <div class="page-bar">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li>
                    <a href="/dashboard/cp">Content Provider</a>
                </li>
                <li>
                    <a href="#">Category</a>
                </li>
            </ul>
        </div>
        <div class="secondary-box" >
            <div class="modal-header">
                <h4>
                    Category <small>Function</small>
                </h4>
                <div class="modal-action">
                    <div><a href="JavaScript:App.Category.ShowDetailDialog()" class="icon-plus" title="Add new entry"></a></div>
                    <div class="dropdown pull-right">
                        <a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="JavaScript:App.Category.ShowDetailDialog()"><span class="icon-plus"></span> Add New</a></li>
                            <li><a href="JavaScript:App.Category.Refresh()"><span class="icon-refresh"></span> Refresh</a></li>
                            <li><a href="#"><span class="icon-settings"></span> Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><span class="icon-question"></span> Help</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="jqxGrid" id="jqxGrid" style="border:0">
                
            </div>
            <div class="modal-body" id="login-dialog">
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            App.Category.sid = '<?php echo $setting_detail->id; ?>';
            App.Category.entry_setting = <?php echo json_encode($setting_detail); ?>;
            App.Category.Grid()
        }, 300)
    })
</script>