<?php

class Bw_admin {

    static function init() {

        # register required plugins
        Bw_required_plugins::init();

        add_action( 'admin_init', array( 'Bw_admin', 'components' ) );
    }

    static function components() {

        # enqueue scripts for admin area
        self::enqueue_assets();

        # call once after theme was activated
        Bw_after_activation::init();

        # admin ajax
        Bw_admin_ajax::init();
        
        # enables the use of megamenu
        Bw_megamenu::init();
    }

    static function enqueue_assets() {

        # css
        Bw_assets::addStyle( 'bw-admin-select2-css', 'bw/assets/css/vendors/select2/select2.css' );
        Bw_assets::addStyle( 'bw-admin', 'bw/assets/css/admin.css' );
        
        global $pagenow;
        if( $pagenow !== 'themes.php' ) {
            Bw_assets::addStyle( 'bw-ui-slider', 'bw/assets/css/vendors/jquery-ui.slider/jquery-ui.slider.css' );
        }

        # js
        Bw_assets::addScript( 'bw-admin-select2-js', 'bw/assets/js/vendors/select2/select2.min.js' );
        Bw_assets::addScript( 'bw-admin-select2-sortable', 'bw/assets/js/vendors/select2/select2.sortable.js' );
        Bw_assets::addScript( 'bw-qjax', 'bw/assets/js/vendors/jquery.qjax/jquery.qjax.min.js' );
        Bw_assets::addScript( 'bw-admin', 'bw/assets/js/admin.js', array( 'jquery' ) );
    }

}