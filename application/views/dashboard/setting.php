<?php 
$this->CI =& get_instance();
?>
<!-- <div class=" fluid"> -->
    <div class="modal-body">
        <!-- <h3 class="page-title">
            Dashboard <small>Setting</small>
        </h3> -->
        <div class="page-bar">
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo base_url('dashboard') ?>">Dashboard</a>
                </li>
                <li>
                    <a href="#">Setting</a>
                </li>
            </ul>
        </div>
        <div class="secondary-box" id="entrys-list">
            <div class="modal-header">
                <h4>
                    Setting <small>List</small>
                </h4>
                <div class="modal-action">
                    <div><a <?php $settings[$sid]->data['add'] != 'true'?'disabled':'' ?> href="JavaScript:App.Setting.ShowDetailDialog()" class="icon-plus" title="Add new entry"></a></div>
                    <div class="dropdown pull-right">
                        <a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a <?php $settings[$sid]->data['add'] != 'true'?'disabled':'' ?> href="JavaScript:App.Setting.ShowDetailDialog()"><span class="icon-plus"></span> Add New</a></li>
                            <li><a href="JavaScript:App.Setting.Refresh()"><span class="icon-refresh"></span> Refresh</a></li>
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

        <div class="-secondary-box" id="entry-detail">
            <div class="modal-header">
                <h4>
                    Setting <small>Add/Edit</small>
                </h4>
            </div>

        </div>
    </div>
<!-- </div> -->
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            App.Module.type = <?php echo json_encode($type); ?>;
            App.Setting.Grid()
        }, 300)
    })
</script>