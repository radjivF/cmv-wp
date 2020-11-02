<div id='bwpb' class='loading <?php echo ( ( ! isset( Bwpb::$global['hide_editor'] ) or Bwpb::$global['hide_editor'] == true ) ? '' : 'not-hide-editor' ) . "' data-editor='" . __( 'Enable Peenapo Page Builder', PBTD ) . "' data-classic='" . __( 'WP Editor', PBTD ); ?>'">

    <div class="bwpb-main-header">
    <input type="text" value="<?php echo esc_attr( Bwpb::bw_check_status() ); ?>" name="bw_status" id="bw_status">

    <?php require_once( PB_TEMPLATES . 'backend/panel-custom_css.tpl.php' ); ?>

    <textarea class='bwpb-custom-css-textarea' name='bw_custom_css'><?php echo strip_tags( Bwpb_back::bw_check_custom_css() ); ?></textarea>

    </div>

    <div class='bwpb-plus-section bwpb-plus-top'>
        <div class='bwpb-button bwpb-open-modal append-ele-top'><?php _e( 'Add new element', PBTD ); ?></div>
        <div class='bwpb-button bwpb-button-gray bwpb-open-custom-css-panel'>Custom CSS</div>
    </div>

    <?php require_once( PB_TEMPLATES . 'backend/welcome.tpl.php' ); ?>

    <div class='bwpb-blocks-holder no-selection'>
        <div class='bwpb-blocks'></div>
    </div>

    <div class='bwpb-plus-section bwpb-plus-bottom'>
        <div class='bwpb-button bwpb-open-modal'><?php _e( 'Add new element', PBTD ); ?></div>
        <div class='bwpb-button bwpb-button-red bwpb-empty-content'><?php _e( 'Empty content', PBTD ); ?></div>
        <p class='bwpb-copy'>&copy; Peenapo Page Builder, by <a target='_blank' href='http://themeforest.net/user/Peenapo/portfolio?ref=Peenapo'>Peenapo</a>. <a target='_blank' href='#'>User guide</a>, <a target='_blank' href='http://docs.bwdesk.com/peenapo-page-builder/'>Developers</a></p>
    </div>
    
</div>

<div id='bwpb-bg'></div>

<div id='bwpb-modal'>
    <div class='modal-header'><h3><?php _e( 'Add element', PBTD ); ?></h3><span class='modal-close'></span></div>
    <?php self::modal_list(); ?>
</div>