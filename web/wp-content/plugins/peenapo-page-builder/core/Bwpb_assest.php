<?php

class Bwpb_assets {
	
	static function init() {
        
        if( is_admin() ) {
            add_action( 'admin_enqueue_scripts', array( 'Bwpb_assets', 'enqueue_admin' ) );
        }else{
            add_action( 'wp_enqueue_scripts', array( 'Bwpb_assets', 'enqueue_front' ) );
        }
		
	}
    
	static function enqueue_admin() {
		
		# css
        wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'bwpb', PB_ASSEST . 'css/bwpb.css' );
		wp_enqueue_style( 'bwpb-jquery-ui', PB_ASSEST . 'css/vendors/jquery-ui.css' );
		wp_enqueue_style( 'bwpb-select2', PB_ASSEST . 'css/vendors/select2.css' );
		
		# js
		wp_enqueue_script( array( "jquery", "jquery-ui-core", "jquery-ui-dialog", "jquery-ui-sortable", "wp-color-picker", "jquery-ui-slider" ) );
        wp_register_script( 'bwpb', PB_ASSEST . 'js/bwpb.js', array('jquery-ui-sortable'), PB_VER, true );
		wp_localize_script( 'bwpb', 'bwpb_admin_root', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_script( 'bwpb-smart-resize', PB_ASSEST . 'js/vendors/jquery-smartresize-master/jquery.debouncedresize.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-select2', PB_ASSEST . 'js/vendors/jquery.select2/select2.min.js', array(), PB_VER, true );
        wp_enqueue_script( 'ace-editor', PB_ASSEST . 'js/vendors/ace-editor-src-min-noconflict/ace.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-php-default', PB_ASSEST . 'js/vendors/php.default/php.default.min.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-colorpicker', PB_ASSEST . 'js/vendors/wpcolorpicker/wp-colorpicker.min.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-blocker', PB_ASSEST . 'js/bwpb.blocker.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-shortcoder', PB_ASSEST . 'js/bwpb.shortcoder.js', array(), PB_VER, true );
        wp_enqueue_script( 'bwpb-mapper', PB_ASSEST . 'js/bwpb.mapper.js', array(), PB_VER, true );
		wp_enqueue_script( 'bwpb' );
	}
	
	static function enqueue_front() {
        
        # css
        wp_enqueue_style('bwpb-front', PB_ASSEST . 'css/bwpb-front.css');
        
        # js
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'bwpb-google-maps', '//maps.google.com/maps/api/js?sensor=false' );
        
        wp_enqueue_script( 'bwpb-front-plugins', PB_ASSEST . 'js/bwpb-front-plugins.js', array('jquery'), PB_VER, true );
        wp_enqueue_script( 'bwpb-front', PB_ASSEST . 'js/bwpb-front.js', array('jquery'), PB_VER, true );
        
    }
}

?>