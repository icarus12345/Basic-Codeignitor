<?php 
$this->CI =& get_instance();
?>
<!-- <div class=" fluid"> -->
    <div class="modal-body">
        <!-- <h3 class="page-title">
            Dashboard <small>Content</small>
        </h3> -->
        <div class="page-bar">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li>
                    <a href="/dashboard/cp" id = "dropdownMenu1">Module</a>
                </li>
                <li>
                    <a href="#">Module</a>
                </li>
            </ul>
        </div>
        <div class="secondary-box" >
            <div class="modal-header">
                <h4>
                    Module <small>Function</small>
                </h4>
                <div class="modal-action">
                    <div><a href="JavaScript:App.Module.ShowDetailDialog()" class="icon-plus" title="Add new entry"></a></div>
                    <div class="dropdown pull-right">
                        <a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="JavaScript:App.Module.ShowDetailDialog()"><span class="icon-plus"></span> Add New</a></li>
                            <li><a href="JavaScript:App.Module.Refresh()"><span class="icon-refresh"></span> Refresh</a></li>
                            <li><a href="#"><span class="icon-settings"></span> Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><span class="icon-question"></span> Help</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="jqxGrid" id="jqxGrid" style="border:0">
                
            </div>
        </div>
    </div>
<!-- </div> -->
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            App.Module.basic_module = <?php echo json_encode($basic_module); ?>;
            App.Module.type = <?php echo json_encode($type); ?>;
            App.Module.Grid()
        }, 300)
    })
</script>