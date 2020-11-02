<?php

$controls_row = "
<div class='bwpb-controls'>
    <div class='bwpb-row-hight bwpb-drag'>
        <span class='bwpb-row-option' title='" .  __( 'Move', PBTD ) . "'><i class='bwpb-lineicon-cursor-move'></i></span>
        <span class='bwpb-row-label'>" .  __( 'Row', PBTD ) . "</span>
    </div>
    <div class='bwpb-row-options'>
        <span class='bwpb-row-option bwpb-edit' title='" .  __( 'Edit', PBTD ) . "'><i class='fa fa-search'></i></span>
        <span class='bwpb-row-option bwpb-duplicate' title='" .  __( 'Duplicate', PBTD ) . "'><i class='fa fa-copy'></i></span>
        <span class='bwpb-row-option bwpb-cut' title='" .  __( 'New Column', PBTD ) . "'><i class='fa fa-scissors'></i></span>
        <span class='bwpb-row-option bwpb-visibility' title='" .  __( 'Visibility', PBTD ) . "'><i class='fa fa-power-off'></i></span>
        <span class='bwpb-row-option bwpb-trash bwpb-trash-check-empty' title='" .  __( 'Delete', PBTD ) . "'><i class='fa fa-times'></i></span>
    </div>
</div>
";

$block_edit_buttons = "
<div class='just-edit'>
    <div class='bwpb-label no-selection'></div>
    <div class='bwpb-option-holder'>
        <div class='bwpb-option bwpb-edit' title='" .  __( 'Edit', PBTD ) . "'><i class='fa fa-search'></i></div>
        <div class='bwpb-option bwpb-duplicate' title='" .  __( 'Duplicate', PBTD ) . "'><i class='fa fa-copy'></i></div>
        <div class='bwpb-option bwpb-trash bwpb-trash-check-empty' title='" .  __( 'Delete', PBTD ) . "'><i class='fa fa-times'></i></div>
    </div>
</div>";

$container_edit_buttons = "
<div class='bwpb-top-ctrl'>
    <span class='bwpb-option bwpb-open-modal append-ele-top' title='" .  __( 'Add element', PBTD ) . "'><i class='fa fa-plus'></i></span>
    <span class='bwpb-option bwpb-edit' title='" .  __( 'Edit', PBTD ) . "'><i class='fa fa-search'></i></span>
    <span class='bwpb-option bwpb-duplicate' title='" .  __( 'Duplicate', PBTD ) . "'><i class='fa fa-copy'></i></span>
    <span class='bwpb-option bwpb-trash bwpb-trash-check-empty' title='" .  __( 'Delete', PBTD ) . "'><i class='fa fa-times'></i></span>
</div>";

$tab_edit_buttons = "
<div class='bwpb-top-ctrl bwpb-tab-ctrl'>
    <span class='bwpb-option bwpb-add-element' data-toadd='' title='" .  __( 'Add element', PBTD ) . "'><i class='fa fa-plus'></i></span>
    <span class='bwpb-option bwpb-edit' title='" .  __( 'Edit', PBTD ) . "'><i class='fa fa-search'></i></span>
    <span class='bwpb-option bwpb-duplicate' title='" .  __( 'Duplicate', PBTD ) . "'><i class='fa fa-copy'></i></span>
    <span class='bwpb-option bwpb-trash bwpb-trash-check-empty' title='" .  __( 'Delete', PBTD ) . "'><i class='fa fa-times'></i></span>
</div>";

$tab_item_edit_buttons = "
<div class='just-edit'>
    <div class='bwpb-label no-selection'></div>
    <div class='bwpb-option-holder'>
        <div class='bwpb-option bwpb-edit'><i class='fa fa-search'></i></div>
        <div class='bwpb-option bwpb-duplicate-tab'><i class='fa fa-copy'></i></div>
        <div class='bwpb-option bwpb-trash-tab bwpb-trash-check-empty'><i class='fa fa-times'></i></div>
    </div>
</div>";

$bottom_options = "";
//$bottom_options = "<div class='bwpb-bottom-ctrl'></div>";
/*
<div class='bwpb-bottom-ctrl'>
    <span class='bwpb-option bwpb-open-modal'></span>
</div>
*/

$block_drag = "
<div class='bwpb-drag-placeholder'>
    <div class='bwpb-drag-icon'><i class='bwpb-icon'></i></div>
    <div class='bwpb-drag-label'></div>
</div>
";
?>

<!-- row -->
<script type="text/html" id="bwpb_template-row">
    <div class='bwpb-block block-row' data-id='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $controls_row; ?>
            <div class='bwpb-content'></div>
            
        </div>
        <?php echo $block_drag; ?>
        <div class="bwpb-col-drag-bg"></div>
    </div>
</script>

<!-- column -->
<script type="text/html" id="bwpb_template-column">
    <div class='bwpb-block block-column' data-id='' data-module='' data-col-width=''>
        <div class='bwpb-block-container'>
            
            <div class='bwpb-top-column'>
                <div class='bwpb-col-ctrl'>
                    <span>100</span> %
                </div>
                <div class='bwpb-top-ctrl'>
                    <span class='bwpb-option bwpb-open-modal append-ele-top'><i class='fa fa-plus'></i></span>
                    <span class='bwpb-option bwpb-edit'><i class='fa fa-search'></i></span>
                    <span class='bwpb-option bwpb-trash'><i class='fa fa-times'></i></span>
                </div>
            </div>
            
            <span class='bwpb-col-plus bwpb-open-modal'><i class='fa fa-plus'></i></span>
            
            <div class="bwpb-content"></div>
            
            <?php echo $bottom_options; ?>
            
        </div>
        <span class="bwpb-column-drag"><span class="bwpb-col-drag-handle"></span></span>
        <div class="bwpb-column-width">
            <span class="bwpb-col-width-label"><em>50</em> %</span>
        </div>
    </div>
</script>

<!-- block -->
<script type="text/html" id="bwpb_template-block">
    <div class='bwpb-block bwpb-simple-block' data-id='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $block_edit_buttons; ?>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- text -->
<script type="text/html" id="bwpb_template-text">
    <div class='bwpb-block bwpb-text-block' data-id='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $block_edit_buttons; ?>
            <div class="bwpb-holder">
                <div class="bwpb-html-text"></div>
            </div>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- listing -->
<script type="text/html" id="bwpb_template-listing">
    <div class='bwpb-block bwpb-listing' data-id='' data-container='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $container_edit_buttons; ?>
            <span class='bwpb-col-plus bwpb-open-modal'><i class='fa fa-plus'></i></span>
            <div class='bwpb-content' data-connect='bwpb-content'></div>
            
            <?php echo $bottom_options; ?>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- listing item -->
<script type="text/html" id="bwpb_template-listing_item">
    <div class='bwpb-block bwpb-listing-item' data-id='' data-container='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $block_edit_buttons; ?>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- tab -->
<script type="text/html" id="bwpb_template-tab">
    <div class='bwpb-block bwpb-tab' data-id='' data-container='' data-module='' data-tabtext=''>
        <div class='bwpb-block-container'>
            
            <ul class='bwpb-tab-list'></ul>
            
            <?php echo $tab_edit_buttons; ?>
            <span class='bwpb-col-plus bwpb-add-element' data-toadd=''><i class='fa bwpb-oi-plus'></i></span>
            <div class='bwpb-content' data-connect='bwpb-content'></div>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- tab item -->
<script type="text/html" id="bwpb_template-tab_item">
    <div class='bwpb-block bwpb-tab-item' data-id='' data-container='' data-module=''>
        <div class='bwpb-block-container'>
            
            <?php echo $tab_item_edit_buttons; ?>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>

<!-- divider -->
<script type="text/html" id="bwpb_template-separator">
    <div class='bwpb-block bwpb-separator-block' data-id='' data-module=''>
        <div class='bwpb-block-container'>
            
            <div class="bwpb-holder">
                <h4></h4>
            </div>
            
            <?php echo $block_edit_buttons; ?>
            
        </div>
        <?php echo $block_drag; ?>
    </div>
</script>
