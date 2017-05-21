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
                    <a href="<?php echo base_url('dashboard') ?>">Dashboard</a>
                </li>
                <li>
                    <a href="#"><?php echo $settings[$sid]->title; ?></a>
                </li>
            </ul>
        </div>
        <!-- 
         -->
         <?php if($settings): ?>
        <div class="secondary-box" id="entrys-list">
            <div class="modal-header">
                <h4>
                    <?php echo $settings[$sid]->title; ?> <small>List</small>
                </h4>
                <div class="modal-action">
                    <div><a <?php $settings[$sid]->data['add'] != 'true'?'disabled':'' ?> href="JavaScript:App.Common.ShowDetailDialog()" class="icon-plus" title="Add new entry"></a></div>
                    <div class="dropdown pull-right">
                        <a href="JavaScript:" class="icon-options-vertical" data-toggle="dropdown" title="Show more action"></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a <?php $settings[$sid]->data['add'] != 'true'?'disabled':'' ?> href="JavaScript:App.Common.ShowDetailDialog()"><span class="icon-plus"></span> Add New</a></li>
                            <li><a href="JavaScript:App.Common.Refresh()"><span class="icon-refresh"></span> Refresh</a></li>
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
                    <?php echo $settings[$sid]->title; ?> <small>Add/Edit</small>
                </h4>
            </div>

        </div>
        <?php else: ?>
            <div class="portlet light bg-inverse">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-question"></i>Manual
                    </div>
                </div>
                <div class="portlet-body">
                    <ul style="padding-left: 16px">
                        <li>
                            Right-Click on a Grid Row to open a Context Menu.<br>
                            <img src="<?php echo base_url('lib/dashboard/images/context-menu.jpg') ?>">
                        </li>
                        <li>
                            In Grid row, 'double click' on a Grid cell to edit.<br>
                            <img src="<?php echo base_url('lib/dashboard/images/cell-edit.jpg') ?>">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="portlet light bg-inverse">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-question"></i>Keyboard Navigation
                    </div>
                </div>
                <div class="portlet-body">
                    <div>
                    If the user starts typing text, the cell's content is replaced with the text entered from the user.
                    </div>
                    <ul style="padding-left: 16px">
                        <li>Left Arrow key is pressed - Selects the left cell, when the Grid is not in edit
                        mode. Otherwise, the key stroke is handled by the editor.</li>
                        <li>Right Arrow key is pressed - Selects the right cell, when the Grid is not in edit
                        mode. Otherwise, the key stroke is handled by the editor.</li>
                        <li>Up Arrow key is pressed - Selects the cell above, when the Grid is not in edit mode.
                        Otherwise, the key stroke is handled by the editor.</li>
                        <li>Down Arrow key is pressed - Selects the cell below, when the Grid is not in edit
                        mode. Otherwise, the key stroke is handled by the editor.</li>
                        <li>Page Up/Down is pressed - Navigate Up or Down with one page, when the Grid is not
                        in edit mode. Otherwise, the key stroke is handled by the editor.</li>
                        <li>Home/End is pressed - Navigate to the first or last row, when the Grid is not in
                        edit mode. Otherwise, the key stroke is handled by the editor.</li>
                        <li>Enter key is pressed - Shows the selected cell's editor. If the cell is in edit
                            mode, hides the cell's editor and saves the new value. The editor's value is equal
                        to the cell's value.</li>
                        <li>Esc key is pressed - Hides the cell's editor and cancels the changes.</li>
                        <li>Tab key is pressed - Selects the right cell. If the Grid is in edit mode, saves
                        the edit cell's value, closes its editor, selects the right cell and opens its editor.</li>
                        <li>Shift+Tab keys are pressed - Selects the left cell. If the Grid is in edit mode,
                            saves the edit cell's value, closes its editor, selects the left cell and opens
                        its editor.</li>
                        <li>F2 key is pressed - shows the selected cell's editor when the Grid is in edit mode.</li>
                        <li>Space key is pressed - Toggles the checkbox editor's check state when the selected
                        cell's column is a checkbox column and the Grid is editable.</li>
                        <li>Ctrl key is pressed - in 'multiplecellsextended and multiplerowsextended' selection
                        mode, extends the selection when the user clicks on a cell or row. </li>
                        <li>Ctrl+ARROW KEY - moves to an edge. </li>
                        <li>SHIFT+ARROW KEY extends the selection.</li>
                        <li>Page Down - Moves one screen down</li>
                        <li>Page Up - Moves one screen up</li>
                        <li>Home - Moves to the beginning</li>
                        <li>End - Moves to the end</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
<!-- </div> -->
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            App.Common.sid = '<?php echo $sid; ?>';
            App.Common.settings = <?php echo json_encode($settings); ?>;
            App.Common.Grid()
        }, 300)
    })
</script>