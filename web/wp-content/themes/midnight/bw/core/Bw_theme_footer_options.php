<?php

class Bw_theme_footer_options {
    
    static function init() {
        
        add_action( 'wp_footer', array( 'Bw_theme_footer_options', 'set_footer' ) );
        
    }
    
    static function set_footer() {
        
        self::custom_js();
        
    }
    
    static function custom_js() {
        $custom_js = Bw::get_option('custom_js');
        if ($custom_js) { echo "<script type='text/javascript'>{$custom_js}</script>"; }
    }
}