<div id='bwpb-custom-css' class='bwpb-panel bwpb-draggable' data-title='<?php _e( 'Custom CSS', PBTD ); ?>'>
    <div class='panel-header'><h4 class='panel-title'></h4><span class='panel-h-button panel-close button-close'></span></div>
    <div class='panel-content'>
        <div class='panel-row'>
            <p><?php _e( 'Add additional CSS code, displayed for the current post.', PBTD ); ?></p>
            <div id="bw_custom_css_editor"><?php echo strip_tags( Bwpb_back::bw_check_custom_css() ); ?></div>
        </div>
    </div>
    <div class='panel-footer'>
        <div class='panel-scripts'></div>
        <span class='panel-button button-close'><?php _e( 'Close', PBTD ); ?></span>
        <span class='panel-button button-save'><?php _e( 'Save Custom CSS', PBTD ); ?></span>
    </div>
</div>