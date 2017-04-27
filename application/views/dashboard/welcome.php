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
                    <a href="#">Content</a>
                </li>
            </ul>
        </div>
        <div class="secondary-box" >
            <div class="modal-header">
                <h4>
                    Setting <small>Function</small>
                </h4>
                <div class="modal-action">
                    <div><a href="JavaScript:App.Setting.Add()" class="icon-plus" title="Add new entry"></a></div>
                    <div class="dropdown pull-right">
                        <a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="JavaScript:App.Setting.Add()"><span class="icon-plus"></span> Add New</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#"><span class="icon-settings"></span> Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="JavaScript:App.Setting.Refresh()"><span class="icon-refresh"></span> Refresh</a></li>
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